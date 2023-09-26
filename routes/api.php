<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostkmController;

Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('postkms', PostkmController::class);
    Route::post('register', [AuthController::class, 'register']);
    Route::resource('users', AuthController::class);
    Route::post('logout', [AuthController::class, 'logout']);
});
