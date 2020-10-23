<?php

namespace App\Http\Middleware;
//use App\Http\Middleware\Auth;

use Closure;
use Auth;

class CustomMiddleware
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
        if(!Auth::user()){
            return redirect('login');
        }
        return $next($request);
    }
}
