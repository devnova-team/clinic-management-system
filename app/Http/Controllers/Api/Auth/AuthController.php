<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\JWTGuard;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid email or password.',
            ], 401);
        }

        $user = Auth::guard('api')->user();

        if (! $user instanceof User) {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        }

        if (! $user->is_active) {
            Auth::guard('api')->logout();

            return response()->json([
                'message' => 'Your account is inactive.',
            ], 403);
        }

        $user->update([
            'last_login_at' => now(),
        ]);

        return response()->json([
            'message' => 'Login successful.',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'role' => $user->role,
                    'clinic_id' => $user->clinic_id,
                ],
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ],
            ],
        ]);
    }

    public function logout(): JsonResponse
    {
        Auth::guard('api')->logout();

        return response()->json([
            'message' => 'Logout successful.',
        ]);
    }

    public function refresh(): JsonResponse
    {
        /** @var JWTGuard $guard */
        $guard = Auth::guard('api');

        $token = $guard->refresh();

        return response()->json([
            'message' => 'Token refreshed successfully.',
            'data' => [
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ],
            ],
        ]);
    }

    public function me(): JsonResponse
    {
        $user = Auth::guard('api')->user();

        if (! $user instanceof User) {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        }

        return response()->json([
            'message' => 'Authenticated user retrieved successfully.',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'role' => $user->role,
                    'clinic_id' => $user->clinic_id,
                ],
            ],
        ]);
    }
}
