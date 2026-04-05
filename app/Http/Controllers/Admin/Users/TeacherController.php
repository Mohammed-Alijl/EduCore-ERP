<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Teacher\StoreRequest;
use App\Http\Requests\Admin\Teacher\UpdateRequest;
use App\Models\Teacher;
use App\Services\TeacherService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class TeacherController extends Controller implements HasMiddleware
{
    public function __construct(protected TeacherService  $teacherService)
    {
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_teachers', only: ['index']),
            new Middleware('permission:create_teachers', only: ['store']),
            new Middleware('permission:edit_teachers', only: ['update']),
            new Middleware('permission:delete_teachers', only: ['destroy']),
            new Middleware('permission:view-archived_teachers', only: ['archive']),
            new Middleware('permission:restore_teachers', only: ['restore']),
            new Middleware('permission:force-delete_teachers', only: ['forceDelete']),
        ];
    }
    /**
     * Render the main listing page.
     */
    public function index()
    {
        $lookups = $this->teacherService->getLookups();
        $teachers = $this->teacherService->getAll();
        return view('admin.Users.teachers.index', array_merge(['teachers' => $teachers], $lookups));
    }

    // ─── Store ────────────────────────────────────────────────────────────────

    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $this->teacherService->store($request->validated());
            return response()->json([
                'status'  => 'success',
                'message' => __('admin.Users.teachers.messages.success.add'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage() ?: __('admin.Users.teachers.messages.failed'),
            ], 500);
        }
    }

    // ─── Update ───────────────────────────────────────────────────────────────

    public function update(UpdateRequest $request, Teacher $teacher): JsonResponse
    {
        try {
            $this->teacherService->update($teacher, $request->validated());
            return response()->json([
                'status'  => 'success',
                'message' => __('admin.Users.teachers.messages.success.update'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage() ?: __('admin.Users.teachers.messages.failed.update'),
            ], 500);
        }
    }

    // ─── Destroy (soft-delete) ────────────────────────────────────────────────

    public function destroy(Teacher $teacher): JsonResponse
    {
        try {
            $this->teacherService->delete($teacher);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.Users.teachers.messages.success.delete')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => trans('admin.Users.teachers.messages.failed.delete')
            ], 500);
        }
    }

    // ─── List The Archive ────────────────────────────────────────────────

    public function archive()
    {
        try {
            $teachers= $this->teacherService->archive();
            return view('admin.Users.teachers.archived', compact('teachers'));
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage() ?: trans('admin.Users.teachers.messages.failed.archive')
            ], 500);
        }
    }

    // ─── Restore ─────────────────────────────────────────────────────────────

    public function restore(int $id): JsonResponse
    {
        try {
            $this->teacherService->restore($id);
            return response()->json([
                'status' => 'success',
                'message' => trans('admin.Users.teachers.messages.success.restore')
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage() ?: trans('admin.Users.teachers.messages.failed.restore')
            ], 404);
        }
    }

    // ─── Destroy (force-delete) ────────────────────────────────────────────────

    public function forceDelete($id)
    {
        try {
            $this->teacherService->forceDelete($id);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.Users.teachers.messages.success.delete')
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage() ?: trans('admin.Users.teachers.messages.failed.delete')
            ], 500);
        }
    }

    public function getNextTeacherCode() {
        try {
            $teacher_code = $this->teacherService->getNextTeacherCode();
            return response()->json([
                'status' => 'success',
                'teacher_code' => $teacher_code
            ]);

        }catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteAttachment($id): JsonResponse
    {
        try {
            $this->teacherService->deleteAttachment($id);
            return response()->json([
                'status' => 'success',
                'message' => trans('admin.Users.teachers.messages.success.delete')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
