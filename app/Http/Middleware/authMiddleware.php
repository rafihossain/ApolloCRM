<?php

namespace App\Http\Middleware;
use Redirect;

use Closure;

class authMiddleware
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
        if(session('user_id')){
           return $next($request);
        }
        else{
           return redirect()->route('login_index')->with('error_message','Unauthorized access page.');
        }
    }
}