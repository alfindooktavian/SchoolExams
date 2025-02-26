<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'question_text' => 'required|string',
            'type' => 'required|in:multiple_choice,essay',
        ]);

        $question = Question::create($request->all());
        return response()->json($question, 201);
    }

    public function index(Request $request) {
        return response()->json(Question::where('exam_id', $request->exam_id)->with('choices')->get());
    }


    
    public function destroy($id)
{
    $question = Question::findOrFail($id);
    $question->delete();

    return response()->json(['message' => 'Question deleted successfully']);
}

}
