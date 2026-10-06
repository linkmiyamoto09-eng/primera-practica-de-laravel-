<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'is_active'];

    protected $hidden = ['password', 'remember_token'];

    public function isTeacher(): bool {
        return $this->role === 'teacher';
    }

    public function isStudent(): bool {
        return $this->role === 'student';
    }

    public function submissions() {
        return $this->hasMany(TaskSubmission::class, 'student_id');
    }

    public function notifications() {
        return $this->hasMany(Notification::class);
    }
}