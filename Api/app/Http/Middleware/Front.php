<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Front
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (in_array(Auth::user()->user_type, ['user'])) {
                if (Auth::user()->status == "active") {
                    return $next($request);
                } else {
                    dd("in1");
                    Auth::logout();
                    return redirect()->route('front.home');
                }
            } else {
                dd("in2");
                session()->flash('isLogin', false);
                return redirect()->route('front.home');
            }
        } else {
            return redirect()->route('front.showLoginForm');
        }
    }
}
