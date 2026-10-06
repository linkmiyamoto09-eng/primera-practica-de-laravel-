<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TeacherController extends Controller {
    public function dashboard() {
        $tasks = Task::withCount('submissions')->orderBy('created_at', 'desc')->get();
        return view('teacher.dashboard', compact('tasks'));
    }

    public function students() {
        $students = User::where('role', 'student')->get();
        return view('teacher.students', compact('students'));
    }

    public function storeStudent(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
            'is_active' => true,
        ]);

        return back()->with('success', 'Alumno registrado correctamente.');
    }

    public function bulkStoreStudents(Request $request) {
        $request->validate([
            'csv_data' => 'required|string',
        ]);

        $lines = explode("\n", trim($request->csv_data));
        foreach ($lines as $line) {
            $data = str_getcsv($line);
            if (count($data) >= 3) {
                User::updateOrCreate(
                    ['email' => trim($data[1])],
                    [
                        'name' => trim($data[0]),
                        'password' => Hash::make(trim($data[2])),
                        'role' => 'student',
                        'is_active' => true,
                    ]
                );
            }
        }

        return back()->with('success', 'Carga masiva procesada con éxito.');
    }

    public function toggleUserStatus($id) {
        $user = User::findOrFail($id);
        if ($user->role === 'student') {
            $user->is_active = !$user->is_active;
            $user->save();
        }
        return back()->with('success', 'Estado del usuario actualizado.');
    }

    public function createTask() {
        return view('teacher.tasks_create');
    }

    public function storeTask(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:tareas en casa,actividades,exposiciones',
            'due_date' => 'required|date|after:today',
        ]);

        // Ajuste de hora límite a las 23:59:59 del día de entrega asignado
        $dueDate = Carbon::parse($request->due_date)->endOfDay();

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'due_date' => $dueDate,
            'teacher_id' => auth()->id(),
        ]);

        // Notificar a los estudiantes activos
        $students = User::where('role', 'student')->where('is_active', true)->get();
        foreach ($students as $student) {
            Notification::create([
                'user_id' => $student->id,
                'message' => "Nueva tarea asignada: {$task->title}",
            ]);
        }

        return redirect()->route('teacher.dashboard')->with('success', 'Tarea creada y asignada.');
    }

    public function cancelTask($id) {
        $task = Task::findOrFail($id);
        $task->is_cancelled = true;
        $task->save();

        $students = User::where('role', 'student')->get();
        foreach ($students as $student) {
            Notification::create([
                'user_id' => $student->id,
                'message' => "La tarea '{$task->title}' ha sido cancelada por el docente.",
            ]);
        }

        return back()->with('success', 'Tarea cancelada con éxito.');
    }

    public function showTask($id) {
        $task = Task::findOrFail($id);
        $students = User::where('role', 'student')->get();
        $submissions = TaskSubmission::where('task_id', $id)->get()->keyBy('student_id');

        return view('teacher.task_show', compact('task', 'students', 'submissions'));
    }

    public function gradeSubmission(Request $request, $id) {
        $submission = TaskSubmission::findOrFail($id);
        
        if (!$submission->task->isExpired()) {
            return back()->withErrors(['error' => 'Solo se puede evaluar después de cumplida la fecha límite.']);
        }

        $request->validate([
            'score' => 'required|integer|min:1|max:10',
        ]);

        $submission->score = $request->score;
        $submission->is_published = true;
        $submission->save();

        Notification::create([
            'user_id' => $submission->student_id,
            'message' => "Tu tarea '{$submission->task->title}' ha sido calificada: {$submission->score}/10",
        ]);

        return back()->with('success', 'Calificación publicada.');
    }
}