<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Publisher\AddPublisherRequest;
use App\Http\Requests\Publisher\UpdatePublisherRequest;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublisherController extends Controller
{
    public function index(Request $request) {
        $data = Publisher::get();
        return view('pages.Publisher.publisher', [
            'data' => $data,
        ]);
    }

    public function store(AddPublisherRequest $request) {
        $data = Publisher::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return redirect()->route('publisher.index')->with(['message' => 'Add publisher successfully!']);
    }
    public function edit(Publisher $publisher) {
        return view('pages.Publisher.edit_publisher', [
            'data' => $publisher
        ]);
    }
    public function update(UpdatePublisherRequest $request) {
        Publisher::findOrFail($request->id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return redirect()->route('publisher.index')->with(['message' => 'Update publisher successfully!']);
    }
}
