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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('student_code', 8)->unique();
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('national_id')->unique();
            $table->date('date_of_birth');
            $table->foreignId('grade_id')->nullable()->constrained('grades')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('classroom_id')->nullable()->constrained('class_rooms')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('section_id')->nullable()->constrained('sections')->cascadeOnUpdate()->nullOnDelete();
            $table->string('academic_year');
            $table->foreignId('guardian_id')->constrained('guardians')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('blood_type_id')->constrained('type_bloods')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('nationality_id')->constrained('nationalities')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('religion_id')->constrained('religions')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('gender_id')->constrained('genders')->cascadeOnUpdate()->restrictOnDelete();
            $table->tinyInteger('status')->default(1);
            $table->boolean('is_graduated')->default(false);
            $table->timestamp('graduated_at')->nullable();
            $table->foreignId('graduation_academic_year_id')->nullable()->constrained('academic_years')->nullOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained()->nullOnDelete();
            $table->string('image')->nullable();
            $table->json('attachments')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['is_graduated', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
