<?php

namespace Database\Seeders;

use App\Models\Assessments\Exam;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentExamResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exams = Exam::all();
        $students = Student::all();

        if ($exams->isEmpty() || $students->isEmpty()) {
            $this->command->info('Please ensure exams and students exist before running this seeder.');

            return;
        }

        $resultsToInsert = [];
        $now = now();

        foreach ($exams as $exam) {
            // Pick a random subset of students who "took" this exam (70-90% attendance)
            $examStudents = $students->random(rand(intval($students->count() * 0.7), intval($students->count() * 0.9)));

            foreach ($examStudents as $student) {
                // Determine a realistic score distribution
                // 10% fail, 40% pass (50-80%), 50% excellent (80-100%)
                $rand = rand(1, 100);
                $totalMarks = $exam->total_marks ?? 100;

                if ($rand <= 10) {
                    // Fail (10 - 49%)
                    $percentage = rand(10, 49) / 100;
                } elseif ($rand <= 50) {
                    // Pass (50 - 79%)
                    $percentage = rand(50, 79) / 100;
                } else {
                    // Excellent (80 - 100%)
                    $percentage = rand(80, 100) / 100;
                }

                $finalScore = round($totalMarks * $percentage);

                $resultsToInsert[] = [
                    'exam_id' => $exam->id,
                    'student_id' => $student->id,
                    'final_score' => $finalScore,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // Chunk inserts to avoid memory issues
        foreach (array_chunk($resultsToInsert, 500) as $chunk) {
            // Use insertOrIgnore to avoid unique constraint violations if running multiple times
            DB::table('student_exam_results')->insertOrIgnore($chunk);
        }

        $this->command->info('Successfully seeded '.count($resultsToInsert).' student exam results!');
    }
}
