<?php

namespace App\Services;

use App\Models\Appointment;

class AppointmentService
{
    public function getAllAppointments()
    {
        return Appointment::where('clinic_id', auth()->user()->clinic_id)
            ->paginate(15);
    }

    public function getAppointmentId(string $appointmentId)
    {
        return Appointment::where('clinic_id', auth()->user()->clinic_id)
            ->findOrFail($appointmentId);
    }

    public function createAppointment(array $data)
    {
        unset($data['clinic_id']);

        $data['clinic_id'] = auth()->user()->clinic_id;

        return Appointment::create($data);
    }

    public function updateAppointment(string $appointmentId, array $data)
    {
        $appointment = $this->getAppointmentId($appointmentId);

        unset($data['clinic_id']);

        $appointment->update($data);

        return $appointment;
    }

    public function deleteAppointment(string $appointmentId)
    {
        $appointment = $this->getAppointmentId($appointmentId);

        return $appointment->delete();
    }
}