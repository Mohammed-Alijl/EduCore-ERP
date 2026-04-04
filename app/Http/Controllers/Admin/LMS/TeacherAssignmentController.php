<?php

namespace App\Http\Controllers\Admin\LMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeacherAssignment\StoreRequest;
use App\Http\Requests\Admin\TeacherAssignment\UpdateRequest;
use App\Models\TeacherAssignment;
use App\Services\TeacherAssignmentService;
use Illuminate\Http\Request;

class TeacherAssignmentController extends Controller
{
    protected TeacherAssignmentService $assignmentService;

    public function __construct(TeacherAssignmentService $assignmentService)
    {
        $this->assignmentService = $assignmentService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->assignmentService->getAssignmentsDataTable($request);
        }

        $lookups = $this->assignmentService->getLookups();

        return view('admin.teacher_assignments.index', compact('lookups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $this->assignmentService->store($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.teachers.messages.success.add')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $assignment = TeacherAssignment::with('section.classroom.grade')->findOrFail($id);

        return response()->json([
            'id' => $assignment->id,
            'teacher_id' => $assignment->teacher_id,
            'subject_id' => $assignment->subject_id,
            'grade_id' => $assignment->section->classroom->grade_id ?? null,
            'classroom_id' => $assignment->section->classroom_id ?? null,
            'classroom_name' => $assignment->section->classroom->name ?? '',
            'section_id' => $assignment->section_id,
            'section_name' => $assignment->section->name ?? '',
            'academic_year' => $assignment->academic_year,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        try {
            $assignment = TeacherAssignment::findOrFail($id);
            $this->assignmentService->update($assignment, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.teachers.messages.success.update')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeacherAssignment $assignment)
    {
        try {
            $this->assignmentService->delete($assignment);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.teachers.messages.success.delete')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
