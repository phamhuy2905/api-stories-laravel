<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Mail\ForgotPasswordMail;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Image;


class AuthController extends Controller
{
    public function Login(Request $request) {
        try {
            if(Auth::attempt($request->only('email','password'))) {
                $user = Auth::user();
                $token = $user->createToken('app')->accessToken;
                return response([
                    'status' => 200,
                    'message' => 'Login successfull!',
                    'token' => $token,
                    'user' => $user,
                ],200);
            }
        } catch (\Throwable $err) {
            return response([
                'status' => 401,
                'message' => $err->getMessage()
            ], 401);
        }

        return response([
            'message' => 'Email or password incorrect!'
        ],400);
    }

    public function Register(RegisterRequest $request) {
        try {
           $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
           ]);

           return response([
            'message' => 'Register successfully!',
            'user' => $user,
        ],200);

        } catch (\Throwable $err) {
            return response([
                'status' => 401,
                'message' => $err->getMessage()
            ], 401);
        }
    }
    public function verify() {
        $user = Auth::guard('api')->user();
        if($user) {
            return response()->json(['data' => $user]);
        }
        return response([
            'status' => 401,
            'message' => 'Unauthorized'
        ], 401);
    }

    public function forgotPassword(Request $request) {
        $data = User::where('email', $request->email)->get()->first();
        if(!$data) {
            return response([
                'status' => 400,
                'message' => 'Email incorrect!'
            ], 400);
        }
        $random = mt_rand(10000, 100000);
        User::where('email', $request->email)->update(['pass_forgot' => $random]);
        Mail::to($request->email)->send(new ForgotPasswordMail($random));
        return response()->json([
            'success' => true,
            'message' => "Please check mail!"
        ], 200);
    }

    public function vefiryForgotPassword(Request $request) {
        $data = User::where('pass_forgot', $request->pass_forgot)->get()->first();
        if(!$data){
            return response([
                'status' => 400,
                'message' => 'Pass forgot incorrect!'
            ], 400);
        }
        User::where('pass_forgot', $request->pass_forgot)->update([
            'pass_forgot' => null,
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Success!',
        ], 200);
    }

    public function updateProfile(UpdateProfileRequest $request) {
        $user = Auth::guard('api')->user();
        if(!$user) {
            return response([
                'status' => 401,
                'message' => 'Unauthorized'
            ], 401);
        }
        if($request->avatar) {
            $name_general = hexdec(uniqid()).'.'.$request->avatar->getClientOriginalExtension();
            $url= 'img/user/'.$name_general;
            Image::make($request->avatar)->resize(100,100)->save($url);
            User::findOrFail($user->id)
            ->update([
                'name' => $request->name,
                'avatar' => $url,
            ]);
        }
        else {
            User::findOrFail($user->id)
            ->update([
                'name' => $request->name,
            ]);
        }
        return response()->json([
            'success' => true,
        ], 200);
        
    }

    public function UpdatePassword(UpdatePasswordRequest $request) {
        $user = Auth::guard('api')->user();
        if(!$user) {
            return response([
                'status' => 401,
                'message' => 'Unauthorized'
            ], 401);
        }

        $data = User::where('id', $user->id)
        ->get()->first();
        $check = Hash::check($request->current_password, $data->password);
        if(!$check) {
            return response()->json([
                'success' => false,
                'message' => 'Current password incorrect!!',
            ], 401);
        }
        $data = User::findOrFail($user->id)
        ->update([
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Update password successfully!',
        ], 200);
    }
}
