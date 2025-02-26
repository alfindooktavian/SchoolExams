<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'duration', 'guru_id']; // ✅ Lengkapi fillable

    // ✅ Relasi ke Guru (User)
    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    // ✅ Relasi ke Soal Ujian
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // ✅ Relasi ke Hasil Ujian
    public function results()
    {
        return $this->hasMany(ExamResult::class);
    }
}
