<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
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

            $user_roles_arr = explode(',', $user->roles);
            // return $user_roles_arr;

            $token = $user->createToken('desktop_login', $user_roles_arr)->plainTextToken;

            $user->token = $token;

            return UserResource::make($user);

            return 'user logged in successfully';
        } else {
            return 'Failed to login';
        }
    }
    function login_mob(LoginRequest $request)
    {

        if (Auth::attempt($request->validated())) {

            // $user = User::where('email', $request->email)->first();

            /** @var App\Models\User $user  */
            $user = Auth::user();

            $user_roles_arr = explode(',', $user->roles);
            // return $user_roles_arr;

            $token = $user->createToken('mobile_login', ['read', 'write'])->plainTextToken;

            $user->token = $token;

            return UserResource::make($user);

            return 'user logged in successfully';
        } else {
            return 'Failed to login';
        }
    }

    function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $ability = 'user';

        $data['roles'] = $ability;

        $user = User::create($data);

        if ($user) {
            $user->token = $user->createToken('register', [$ability])->plainTextToken;
        }

        return $this->json_response(compact('user'), 'User Registered, Welcome aboard');
    }
}
