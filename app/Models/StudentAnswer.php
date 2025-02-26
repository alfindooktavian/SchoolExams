<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'exam_id', 'question_id', 'choice_id', 'is_correct'];

    public function student() {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function question() {
        return $this->belongsTo(Question::class);
    }

    public function choice() {
        return $this->belongsTo(Choice::class);
    }
}
