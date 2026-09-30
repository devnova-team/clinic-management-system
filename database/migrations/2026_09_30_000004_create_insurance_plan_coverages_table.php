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
        Schema::create('insurance_plan_coverages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('insurance_plan_id')
                ->constrained('insurance_plans')
                ->cascadeOnDelete();

            $table->string('service_type');

            $table->decimal('coverage_percentage', 5, 2)->nullable();
            $table->decimal('copay_amount', 10, 2)->nullable();
            $table->decimal('deductible_amount', 10, 2)->nullable();

            $table->boolean('is_covered')->default(true);

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index([
                'insurance_plan_id',
                'service_type'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_plan_coverages');
    }
};
