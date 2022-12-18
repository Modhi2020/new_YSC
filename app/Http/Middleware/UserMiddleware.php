<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    
    public function handle($request, Closure $next)
    {
        // if(Auth::check() && Auth::user()->role->id == 3)
        if(Auth::check() && Auth::user()->role->id == 7 || Auth::user()->role->id == 8 || Auth::user()->role->id == 9)
        {
            return $next($request);

        }else{

            return redirect()->route('login');
        }
    }
}
