<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Employee\StoreRequest;
use App\Http\Requests\Admin\Employee\UpdateRequest;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class EmployeeController extends Controller implements HasMiddleware
{
    public function __construct(protected EmployeeService $employeeService) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_employees', only: ['index']),
            new Middleware('permission:create_employees', only: ['store']),
            new Middleware('permission:edit_employees', only: ['update']),
            new Middleware('permission:delete_employees', only: ['destroy']),
            new Middleware('permission:view-archived_employees', only: ['archive']),
            new Middleware('permission:restore_employees', only: ['restore']),
            new Middleware('permission:force-delete_employees', only: ['forceDelete']),
        ];
    }

    /**
     * Render the main listing page.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->employeeService->getEmployeesDataTable($request);
        }

        $lookups = $this->employeeService->getLookups();

        return view('admin.Users.employees.index', $lookups);
    }

    // ─── Store ────────────────────────────────────────────────────────────────

    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $this->employeeService->store($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => __('admin.Users.employees.messages.success.add'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?: __('admin.Users.employees.messages.failed'),
            ], 500);
        }
    }

    // ─── Update ───────────────────────────────────────────────────────────────

    public function update(UpdateRequest $request, Employee $employee): JsonResponse
    {
        try {
            $this->employeeService->update($employee, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => __('admin.Users.employees.messages.success.update'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?: __('admin.Users.employees.messages.failed.update'),
            ], 500);
        }
    }

    // ─── Destroy (soft-delete) ────────────────────────────────────────────────

    public function destroy(Employee $employee): JsonResponse
    {
        try {
            $this->employeeService->delete($employee);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.Users.employees.messages.success.delete'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => trans('admin.Users.employees.messages.failed.delete'),
            ], 500);
        }
    }

    // ─── List The Archive ────────────────────────────────────────────────

    public function archive(Request $request)
    {
        if ($request->ajax()) {
            return $this->employeeService->getArchivedDataTable($request);
        }

        try {
            $archivedCount = \App\Models\Employee::onlyTrashed()->count();
            return view('admin.Users.employees.archived', compact('archivedCount'));
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage() ?: trans('admin.Users.employees.messages.failed.archive'),
            ], 500);
        }
    }

    // ─── Restore ─────────────────────────────────────────────────────────────

    public function restore(int $id): JsonResponse
    {
        try {
            $this->employeeService->restore($id);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.Users.employees.messages.success.restore'),
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage() ?: trans('admin.Users.employees.messages.failed.restore'),
            ], 404);
        }
    }

    // ─── Destroy (force-delete) ────────────────────────────────────────────────

    public function forceDelete(int $id): JsonResponse
    {
        try {
            $this->employeeService->forceDelete($id);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.Users.employees.messages.success.delete'),
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage() ?: trans('admin.Users.employees.messages.failed.delete'),
            ], 500);
        }
    }

    public function deleteAttachment(int $id): JsonResponse
    {
        try {
            $this->employeeService->deleteAttachment($id);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.Users.employees.messages.success.delete'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
