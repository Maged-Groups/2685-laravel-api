<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mockery\Expectation;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user_roles = auth()->user()->roles;

        if ($user_roles !== 'admin')
            return response()->json('You are not an admin', 403);

        return $next($request);
    }
}
