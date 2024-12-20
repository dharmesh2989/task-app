<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\RedirectResponse;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(Auth::guard($guard)->check()) {
            if (in_array(Auth::user()->user_type,['admin'])){
                if(Auth::user()->status == "active"){
                    return $next($request);
                }else{
                    Auth::logout();
                    return redirect()->route('admin.login');
                }

            }else{
                return redirect()->route('admin.login');
            }
        }else{
            return redirect()->route('admin.login');
        }
    }
}
