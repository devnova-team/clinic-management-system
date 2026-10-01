<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('clinic_id')
                ->after('id')
                ->constrained('clinics')
                ->cascadeOnDelete();

            $table->string('phone')
                ->nullable()
                ->after('email');

            $table->enum('role', [
                'owner',
                'doctor',
                'receptionist',
                'nurse',
                'patient',
            ])->after('password');

            $table->boolean('is_active')
                ->default(true)
                ->after('role');

            $table->timestamp('last_login_at')
                ->nullable()
                ->after('email_verified_at');

            $table->softDeletes();

            $table->index(['clinic_id', 'role']);
            $table->index(['clinic_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['clinic_id']);

            $table->dropIndex(['clinic_id', 'role']);
            $table->dropIndex(['clinic_id', 'is_active']);

            $table->dropColumn([
                'clinic_id',
                'phone',
                'role',
                'is_active',
                'last_login_at',
                'deleted_at',
            ]);
        });
    }
};
