<?php

namespace App\Http\Controllers\Admin\LMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Subject\StoreRequest;
use App\Http\Requests\Admin\Subject\UpdateRequest;
use App\Models\Academic\Subject;
use App\Services\LMS\SubjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SubjectController extends Controller implements HasMiddleware
{
    public function __construct(protected SubjectService $subjectService)
    {
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_subjects',          only: ['index']),
            new Middleware('permission:create_subjects',        only: ['store']),
            new Middleware('permission:edit_subjects',          only: ['update']),
            new Middleware('permission:delete_subjects',        only: ['destroy']),
            new Middleware('permission:view-archived_subjects', only: ['archive']),
            new Middleware('permission:restore_subjects',       only: ['restore']),
            new Middleware('permission:force-delete_subjects',  only: ['forceDelete']),
        ];
    }

    // ─── Index ────────────────────────────────────────────────────────────────

    public function index()
    {
        $subjects  = $this->subjectService->getAll();
        $lookups   = $this->subjectService->getLookups();

        return view('admin.Academic.subjects.index', compact('subjects', 'lookups'));
    }

    // ─── Store ────────────────────────────────────────────────────────────────

    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $this->subjectService->store($request->validated());

            return response()->json([
                'status'  => 'success',
                'message' => __('admin.Academic.subjects.messages.success.add'),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => __('admin.Academic.subjects.messages.failed.add'),
            ], 500);
        }
    }

    // ─── Update ───────────────────────────────────────────────────────────────

    public function update(UpdateRequest $request, Subject $subject): JsonResponse
    {
        try {
            $this->subjectService->update($subject, $request->validated());

            return response()->json([
                'status'  => 'success',
                'message' => __('admin.Academic.subjects.messages.success.update'),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => __('admin.Academic.subjects.messages.failed.update'),
            ], 500);
        }
    }

    // ─── Destroy ──────────────────────────────────────────────────────────────

    public function destroy(Subject $subject): JsonResponse
    {
        try {
            $this->subjectService->delete($subject);

            return response()->json([
                'status'  => 'success',
                'message' => __('admin.Academic.subjects.messages.success.delete'),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => __('admin.Academic.subjects.messages.failed.delete'),
            ], 500);
        }
    }

    // ─── List The Archive ────────────────────────────────────────────────

    public function archive()
    {
        try {
            $subjects= $this->subjectService->archive();
            return view('admin.Academic.subjects.archived', compact('subjects'));
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage() ?: trans('admin.Academic.subjects.messages.failed.archive')
            ], 500);
        }
    }

    // ─── Restore ─────────────────────────────────────────────────────────────

    public function restore(int $id): JsonResponse
    {
        try {
            $this->subjectService->restore($id);
            return response()->json([
                'status' => 'success',
                'message' => trans('admin.Academic.subjects.messages.success.restore')
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage() ?: trans('admin.Academic.subjects.messages.failed.restore')
            ], 404);
        }
    }

    // ─── Destroy (force-delete) ────────────────────────────────────────────────

    public function forceDelete($id)
    {
        try {
            $this->subjectService->forceDelete($id);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.Academic.subjects.messages.success.delete')
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage() ?: trans('admin.Academic.subjects.messages.failed.delete')
            ], 500);
        }
    }
}
