<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MedicalRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'clinic_id',
        'patient_id',
        'doctor_id',
        'appointment_id',
        'family_history',
        'chief_complaint',
        'diagnosis',
        'symptoms',
        'allergies',
        'chronic_conditions',
        'examination_notes',
        'treatment_plan',
        'prescriptions',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'prescriptions' => 'array',
        ];
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function attachedFiles(): HasMany
    {
        return $this->hasMany(AttachedFile::class);
    }
}
