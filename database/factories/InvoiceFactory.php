<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Student;
use App\Models\Fee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $student = Student::inRandomOrder()->first() ?? Student::factory()->create();
        $fee = Fee::inRandomOrder()->first() ?? Fee::factory()->create();

        return [
            'student_id'   => $student->id,
            'academic_year_id' => \App\Models\AcademicYear::factory(),
            'grade_id'     => $student->grade_id,
            'classroom_id' => $student->classroom_id,
            'fee_id'       => $fee->id,
            'amount'       => $fee->amount,
            'invoice_date' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'description'  => 'testing invoice: ' . $fee->title,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Invoice $invoice) {
            $invoice->studentAccount()->create([
                'student_id'  => $invoice->student_id,
                'debit'       => $invoice->amount,
                'credit'      => 0.00,
                'date'        => $invoice->invoice_date,
                'description' => 'create invoice: ' . $invoice->description,
            ]);
        });
    }
}
