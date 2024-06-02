<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Quiz;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    private $correctAnswers = [
        'level_1_answers' => ['c', 'b', 'a'],
        'level_2_answers' => ['a', 'c', 'b'],
        'level_3_answers' => ['b', 'a', 'c'],
    ];

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

        return response()->json($this->calculateScore($answer, 'level_1_answers', 1), 201);
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

        return response()->json($this->calculateScore($answer, 'level_2_answers', 2), 201);
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

        return response()->json($this->calculateScore($answer, 'level_3_answers', 3), 201);
    }


    private function calculateScore(Answer $answer, $level, $levelNumber)
    {
        $result = [
            'score' => 0,
            'wrong_answers' => []
        ];

        if (!empty($answer->$level)) {
            $userAnswers = $answer->$level;
            $correctAnswers = $this->correctAnswers[$level];
            $totalQuestions = count($correctAnswers);
            $correctCount = 0;

            $questions = Quiz::where('id', $levelNumber)->first()->questions;

            foreach ($userAnswers as $index => $userAnswer) {
                if (isset($correctAnswers[$index]) && $userAnswer === $correctAnswers[$index]) {
                    $correctCount++;
                } else {
                    $result['wrong_answers'][] =
                        // 'level' => $level,
                        $questions[$index] ?? null;
                    // 'question_index' => $index,
                    // 'user_answer' => $userAnswer,
                    // 'correct_answer' => $correctAnswers[$index] ?? null
                    ;

                }
            }

            $result['score'] = $correctCount;
        }

        return $result;
    }

    public function show($id)
    {
        $answer = Answer::find($id);

        if (!$answer) {
            return response()->json(['message' => 'Answer not found'], 404);
        }

        return response()->json($answer);
    }

    public function getProgress($userId)
    {
        $answer = Answer::where('user_id', $userId)->first();

        $progress = [1, 0, 0];

        if ($answer) {
            if (!empty($answer->level_1_answers)) {
                $progress[1] = 1;
            }
            if (!empty($answer->level_2_answers)) {
                $progress[2] = 1;
            }
        }

        return response()->json(['data' => $progress]);
    }
}
