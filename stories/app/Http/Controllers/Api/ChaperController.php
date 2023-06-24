<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chaper;

class ChaperController extends Controller
{
    public function index($slug, $chaper) {
        $data = Chaper::join('stories', 'chapers.story_id', '=', 'stories.id')
        ->select('chapers.*', 'stories.name as story_name', 'stories.id as story_id')
        ->where('stories.slug', $slug)
        ->where('chapers.slug', $chaper)
        ->get()->first();

        $page = Chaper::select('chapers.slug')
        ->join('stories', 'chapers.story_id', '=', 'stories.id')
        ->where('stories.slug',$slug)
        ->get();
        $next_page = $page->where('slug', '>', $data->slug)->first();
        $pre_page = $page->where('slug', '<', $data->slug)->last();
        $data->next_page = $next_page->slug ?? null;
        $data->pre_page = $pre_page->slug ?? null;
        return response()->json([
            'success' => true,
            'data' => $data,
            'pages' => $page
        ], 200);
    }
}
