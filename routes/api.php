<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('posts', PostController::class);

    Route::resource('users', UserController::class);
});





// Unprotected Routes
Route::post('auth/login', [AuthController::class, 'login']);
