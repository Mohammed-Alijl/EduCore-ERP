<?php

namespace App\Services\LMS;

use App\Models\AcademicYear;
use App\Models\ClassRoom;
use App\Models\Grade;
use App\Models\Scheduling\OnlineClass;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class OnlineClassService
{

    public function getOnlineClassesQuery(array $filters): Builder
    {
        $query = OnlineClass::with(['academicYear', 'grade', 'classroom', 'section', 'teacher', 'subject']);

        return $this->applyFilters($query, $filters);
    }


    private function applyFilters(Builder $query, array $filters): Builder
    {
        $query->when($filters['academic_year_id'] ?? null, fn($q, $id) => $q->where('academic_year_id', $id));
        $query->when($filters['grade_id'] ?? null, fn($q, $id) => $q->where('grade_id', $id));
        $query->when($filters['classroom_id'] ?? null, fn($q, $id) => $q->where('classroom_id', $id));
        $query->when($filters['section_id'] ?? null, fn($q, $id) => $q->where('section_id', $id));
        $query->when($filters['teacher_id'] ?? null, fn($q, $id) => $q->where('teacher_id', $id));
        return $query->orderByDesc('start_at');
    }


    public function deleteOnlineClass(OnlineClass $onlineClass): bool
    {
        try {


            return $onlineClass->delete();
        } catch (\Exception $e) {
            Log::error("Error deleting online class {$onlineClass->id}: " . $e->getMessage());
            return false;
        }
    }

    public function getLookups()
    {
        return [
            'academic_years' => AcademicYear::orderBy('name')->get(),
            'grades'        => Grade::all(),
            'classrooms' => ClassRoom::all(),
            'sections' => Section::all(),
            'teachers' => \App\Models\Teacher::all(),
            'subjects' => Subject::all(),
        ];
    }
}
