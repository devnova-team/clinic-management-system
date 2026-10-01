<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class VerifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): Response $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (! auth('api')->check()) {
                return response()->json([
                    'message' => 'Unauthenticated.',
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'Invalid or expired token.',
            ], 401);
        }

        return $next($request);
    }
}
