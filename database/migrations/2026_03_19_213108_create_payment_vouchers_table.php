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
        Schema::create('payment_vouchers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            
            $table->foreignId('payment_gateway_id')->constrained('payment_gateways'); 
            
            $table->decimal('amount', 10, 2); 
            $table->string('currency_code', 3);
            $table->decimal('exchange_rate', 10, 4)->default(1.0000);
            $table->decimal('base_amount', 10, 2); 
            
            $table->date('date');
            $table->string('reference_number')->nullable();
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_vouchers');
    }
};
