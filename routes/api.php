<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\StudentAnswerController;
use App\Http\Controllers\ExamResultController;
use App\Http\Controllers\CheatingLogController;

// **🔹 Authentication Routes**
Route::post('/register', [AuthController::class, 'register']); // 🔹 Register user
Route::post('/login', [AuthController::class, 'login']);       // 🔹 Login user
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum'); // ✅ Logout
Route::get('/user', [AuthController::class, 'currentUser'])->middleware('auth:sanctum'); // ✅ Current User

// **🔹 Protected Routes (Authenticated Users Only)**
Route::middleware('auth:sanctum')->group(function () {

    // **🔹 Exams (Ujian)**
    Route::get('/exams', [ExamController::class, 'index']);     // 🔹 Lihat semua ujian
    Route::get('/exams/{id}', [ExamController::class, 'show']); // 🔹 Lihat detail ujian
        Route::post('/exams', [ExamController::class, 'store']); // ✅ Buat ujian (Guru)
        Route::put('/exams/{id}', [ExamController::class, 'update']); // ✅ Edit ujian (Guru)
        Route::delete('/exams/{id}', [ExamController::class, 'destroy']); // ✅ Hapus ujian (Guru)
    

    // **🔹 Questions (Pertanyaan)**
    Route::get('/questions', [QuestionController::class, 'index']);      // 🔹 Lihat semua pertanyaan
    Route::get('/questions/{id}', [QuestionController::class, 'show']);  // 🔹 Lihat detail pertanyaan
    Route::post('/questions', [QuestionController::class, 'store']);     // 🔹 Tambah pertanyaan
    Route::put('/questions/{id}', [QuestionController::class, 'update']); // 🔹 Update pertanyaan
    Route::delete('/questions/{id}', [QuestionController::class, 'destroy']); // 🔹 Hapus pertanyaan

    // **🔹 Choices (Pilihan Jawaban)**
    Route::get('/choices', [ChoiceController::class, 'index']);       // 🔹 Lihat semua pilihan jawaban
    Route::get('/choices/{id}', [ChoiceController::class, 'show']);   // 🔹 Lihat detail pilihan jawaban
    Route::post('/choices', [ChoiceController::class, 'store']);      // 🔹 Tambah pilihan jawaban
    Route::put('/choices/{id}', [ChoiceController::class, 'update']); // 🔹 Update pilihan jawaban
    Route::delete('/choices/{id}', [ChoiceController::class, 'destroy']); // 🔹 Hapus pilihan jawaban

    // **🔹 Student Answers (Jawaban Siswa)**
    Route::get('/student-answers', [StudentAnswerController::class, 'index']);      // 🔹 Lihat semua jawaban siswa
    Route::get('/student-answers/{id}', [StudentAnswerController::class, 'show']);  // 🔹 Lihat jawaban siswa tertentu
    Route::post('/student-answers', [StudentAnswerController::class, 'store']);     // 🔹 Simpan jawaban siswa
    Route::put('/student-answers/{id}', [StudentAnswerController::class, 'update']); // 🔹 Update jawaban siswa
    Route::delete('/student-answers/{id}', [StudentAnswerController::class, 'destroy']); // 🔹 Hapus jawaban siswa

    // **🔹 Exam Results (Hasil Ujian)**
    Route::get('/exam-results', [ExamResultController::class, 'index']);      // 🔹 Lihat semua hasil ujian
    Route::get('/exam-results/{id}', [ExamResultController::class, 'show']);  // 🔹 Lihat hasil ujian tertentu
    Route::post('/exam-results', [ExamResultController::class, 'store']);     // 🔹 Simpan hasil ujian
    Route::put('/exam-results/{id}', [ExamResultController::class, 'update']); // 🔹 Update hasil ujian
    Route::delete('/exam-results/{id}', [ExamResultController::class, 'destroy']); // 🔹 Hapus hasil ujian

    // **🔹 Cheating Logs (Catatan Kecurangan)**
    Route::get('/cheating-logs', [CheatingLogController::class, 'index']);      // 🔹 Lihat semua catatan kecurangan
    Route::get('/cheating-logs/{id}', [CheatingLogController::class, 'show']);  // 🔹 Lihat detail catatan kecurangan
    Route::post('/cheating-logs', [CheatingLogController::class, 'store']);     // 🔹 Simpan catatan kecurangan
    Route::put('/cheating-logs/{id}', [CheatingLogController::class, 'update']); // 🔹 Update catatan kecurangan
    Route::delete('/cheating-logs/{id}', [CheatingLogController::class, 'destroy']); // 🔹 Hapus catatan kecurangan
});
