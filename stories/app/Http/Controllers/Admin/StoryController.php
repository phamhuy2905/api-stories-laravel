<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Story\AddStoryRequest;
use App\Http\Requests\Story\UpdateStoryRequest;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Review;
use App\Models\Story;
use Illuminate\Support\Str;
use Image;

class StoryController extends Controller
{
    public function index() {
        $data = Story::get();
        return view('pages.Story.story', [
            'data' => $data,
        ]);
    }

    public function add() {
        $publisher = Publisher::get();
        $category = Category::get();
        return view('pages.Story.add_story', [
            'publisher' => $publisher,
            'category' => $category
        ]);
    }

    public function store(AddStoryRequest $request) {
        $image = $request->thumbnail;
        $trailer = $request->trailer;
        $name_general_trailer = hexdec(uniqid()).'.'.$trailer->getClientOriginalExtension();
        $name_general = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $url= 'img/story/'.$name_general;
        $url_trailer= 'video/story/'.$name_general_trailer;
        $data =  Story::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'name_author' => $request->name_author,
            'thumbnail' => $url,
            'trailer' => $url_trailer,
            'description_short' => $request->description_short,
            'description_long' => $request->description_long,
            'description_long' => $request->description_long,
            'publisher_id' => $request->publisher_id,
            'category_id' => $request->category_id,
        ]);
       
        Image::make($image)->resize(320,480)->save($url);
        $trailer->move(public_path('video/story'), $name_general_trailer);
        return redirect()->route('story.index')->with(['message' => 'Add story successfully!']);
    }

    public function edit(Story $story) {
        $publisher = Publisher::get();
        $category = Category::get();
        return view('pages.Story.edit_story', [
            'data' => $story,
            'publisher' => $publisher,
            'category' => $category
        ]);
    }

    public function update(UpdateStoryRequest $request) {
        $thumbnail_current = $request->thumbnail_current;
        $trailer_current = $request->trailer_current;
        $url = null;
        $url_trailer = null;
        if($request->thumbnail) {
            $thumbnail = $request->thumbnail;
            $name_general = hexdec(uniqid()).'.'.$thumbnail->getClientOriginalExtension();
            $url= 'img/story/'.$name_general;
            Image::make($thumbnail)->resize(320,480)->save($url);
            if(file_exists($thumbnail_current)) {
                unlink($thumbnail_current);
            }
        }
        if($request->trailer) {
            $trailer = $request->trailer;
            $name_general = hexdec(uniqid()).'.'.$trailer->getClientOriginalExtension();
            $url_trailer= 'video/story/'.$name_general;
            if(file_exists($trailer_current)) {
                unlink($trailer_current);
            }
            $trailer->move(public_path('video/story'), $name_general);
        }
        Story::findOrFail($request->id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'name_author' => $request->name_author,
            'thumbnail' => $url ?? $thumbnail_current,
            'trailer' => $url_trailer ?? $trailer_current,
            'description_short' => $request->description_short,
            'description_long' => $request->description_long,
            'description_long' => $request->description_long,
            'publisher_id' => $request->publisher_id,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('story.index')->with(['message' => 'Update story successfully!']);
    }

    public function destroy($id) {
        Story::findOrFail($id)->update([
            'isDeleted' => 1
        ]);
        return redirect()->route('story.index')->with(['message' => 'Delete story successfully!']);
    }

    public function detail(Story $story) {
        $data = Story::where('id', $story->id)
        ->with('category:id,name')
        ->with('publisher:id,name')
        ->get()->first();

        return view('pages.Story.detail_story', [
            'data' => $data,
        ]);
    }
}
