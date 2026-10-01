<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InsurancePlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'insurance_provider_id',
        'name',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function insuranceProvider(): BelongsTo
    {
        return $this->belongsTo(InsuranceProvider::class);
    }

    public function coverages(): HasMany
    {
        return $this->hasMany(InsurancePlanCoverage::class);
    }

    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class);
    }
}
