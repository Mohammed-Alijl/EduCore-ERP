<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing test data (keep real data)
        DB::table('student_accounts')->where('description', 'LIKE', 'Sample %')->delete();

        // Get student IDs
        $studentIds = DB::table('students')->pluck('id')->toArray();

        if (empty($studentIds)) {
            $this->command->error('No students found. Please seed students first.');

            return;
        }

        $this->command->info('Creating sample financial data for '.count($studentIds).' students...');

        $transactions = [];
        $startDate = Carbon::now()->subMonths(12);
        $transactionId = 1000; // Start with a high number to avoid conflicts

        // Monthly fee amounts (varying by month)
        $monthlyFees = [
            500,
            520,
            480,
            550,
            530,
            510,  // First 6 months
            560,
            540,
            520,
            580,
            570,
            550,   // Last 6 months
        ];

        for ($month = 0; $month < 12; $month++) {
            $currentMonth = $startDate->copy()->addMonths($month);
            $monthlyFee = $monthlyFees[$month];

            // Create charges (invoices) for each student at the beginning of month
            foreach ($studentIds as $studentId) {
                $chargeDate = $currentMonth->copy()->addDays(rand(1, 5));

                // Monthly tuition charge
                $transactions[] = [
                    'student_id' => $studentId,
                    'transactionable_type' => 'App\\Models\\Invoice',
                    'transactionable_id' => $transactionId++, // Use incremental ID
                    'debit' => $monthlyFee + rand(-50, 100), // Add some variation
                    'credit' => 0,
                    'description' => 'Sample Monthly Tuition - '.$currentMonth->format('F Y'),
                    'date' => $chargeDate->format('Y-m-d'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Some students get additional charges (books, activities, etc.)
                if (rand(1, 4) == 1) { // 25% chance
                    $transactions[] = [
                        'student_id' => $studentId,
                        'transactionable_type' => 'App\\Models\\Invoice',
                        'transactionable_id' => $transactionId++,
                        'debit' => rand(50, 200),
                        'credit' => 0,
                        'description' => 'Sample Additional Fees - '.$currentMonth->format('F Y'),
                        'date' => $chargeDate->copy()->addDays(rand(1, 10))->format('Y-m-d'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            // Create payments throughout the month (not all students pay every month)
            $payingStudents = array_slice($studentIds, 0, (int) (count($studentIds) * (rand(70, 95) / 100))); // 70-95% pay

            foreach ($payingStudents as $studentId) {
                $paymentDate = $currentMonth->copy()->addDays(rand(10, 28));
                $paymentAmount = rand(200, $monthlyFee + 100); // Partial to full payments

                $transactions[] = [
                    'student_id' => $studentId,
                    'transactionable_type' => 'App\\Models\\Receipt',
                    'transactionable_id' => $transactionId++,
                    'debit' => 0,
                    'credit' => $paymentAmount,
                    'description' => 'Sample Payment - '.$currentMonth->format('F Y'),
                    'date' => $paymentDate->format('Y-m-d'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $this->command->info("Created transactions for {$currentMonth->format('F Y')}");
        }

        // Insert all transactions in chunks for better performance
        $chunks = array_chunk($transactions, 500);
        foreach ($chunks as $chunk) {
            DB::table('student_accounts')->insert($chunk);
        }

        $this->command->info('✅ Successfully created '.count($transactions).' sample financial transactions!');
        $this->command->info('📊 Charts should now display meaningful data across 12 months.');
    }
}
