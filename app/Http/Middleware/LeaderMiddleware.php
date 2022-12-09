<?php

namespace App\Http\Middleware;

use Closure;

class LeaderMiddleware
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
        if(session('leader_id')){
            return $next($request);
        }
        else{
            return redirect()->route('leader')->with('error_message','Unauthorized access page.');
        }
    }
}
