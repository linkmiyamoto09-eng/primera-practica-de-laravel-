<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('task_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->string('file_path');
            $table->unsignedTinyInteger('score')->nullable(); // Escala del 1 al 10
            $table->boolean('is_published')->default(false);
            $table->timestamps();
            $table->unique(['task_id', 'student_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('task_submissions');
    }
};