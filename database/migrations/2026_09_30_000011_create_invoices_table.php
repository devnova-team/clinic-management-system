<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('clinic_id')
                ->constrained('clinics')
                ->cascadeOnDelete();

            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            $table->string('invoice_number')->unique();

            $table->decimal('total_amount', 10, 2);

            $table->decimal('discount_amount', 10, 2)
                ->default(0);

            $table->decimal('tax_amount', 10, 2)
                ->default(0);

            $table->decimal('net_amount', 10, 2);

            $table->date('issue_date');

            $table->date('due_date')->nullable();

            $table->enum('status', [
                'draft',
                'issued',
                'partially_paid',
                'paid',
                'overdue',
                'cancelled'
            ])->default('draft');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['clinic_id', 'status']);
            $table->index(['patient_id', 'status']);
            $table->index(['issue_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
