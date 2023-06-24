<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\AddCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request) {
        $data = Category::get();
        return view('pages.Category.category', [
            'data' => $data,
        ]);
    }

    public function store(AddCategoryRequest $request) {
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return redirect()->route('category.index')->with(['message' => 'Add category successfully!']);
    }
    public function edit(Category $category) {
        return view('pages.Category.edit_category', [
            'data' => $category
        ]);
    }
    public function update(UpdateCategoryRequest $request) {
        Category::findOrFail($request->id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return redirect()->route('category.index')->with(['message' => 'Update category successfully!']);
    }
}
