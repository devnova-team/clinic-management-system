<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Http\Traits\ApiResponse;
use App\Services\AppointmentService;

class AppointmentController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly AppointmentService $appointmentService
    ) {}

    public function getAllAppointments()
    {
        $appointments = $this->appointmentService->getAllAppointments();

        return $this->paginated(
            $appointments,
            AppointmentResource::class,
            'Appointments retrieved successfully'
        );
    }

    public function getAppointmentId(string $appointmentId)
    {
        $appointment = $this->appointmentService->getAppointmentId($appointmentId);

        return $this->success(
            new AppointmentResource($appointment),
            'Appointment retrieved successfully'
        );
    }

    public function createAppointment(StoreAppointmentRequest $request)
    {
        $appointment = $this->appointmentService->createAppointment(
            $request->validated()
        );

        return $this->success(
            new AppointmentResource($appointment),
            'Appointment created successfully',
            201
        );
    }

    public function updateAppointment(UpdateAppointmentRequest $request, string $appointmentId)
    {
        $appointment = $this->appointmentService->updateAppointment(
            $appointmentId,
            $request->validated()
        );

        return $this->success(
            new AppointmentResource($appointment),
            'Appointment updated successfully'
        );
    }

    public function deleteAppointment(string $appointmentId)
    {
        $this->appointmentService->deleteAppointment($appointmentId);

        return $this->success(
            null,
            'Appointment deleted successfully'
        );
    }
}