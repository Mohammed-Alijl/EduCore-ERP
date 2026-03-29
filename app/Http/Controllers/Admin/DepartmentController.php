<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Department\StoreRequest;
use App\Http\Requests\Admin\Department\UpdateRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DepartmentController extends Controller implements HasMiddleware
{
    public function __construct(protected DepartmentService $departmentService) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_department', only: ['index']),
            new Middleware('permission:create_department', only: ['store']),
            new Middleware('permission:edit_department', only: ['update']),
            new Middleware('permission:delete_department', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\View\View
    {
        $departments = $this->departmentService->getAll();

        return view('admin.departments.index', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->departmentService->store($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.departments.messages.success.add'),
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Department $department): \Illuminate\Http\JsonResponse
    {
        try {
            $this->departmentService->update($department, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.departments.messages.success.update'),
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department): \Illuminate\Http\JsonResponse
    {
        try {
            $this->departmentService->delete($department);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.departments.messages.success.delete'),
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
