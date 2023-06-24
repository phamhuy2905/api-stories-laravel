<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    function index() {
        $data = Story::orWhere('name','like','%','')
        ->with('category:id,name')
        ->with('publisher:id,name')
        ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    function detail($slug) {
        $data = Story::where('slug',$slug)
        ->with('category:id,name')
        ->with('publisher:id,name')
        ->get()->first();

        $firt_chaper = Story::where('stories.slug',$slug)
        ->join('chapers', 'stories.id', 'chapers.story_id')
        ->Addselect('stories.thumbnail','stories.trailer' )
        ->Addselect('chapers.slug')
        ->get()->first();
        $data->firt_chaper = $firt_chaper->slug ?? null;
        
        return response()->json([
            'success' => true,
            'data' => $data,
        ], 200);
    }
    function search(Request $request) {
        $name = $request->query('name');
        $data = Story::where('name','like',"%$name%")
        ->with('category:id,name')
        ->with('publisher:id,name')
        ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }
}
