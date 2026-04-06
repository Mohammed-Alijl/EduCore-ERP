<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Attendance\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('attendances')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $academicYear = AcademicYear::where('is_current', true)->first() ?? AcademicYear::first();

        if (! $academicYear) {
            return;
        }

        $students = Student::get();

        if ($students->isEmpty()) {
            return;
        }

        $attendances = [];
        $startDate = Carbon::now()->subDays(60);
        $endDate = Carbon::now();

        foreach ($students as $student) {
            $currentDate = $startDate->copy();

            while ($currentDate <= $endDate) {
                if ($currentDate->isWeekday()) {
                    $rand = rand(1, 100);

                    if ($rand <= 82) {
                        $status = Attendance::STATUS_PRESENT;
                    } elseif ($rand <= 92) {
                        $status = Attendance::STATUS_ABSENT;
                    } else {
                        $status = Attendance::STATUS_LATE;
                    }

                    $attendances[] = [
                        'student_id' => $student->id,
                        'academic_year_id' => $academicYear->id,
                        'grade_id' => $student->grade_id,
                        'classroom_id' => $student->classroom_id,
                        'section_id' => $student->section_id,
                        'teacher_id' => 1,
                        'attendance_date' => $currentDate->toDateString(),
                        'attendance_status' => $status,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                $currentDate->addDay();
            }
        }

        foreach (array_chunk($attendances, 1000) as $chunk) {
            Attendance::insert($chunk);
        }
    }
}
