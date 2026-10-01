<?php

namespace App\Http\Requests\Api\Staff;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'phone' => ['nullable', 'string', 'max:30'],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                Rule::in(['doctor', 'receptionist']),
            ],

            'specialization' => [
                'required_if:role,doctor',
                'nullable',
                'string',
                'max:255',
            ],

            'license_number' => [
                'nullable',
                'string',
                'max:255',
            ],

            'bio' => [
                'nullable',
                'string',
            ],

            'consultation_fee' => [
                'required_if:role,doctor',
                'nullable',
                'numeric',
                'min:0',
            ],
        ];
    }
}
