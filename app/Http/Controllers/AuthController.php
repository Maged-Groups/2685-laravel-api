<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

    function forget_password(ForgetPasswordRequest $request)
    {
        // $validated = $request->validate([
        //     'email' => 'required|email',
        // ]);

        $validated = $request->validated();

        $email = $validated['email'];

        $token = Str::random(60);

        $hashedToken = Hash::make($token);

        DB::table('password_reset_tokens')
            ->updateOrInsert(
                ['email' => $email],
                [
                    'token' => $hashedToken,
                    'created_at' => now()
                ]
            );


        $user = User::where('email', $email)->first();

        $user->notify(new ResetPasswordNotification($token));

        return [$hashedToken, $token];

    }

    function reset_password(ResetPasswordRequest $request)
    {

        // return Hash::check(
        //     "FWvi2DrWWZamTTjgrEzzQUAhOuB03udRA71YvNv1NbXDDhirH4PF2AYDLC0x",
        //     '$2y$12$k9CueyM/ifuN.RwuvZRs.uJZobEItSw/ZAhuKegATeL.bqU3p7jDu',
        // );


        $validated = $request->validated();

        $token = $validated['token'];
        $email = $validated['email'];

        $row = DB::table('password_reset_tokens')->where('email', $email)->first();

        $created_at = $row->created_at;

        $expire_seconds = config('auth.passwords.users.expire');

        if (Carbon::parse($created_at)->diffInSeconds(now()) > $expire_seconds)
            return $this->json_error('Link expired');

        $valid = Hash::check($token, $row->token);

        if (!$valid)
            return $this->json_not_found('The link is not valid');


        $user = User::where('email', $email)->first();
        // $user->notify(new ResetPasswordNotification($token));
        $user->password = $validated['password'];

        if ($user->save()) {
            // Delete the 

            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return $this->json_response(['user' => UserResource::make($user)], 'Password reset success');
        }

        return $this->json_error('Password not reset');


    }





}
