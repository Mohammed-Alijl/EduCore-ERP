<?php

namespace App\Http\Controllers\Admin\Academic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Section\StoreRequest;
use App\Http\Requests\Admin\Section\UpdateRequest;
use App\Models\Academic\Section;
use App\Services\Academic\ClassroomService;
use App\Services\Academic\GradeService;
use App\Services\Academic\SectionService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SectionController extends Controller implements HasMiddleware
{
    public function __construct(
        protected SectionService $sectionService,
        protected ClassroomService $classroomService,
        protected GradeService $gradeService) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_sections', only: ['index']),
            new Middleware('permission:create_sections', only: ['store']),
            new Middleware('permission:edit_sections', only: ['update']),
            new Middleware('permission:delete_sections', only: ['destroy']),
            new Middleware('permission:view-archived_sections', only: ['archive']),
            new Middleware('permission:restore_sections', only: ['restore']),
            new Middleware('permission:force-delete_sections', only: ['forceDelete']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->sectionService->getSectionsDataTable($request);
        }
        try {
            $lookups = $this->sectionService->getLookups();
            $grades = $this->gradeService->getAllWithClassrooms();

            return view('admin.Academic.sections.index', array_merge($lookups, compact('grades')));
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $this->sectionService->store($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => __('admin.Academic.sections.messages.success.add'),
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage() ?? __('admin.Academic.sections.messages.failed.add'),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Section $section)
    {
        try {
            $this->sectionService->update($section, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => __('admin.Academic.sections.messages.success.update'),
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage() ?? __('admin.Academic.sections.messages.failed.update'),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        try {
            $this->sectionService->delete($section);

            return response()->json([
                'status' => 'success',
                'message' => __('admin.Academic.sections.messages.success.archive'),
            ], 200);

        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage() ?? __('admin.Academic.sections.messages.failed.archive'),
            ], 500);
        }
    }

    public function archive(Request $request)
    {
        if ($request->ajax()) {
            return $this->sectionService->getArchivedSectionsDataTable($request);
        }
        try {
            $grades = $this->gradeService->getAllWithClassrooms();

            return view('admin.Academic.sections.archived', compact('grades'));
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage() ?? __('admin.Academic.sections.messages.failed.archive'),
            ], 500);
        }
    }

    public function restore($id)
    {
        try {
            $this->sectionService->restore($id);

            return response()->json([
                'status' => 'success',
                'message' => __('admin.Academic.sections.messages.success.restore'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?? __('admin.Academic.sections.messages.failed.restore'),
            ], 404);
        }
    }

    public function forceDelete($id)
    {
        try {
            $this->sectionService->forceDelete($id);

            return response()->json([
                'status' => 'success',
                'message' => __('admin.Academic.sections.messages.success.delete'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?? __('admin.Academic.sections.messages.failed.delete'),
            ], 500);
        }
    }

    public function getByClassroom(Request $request)
    {
        $sections = $this->sectionService->getClassroomSections($request->classroom_id);

        return response()->json([
            'success' => true,
            'data' => $sections,
        ]);
    }

    public function getByGrade(Request $request)
    {
        $sections = $this->sectionService->getGradeSections($request->grade_id);

        return response()->json([
            'success' => true,
            'data' => $sections,
        ]);
    }

    /**
     * Return students of a section as JSON (for Show Modal)
     */
    public function studentsOf(Section $section)
    {
        $students = $section->students()->with([])->get()->map(function ($s) {
            return [
                'id' => $s->id,
                'name' => $s->getTranslation('name', app()->getLocale()),
                'student_code' => $s->student_code,
                'status' => $s->status,
                'status_text' => $s->status ? trans('admin.global.active') : trans('admin.global.disabled'),
            ];
        });

        return response()->json(['success' => true, 'data' => $students]);
    }
}
