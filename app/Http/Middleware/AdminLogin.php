<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminLogin
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
        if(Auth::check()){
            if(Auth::user()->level != 1){
                return redirect('login')->with(['mess' => 'You are not enough permission', 'level' => 'danger']);
            }else{
                return $next($request);
            }
        }else{
            return redirect('login');
        }
        
    }
}
