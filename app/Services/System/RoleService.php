<?php

namespace App\Services\System;

use Exception;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleService
{
    const SUPER_ADMIN_NAME = 'Super Admin';
    /**
     * get Roles with permissions count
     */
    public function getAll()
    {
        return Role::where('name', '!=', self::SUPER_ADMIN_NAME)->withCount('permissions')->get();
    }

    /**
     * Get permissions grouped by his permissions
     * [
     * 'admins' => [PermissionObj, PermissionObj],
     * 'products' => [PermissionObj, ...],
     * ]
     */
    public function getGroupedPermissions()
    {
        $permissions = Permission::get();
        $grouped = [];

        foreach ($permissions as $permission) {
            $parts = explode('_', $permission->name, 2);
            $model = $parts[1] ?? 'other';
            $grouped[$model][] = $permission;
        }

        ksort($grouped);
        return $grouped;
    }

    /**
     * get all permissions
     */
    public function getAllPermissions()
    {
        return Permission::all();
    }

    public function store(array $data)
    {
        if (strtolower($data['name']) === strtolower(self::SUPER_ADMIN_NAME)) {
            throw new Exception(__('admin.System.roles.messages.failed.reserved_name'));
        }

        $role = Role::create(['name' => $data['name']]);

        $role->syncPermissions($data['permissions'] ?? []);

        return $role;
    }

    public function update($role, array $data)
    {
        if ($role->name === self::SUPER_ADMIN_NAME) {
            throw new Exception( __('admin.System.roles.messages.failed.update'));
        }
        $role->update(['name' => $data['name']]);
        $role->syncPermissions($data['permissions'] ?? []);

        return $role;
    }

    public function delete($role)
    {
        if ($role->name === self::SUPER_ADMIN_NAME) {
            throw new Exception(__('admin.System.roles.messages.failed.delete'));
        }

        if ($role->users()->count() > 0)
            return false;

        $role->delete();
            return true;
    }
}
