<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Subject\StoreRequest;
use App\Http\Requests\Admin\Subject\UpdateRequest;
use App\Models\Subject;
use App\Services\SubjectService;
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
            new Middleware('permission:view_subjects',   only: ['index']),
            new Middleware('permission:create_subjects', only: ['store']),
            new Middleware('permission:edit_subjects',   only: ['update']),
            new Middleware('permission:delete_subjects', only: ['destroy']),
        ];
    }

    // ─── Index ────────────────────────────────────────────────────────────────

    public function index()
    {
        $subjects  = $this->subjectService->getAll();
        $lookups   = $this->subjectService->getLookups();

        return view('admin.subjects.index', compact('subjects', 'lookups'));
    }

    // ─── Store ────────────────────────────────────────────────────────────────

    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $this->subjectService->store($request->validated());

            return response()->json([
                'status'  => 'success',
                'message' => __('admin.subjects.messages.success.add'),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => __('admin.subjects.messages.failed.add'),
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
                'message' => __('admin.subjects.messages.success.update'),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => __('admin.subjects.messages.failed.update'),
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
                'message' => __('admin.subjects.messages.success.delete'),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => __('admin.subjects.messages.failed.delete'),
            ], 500);
        }
    }
}
