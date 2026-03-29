<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\AcademicYear;
use App\Models\StudentEnrollment;

class StudentEnrollmentSeeder extends Seeder
{
    public function run()
    {
        $students = Student::all();
        $academicYears = AcademicYear::all();

        if ($students->isEmpty() || $academicYears->isEmpty()) {
            $this->command->info('Please seed Students and Academic Years first.');
            return;
        }

        foreach ($students as $student) {
            $numberOfYears = rand(1, min(3, $academicYears->count()));
            $randomYears = $academicYears->random($numberOfYears);

            foreach ($randomYears as $year) {
                // ننشئ السجل ونمرر الـ IDs صراحةً ليتجاهل الـ Factory العشوائية
                StudentEnrollment::factory()->create([
                    'student_id' => $student->id,
                    'academic_year_id' => $year->id,
                ]);
            }
        }
    }
}