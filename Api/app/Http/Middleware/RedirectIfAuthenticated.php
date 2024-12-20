<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guard): Response
    {
        if (Auth::guard($guard)->check()) {
            if (in_array(Auth::user()->user_type, ['admin'])) {
                // dd("out");
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->user_type == 'user') {
                return redirect()->route('front.home');
            } else {
                // return $next($request);
                // return redirect('front/profile');
                dd("Front End---");
            }
        } else {
            // dd("in");
            return $next($request);
        }
    }
}
