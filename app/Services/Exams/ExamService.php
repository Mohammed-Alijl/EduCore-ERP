<?php

namespace App\Services\Exams;

use App\Models\Assessments\Exam;
use App\Models\Assessments\ExamAttempt;
use App\Models\Assessments\StudentExamResult;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExamService
{

    /**
     * return all filter exams
     */
    public function getExamsQuery(array $filters): Builder
    {
        $query = Exam::with(['subject', 'teacher', 'academicYear']);

        return $this->applyFilters($query, $filters);
    }

    /**
     * Admin Can Reset Student Attempt In Case Any Error Happen
     */
    public function resetStudentAttempt($examId, $studentId)
    {
        try {
            DB::beginTransaction();

            ExamAttempt::where('exam_id', $examId)
                ->where('student_id', $studentId)
                ->delete();

            StudentExamResult::where('exam_id', $examId)
                ->where('student_id', $studentId)
                ->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error resetting exam attempt for student {$studentId} in exam {$examId}: " . $e->getMessage());
            return false;
        }
    }

    private function applyFilters(Builder $query, array $filters): Builder
    {
        $query->when($filters['academic_year_id'] ?? null, function ($q, $academicYearId) {
            $q->where('academic_year_id', $academicYearId);
        });

        $query->when($filters['section_id'] ?? null, function ($q, $sectionId) {
            $q->whereHas('sections', function ($subQuery) use ($sectionId) {
                $subQuery->where('sections.id', $sectionId);
            });
        });

        return $query->orderByDesc('start_time');
    }
}
