<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Student\StoreRequest;
use App\Http\Requests\Admin\Student\UpdateRequest;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Section;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class StudentController extends Controller implements HasMiddleware
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_students', only: ['index']),
            new Middleware('permission:create_students', only: ['store']),
            new Middleware('permission:edit_students', only: ['update']),
            new Middleware('permission:delete_students', only: ['destroy']),
            new Middleware('permission:view-archived_students', only: ['archive']),
            new Middleware('permission:restore_students', only: ['restore']),
            new Middleware('permission:force-delete_students', only: ['forceDelete']),
        ];
    }

    public function index()
    {
        $students = $this->studentService->getAll();
        $lookups = $this->studentService->getLookups();

        return view('admin.students.index', array_merge(['students' => $students], $lookups));
    }

    public function store(StoreRequest $request)
    {
        try {
            $this->studentService->store($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.students.messages.success.add')
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
                'message' => trans('admin.students.messages.success.update')
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => trans('admin.students.messages.failed.update')], 500);
        }
    }

    public function destroy(Student $student)
    {
        try {
            $this->studentService->delete($student);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.students.messages.success.delete')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => trans('admin.students.messages.failed.delete')
            ], 500);
        }
    }

    public function archive()
    {
        try {
            $students= $this->studentService->archive();
            return view('admin.students.archived', compact('students'));
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => trans('admin.students.messages.failed.archive')
            ], 500);
        }
    }

    public function restore($id)
    {
        try {
            $this->studentService->restore($id);
            return response()->json([
                'status' => 'success',
                'message' => trans('admin.students.messages.success.restore')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => trans('admin.students.messages.failed.restore')
            ], 404);
        }
    }

    public function forceDelete($id)
    {
        try {
            $this->studentService->forceDelete($id);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.students.messages.success.delete')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => trans('admin.students.messages.failed.delete')
            ], 500);
        }
    }

    public function getClassrooms($grade_id)
    {
        $classrooms = Classroom::where('grade_id', $grade_id)->pluck('name', 'id');
        return response()->json($classrooms);
    }

    public function getSections($classroom_id)
    {
        $sections = Section::where('classroom_id', $classroom_id)->pluck('name', 'id');
        return response()->json($sections);
    }
}
