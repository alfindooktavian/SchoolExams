<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheatingLog extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'exam_id', 'description'];

    public function student() {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function exam() {
        return $this->belongsTo(Exam::class);
    }
}