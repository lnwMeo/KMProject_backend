<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostkmController;
use App\Http\Controllers\PostProjactController;
use App\Http\Controllers\PostITController;
use App\Http\Controllers\PageViewsController;

Route::post('login', [AuthController::class, 'login']);
Route::post('count-page', [PageViewsController::class, 'storeIpAddress']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('postkms', PostkmController::class);
    Route::resource('postits', PostITController::class);
    Route::resource('post_projacts', PostProjactController::class);
    Route::resource('users', AuthController::class);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
});
Route::group(['prefix'], function () {
    Route::get('count-users', [AuthController::class, 'countUsers']);
    Route::get('count-postkms', [PostkmController::class, 'countPostkms']);
    Route::get('count-postprojact', [PostProjactController::class, 'countProjact']);
    Route::get('count-postits', [PostITController::class, 'countPostits']);
    Route::get('count-page', [PageViewsController::class, 'countViews']);
});

Route::get('showpostkms',[PostkmController::class,'showfronend']);
Route::get('showpostjacts',[PostProjactController::class,'showpostprojact']);
Route::get('showpostit',[PostITController::class,'showpostprojact']);

Route::get('showkmv',[PostkmController::class,'showkmviews']);
Route::get('showprov',[PostProjactController::class,'showproviews']);
Route::get('showitv',[PostITController::class,'showitviews']);
