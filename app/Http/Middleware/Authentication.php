<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         //return $next($request);
        $currentUser = auth()->user();
        $isLoggedIn = !!$currentUser;

        if(!$isLoggedIn){
            return response()->json(["message"=>"You are not logged in", "type"=>"error"], 403);
        }

        return $next($request);
    }
}
