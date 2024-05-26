<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ForumController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $forum = new Forum([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user_id,
        ]);

        $forum->save();

        return response()->json([
            'message' => 'Forum post created successfully.',
            'forum' => [
                'id' => $forum->id,
                'title' => $forum->title,
                'description' => $forum->description,
                'user_id' => $forum->user_id,
                'created_at' => Carbon::parse($forum->created_at)->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::parse($forum->updated_at)->format('Y-m-d H:i:s'),
                'author_name' => $forum->user->name,
            ]
        ], 201);
    }

    public function index()
    {
        $forums = Forum::with('user')
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($forum) {
                return [
                    'id' => $forum->id,
                    'title' => $forum->title,
                    'description' => $forum->description,
                    'user_id' => $forum->user_id,
                    'created_at' => Carbon::parse($forum->created_at)->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::parse($forum->updated_at)->format('Y-m-d H:i:s'),
                    'author_name' => $forum->user->name,
                    'author_email' => $forum->user->email,
                ];
            });

        return response()->json([
            'data' => $forums
        ]);
    }

    public function show($id)
    {
        $forum = Forum::with(['user', 'replies.user'])->findOrFail($id);

        $forumData =
            $forum->replies->map(function ($reply) {
                return [
                    'id' => $reply->id,
                    'description' => $reply->description,
                    'user_id' => $reply->user_id,
                    'created_at' => Carbon::parse($reply->created_at)->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::parse($reply->updated_at)->format('Y-m-d H:i:s'),
                    'author_name' => $reply->user->name,
                    'author_email' => $reply->user->email,
                ];
            });

        return response()->json([
            'data' => $forumData
        ]);
    }


    public function storeReply(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'forum_id' => 'required|exists:forum,id',
        ]);

        $reply = new Reply([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'forum_id' => $request->forum_id,
        ]);

        $reply->save();

        $user = User::find($request->user_id);

        return response()->json([
            'message' => 'Reply successfully added',
            'status' => 200
        ], 201);
    }

}





