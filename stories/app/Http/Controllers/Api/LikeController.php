<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Like\HandelLikeRequest;
use App\Http\Requests\Like\UpdateLikeRequest;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function get($id) {
        $data = Like::where('story_id', $id)
        ->where('likes.isDeleted', false)
        ->join('users', 'likes.user_id', 'users.id')
        ->addSelect('likes.*')
        ->addSelect('users.name')
        ->get();
        return response()->json([
            'success' => true,
            'data' => $data,
        ], 200);
    }

    public function test(HandelLikeRequest $request) {

        $user = Auth::guard('api')->user();
        if(!$user) {
            return response([
                'status' => 401,
                'message' => 'Unauthorized'
            ], 401);
        }
        try {
            $data = Like::where('user_id',$user->id)
            ->where('story_id', $request->story_id);
            $check = $data->where('type', $request->type)->get()->first();
            if($check) {
                Like::where('user_id',$user->id)
                ->where('story_id', $request->story_id)
                ->update(['isDeleted' => !$check->isDeleted]);

                $check = Like::where('user_id',$user->id)
                ->where('story_id', $request->story_id)
                ->get()->first();
                return response()->json([
                    'success' => true,
                    'data' => $check
                ], 200);
            }
            $data = Like::where('user_id',$user->id)
            ->where('story_id', $request->story_id)->get()->first();
            if($data) {
                  Like::where('user_id',$user->id)
                ->where('story_id', $request->story_id)
                ->update(['type' => $request->type, 'isDeleted' => false]);
            }
            else {
                Like::create([
                    'user_id' => $user->id,
                    'story_id' => $request->story_id,
                    'type' => $request->type,
                ]);
            }
            return response()->json([
                'success' => true,
                'data' => $data
            ], 200);
        } catch (\Throwable $err) {
            return response([
                'status' => 403,
                'message' => 'Your action is Forbidden!'
            ], 403);
        }
    }
}




// $user = Auth::guard('api')->user();
//         if(!$user) {
//             return response([
//                 'status' => 401,
//                 'message' => 'Unauthorized'
//             ], 401);
//         }
//         $id_user_exists = Like::where('user_id', $request->user_id)
//         ->where('review_id', $request->review_id)
//         ->get()->count();
//         if($id_user_exists > 1) {
//             dd('exist');
//             return response()->json([
//                 'success' => false,
//                 'message' => "Id reviews is unique"
//             ], 400);
//         }
//         $data = null;
//         if(!$id_user_exists) {
//             $data = Like::create([
//                 'user_id' => $request->user_id,
//                 'review_id' => $request->review_id,
//                 'type' => $request->type
//             ]);
//         }
//         else {
//             Like::findOrFail($request->id)->update([
//                 'type' => $request->type
//             ]);
//             $data = Like::where('id', $request->id)->get()->first();
//         }
//         return response()->json([
//             'success' => true,
//             'data' => $data
//         ], 200);