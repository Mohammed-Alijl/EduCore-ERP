<?php

namespace Database\Seeders;

use App\Enums\EnrollmentStatus;
use App\Models\Academic\AcademicYear;
use App\Models\Users\Student;
use App\Models\Academic\StudentEnrollment;
use Illuminate\Database\Seeder;

class StudentEnrollmentSeeder extends Seeder
{
    public function run()
    {
        $students = Student::with(['grade', 'classroom', 'section'])->get();
        $academicYears = AcademicYear::orderBy('name')->get();

        if ($students->isEmpty() || $academicYears->count() < 2) {
            $this->command->info('Please seed Students and at least 2 Academic Years first.');

            return;
        }

        foreach ($students as $student) {
            if ($student->is_graduated) {
                continue;
            }

            $enrollmentCount = rand(1, 2);
            $yearsToUse = $academicYears->take($enrollmentCount)->values();

            foreach ($yearsToUse as $index => $year) {
                $isLastYear = $index === ($enrollmentCount - 1);
                $fromAcademicYearId = $index > 0 ? $yearsToUse[$index - 1]->id : $year->id;

                if ($isLastYear) {
                    $status = fake()->randomElement([
                        EnrollmentStatus::Promoted,
                        EnrollmentStatus::Repeating,
                    ]);

                    StudentEnrollment::create([
                        'student_id' => $student->id,
                        'from_grade' => $student->grade_id,
                        'from_classroom' => $student->classroom_id,
                        'from_section' => $student->section_id,
                        'from_academic_year' => $fromAcademicYearId,
                        'to_grade' => $student->grade_id,
                        'to_classroom' => $student->classroom_id,
                        'to_section' => $student->section_id,
                        'to_academic_year' => $year->id,
                        'enrollment_status' => $status,
                        'admin_id' => 1,
                    ]);
                } else {
                    StudentEnrollment::factory()->create([
                        'student_id' => $student->id,
                        'from_academic_year' => $fromAcademicYearId,
                        'to_academic_year' => $year->id,
                    ]);
                }
            }
        }
    }
}
