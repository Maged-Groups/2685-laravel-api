<?php

use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    Mail::to('magedyaseengroups@gmail.com')->send(new WelcomeMail);
});
