<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['password' => 'hashed'];

    public function exams() {
        return $this->hasMany(Exam::class, 'guru_id');
    }

    public function answers() {
        return $this->hasMany(StudentAnswer::class, 'student_id');
    }

    public function cheatingLogs() {
        return $this->hasMany(CheatingLog::class, 'student_id');
    }
}
