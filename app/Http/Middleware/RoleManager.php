<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $currentUser = auth()->user();
        $isLoggedIn = !!$currentUser;

        if(!$isLoggedIn){
            return response()->json(["message"=>"You are not logged in", "type"=>"error"], 403);
        }

        $authUserRole = $currentUser->role ;
        //dd($role, $authUserRole);

        //user logged in and matches role
        if($role == $authUserRole)
            return $next($request);

        /*switch($authUserRole){
            case 0:
                return redirect()->route('admin');
            case 1:
                return redirect()->route('vendor');
            case 2: 
                return redirect()->route('dashboard');       
        }*/



        return redirect()->route('login');
    }
}
