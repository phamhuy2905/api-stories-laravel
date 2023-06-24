<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function Login() {
        if(auth()->id()) {
            return redirect()->back();
        }
        return view('pages.login');
    }
    public function ProcessLogin(Request $request) {
        if(!Auth::attempt($request->only('email','password'))) {
            return redirect()->route('auth.login')->with([
                'message' => "Email or password incorrect!"
            ]);
        }
        return redirect()->intended('/home');
    }
    public function logout() {
        
        Auth::logout();
        return redirect()->route('auth.login');
    }
}

// DB::connection()->getPdo();