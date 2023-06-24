<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        $id = auth()->id();
        $data = User::select('name', 'id','email')->where('id', $id)->get()->first();
        return view('pages.home', [
            'data' => $data,
        ]);
    }
}
