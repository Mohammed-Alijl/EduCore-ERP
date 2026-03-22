<?php

namespace App\Services;

use App\Models\AcademicYear;
use App\Models\Exam;
use App\Models\Student;
use App\Models\StudentExamResult;
use App\Models\Subject;
use Illuminate\Support\Collection;

class StudentGradeService
{
    public function getGradeData(Student $student, ?int $academicYearId = null): array
    {
        $academicYear = $this->resolveAcademicYear($academicYearId);

        $subjectsWithGrades = $this->getSubjectsWithGrades($student, $academicYear);

        return [
            'student' => $this->formatStudentInfo($student),
            'academic_year' => $academicYear,
            'academic_years' => AcademicYear::query()->orderByDesc('is_current')->orderByDesc('starts_at')->get(),
            'subjects' => $subjectsWithGrades,
            'summary' => $this->calculateOverallSummary($subjectsWithGrades),
        ];
    }

    private function resolveAcademicYear(?int $academicYearId): ?AcademicYear
    {
        if ($academicYearId) {
            return AcademicYear::find($academicYearId);
        }

        return AcademicYear::query()->where('is_current', true)->first()
            ?? AcademicYear::query()->orderByDesc('starts_at')->first();
    }

    private function formatStudentInfo(Student $student): array
    {
        return [
            'id' => $student->id,
            'name' => $student->name,
            'student_code' => $student->student_code,
            'image_url' => $student->image_url,
            'grade' => $student->grade?->name,
            'classroom' => $student->classroom?->name,
            'section' => $student->section?->name,
        ];
    }

    private function getSubjectsWithGrades(Student $student, ?AcademicYear $academicYear): Collection
    {
        $subjects = Subject::query()
            ->where('grade_id', $student->grade_id)
            ->where(function ($query) use ($student) {
                $query->whereNull('classroom_id')
                    ->orWhere('classroom_id', $student->classroom_id);
            })
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        $examIds = Exam::query()
            ->whereIn('subject_id', $subjects->pluck('id'))
            ->when($academicYear, fn ($q) => $q->where('academic_year_id', $academicYear->id))
            ->pluck('id');

        $results = StudentExamResult::query()
            ->where('student_id', $student->id)
            ->whereIn('exam_id', $examIds)
            ->with(['exam' => function ($query) {
                $query->select('id', 'title', 'subject_id', 'total_marks', 'start_time', 'academic_year_id');
            }])
            ->get()
            ->groupBy(fn ($result) => $result->exam->subject_id);

        return $subjects->map(function ($subject) use ($results) {
            $subjectResults = $results->get($subject->id, collect());

            $exams = $subjectResults->map(function ($result) {
                $exam = $result->exam;
                $percentage = $exam->total_marks > 0
                    ? round(($result->final_score / $exam->total_marks) * 100, 1)
                    : 0;

                return [
                    'id' => $exam->id,
                    'title' => $exam->title,
                    'score' => $result->final_score,
                    'total_marks' => $exam->total_marks,
                    'percentage' => $percentage,
                    'grade_letter' => $this->getGradeLetter($percentage),
                    'grade_color' => $this->getGradeColor($percentage),
                    'date' => $exam->start_time?->format('Y-m-d'),
                ];
            })->sortByDesc('date')->values();

            $totalScore = $exams->sum('score');
            $totalMarks = $exams->sum('total_marks');
            $averagePercentage = $totalMarks > 0 ? round(($totalScore / $totalMarks) * 100, 1) : null;

            return [
                'id' => $subject->id,
                'name' => $subject->name,
                'exams' => $exams,
                'exam_count' => $exams->count(),
                'total_score' => $totalScore,
                'total_marks' => $totalMarks,
                'average_percentage' => $averagePercentage,
                'grade_letter' => $averagePercentage !== null ? $this->getGradeLetter($averagePercentage) : null,
                'grade_color' => $averagePercentage !== null ? $this->getGradeColor($averagePercentage) : 'secondary',
            ];
        });
    }

    private function calculateOverallSummary(Collection $subjects): array
    {
        $subjectsWithExams = $subjects->filter(fn ($s) => $s['exam_count'] > 0);

        if ($subjectsWithExams->isEmpty()) {
            return [
                'total_subjects' => $subjects->count(),
                'subjects_with_exams' => 0,
                'total_exams' => 0,
                'overall_score' => 0,
                'overall_marks' => 0,
                'overall_percentage' => null,
                'overall_grade' => null,
                'overall_color' => 'secondary',
                'grade_distribution' => $this->getEmptyDistribution(),
            ];
        }

        $totalExams = $subjectsWithExams->sum('exam_count');
        $overallScore = $subjectsWithExams->sum('total_score');
        $overallMarks = $subjectsWithExams->sum('total_marks');
        $overallPercentage = $overallMarks > 0 ? round(($overallScore / $overallMarks) * 100, 1) : 0;

        return [
            'total_subjects' => $subjects->count(),
            'subjects_with_exams' => $subjectsWithExams->count(),
            'total_exams' => $totalExams,
            'overall_score' => $overallScore,
            'overall_marks' => $overallMarks,
            'overall_percentage' => $overallPercentage,
            'overall_grade' => $this->getGradeLetter($overallPercentage),
            'overall_color' => $this->getGradeColor($overallPercentage),
            'grade_distribution' => $this->calculateGradeDistribution($subjectsWithExams),
        ];
    }

    private function calculateGradeDistribution(Collection $subjects): array
    {
        $distribution = $this->getEmptyDistribution();

        foreach ($subjects as $subject) {
            $grade = $subject['grade_letter'];
            if ($grade && isset($distribution[$grade])) {
                $distribution[$grade]++;
            }
        }

        return $distribution;
    }

    private function getEmptyDistribution(): array
    {
        return ['A+' => 0, 'A' => 0, 'B+' => 0, 'B' => 0, 'C+' => 0, 'C' => 0, 'D' => 0, 'F' => 0];
    }

    private function getGradeLetter(float $percentage): string
    {
        return match (true) {
            $percentage >= 95 => 'A+',
            $percentage >= 90 => 'A',
            $percentage >= 85 => 'B+',
            $percentage >= 80 => 'B',
            $percentage >= 75 => 'C+',
            $percentage >= 70 => 'C',
            $percentage >= 60 => 'D',
            default => 'F',
        };
    }

    private function getGradeColor(float $percentage): string
    {
        return match (true) {
            $percentage >= 90 => 'success',
            $percentage >= 80 => 'primary',
            $percentage >= 70 => 'info',
            $percentage >= 60 => 'warning',
            default => 'danger',
        };
    }
}
