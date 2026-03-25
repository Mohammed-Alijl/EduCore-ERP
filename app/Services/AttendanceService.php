<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Student;

// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Log;

class AttendanceService
{
    /**
     * get students in section in specifc date with there attendances
     */
    public function getStudentsForAttendance($sectionId, $date, $academicYearId)
    {
        return Student::where('section_id', $sectionId)
            ->with(['attendances' => function ($query) use ($date, $academicYearId) {
                $query->where('attendance_date', $date)
                    ->where('academic_year_id', $academicYearId);
            }])
            ->orderBy('name')
            ->get();
    }

    /**
     * Store the full attenance for a specifc section
     */
    public function storeAttendance(array $data, $teacherId = null)
    {
        $attendanceDate = $data['attendance_date'];
        $academicYearId = $data['academic_year_id'];
        $gradeId = $data['grade_id'];
        $classroomId = $data['classroom_id'];
        $sectionId = $data['section_id'];

        $insertData = [];
        $now = now();

        foreach ($data['attendances'] as $attendance) {
            $insertData[] = [
                'student_id' => $attendance['student_id'],
                'academic_year_id' => $academicYearId,
                'grade_id' => $gradeId,
                'classroom_id' => $classroomId,
                'section_id' => $sectionId,
                'teacher_id' => $teacherId,
                'attendance_date' => $attendanceDate,
                'attendance_status' => $attendance['attendance_status'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        Attendance::upsert(
            $insertData,
            ['student_id', 'attendance_date'],
            ['attendance_status', 'teacher_id', 'updated_at']
        );

        return true;
    }
}
