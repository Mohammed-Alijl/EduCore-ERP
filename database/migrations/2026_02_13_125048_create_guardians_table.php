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
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->json('name_father');
            $table->string('national_id_father')->unique();
            $table->string('passport_id_father')->nullable();
            $table->string('phone_father');
            $table->json('job_father');
            $table->foreignId('nationality_father_id')->constrained('nationalities');
            $table->foreignId('blood_type_father_id')->constrained('type_bloods');
            $table->foreignId('religion_father_id')->constrained('religions');
            $table->string('address_father');
            $table->json('name_mother');
            $table->string('national_id_mother')->nullable();
            $table->string('passport_id_mother')->nullable();
            $table->string('phone_mother')->nullable();
            $table->json('job_mother')->nullable();
            $table->foreignId('nationality_mother_id')->constrained('nationalities');
            $table->foreignId('blood_type_mother_id')->constrained('type_bloods');
            $table->foreignId('religion_mother_id')->constrained('religions');
            $table->string('address_mother')->nullable();
            $table->string('image')->nullable();
            $table->json('attachments')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardians');
    }
};
