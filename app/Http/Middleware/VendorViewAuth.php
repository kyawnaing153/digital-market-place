<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class VendorViewAuth
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
            return redirect()->route('vendor.login');
        }

        if(Auth::user()->role_type != "VENDOR"){
            Auth::logout();
            return redirect()->route('vendor.login');
        }
        return $next($request);
    }
}
