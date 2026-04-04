<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\StoreRequest;
use App\Http\Requests\Admin\Admin\UpdateRequest;
use App\Models\Admin;
use App\Services\AdminService;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdminController extends Controller implements HasMiddleware
{
    public function __construct(protected AdminService $adminService, protected RoleService $roleService)
    {
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_admins', only: ['index']),
            new Middleware('permission:create_admins', only: ['store']),
            new Middleware('permission:edit_admins', only: ['update']),
            new Middleware('permission:delete_admins', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = $this->adminService->getAll();
        $roles = $this->roleService->getAll();

        return view('admin.admins.index', compact('admins', 'roles'));
    }

    /**
     * Store a newly created resource in storage via AJAX.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $this->adminService->store($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => __('admin.admins.messages.success.add')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('admin.admins.messages.failed.add')
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage via AJAX.
     */
    public function update(UpdateRequest $request, Admin $admin): JsonResponse
    {
        try {
            $this->adminService->update($admin, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => __('admin.admins.messages.success.update')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('admin.admins.messages.failed.update')
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage via AJAX.
     */
    public function destroy(Admin $admin): JsonResponse
    {
        try {
            $this->adminService->delete($admin);

            return response()->json([
                'status' => 'success',
                'message' => __('admin.admins.messages.success.delete')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('admin.admins.messages.failed.delete')
            ], 500);
        }
    }
}
