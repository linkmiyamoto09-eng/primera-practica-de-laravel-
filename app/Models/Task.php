<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model {
    protected $fillable = ['title', 'description', 'type', 'due_date', 'is_cancelled', 'teacher_id'];

    protected $casts = [
        'due_date' => 'datetime',
        'is_cancelled' => 'boolean',
    ];

    public function teacher() {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function submissions() {
        return $this->hasMany(TaskSubmission::class);
    }

    public function isExpired(): bool {
        return Carbon::now()->greaterThan($this->due_date);
    }
}