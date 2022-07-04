<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AppKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if(isset($token) == true){

            if($token != env('APP_KEY')){

                return response()->json(['message' => 'Invalid Application Key'], 401);
            }

        }
        else{
            return response()->json(['message' => 'Please provide Application Key'], 401);
        }


        return $next($request);
    }
}