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
        Schema::create('class_periods', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->integer('sort_order')->default(0);
            $table->integer('duration')->default(60)->comment('Duration in minutes');
            $table->time('start_time');
            $table->time('end_time');
            $table->foreignId('grade_id')->nullable()->constrained('grades')->nullOnDelete();
            $table->boolean('is_break')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->index(['grade_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_periods');
    }
};
