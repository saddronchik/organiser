<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request)
        ->header('Access-Controll-Allow-Origin',"*")
        ->header('Access-Controll-Allow-Methods',"PUT,POST,DELETE,GET,OPTIONS")
        ->header('Access-Controll-Allow-Headers',"Accept,Authorization,Content-Type");
    }
}
