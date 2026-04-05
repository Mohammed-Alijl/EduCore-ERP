<?php

namespace App\Services\LMS;

use App\Models\TeacherAssignment;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Grade;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TeacherAssignmentService
{
    /**
     * Get the DataTables response for Teacher Assignments.
     */
    public function getAssignmentsDataTable(Request $request)
    {
        $assignments = TeacherAssignment::with([
            'teacher',
            'subject',
            'section.classroom.grade'
        ])->select('teacher_assignments.*');

        // Apply filters
        if ($request->filled('filter_teacher')) {
            $assignments->where('teacher_id', (int) $request->filter_teacher);
        }

        if ($request->filled('filter_section')) {
            $assignments->where('section_id', (int) $request->filter_section);
        } elseif ($request->filled('filter_classroom')) {
            $assignments->whereHas('section', function ($q) use ($request) {
                $q->where('classroom_id', (int) $request->filter_classroom);
            });
        } elseif ($request->filled('filter_grade')) {
            $assignments->whereHas('section.classroom', function ($q) use ($request) {
                $q->where('grade_id', (int) $request->filter_grade);
            });
        }

        return DataTables::eloquent($assignments)
            ->addColumn('teacher_name', function ($assignment) {
                return $assignment->teacher->name ?? '-';
            })
            ->addColumn('subject_name', function ($assignment) {
                return $assignment->subject->name ?? '-';
            })
            ->addColumn('section_info', function ($assignment) {
                $section = $assignment->section;
                if (!$section) {
                    return '-';
                }

                $grade = $section->classroom->grade->name ?? '';
                $classroom = $section->classroom->name ?? '';
                $sectionName = $section->name ?? '';

                return trim("{$grade} - {$classroom} - {$sectionName}", ' -');
            })
            ->addColumn('academic_year', function ($assignment) {
                return $assignment->academic_year;
            })
            ->addColumn('actions', function ($assignment) {
                return view('admin.LMS.teacher_assignments.partials._actions', compact('assignment'))->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Get all lookups needed for the index page and modals.
     */
    public function getLookups(): array
    {
        $currentYear = (int) date('Y');

        return [
            'teachers' => Teacher::select('id', 'name')->get(),
            'subjects' => Subject::select('id', 'name')->get(),
            'grades' => Grade::select('id', 'name')->get(),
            'academic_years' => [
                $currentYear . '-' . ($currentYear + 1),
                ($currentYear + 1) . '-' . ($currentYear + 2),
            ]
        ];
    }

    /**
     * Store a new assignment.
     */
    public function store(array $data)
    {
        return TeacherAssignment::create($data);
    }

    /**
     * Update an existing assignment.
     */
    public function update($assignment, array $data)
    {
        $assignment->update($data);
        return $assignment;
    }

    /**
     * Delete an assignment.
     */
    public function delete($assignment)
    {
        return $assignment->delete();
    }
}
