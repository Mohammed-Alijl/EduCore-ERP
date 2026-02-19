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
            $table->foreignId('grade_id')->constrained('grades')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('classroom_id')->constrained('class_rooms')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('section_id')->constrained('sections')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('academic_year');
            $table->foreignId('guardian_id')->constrained('guardians')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('blood_type_id')->constrained('type_bloods')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('nationality_id')->constrained('nationalities')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('religion_id')->constrained('religions')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('gender_id')->constrained('genders')->cascadeOnUpdate()->restrictOnDelete();
            $table->tinyInteger('status')->default(1);
            $table->foreignId('admin_id')->nullable()->constrained()->nullOnDelete();
            $table->string('image')->nullable();
            $table->json('attachments')->nullable();
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
        Schema::dropIfExists('students');
    }
};
