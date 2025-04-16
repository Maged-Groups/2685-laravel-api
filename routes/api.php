<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReactionTypeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('posts', PostController::class);

    Route::apiResource('users', UserController::class);


    // Route::get('reaction-types', [ReactionTypeController::class, 'index']);

    Route::apiResource('reaction-types', ReactionTypeController::class)->only('index');

    Route::apiResource('reaction-types', ReactionTypeController::class)->except('index')->middleware('roles:manager|hr');
});



// Unprotected Routes
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/login-mob', [AuthController::class, 'login_mob']);
