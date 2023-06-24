<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Save\DestroySaveRequest;
use App\Http\Requests\Save\HandelSaveRequest;
use App\Models\Save;
use Illuminate\Support\Facades\Auth;

class SaveController extends Controller
{
    public function index() {
        $user = Auth::guard('api')->user();
        if(!$user) {
            return response([
                'status' => 401,
                'message' => 'Unauthorized'
            ], 401);
        }

        $data = Save::join('stories', 'saves.story_id', 'stories.id')
        ->join('chapers', 'saves.chaper_id', 'chapers.id')
        ->addSelect(['stories.id as story_id','stories.name as name_story', 'stories.slug as slug_story', 'stories.thumbnail'])
        ->addSelect(['chapers.name as name_chaper', 'chapers.slug as slug_chaper'])
        ->addSelect(['saves.name as name_save'])
        ->where('saves.user_id', $user->id)
        ->where('saves.isDeleted',false)
        ->get();

        $data = $data->map(function ($each) {
            $each->thumbnail = "http://127.0.0.1:8000/" . $each->thumbnail;
            return $each;
        });
        
        return response()->json([
            'success' => true,
            'data' => $data,
        ], 200);
    }
    public function handel(HandelSaveRequest $request) {
        $user = Auth::guard('api')->user();
        if(!$user) {
            return response([
                'status' => 401,
                'message' => 'Unauthorized'
            ], 401);
        }

        try {
            $check = Save::where('story_id', $request->story_id)
            ->where('user_id', $user->id)
            ->where('chaper_id', $request->chaper_id)
            ->where('isDeleted', false)
            ->get()->first();

            if($check) {
                Save::where('story_id', $request->story_id)
                ->where('user_id', $user->id)
                ->update(['isDeleted' => true, ]);
            }

            $data = Save::where('story_id', $request->story_id)
            ->where('user_id', $user->id)
            ->get()->first();
            if($data) {
                Save::where('story_id', $request->story_id)
                ->where('user_id', $user->id)
                ->update([
                    'name' => $request->name ?? "",
                    'chaper_id' => $request->chaper_id,
                    'isDeleted' => false, 
                ]);
                return response()->json([
                    'success' => true,
                ], 200);
            }
            else {
                Save::create([
                    'story_id' => $request->story_id,
                    'user_id' => $user->id,
                    'name' => $request->name ?? "",
                    'chaper_id' => $request->chaper_id,
                ]);
            }

            return response()->json([
                'success' => true,
            ], 200);
        } catch (\Throwable $err) {
            return response([
                'status' => 400,
                'message' => $err->getMessage()
            ], 400);
        }

    }
    public function detail($storyId) {
        $user = Auth::guard('api')->user();
        if(!$user) {
            return response([
                'status' => 401,
                'message' => 'Unauthorized'
            ], 401);
        }
        $data = Save::join('stories', 'saves.story_id', 'stories.id')
        ->join('chapers', 'saves.chaper_id', 'chapers.id')
        ->addSelect(['stories.name as name_story', 'stories.slug as slug_story', 'stories.thumbnail'])
        ->addSelect(['chapers.name as name_chaper', 'chapers.slug as slug_chaper'])
        ->where('saves.story_id', $storyId)
        ->where('saves.user_id', $user->id)
        ->where('saves.isDeleted', false)
        ->get()->first();
        if(isset($data->thumbnail)) {
            $data->thumbnail = 'http://127.0.0.1:8000/' . $data->thumbnail;
        }
        return response()->json([
            'success' => true,
            'data' => $data,
        ], 200);
    }

    public function destroy(DestroySaveRequest $request) {

        $user = Auth::guard('api')->user();
        if(!$user) {
            return response([
                'status' => 401,
                'message' => 'Unauthorized'
            ], 401);
        }

        Save::where('story_id', $request->story_id)
        ->where('user_id', $user->id)
        ->update([
            'isDeleted' => true,
        ]);

        return response()->json([
            'success' => true,
        ], 200);
    }
}
