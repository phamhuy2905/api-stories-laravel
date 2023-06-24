<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ChaperController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\SaveController;
use App\Http\Controllers\Api\StoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::controller(AuthController::class)->group(function() {
//     Route::post('verify', 'verify');
// })->middleware('auth:api');


Route::group(['prefix' => '', 'as' => ''],function() {
    Route::post('verify', [AuthController::class, 'verify']);
    Route::post('updateProfile', [AuthController::class, 'updateProfile']);
    Route::post('updatePassword', [AuthController::class, 'UpdatePassword']);


    Route::get('like/{id}', [LikeController::class, 'get']);
    Route::post('like/handel', [LikeController::class, 'test']);
})->middleware('auth:api');

Route::group(['prefix' => 'v1/comment'], function() {
    Route::get('/{idStory}/{page}', [CommentController::class, 'index']);
    Route::post('/store', [CommentController::class, 'store']);
    Route::post('/update', [CommentController::class, 'update']);
    Route::post('/destroy', [CommentController::class, 'destroy']);
})->middleware('auth:api');

Route::group(['prefix' => 'v1/save'], function() {
    Route::get('/', [SaveController::class, 'index']);
    Route::post('/handel', [SaveController::class, 'handel']);
    Route::post('/destroy', [SaveController::class, 'destroy']);
    Route::get('/detail/{storyId}', [SaveController::class, 'detail']);
})->middleware('auth:api');

 

Route::post('/login', [AuthController::class, 'Login']);
Route::post('/register', [AuthController::class, 'Register']);
Route::post('/forgot', [AuthController::class, 'forgotPassword']);
Route::post('/verifyForgot', [AuthController::class, 'vefiryForgotPassword']);


Route::group(['prefix' => 'v1', 'as' => 'story'], function() {
    Route::get('/story', [StoryController::class, 'index']);
    Route::get('/story/search', [StoryController::class, 'search']);
    Route::get('/story/detail/{slug}', [StoryController::class, 'detail']);
});

Route::group(['prefix' => 'v1', 'as' => 'category'], function() {
    Route::get('/category', [CategoryController::class, 'index']);
});


Route::group(['prefix' => 'v1', 'as' => 'chaper'], function() {
    Route::get('/{slug}/{chaper}', [ChaperController::class, 'index']);
});