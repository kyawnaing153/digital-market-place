<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminViewAuth
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
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        if(Auth::user()->role_type != "ADMIN"){
            Auth::logout();
            return redirect()->route('admin.login');
        }
        return $next($request);
    }
}
