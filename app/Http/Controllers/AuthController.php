<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function login(LoginRequest $request)
    {

        if (Auth::attempt($request->validated())) {
            return 'user logged in successfully';
        } else {
            return 'Failed to login';
        }
    }
}
