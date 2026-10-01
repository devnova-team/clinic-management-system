<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InsurancePlanCoverage extends Model
{
    use HasFactory;

    protected $fillable = [
        'insurance_plan_id',
        'service_type',
        'coverage_percentage',
        'copay_amount',
        'deductible_amount',
        'is_covered',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'coverage_percentage' => 'decimal:2',
            'copay_amount' => 'decimal:2',
            'deductible_amount' => 'decimal:2',
            'is_covered' => 'boolean',
        ];
    }

    public function insurancePlan(): BelongsTo
    {
        return $this->belongsTo(InsurancePlan::class);
    }
}
