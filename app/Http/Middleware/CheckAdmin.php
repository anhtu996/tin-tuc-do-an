<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckAdmin
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
        if( Auth::check() ){
            if( Auth::user()->role[0]->id == ROLE_ADMIN ){
                return $next($request);
            } else return redirect()->route('dashbroad'); 
        }
        return redirect()->route('login'); 
    }
}
