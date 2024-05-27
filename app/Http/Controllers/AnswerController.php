<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function show($id)
    {
        $answer = Answer::find($id);

        if (!$answer) {
            return response()->json(['message' => 'Answer not found'], 404);
        }

        return response()->json($answer);
    }

    public function storeLevel1(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'level_1_answers' => 'required|array',
            'level_1_answers.*' => 'string',
        ]);

        $answer = Answer::updateOrCreate(
            ['user_id' => $request->user_id],
            ['level_1_answers' => $request->level_1_answers]
        );

        return response()->json($answer, 201);
    }

    public function storeLevel2(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'level_2_answers' => 'required|array',
            'level_2_answers.*' => 'string',
        ]);

        $answer = Answer::updateOrCreate(
            ['user_id' => $request->user_id],
            ['level_2_answers' => $request->level_2_answers]
        );

        return response()->json($answer, 201);
    }

    public function storeLevel3(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'level_3_answers' => 'required|array',
            'level_3_answers.*' => 'string',
        ]);

        $answer = Answer::updateOrCreate(
            ['user_id' => $request->user_id],
            ['level_3_answers' => $request->level_3_answers]
        );

        return response()->json($answer, 201);
    }
}
