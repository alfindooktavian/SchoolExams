<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use Illuminate\Http\Request;

class ChoiceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'choice_text' => 'required|string',
            'is_correct' => 'required|boolean'
        ]);

        $choice = Choice::create($request->all());

        return response()->json([
            'message' => 'Choice added successfully',
            'choice' => $choice
        ], 201);
    }

    public function index(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id'
        ]);

        $choices = Choice::where('question_id', $request->question_id)->get();

        return response()->json([
            'message' => 'Choices retrieved successfully',
            'choices' => $choices
        ]);
    }
    public function destroy($id)
{
    $choice = Choice::findOrFail($id);
    $choice->delete();

    return response()->json(['message' => 'Choice deleted successfully']);
}

}
