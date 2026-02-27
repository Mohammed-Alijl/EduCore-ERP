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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('teacher_code', 15)->unique();
            $table->json('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone', 20)->nullable();
            $table->string('national_id')->unique();
            $table->text('address')->nullable();
            $table->date('joining_date');
            $table->foreignId('nationality_id')->constrained('nationalities')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('blood_type_id')->constrained('type_bloods')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('religion_id')->constrained('religions')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('gender_id')->constrained('genders')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('specialization_id')->constrained('Specializations')->cascadeOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('teachers');
    }
};
