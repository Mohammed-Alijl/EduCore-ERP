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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained('academic_years')->cascadeOnDelete();

            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->integer('duration_minutes');


            $table->integer('total_questions');
            $table->integer('total_marks');

            $table->integer('max_attempts')->default(1);
            $table->tinyInteger('grading_method')->comment('1: Highest, 2: Latest, 3: Average');
            $table->tinyInteger('result_visibility')->comment('1: Hidden, 2: Immediate, 3: After All Attempts, 4: After End Date');

            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
