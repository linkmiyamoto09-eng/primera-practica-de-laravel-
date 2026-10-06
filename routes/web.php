<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;

// Autenticación
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas Docente
Route::middleware(['auth', 'role:teacher'])->prefix('docente')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
    
    // Alumnos
    Route::get('/alumnos', [TeacherController::class, 'students'])->name('teacher.students');
    Route::post('/alumnos', [TeacherController::class, 'storeStudent'])->name('teacher.students.store');
    Route::post('/alumnos/masivo', [TeacherController::class, 'bulkStoreStudents'])->name('teacher.students.bulk');
    Route::post('/alumnos/{id}/toggle', [TeacherController::class, 'toggleUserStatus'])->name('teacher.students.toggle');

    // Tareas
    Route::get('/tareas/crear', [TeacherController::class, 'createTask'])->name('teacher.tasks.create');
    Route::post('/tareas', [TeacherController::class, 'storeTask'])->name('teacher.tasks.store');
    Route::get('/tareas/{id}', [TeacherController::class, 'showTask'])->name('teacher.tasks.show');
    Route::post('/tareas/{id}/cancelar', [TeacherController::class, 'cancelTask'])->name('teacher.tasks.cancel');
    Route::post('/entregas/{id}/calificar', [TeacherController::class, 'gradeSubmission'])->name('teacher.submissions.grade');
});

// Rutas Alumno
Route::middleware(['auth', 'role:student'])->prefix('alumno')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::post('/tareas/{id}/entregar', [StudentController::class, 'submitTask'])->name('student.tasks.submit');
    Route::post('/notificaciones/leer', [StudentController::class, 'markNotificationsRead'])->name('student.notifications.read');
});