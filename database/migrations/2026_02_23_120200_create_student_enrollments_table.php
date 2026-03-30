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
        Schema::create('student_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreignId('from_grade')->constrained('grades')->cascadeOnDelete();
            $table->foreignId('from_classroom')->constrained('class_rooms')->cascadeOnDelete();
            $table->foreignId('from_section')->constrained('sections')->cascadeOnDelete();
            $table->foreignId('from_academic_year')->constrained('academic_years')->cascadeOnDelete();

            $table->foreignId('to_grade')->nullable()->constrained('grades')->cascadeOnDelete();
            $table->foreignId('to_classroom')->nullable()->constrained('class_rooms')->cascadeOnDelete();
            $table->foreignId('to_section')->nullable()->constrained('sections')->cascadeOnDelete();
            $table->foreignId('to_academic_year')->constrained('academic_years')->cascadeOnDelete();

            $table->string('enrollment_status', 20);
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();

            $table->unique(['student_id', 'to_academic_year']);
            $table->index(['to_academic_year', 'to_grade', 'to_classroom', 'to_section'], 'student_enrollments_scope_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_enrollments');
    }
};
