<?php

namespace App\Services\Students;

use App\Enums\EnrollmentStatus;
use App\Models\Academic\AcademicYear;
use App\Models\Academic\Grade;
use App\Models\Student;
use App\Models\Academic\StudentEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class GraduationService
{
    public function getLookups(): array
    {
        return [
            'grades' => Grade::all(),
            'academicYears' => AcademicYear::orderBy('name')->get(),
        ];
    }

    public function getGraduatedStudentsDataTable(Request $request)
    {
        $query = Student::query()
            ->with(['grade', 'classroom', 'section', 'graduationAcademicYear'])
            ->where('is_graduated', true)
            ->select('students.*');

        $query = $this->applyFilters($query, $request);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('student_code', fn ($row) => $row->student_code)
            ->addColumn('name', fn ($row) => $row->getTranslation('name', app()->getLocale()))
            ->addColumn('last_grade_details', function ($row) {
                return $this->formatLastGradeDetails($row);
            })
            ->addColumn('graduation_year', function ($row) {
                return $row->graduationAcademicYear
                    ? $row->graduationAcademicYear->name
                    : '-';
            })
            ->addColumn('graduated_at', function ($row) {
                return $row->graduated_at
                    ? $row->graduated_at->format('d-m-Y')
                    : '-';
            })
            ->addColumn('actions', function ($row) {
                return view('admin.Students.graduations.partials._actions', compact('row'))->render();
            })
            ->rawColumns(['last_grade_details', 'actions'])
            ->make(true);
    }

    public function restore(int $studentId): bool
    {
        return DB::transaction(function () use ($studentId) {
            $student = Student::where('is_graduated', true)
                ->findOrFail($studentId);

            $graduationEnrollment = StudentEnrollment::where('student_id', $studentId)
                ->where('enrollment_status', EnrollmentStatus::Graduated)
                ->orderByDesc('created_at')
                ->first();

            if (! $graduationEnrollment) {
                throw new \Exception(__('admin.Students.graduations.messages.failed.no_enrollment'));
            }

            $fromYear = AcademicYear::find($graduationEnrollment->from_academic_year);

            $student->update([
                'grade_id' => $graduationEnrollment->from_grade,
                'classroom_id' => $graduationEnrollment->from_classroom,
                'section_id' => $graduationEnrollment->from_section,
                'academic_year' => $fromYear ? $fromYear->name : $student->academic_year,
                'status' => 1,
                'is_graduated' => false,
                'graduated_at' => null,
                'graduation_academic_year_id' => null,
            ]);

            $graduationEnrollment->delete();

            return true;
        });
    }

    private function applyFilters($query, Request $request)
    {
        return $query
            ->when($request->filled('filter_graduation_year'), function ($q) use ($request) {
                $q->where('graduation_academic_year_id', (int) $request->filter_graduation_year);
            });
    }

    private function formatLastGradeDetails(Student $student): string
    {
        $enrollment = StudentEnrollment::where('student_id', $student->id)
            ->where('enrollment_status', EnrollmentStatus::Graduated)
            ->with(['fromGrade', 'fromClassroom', 'fromSection'])
            ->orderByDesc('created_at')
            ->first();

        if (! $enrollment) {
            return '<span class="text-muted">-</span>';
        }

        $locale = app()->getLocale();
        $parts = [];

        if ($enrollment->fromGrade) {
            $parts[] = '<span class="badge badge-soft-primary">'.e($enrollment->fromGrade->getTranslation('name', $locale)).'</span>';
        }

        if ($enrollment->fromClassroom) {
            $parts[] = '<span class="badge badge-soft-info">'.e($enrollment->fromClassroom->getTranslation('name', $locale)).'</span>';
        }

        if ($enrollment->fromSection) {
            $parts[] = '<span class="badge badge-soft-secondary">'.e($enrollment->fromSection->getTranslation('name', $locale)).'</span>';
        }

        return empty($parts) ? '<span class="text-muted">-</span>' : implode(' ', $parts);
    }
}
