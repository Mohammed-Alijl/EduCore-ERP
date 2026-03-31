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
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->cascadeOnDelete();
            $table->foreignId('day_of_week_id')->constrained('days_of_week')->cascadeOnDelete();
            $table->foreignId('class_period_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('employees')->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            // Composite unique constraint: One slot per section per day/period
            $table->unique(
                ['section_id', 'day_of_week_id', 'class_period_id', 'academic_year_id'],
                'timetable_section_slot_unique'
            );

            // Index for teacher conflict detection (critical for performance)
            $table->index(
                ['teacher_id', 'day_of_week_id', 'class_period_id', 'academic_year_id'],
                'timetable_teacher_slot_idx'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timetables');
    }
};
