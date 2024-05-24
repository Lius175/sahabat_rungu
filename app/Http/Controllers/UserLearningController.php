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
        // Fetch the user's learning record
        $userLearning = UserLearning::where('user_id', $user_id)->first();

        // If no record exists, the user has no progress
        if (!$userLearning) {
            return response()->json([
                'user_id' => $user_id,
                'progress' => number_format(0, 2)
            ]);
        }

        // Get the completed learning IDs array
        $completedLearningIds = $userLearning->completed_learning_ids ?? [];

        // Calculate the progress percentage
        $totalLearnings = 3; // Assuming 3 as the total number of learnings
        $completedCount = count($completedLearningIds);
        $progress = ($completedCount / $totalLearnings) * 100;

        $formattedProgress = number_format($progress, 2);

        return response()->json([
            'user_id' => $user_id,
            'progress' => $formattedProgress
        ]);
    }
}
