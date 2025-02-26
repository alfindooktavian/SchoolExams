<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'exam_id', 'score', 'cheating_score', 'status'];

    public function student() {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function exam() {
        return $this->belongsTo(Exam::class);
    }
}

