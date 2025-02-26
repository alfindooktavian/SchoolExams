<?php

namespace App\Http\Controllers;

use App\Models\StudentAnswer;
use Illuminate\Http\Request;

class StudentAnswerController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'question_id' => 'required|exists:questions,id',
            'choice_id' => 'nullable|exists:choices,id',
            'answer' => 'nullable|string'
        ]);

        $answer = StudentAnswer::create([
            'student_id' => auth()->id(),
            'exam_id' => $request->exam_id,
            'question_id' => $request->question_id,
            'choice_id' => $request->choice_id,
            'answer' => $request->answer
        ]);

        return response()->json([
            'message' => 'Answer saved successfully',
            'answer' => $answer
        ], 201);
    }

    public function index(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id'
        ]);

        $answers = StudentAnswer::where('exam_id', $request->exam_id)
            ->where('student_id', auth()->id())
            ->get();

        return response()->json([
            'message' => 'Answers retrieved successfully',
            'answers' => $answers
        ]);
    }
    public function destroy($id)
{
    $answer = StudentAnswer::findOrFail($id);
    $answer->delete();

    return response()->json(['message' => 'Student answer deleted successfully']);
}

}
