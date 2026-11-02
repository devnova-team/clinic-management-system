<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAppointmentRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'patient_id' => ['nullable', 'uuid', 'exists:patients,id'],
            'user_id' => ['nullable', 'uuid', 'exists:users,id'],
            'appointment_date' => ['nullable', 'date', 'after_or_equal:today'],
            'appointment_time' => ['nullable', 'date_format:H:i'],
            'consultation_fee' => ['nullable', 'numeric', 'min:0', 'decimal:0,2'],
            'status' => ['sometimes', 'nullable', Rule::in(['pending', 'checked_in', 'in_consultation', 'completed', 'cancelled'])],
        ];
    }
}
