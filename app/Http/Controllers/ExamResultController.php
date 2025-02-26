<?php

namespace App\Http\Controllers;

use App\Models\ExamResult;
use App\Models\CheatingLog;
use App\Models\StudentAnswer;
use Illuminate\Http\Request;

class ExamResultController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
        ]);

        $studentId = auth()->id();
        $examId = $request->exam_id;

        $correctAnswers = StudentAnswer::where('student_id', $studentId)
            ->where('exam_id', $examId)
            ->whereHas('choice', function ($query) {
                $query->where('is_correct', true);
            })
            ->count();

        $totalQuestions = StudentAnswer::where('student_id', $studentId)
            ->where('exam_id', $examId)
            ->count();

        $score = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;

        $cheatingScore = CheatingLog::where('student_id', $studentId)
            ->where('exam_id', $examId)
            ->count() * 10;

        $status = $cheatingScore >= 50 ? 'disqualified' : 'completed';

        $examResult = ExamResult::create([
            'student_id' => $studentId,
            'exam_id' => $examId,
            'score' => $score,
            'cheating_score' => $cheatingScore,
            'status' => $status,
        ]);

        return response()->json([
            'message' => 'Exam result saved successfully',
            'exam_result' => $examResult
        ], 201);
    }


    // ✅ Ambil hasil ujian untuk siswa tertentu
    public function index(Request $request)
    {
        try {
            $request->validate([
                'exam_id' => 'required|exists:exams,id',
            ]);

            $studentId = auth()->id();
            $examId = $request->exam_id;

            $result = ExamResult::where('exam_id', $examId)
                ->where('student_id', $studentId)
                ->first();

            if (!$result) {
                return response()->json(['message' => 'Exam result not found'], 404);
            }

            return response()->json(['exam_result' => $result]);
        } catch (\Exception $e) {
            Log::error('❌ Error fetching exam result: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    // ✅ Tampilkan detail hasil ujian berdasarkan ID
    public function show($id)
    {
        try {
            $result = ExamResult::findOrFail($id);
            return response()->json(['exam_result' => $result]);
        } catch (\Exception $e) {
            Log::error('❌ Error fetching exam result: ' . $e->getMessage());
            return response()->json(['error' => 'Exam result not found'], 404);
        }
    }
    
    public function destroy($id)
{
    $result = ExamResult::findOrFail($id);
    $result->delete();

    return response()->json(['message' => 'Exam result deleted successfully']);
}

}
