<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if(!Auth::check()){
            return redirect()->route('login');
        }

        /*
         *
         * Redirect based on role
         *
         * by Delower
         *
         */

         switch(strtolower($role)){
            case 'admin':
                if(Auth::user()->role === 0){
                    return $next($request);
                }
                break;

            case 'vendor':
                if(Auth::user()->role === 1){
                    return $next($request);
                }
                break;

            case 'customer':
                if(Auth::user()->role === 2){
                    return $next($request);
                }
                break;
        }

        switch(Auth::user()->role){
            case 0:
                return redirect()->route('admin');
            case 1:
                return redirect()->route('vendor');
            case 2:
                return redirect()->route('dashboard');
        }

        return redirect()->route('login');
    }
}
