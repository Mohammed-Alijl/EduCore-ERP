<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Student\StoreRequest;
use App\Http\Requests\Admin\Student\UpdateRequest;
use App\Models\Student;
use App\Services\StudentFinanceService;
use App\Services\StudentGradeService;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class StudentController extends Controller implements HasMiddleware
{
    public function __construct(
        protected readonly StudentService $studentService,
        protected readonly StudentFinanceService $financeService,
        protected readonly StudentGradeService $gradeService
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_students', only: ['index', 'finance', 'grades']),
            new Middleware('permission:create_students', only: ['store']),
            new Middleware('permission:edit_students', only: ['update']),
            new Middleware('permission:delete_students', only: ['destroy']),
            new Middleware('permission:view-archived_students', only: ['archive']),
            new Middleware('permission:restore_students', only: ['restore']),
            new Middleware('permission:force-delete_students', only: ['forceDelete']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->studentService->getStudentsDataTable($request);
        }

        $lookups = $this->studentService->getLookups();

        return view('admin.students.index', $lookups);
    }

    public function store(StoreRequest $request)
    {
        try {
            $this->studentService->store($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.students.messages.success.add'),
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateRequest $request, Student $student)
    {
        try {
            $this->studentService->update($student, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.students.messages.success.update'),
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage() ?? trans('admin.students.messages.failed.update'),
            ], 500);
        }
    }

    public function destroy(Student $student)
    {
        try {
            $this->studentService->delete($student);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.students.messages.success.delete'),
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage() ?? trans('admin.students.messages.failed.delete'),
            ], 500);
        }
    }

    public function archive(Request $request)
    {
        if ($request->ajax()) {
            return $this->studentService->getArchivedDataTable($request);
        }

        $grades = $this->studentService->getLookups()['grades'];

        return view('admin.students.archived', compact('grades'));
    }

    public function restore($id)
    {
        try {
            $this->studentService->restore($id);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.students.messages.success.restore'),
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage() ?? trans('admin.students.messages.failed.restore'),
            ], 404);
        }
    }

    public function forceDelete($id)
    {
        try {
            $this->studentService->forceDelete($id);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.students.messages.success.delete'),
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage() ?? trans('admin.students.messages.failed.delete'),
            ], 500);
        }
    }

    public function deleteAttachment(Request $request): \Illuminate\Http\JsonResponse
    {

        try {
            $this->studentService->deleteAttachment($request->key);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.students.messages.success.delete'),
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage() ?? trans('admin.students.messages.failed.delete'),
            ], 500);
        }
    }

    public function getNextStudentCode()
    {
        try {
            $student_code = $this->studentService->getNextStudentCode();

            return response()->json([
                'status' => 'success',
                'student_code' => $student_code,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function search(Request $request)
    {
        return response()->json([
            'status' => 'success',
            ...$this->studentService->searchForSelect($request),
        ]);
    }

    /**
     * Get student financial overview modal content.
     */
    public function finance(Student $student)
    {
        $data = $this->financeService->getFinancialOverview($student);

        return view('admin.students.finance_modal', $data);
    }

    public function grades(Request $request, Student $student)
    {
        $academicYearId = $request->input('academic_year_id');

        $data = $this->gradeService->getGradeData($student, $academicYearId);

        return view('admin.students.grades', $data);
    }
}
