<?php

namespace App\Services\Schedule;

use App\Models\Scheduling\ClassPeriod;
use App\Models\Scheduling\DayOfWeek;
use App\Models\Academic\Section;
use App\Models\Academic\Subject;
use App\Models\Scheduling\TeacherAssignment;
use App\Models\Scheduling\Timetable;
use Illuminate\Validation\ValidationException;

class TimetableService
{
    /**
     * Get timetable matrix data for a specific section.
     *
     * @return array{periods: Collection, days: Collection, slots: array}
     */
    public function getMatrixData(int $sectionId, int $academicYearId): array
    {
        $section = Section::with(['grade', 'classroom'])->findOrFail($sectionId);

        $periods = ClassPeriod::query()
            ->active()
            ->forGrade($section->grade_id)
            ->ordered()
            ->get();

        $days = DayOfWeek::query()
            ->active()
            ->workingDays()
            ->orderBy('day_number')
            ->get();

        $timetableSlots = Timetable::query()
            ->with(['subject', 'teacher', 'dayOfWeek', 'classPeriod'])
            ->forSection($sectionId)
            ->forAcademicYear($academicYearId)
            ->get();

        $slots = [];
        foreach ($timetableSlots as $slot) {
            $key = "{$slot->day_of_week_id}_{$slot->class_period_id}";
            $slots[$key] = [
                'id' => $slot->id,
                'subject_id' => $slot->subject_id,
                'subject_name' => $slot->subject->name,
                'teacher_id' => $slot->teacher_id,
                'teacher_name' => $slot->teacher->name,
            ];
        }

        return [
            'section' => $section,
            'periods' => $periods,
            'days' => $days,
            'slots' => $slots,
        ];
    }

    /**
     * Validate and store a timetable slot.
     *
     * @param  array<string, mixed>  $data
     *
     * @throws ValidationException
     */
    public function assignSlot(array $data): Timetable
    {
        $this->validateNoTeacherConflict($data);

        return Timetable::create($data);
    }

    /**
     * Validate and update a timetable slot.
     *
     * @param  array<string, mixed>  $data
     *
     * @throws ValidationException
     */
    public function updateSlot(Timetable $timetable, array $data): Timetable
    {
        $this->validateNoTeacherConflict($data, $timetable->id);

        $timetable->update($data);

        return $timetable->fresh();
    }

    /**
     * Delete a timetable slot.
     */
    public function deleteSlot(Timetable $timetable): bool
    {
        return $timetable->delete();
    }

    /**
     * Check if teacher is already assigned to another section at same day/period.
     *
     * @param  array<string, mixed>  $data
     *
     * @throws ValidationException
     */
    protected function validateNoTeacherConflict(array $data, ?int $excludeId = null): void
    {
        $query = Timetable::query()
            ->where('teacher_id', $data['teacher_id'])
            ->where('day_of_week_id', $data['day_of_week_id'])
            ->where('class_period_id', $data['class_period_id'])
            ->where('academic_year_id', $data['academic_year_id']);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        if ($query->exists()) {
            $conflict = $query->with(['section.classroom.grade', 'dayOfWeek', 'classPeriod'])->first();

            throw ValidationException::withMessages([
                'teacher_id' => __('admin.Schedule.timetables.errors.teacher_conflict', [
                    'section' => $conflict->section->name,
                    'grade' => $conflict->section->grade->name,
                    'day' => $conflict->dayOfWeek->name,
                    'period' => $conflict->classPeriod->name,
                ]),
            ]);
        }
    }

    /**
     * Get teacher's timetable.
     */
    public function getTeacherTimetable(int $teacherId, int $academicYearId)
    {
        return Timetable::query()
            ->with(['section.grade', 'section.classroom', 'dayOfWeek', 'classPeriod', 'subject'])
            ->forTeacher($teacherId)
            ->forAcademicYear($academicYearId)
            ->get();
    }

    /**
     * Get section's complete timetable.
     */
    public function getSectionTimetable(int $sectionId, int $academicYearId)
    {
        return Timetable::query()
            ->with(['subject', 'teacher', 'dayOfWeek', 'classPeriod'])
            ->forSection($sectionId)
            ->forAcademicYear($academicYearId)
            ->get();
    }

    /**
     * Bulk delete timetable for a section.
     */
    public function clearSectionTimetable(int $sectionId, int $academicYearId): int
    {
        return Timetable::query()
            ->forSection($sectionId)
            ->forAcademicYear($academicYearId)
            ->delete();
    }

    /**
     * Get subjects available for a section.
     */
    public function getAvailableSubjects(int $sectionId)
    {
        $section = Section::findOrFail($sectionId);

        return Subject::where('grade_id', $section->grade_id)
            ->where('classroom_id', $section->classroom_id)
            ->active()
            ->pluck('name', 'id');
    }

    /**
     * Get teachers who can teach a specific subject.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAvailableTeachers(int $subjectId)
    {
        return TeacherAssignment::query()
            ->where('subject_id', $subjectId)
            ->with(['teacher' => function ($query) {
                $query->where('status', 1);
            }])
            ->get()
            ->pluck('teacher')
            ->filter()
            ->unique('id')
            ->map(function ($teacher) {
                return [
                    'id' => $teacher->id,
                    'name' => $teacher->name,
                ];
            })
            ->values();
    }

    /**
     * Copy timetable from one section to another.
     */
    public function copyTimetable(
        int $fromSectionId,
        int $toSectionId,
        int $fromAcademicYearId,
        int $toAcademicYearId
    ): int {
        $sourceTimetable = Timetable::query()
            ->forSection($fromSectionId)
            ->forAcademicYear($fromAcademicYearId)
            ->get();

        $copied = 0;

        foreach ($sourceTimetable as $slot) {
            try {
                $this->assignSlot([
                    'section_id' => $toSectionId,
                    'day_of_week_id' => $slot->day_of_week_id,
                    'class_period_id' => $slot->class_period_id,
                    'subject_id' => $slot->subject_id,
                    'teacher_id' => $slot->teacher_id,
                    'academic_year_id' => $toAcademicYearId,
                ]);
                $copied++;
            } catch (ValidationException $e) {
                // Skip conflicting slots
                continue;
            }
        }

        return $copied;
    }
}
