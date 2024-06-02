<?php

namespace App\Http\Controllers;

use App\Models\UserLearning;
use Illuminate\Http\Request;

class UserLearningController extends Controller
{
    public function markAsCompleted(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'learning_id' => 'required|exists:learnings,id',
        ]);

        $userLearning = UserLearning::firstOrCreate(
            ['user_id' => $request->user_id],
            ['completed_learning_ids' => []]
        );

        $completedIds = $userLearning->completed_learning_ids;

        if (!in_array($request->learning_id, $completedIds)) {
            $completedIds[] = $request->learning_id;
            $userLearning->completed_learning_ids = $completedIds;
            $userLearning->save();
        }

        return response()->json([
            'message' => 'Learning Completed',
            'status' => 200
        ], 200);
    }



    public function getProgress($user_id)
    {
        $userLearning = UserLearning::where('user_id', $user_id)->first();

        if (!$userLearning) {
            return response()->json([
                'user_id' => $user_id,
                'progress' => 0,
                'progressArray' => [0, 0, 0]
            ], 200);
        }

        $completedLearningIds = $userLearning->completed_learning_ids ?? [];

        $totalLearnings = 3;
        $completedCount = count($completedLearningIds);
        $progress = ($completedCount / $totalLearnings) * 100;
        $formattedProgress = number_format($progress, 2);

        // Calculate the progress array
        $progressArray = array_fill(0, $totalLearnings, 0);

        foreach ($completedLearningIds as $id) {
            if ($id <= $totalLearnings) {
                $progressArray[$id - 1] = 1;
            }
        }

        return response()->json([
            'user_id' => $user_id,
            'progress' => $formattedProgress,
            'progressArray' => $progressArray
        ], 200);
    }
}
