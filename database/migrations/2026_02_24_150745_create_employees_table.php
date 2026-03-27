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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code', 15)->unique();
            $table->foreignId('designation_id')->constrained('designations')->cascadeOnUpdate()->restrictOnDelete();
            $table->json('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone', 20)->nullable();
            $table->string('national_id')->unique();
            $table->text('address')->nullable();
            $table->foreignId('nationality_id')->constrained('nationalities')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('blood_type_id')->constrained('type_bloods')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('religion_id')->constrained('religions')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('gender_id')->constrained('genders')->cascadeOnUpdate()->restrictOnDelete();

            $table->date('joining_date');
            $table->foreignId('specialization_id')->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('department_id')->constrained('departments')->cascadeOnUpdate()->restrictOnDelete();
            $table->enum('contract_type', ['full_time', 'part_time', 'contract']);

            $table->decimal('basic_salary', 10, 2);
            $table->string('bank_account_number')->nullable();

            $table->tinyInteger('status')->default(1);
            $table->string('image')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained()->nullOnDelete();

            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
