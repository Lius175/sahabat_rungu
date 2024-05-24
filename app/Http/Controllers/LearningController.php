<?php

namespace App\Http\Controllers;

use App\Models\Learning;
use Illuminate\Http\Request;

class LearningController extends Controller
{
    public function show($id)
    {
        $learning = Learning::findOrFail($id);

        // Check if 'description' and 'video' are already arrays
        $description = is_string($learning->description) ? json_decode($learning->description) : $learning->description;
        $video = is_string($learning->video) ? json_decode($learning->video) : $learning->video;

        return response()->json([
            'id' => $learning->id,
            'title' => $learning->title,
            'description' => $description,
            'video' => $video
        ]);
    }
}


