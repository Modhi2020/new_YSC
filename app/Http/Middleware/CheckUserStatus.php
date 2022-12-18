<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->status <> 1)
        {
            $user = Auth::user();
            Auth::logout();

            if (\App::getLocale() == 'en')
            {
                $msghello = 'Hello : ';
                $msguserstatus = 'We regret to inform you that your account has been suspended, please contact with the administration. ';
            }
            else
            {
                $msghello = 'مرحبــاً : ';
                $msguserstatus = 'يؤسفنا إبلاغك بأن حسابك موقوف يرجى التواصل مع الإدارة.';
            }
           
            return redirect()->route('login')->with(['message'=> $msghello.' '.$user->name.
            ' '.$msguserstatus]);
            
        }

        return $next($request);
      
    }

}
