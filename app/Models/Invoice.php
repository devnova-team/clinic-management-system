<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'patient_id',
        'invoice_number',
        'total_amount',
        'discount_amount',
        'tax_amount',
        'net_amount',
        'issue_date',
        'due_date',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'net_amount' => 'decimal:2',
            'issue_date' => 'date',
            'due_date' => 'date',
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

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
