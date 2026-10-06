<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // Docente
        User::create([
            'name' => 'Prof. Carlos Mendoza',
            'email' => 'docente@sistema.edu',
            'password' => Hash::make('password123'),
            'role' => 'teacher',
            'is_active' => true,
        ]);

        // 15 Alumnos
        for ($i = 1; $i <= 15; $i++) {
            User::create([
                'name' => "Alumno $i",
                'email' => "alumno$i@sistema.edu",
                'password' => Hash::make('password123'),
                'role' => 'student',
                'is_active' => true,
            ]);
        }
    }
}