<?php

namespace App\Http\Controllers\Admin\Academic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Classroom\StoreRequest;
use App\Http\Requests\Admin\Classroom\UpdateRequest;
use App\Models\ClassRoom;
use App\Services\ClassroomService;
use App\Services\GradeService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ClassroomController extends Controller implements HasMiddleware
{
    public function __construct(protected ClassroomService $classroomService, protected GradeService $gradeService)
    {
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_classrooms', only: ['index']),
            new Middleware('permission:create_classrooms', only: ['store']),
            new Middleware('permission:edit_classrooms', only: ['update']),
            new Middleware('permission:delete_classrooms', only: ['destroy']),
            new Middleware('permission:view-archived_classrooms', only: ['archive']),
            new Middleware('permission:restore_classrooms', only: ['restore']),
            new Middleware('permission:force-delete_classrooms', only: ['forceDelete']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $classrooms = $this->classroomService->getAll();
            $grades = $this->gradeService->getActive();
            return view('admin.classrooms.index', compact('classrooms', 'grades'));
        }catch (\Exception $ex){
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $this->classroomService->store($request->validated());
            return response()->json([
                'status' => 'success',
                'message' => __('admin.classrooms.messages.success.add')
            ],200);
        }catch (\Exception $ex){
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ],500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, ClassRoom $classroom)
    {
        try {
            $this->classroomService->update($classroom, $request->validated());
            return response()->json([
                'status' => 'success',
                'message' => __('admin.classrooms.messages.success.update')
            ],200);
        }catch (\Exception $ex){
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassRoom $classroom)
    {
        try {
            $this->classroomService->delete($classroom);

            return response()->json([
                'status' => 'success',
                'message' => __('admin.classrooms.messages.success.archive')
            ], 200);

        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function archive()
    {
        try {
            $classrooms = $this->classroomService->archive();
            $grades = $this->gradeService->getActive();
            return view('admin.classrooms.archived', compact('classrooms', 'grades'));
        } catch (\Exception $ex){
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ],500);
        }
    }

    public function restore($id)
    {
        try {
          $this->classroomService->restore($id);
            return response()->json([
                'status' => 'success',
                'message' => __('admin.classrooms.messages.success.restore')
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 404);
        }
    }

    public function forceDelete($id)
    {
        try {
            $this->classroomService->forceDelete($id);

            return response()->json([
                'status' => 'success',
                'message' => __('admin.classrooms.messages.success.delete')
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function getByGrade(Request $request)
    {
        $classrooms = $this->classroomService->getGradeClassrooms($request->grade_id);
        return response()->json([
            'success' => true,
            'data' => $classrooms
        ]);
    }
}
