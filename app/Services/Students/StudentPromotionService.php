<?php

namespace App\Services\Students;

use App\Enums\EnrollmentStatus;
use App\Models\Academic\AcademicYear;
use App\Models\Academic\Grade;
use App\Models\Users\Student;
use App\Models\Academic\StudentEnrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentPromotionService
{
    public function getLookups()
    {
        return [
            'grades' => Grade::all(),
            'academicYears' => AcademicYear::orderBy('name')->get(),
        ];
    }

    public function hasPromotionFilters(array $filters): bool
    {
        return ! empty($filters['from_grade_id'])
            && ! empty($filters['from_classroom_id'])
            && ! empty($filters['from_section_id'])
            && ! empty($filters['from_academic_year_id']);
    }

    public function getStudentsForPromotion(array $filters)
    {
        if (! $this->hasPromotionFilters($filters)) {
            return collect();
        }

        $fromYearName = $this->getAcademicYearName($filters['from_academic_year_id']);

        return Student::with(['grade', 'classroom', 'section', 'guardian'])
            ->where('grade_id', $filters['from_grade_id'])
            ->where('classroom_id', $filters['from_classroom_id'])
            ->where('section_id', $filters['from_section_id'])
            ->where('academic_year', $fromYearName)
            ->where('status', 1)
            ->orderBy('student_code')
            ->get();
    }

    public function promote(array $data)
    {
        return DB::transaction(function () use ($data) {
            $promoteIds = $this->normalizeIds($data['promote_student_ids'] ?? []);
            $graduateIds = $this->normalizeIds($data['graduate_student_ids'] ?? []);

            $toAcademicYearId = $data['to_academic_year_id'] ?? $data['from_academic_year_id'];

            if ($data['from_academic_year_id'] == $toAcademicYearId && !empty($promoteIds)) {
                throw new \Exception(__('admin.Students.promotions.messages.failed.same_year'));
            }

            if (! empty($promoteIds) && $this->isSameDestination($data)) {
                throw new \Exception(__('admin.Students.promotions.messages.failed.same_place'));
            }

            if (! empty(array_intersect($promoteIds, $graduateIds))) {
                throw new \Exception(__('admin.Students.promotions.messages.failed.conflict'));
            }

            $fromYearName = $this->getAcademicYearName($data['from_academic_year_id']);
            $toYear = AcademicYear::find($toAcademicYearId);
            if (! $toYear) {
                throw new \Exception(__('admin.Students.promotions.messages.failed.invalid_year'));
            }

            $students = Student::where('grade_id', $data['from_grade_id'])
                ->where('classroom_id', $data['from_classroom_id'])
                ->where('section_id', $data['from_section_id'])
                ->where('academic_year', $fromYearName)
                ->where('status', 1)
                ->lockForUpdate()
                ->get();

            $allIds = $students->pluck('id')->all();
            $invalidPromote = array_diff($promoteIds, $allIds);
            $invalidGraduate = array_diff($graduateIds, $allIds);

            if (! empty($invalidPromote) || ! empty($invalidGraduate)) {
                throw new \Exception(__('admin.Students.promotions.messages.failed.mismatch'));
            }

            $repeatIds = array_values(array_diff($allIds, $promoteIds, $graduateIds));
            $targetIds = array_values(array_unique(array_merge($promoteIds, $repeatIds, $graduateIds)));

            if (! empty($targetIds)) {
                $existing = StudentEnrollment::where('to_academic_year', $toAcademicYearId)
                    ->whereIn('student_id', $targetIds)
                    ->pluck('student_id')
                    ->all();

                if (! empty($existing) && $toAcademicYearId != $data['from_academic_year_id']) {
                    throw new \Exception(__('admin.Students.promotions.messages.failed.already_enrolled'));
                }
            }

            $now = now();
            $adminId = Auth::id();
            $enrollmentRows = [];

            foreach ($promoteIds as $studentId) {
                $enrollmentRows[] = [
                    'student_id' => $studentId,
                    'from_grade' => $data['from_grade_id'],
                    'from_classroom' => $data['from_classroom_id'],
                    'from_section' => $data['from_section_id'],
                    'from_academic_year' => $data['from_academic_year_id'],
                    'to_grade' => $data['to_grade_id'],
                    'to_classroom' => $data['to_classroom_id'],
                    'to_section' => $data['to_section_id'],
                    'to_academic_year' => $toAcademicYearId,
                    'enrollment_status' => EnrollmentStatus::Promoted->value,
                    'admin_id' => $adminId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            foreach ($repeatIds as $studentId) {
                $enrollmentRows[] = [
                    'student_id' => $studentId,
                    'from_grade' => $data['from_grade_id'],
                    'from_classroom' => $data['from_classroom_id'],
                    'from_section' => $data['from_section_id'],
                    'from_academic_year' => $data['from_academic_year_id'],
                    'to_grade' => $data['from_grade_id'],
                    'to_classroom' => $data['from_classroom_id'],
                    'to_section' => $data['from_section_id'],
                    'to_academic_year' => $toAcademicYearId,
                    'enrollment_status' => EnrollmentStatus::Repeating->value,
                    'admin_id' => $adminId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            foreach ($graduateIds as $studentId) {
                $enrollmentRows[] = [
                    'student_id' => $studentId,
                    'from_grade' => $data['from_grade_id'],
                    'from_classroom' => $data['from_classroom_id'],
                    'from_section' => $data['from_section_id'],
                    'from_academic_year' => $data['from_academic_year_id'],
                    'to_grade' => null,
                    'to_classroom' => null,
                    'to_section' => null,
                    'to_academic_year' => $toAcademicYearId,
                    'enrollment_status' => EnrollmentStatus::Graduated->value,
                    'admin_id' => $adminId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            if (! empty($enrollmentRows)) {
                StudentEnrollment::insert($enrollmentRows);
            }

            if (! empty($promoteIds)) {
                Student::whereIn('id', $promoteIds)
                    ->update([
                        'grade_id' => $data['to_grade_id'],
                        'classroom_id' => $data['to_classroom_id'],
                        'section_id' => $data['to_section_id'],
                        'academic_year' => $toYear->name,
                    ]);
            }

            if (! empty($repeatIds)) {
                Student::whereIn('id', $repeatIds)
                    ->update([
                        'academic_year' => $toYear->name,
                    ]);
            }

            if (! empty($graduateIds)) {
                Student::whereIn('id', $graduateIds)
                    ->update([
                        'grade_id' => null,
                        'classroom_id' => null,
                        'section_id' => null,
                        'status' => 0,
                        'is_graduated' => true,
                        'graduated_at' => $now,
                        'graduation_academic_year_id' => $data['from_academic_year_id'],
                    ]);
            }

            return [
                'promoted' => count($promoteIds),
                'repeating' => count($repeatIds),
                'graduated' => count($graduateIds),
            ];
        });
    }

    public function rollbackPromotion(int $enrollmentId): bool
    {
        return DB::transaction(function () use ($enrollmentId) {
            $enrollment = StudentEnrollment::with('student')->findOrFail($enrollmentId);

            if (! $enrollment) {
                throw new \Exception(__('admin.Students.promotions.messages.failed.not_found'));
            }

            $student = $enrollment->student;

            $updateData = [
                'grade_id' => $enrollment->from_grade,
                'classroom_id' => $enrollment->from_classroom,
                'section_id' => $enrollment->from_section,
            ];

            if ($enrollment->enrollment_status === EnrollmentStatus::Graduated) {
                $updateData['is_graduated'] = false;
                $updateData['graduated_at'] = null;
                $updateData['graduation_academic_year_id'] = null;
                $updateData['status'] = 1;
            }

            $fromYear = AcademicYear::find($enrollment->from_academic_year);
            if ($fromYear) {
                $updateData['academic_year'] = $fromYear->name;
            }

            $student->update($updateData);

            $enrollment->delete();

            return true;
        });
    }

    private function isSameDestination(array $data): bool
    {
        return $data['from_grade_id'] == ($data['to_grade_id'] ?? null)
            && $data['from_classroom_id'] == ($data['to_classroom_id'] ?? null)
            && $data['from_section_id'] == ($data['to_section_id'] ?? null)
            && $data['from_academic_year_id'] == ($data['to_academic_year_id'] ?? null);
    }

    private function normalizeIds(array $ids): array
    {
        return array_values(array_unique(array_filter(array_map('intval', $ids))));
    }

    private function getAcademicYearName($id): string
    {
        $year = AcademicYear::find($id);
        if (! $year) {
            throw new \Exception(__('admin.Students.promotions.messages.failed.invalid_year'));
        }

        return $year->name;
    }
}
