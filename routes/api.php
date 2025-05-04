<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReactionTypeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('posts', PostController::class);

    Route::apiResource('comments', CommentController::class);

    Route::apiResource('users', UserController::class);


    // Route::get('reaction-types', [ReactionTypeController::class, 'index']);

    Route::apiResource('reaction-types', ReactionTypeController::class)->only('index');

    Route::apiResource('reaction-types', ReactionTypeController::class)->except('index')->middleware('roles:manager|hr');

    Route::get('reports', function () {
        return 'Reports';
    })->middleware('roles:salesManager|accountManager|manager');


});



// Unprotected Routes
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login-mob', [AuthController::class, 'login_mob']);
Route::post('auth/forget-password', [AuthController::class, 'forget_password']);
Route::post('auth/reset-password', [AuthController::class, 'reset_password']);


// payment (SAMPLE)

// Route::post('payment-success', [PaymentController:class, 'success_payment']);
// Route::post('fail-success', [PaymentController:class, 'fail_payment']);