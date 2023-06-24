<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChaperController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Admin\StoryController;
use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;




Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', function () {
        return view('pages.home');
    });

    Route::group(['prefix' => '', 'as' => 'auth.'], function(){
        Route::get('/logout', action:[AuthController::class, 'logout'])->name('logout');
    });

    
    Route::group(['prefix' => '', 'as' => 'admin.'], function(){
        Route::get('/home', action:[AdminController::class, 'index'])->name('home');
    });

  


    Route::group(['prefix' => 'publisher', 'as' => 'publisher.'], function(){
        Route::get('', action:[PublisherController::class, 'index'])->name('index');
        Route::post('', action:[PublisherController::class, 'store'])->name('store');
        Route::get('/edit/{publisher}', action:[PublisherController::class, 'edit'])->name('edit');
        Route::post('/update', action:[PublisherController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'category', 'as' => 'category.'], function(){
        Route::get('', action:[CategoryController::class, 'index'])->name('index');
        Route::post('', action:[CategoryController::class, 'store'])->name('store');
        Route::get('/edit/{category}', action:[CategoryController::class, 'edit'])->name('edit');
        Route::post('/update', action:[CategoryController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'story', 'as' => 'story.'], function(){
        Route::get('', action:[StoryController::class, 'index'])->name('index');
        Route::get('/add', action:[StoryController::class, 'add'])->name('add');
        Route::post('', action:[StoryController::class, 'store'])->name('store');
        Route::get('/edit/{story}', action:[StoryController::class, 'edit'])->name('edit');
        Route::post('/update', action:[StoryController::class, 'update'])->name('update');
        Route::get('/destroy/{id}', action:[StoryController::class, 'destroy'])->name('destroy');
        Route::get('/detail/{story}', action:[StoryController::class, 'detail'])->name('detail');
    });

    Route::group(['prefix' => 'chaper', 'as' => 'chaper.'], function(){
        Route::get('', action:[ChaperController::class, 'index'])->name('index');
        Route::get('/add', action:[ChaperController::class, 'add'])->name('add');
        Route::post('', action:[ChaperController::class, 'store'])->name('store');
        Route::get('/edit/{chaper}', action:[ChaperController::class, 'edit'])->name('edit');
        Route::post('/update', action:[ChaperController::class, 'update'])->name('update');
        Route::get('/destroy/{id}', action:[ChaperController::class, 'destroy'])->name('destroy');
        Route::get('/detail/{chaper}', action:[ChaperController::class, 'detail'])->name('detail');
    });
});


Route::group(['prefix' => '', 'as' => 'auth.'], function(){
    Route::get('/login', action:[AuthController::class, 'Login'])->name('login');
    Route::post('/processLogin', action:[AuthController::class, 'ProcessLogin'])->name('processlogin');
});