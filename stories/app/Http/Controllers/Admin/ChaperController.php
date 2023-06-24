<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chaper\AddChaperRequest;
use App\Http\Requests\Chaper\UpdateChaperRequest;
use App\Models\Chaper;
use App\Models\Story;
use Illuminate\Support\Str;
use Image;

class ChaperController extends Controller
{
    public function index() {
        $data = Chaper::with('story:id,name')
        ->get();
        return view('pages.Chaper.chaper', [
            'data' => $data,
        ]);
    }

    public function add() {
        $story = Story::get();
        return view('pages.Chaper.add_chaper', [
            'story' => $story,
        ]);
    }

    public function store(AddChaperRequest $request) {
        $image = $request->thumbnail;
        $name_general = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $url= 'img/chaper/'.$name_general;
        Chaper::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'thumbnail' => $url,
            'description' => $request->description,
            'story_id' => $request->story_id,
        ]);
        Image::make($image)->resize(500,500)->save($url);
        return redirect()->route('chaper.index')->with(['message' => 'Add chaper successfully!']);
    }

    public function edit(Chaper $chaper) {
        $story = Story::get();
        return view('pages.Chaper.edit_chaper', [
            'data' => $chaper,
            'story' => $story,
        ]);
    }

    public function update(UpdateChaperRequest $request) {

        if($request->thumbnail) {
            $thumbnail_current = $request->thumbnail_current;
            $thumbnail = $request->thumbnail;
            $name_general = hexdec(uniqid()).'.'.$thumbnail->getClientOriginalExtension();
            $url= 'img/chaper/'.$name_general;
            if(file_exists($thumbnail_current)) {
                unlink($thumbnail_current);
            }
            Chaper::findOrFail($request->id)->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'thumbnail' => $url,
                'description' => $request->description,
                'story_id' => $request->story_id,
            ]);
            Image::make($thumbnail)->resize(300,300)->save($url);
        }

        else {
            Chaper::findOrFail($request->id)->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'story_id' => $request->story_id,
            ]);
        }
        return redirect()->route('chaper.index')->with(['message' => 'Update chaper successfully!']);
    }

    public function destroy($id) {
        Chaper::findOrFail($id)->update([
            'isDeleted' => 1
        ]);
        return redirect()->route('chaper.index')->with(['message' => 'Delete chaper successfully!']);
    }

    public function detail(Chaper $chaper) {
        $data = Chaper::where('id', $chaper->id)
        ->with('story:id,name')
        ->get()->first();

        return view('pages.Chaper.detail_chaper', [
            'data' => $data,
        ]);
    }
}
