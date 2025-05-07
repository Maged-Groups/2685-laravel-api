<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    Log::info('open', ['Home page opened']);

    return view('welcome');
    // Mail::to('magedyaseengroups@gmail.com')->send(new WelcomeMail);
});


Route::resource('posts', PostController::class)->middleware('throttle:5,1');
Route::resource('users', UserController::class);
