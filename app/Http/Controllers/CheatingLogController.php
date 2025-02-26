<?php

namespace App\Http\Controllers;

use App\Models\CheatingLog;
use Illuminate\Http\Request;

class CheatingLogController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'cheating_type' => 'required|in:tab_switch,screen_sharing,copy_paste_attempt,dev_tools_access',
        ]);

        CheatingLog::create([
            'student_id' => auth()->id(),
            'exam_id' => $request->exam_id,
            'cheating_type' => $request->cheating_type,
        ]);

        return response()->json(['message' => 'Cheating attempt recorded']);
    }
    public function destroy($id)
{
    $cheatingLog = CheatingLog::findOrFail($id);
    $cheatingLog->delete();

    return response()->json(['message' => 'Cheating log deleted successfully']);
}

}

