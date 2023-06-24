<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\AddCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index($idStory, $page = 1) {
        $current_page = $page;
        $totalComment = $page * 10;
        // $user = Auth::guard('api')->user();
        // if(!$user) {
        //     return response([
        //         'status' => 401,
        //         'message' => 'Unauthorized'
        //     ], 401);
        // }

        $data = Comment::join('users', 'comments.user_id', 'users.id')
        ->addSelect('comments.*')
        ->addSelect('users.name')
        ->orderBy('id', 'desc')
        ->where('story_id', $idStory)
        ->where('comments.isDeleted', false)
        ->get();
        $next_page = null;
        if(count($data) > $totalComment) {
            $data = $data->take($totalComment);
            $next_page = $page + 1;
        }
        return response()->json([
            'success' => true,
            'data' => $data,
            'next_page' => $next_page,
        ]);
    }
    public function store(AddCommentRequest $request) {
        $user = Auth::guard('api')->user();
        if(!$user) {
            return response([
                'status' => 401,
                'message' => 'Unauthorized'
            ], 401);
        }
        try {
            $data = Comment::create([
                'user_id' => $user->id,
                'story_id' => $request->story_id,
                'comment' => $request->comment,
            ]);
            return response()->json([
                'success' => true,
                'data' => $data
            ], 201);
        } catch (\Throwable $err) {
            return response([
                'status' => 401,
                'message' => $err->getMessage()
            ], 401);
        }
    }
    public function update(UpdateCommentRequest $request) {
        $user = Auth::guard('api')->user();
        if(!$user) {
            return response([
                'status' => 401,
                'message' => 'Unauthorized'
            ], 401);
        }

        try {
            Comment::findOrFail($request->id)
            ->update(['comment' => $request->comment]);
            return response()->json([
                'success' => true,
            ], 200);
        } catch (\Throwable $err) {
            return response([
                'status' => 401,
                'message' => $err->getMessage()
            ], 401);
        }
    }
    public function destroy(Request $request) {
        $user = Auth::guard('api')->user();
        if(!$user) {
            return response([
                'status' => 401,
                'message' => 'Unauthorized'
            ], 401);
        }

        try {
            Comment::findOrFail($request->id)
            ->update(['isDeleted' => true]);
            return response()->json([
                'success' => true,
            ], 200);
        } catch (\Throwable $err) {
            return response([
                'status' => 401,
                'message' => $err->getMessage()
            ], 401);
        }
    }
}
