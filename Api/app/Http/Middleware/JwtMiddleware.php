<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class JwtMiddleware extends BaseMiddleware
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
        $headers = apache_request_headers();
        // $request->headers->set('Authorization', $headers['Authorization']);
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return response()->json([
                    'status' => 'token_error',
                    'message' => 'Token is Invalid',
                ],401);
            } else if ($e instanceof TokenExpiredException) {
                return response()->json([
                    'status' => 'token_error',
                    'message' => 'Token Expired Invalid',
                ],401);
            } else {
                return response()->json([
                    'status'  => 'token_error',
                    'message' => 'Authorization Token not found'
                ],401);
            }
        }
        return $next($request);
    }
}
