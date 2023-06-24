<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function index() {
        $data = Category::orWhere('name','like','%','')->skip(0)->take(7)->get();
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }
}
