<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class VendorViewUnAuth
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
            if(Auth::user()->role_type != "VENDOR"){
                Auth::logout();
                return redirect()->route('vendor.login');
            }
            return redirect()->route('vendor.dashboard');
        }
        return $next($request);
    }
}
