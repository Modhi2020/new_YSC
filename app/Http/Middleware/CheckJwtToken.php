<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckJwtToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $message = '';
        
        try
        {
            JWTAuth::parseToken()->authenticate();
            return $next($request);
        } catch(\Tymon\JWTAuth\Exceptions\TokenExpiredException $e)
        {
            $message = 'token expire';
        }catch(\Tymon\JWTAuth\Exceptions\TokenInvalidException $e)
        {
            $message = 'invalid token';            
        }catch(\Tymon\JWTAuth\Exceptions\JWTException $e)
        {
            $message = 'provide token';
        }

        return response()->json([
            'success' => false,
             'message' => $message
        ]);
    }
}
