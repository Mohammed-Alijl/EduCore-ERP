<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\StoreRequest;
use App\Http\Requests\Admin\Role\UpdateRequest;
use App\Services\System\RoleService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Role;

class RoleController extends Controller implements HasMiddleware
{
    public function __construct(protected RoleService $roleService)
    {
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_roles', only: ['index','show']),
            new Middleware('permission:create_roles', only: ['create','store']),
            new Middleware('permission:edit_roles', only: ['edit','update']),
            new Middleware('permission:delete_roles', only: ['destroy']),
        ];
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = $this->roleService->getAll();
        $groupedPermissions = $this->roleService->getGroupedPermissions();
        return view('admin.System.roles.index', compact('roles', 'groupedPermissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groupedPermissions = $this->roleService->getGroupedPermissions();
        return view('admin.System.roles.create', compact('groupedPermissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $this->roleService->store($request->validated());
            return response()->json([
                'status' => 'success',
                'message' => __('admin.System.roles.messages.success.add')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => __('admin.System.roles.messages.failed.add')
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        if ($role->name === $this->roleService::SUPER_ADMIN_NAME) {
            return redirect()->route('admin.System.roles.index');
        }
        $groupedPermissions = $this->roleService->getGroupedPermissions();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('admin.System.roles.edit', compact('role', 'groupedPermissions','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Role $role)
    {
        try {
            $this->roleService->update($role,$request->validated());
            return redirect()->route('admin.System.roles.index')->with(['status' => 'success', 'message' => __('admin.System.roles.messages.success.update')]);
        } catch (\Exception $e) {
            return redirect()->route('admin.System.roles.index')->withErrors(['status' => 'failed', 'message' => __('admin.System.roles.messages.failed.update')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            if($this->roleService->delete($role))
                    return response()->json([
                        'status' => 'success',
                        'message' => __('admin.System.roles.messages.success.delete')
                    ], 200);
            else
                return response()->json([
                    'status' => 'error',
                    'message' => __('admin.System.roles.messages.failed.used')
                ], 422);
        }catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => __('admin.System.roles.messages.failed.delete')
            ], 403);
        }
    }
}
