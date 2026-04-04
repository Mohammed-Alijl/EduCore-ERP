<?php

namespace App\Http\Controllers\Admin\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Designation\StoreRequest;
use App\Http\Requests\Admin\Designation\UpdateRequest;
use App\Models\Department;
use App\Models\Designation;
use App\Services\DesignationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class DesignationController extends Controller implements HasMiddleware
{
    public function __construct(protected DesignationService $designationService) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_designations', only: ['index']),
            new Middleware('permission:create_designations', only: ['store']),
            new Middleware('permission:edit_designations', only: ['update']),
            new Middleware('permission:delete_designations', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $designations = $this->designationService->getAll();
        $departments = Department::query()->orderBy('name')->get(['id', 'name']);

        return view('admin.designations.index', compact('designations', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $this->designationService->store($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.designations.messages.success.add'),
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Designation $designation): JsonResponse
    {
        try {
            $this->designationService->update($designation, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.designations.messages.success.update'),
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Designation $designation): JsonResponse
    {
        try {
            $this->designationService->delete($designation);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.designations.messages.success.delete'),
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get designations for a specific department (AJAX)
     */
    public function getByDepartment(Request $request): JsonResponse
    {
        $designations = $this->designationService->getByDepartment($request->department_id);

        return response()->json($designations);
    }
}
