<?php

namespace App\Http\Requests\Api\Staff;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $staffId = $this->route('staff');

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($staffId),
            ],

            'phone' => [
                'sometimes',
                'nullable',
                'string',
                'max:30',
            ],

            'password' => [
                'sometimes',
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'specialization' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
            ],

            'license_number' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
            ],

            'bio' => [
                'sometimes',
                'nullable',
                'string',
            ],

            'consultation_fee' => [
                'sometimes',
                'nullable',
                'numeric',
                'min:0',
            ],

            'is_active' => [
                'sometimes',
                'boolean',
            ],
        ];
    }
}
