<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function login(LoginRequest $request)
    {

        if (Auth::attempt($request->validated())) {

            // $user = User::where('email', $request->email)->first();

            /** @var App\Models\User $user  */
            $user = Auth::user();

            $token = $user->createToken('desktop_login')->plainTextToken;

            $user->token = $token;

            return UserResource::make($user);

            return 'user logged in successfully';
        } else {
            return 'Failed to login';
        }
    }
}
