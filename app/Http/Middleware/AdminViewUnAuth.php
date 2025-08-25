<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminViewUnAuth
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
        if (Auth::check()) {
            if(Auth::user()->role_type != "ADMIN"){
                Auth::logout();
                return redirect()->route('admin.login');
            }
            return redirect()->route('admin.dashboard');
        }
        return $next($request);
    }
}
