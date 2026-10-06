<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller {
    public function dashboard() {
        $studentId = Auth::id();
        $tasks = Task::where('is_cancelled', false)->orderBy('due_date', 'asc')->get();
        $submissions = TaskSubmission::where('student_id', $studentId)->get()->keyBy('task_id');
        $notifications = Notification::where('user_id', $studentId)->where('is_read', false)->get();

        return view('student.dashboard', compact('tasks', 'submissions', 'notifications'));
    }

    public function submitTask(Request $request, $taskId) {
        $task = Task::findOrFail($taskId);

        if ($task->is_cancelled || $task->isExpired()) {
            return back()->withErrors(['error' => 'No es posible enviar entrega para esta tarea.']);
        }

        $request->validate([
            'file' => 'required|mimes:pdf|max:2048', // PDF de max 2MB
        ]);

        $path = $request->file('file')->store('evidencias', 'public');

        TaskSubmission::updateOrCreate(
            ['task_id' => $task->id, 'student_id' => Auth::id()],
            ['file_path' => $path]
        );

        return back()->with('success', 'Evidencia subida correctamente.');
    }

    public function markNotificationsRead() {
        Notification::where('user_id', Auth::id())->update(['is_read' => true]);
        return back();
    }
}