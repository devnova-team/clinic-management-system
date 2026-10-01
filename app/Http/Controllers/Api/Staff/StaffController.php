<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Staff\StoreStaffRequest;
use App\Http\Requests\Api\Staff\UpdateStaffRequest;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    /**
     * Display all doctors and receptionists
     * belonging to the authenticated owner's clinic.
     */
    public function index(): JsonResponse
    {
        $clinicId = auth('api')->user()->clinic_id;

        $staff = User::query()
            ->where('clinic_id', $clinicId)
            ->whereIn('role', ['doctor', 'receptionist'])
            ->with('doctor')
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Staff retrieved successfully.',
            'data' => $staff,
        ]);
    }

    /**
     * Create a new doctor or receptionist.
     */
    public function store(StoreStaffRequest $request): JsonResponse
    {
        $data = $request->validated();

        $clinicId = auth('api')->user()->clinic_id;

        $user = DB::transaction(function () use ($data, $clinicId) {
            $user = User::create([
                'clinic_id' => $clinicId,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'password' => $data['password'],
                'role' => $data['role'],
                'is_active' => true,
            ]);

            if ($data['role'] === 'doctor') {
                Doctor::create([
                    'user_id' => $user->id,
                    'clinic_id' => $clinicId,
                    'specialization' => $data['specialization'],
                    'license_number' => $data['license_number'] ?? null,
                    'bio' => $data['bio'] ?? null,
                    'consultation_fee' => $data['consultation_fee'],
                    'is_active' => true,
                ]);
            }

            return $user;
        });

        $user->load('doctor');

        return response()->json([
            'message' => 'Staff member created successfully.',
            'data' => $user,
        ], 201);
    }

    /**
     * Update an existing doctor or receptionist.
     */
    public function update(
        UpdateStaffRequest $request,
        User $staff
    ): JsonResponse {
        $clinicId = auth('api')->user()->clinic_id;

        if ($staff->clinic_id !== $clinicId) {
            return response()->json([
                'message' => 'Staff member not found.',
            ], 404);
        }

        if (! in_array($staff->role, ['doctor', 'receptionist'], true)) {
            return response()->json([
                'message' => 'The selected user is not a staff member.',
            ], 422);
        }

        $data = $request->validated();

        DB::transaction(function () use ($data, $staff) {
            $userData = [];

            foreach (
                [
                    'name',
                    'email',
                    'phone',
                    'password',
                    'is_active',
                ] as $field
            ) {
                if (array_key_exists($field, $data)) {
                    $userData[$field] = $data[$field];
                }
            }

            if (! empty($userData)) {
                $staff->update($userData);
            }

            if ($staff->role === 'doctor') {
                $doctorData = [];

                foreach (
                    [
                        'specialization',
                        'license_number',
                        'bio',
                        'consultation_fee',
                    ] as $field
                ) {
                    if (array_key_exists($field, $data)) {
                        $doctorData[$field] = $data[$field];
                    }
                }

                if (! empty($doctorData)) {
                    $staff->doctor()->update($doctorData);
                }
            }
        });

        $staff->load('doctor');

        return response()->json([
            'message' => 'Staff member updated successfully.',
            'data' => $staff,
        ]);
    }
}
