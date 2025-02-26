<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya pengguna yang sudah login yang dapat mengakses
        $this->middleware('auth:sanctum');
    }

    // ✅ CREATE EXAM (Guru Saja)
    public function store(Request $request)
    {
        try {
            if (Auth::user()->role !== 'guru') {
                return response()->json(['message' => 'Only teachers can create exams'], 403);
            }

            // ✅ Debug log untuk melihat data yang masuk dari frontend/Postman
            \Log::info('Received Exam Data:', $request->all());

            // ✅ Validasi request
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'duration' => 'required|integer|min:1'
            ]);

            // ✅ Simpan ujian ke database
            $exam = Exam::create([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'] ?? null, // Pastikan null jika kosong
                'duration' => $validatedData['duration'], 
                'guru_id' => auth()->id()
            ]);

            return response()->json([
                'message' => 'Exam created successfully',
                'exam' => $exam
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create exam',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ✅ LIST EXAMS (Siswa & Guru)
    public function index()
    {
        try {
            $exams = Exam::all();

            return response()->json([
                'message' => 'Exams retrieved successfully',
                'exams' => $exams
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve exams',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ✅ SHOW EXAM DETAILS (Siswa & Guru)
    public function show($id)
    {
        try {
            $exam = Exam::findOrFail($id);

            return response()->json([
                'message' => 'Exam retrieved successfully',
                'exam' => $exam
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve exam',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ✅ UPDATE EXAM (Guru Saja)
    public function update(Request $request, $id)
    {
        try {
            if (Auth::user()->role !== 'guru') {
                return response()->json(['message' => 'Only teachers can update exams'], 403);
            }

            $exam = Exam::findOrFail($id);

            $validatedData = $request->validate([
                'title' => 'string|max:255',
                'description' => 'nullable|string',
                'duration' => 'integer|min:1'
            ]);

            $exam->update([
                'title' => $validatedData['title'] ?? $exam->title,
                'description' => $validatedData['description'] ?? $exam->description,
                'duration' => $validatedData['duration'] ?? $exam->duration,
            ]);

            return response()->json([
                'message' => 'Exam updated successfully',
                'exam' => $exam
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update exam',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ✅ DELETE EXAM (Guru Saja)
    public function destroy($id)
    {
        try {
            if (Auth::user()->role !== 'guru') {
                return response()->json(['message' => 'Only teachers can delete exams'], 403);
            }

            $exam = Exam::findOrFail($id);
            $exam->delete();

            return response()->json(['message' => 'Exam deleted successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete exam',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
