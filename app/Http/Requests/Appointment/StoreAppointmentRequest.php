<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id' => ['required', 'uuid', 'exists:patients,id'],
            'user_id' => ['required', 'uuid', 'exists:users,id'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'consultation_fee' => ['required', 'numeric', 'min:0', 'decimal:0,2'],
            'status' => ['sometimes', 'required', Rule::in(['pending', 'checked_in', 'in_consultation', 'completed', 'cancelled'])],
        ];
    }
}
