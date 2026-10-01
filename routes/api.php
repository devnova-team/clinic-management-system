<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Staff\StaffController;

// authentication routes
Route::prefix('auth')->group(function () {

    // Public route
    Route::post('/login', [AuthController::class, 'login']);

    // Protected routes
    Route::middleware('verifyToken')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});
// Staff management routes
Route::middleware(['verifyToken', 'role:owner'])->group(function () {
    Route::get('/staff', [StaffController::class, 'index']);
    Route::post('/staff', [StaffController::class, 'store']);
    Route::put('/staff/{staff}', [StaffController::class, 'update']);
});
