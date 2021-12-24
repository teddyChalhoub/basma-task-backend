<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Http\Request;

class JWTMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next,$guard)
    {
        try {
            $user = auth($guard)->check();
            if( !$user ) throw new Exception('Not Found');
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'You must be logged in',
            ],401);
        }
        return $next($request);
    }
}
