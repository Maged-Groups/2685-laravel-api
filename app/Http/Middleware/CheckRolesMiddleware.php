<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mockery\Expectation;
use Symfony\Component\HttpFoundation\Response;

class CheckRolesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $accepted_roles): Response
    {
        // manager|hr
        $route_roles_arr = explode('|', $accepted_roles);

        // $user_roles = auth()->user()->roles;
        $user_roles_arr = auth()->user()->currentAccessToken()->abilities;

        $match = array_intersect($route_roles_arr, $user_roles_arr);

        if (count($match) === 0)
            return response()->json('You are not authorized to get this resource', 403);


        return $next($request);
    }
}
