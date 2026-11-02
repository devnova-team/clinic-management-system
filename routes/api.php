<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\UserManagementController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;




Route::prefix('auth')->group(function () {

    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:login');

    Route::middleware(['auth:sanctum', 'tenant'])->group(function () {

        Route::get('/me', [AuthController::class, 'me']);

        Route::post('/logout', [AuthController::class, 'logout']);
    });
});



Route::middleware(['auth:sanctum', 'tenant', 'role:owner'])->group(function () {

    // Patients
    Route::prefix('patients')->controller(PatientController::class)->group(function () {
        Route::get('/', 'getAllPatients');
        Route::get('/{patientId}', 'getPatientById');
        Route::post('/', 'createPatient');
        Route::put('/{patientId}', 'updatePatient');
        Route::delete('/{patientId}', 'deletePatient');
    });

    // UserManagement
    Route::prefix('users')->controller(UserManagementController::class)->group(function () {
        Route::get('/', 'getAllUsers');
        Route::get('/{userId}', 'getUserById');
        Route::post('/', 'createUser');
        Route::put('/{userId}', 'updateUser');
        Route::delete('/{userId}', 'deleteUser');
    });
});


Route::middleware(['auth:sanctum', 'tenant', 'role:owner,receptionist'])->group(function () {

    Route::prefix('appointments')->controller(AppointmentController::class)->group(function () {
        Route::get('/', 'getAllAppointments');
        Route::get('/{appointmentId}', 'getAppointmentId');
        Route::post('/', 'createAppointment');
        Route::put('/{appointmentId}', 'updateAppointment');
        Route::delete('/{appointmentId}', 'deleteAppointment');
    });
});
