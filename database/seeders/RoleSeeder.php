<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'admins'    => ['view', 'create', 'edit', 'delete'],
            'roles'     => ['view', 'create', 'edit', 'delete'],
            'grades'    => ['view', 'create', 'edit', 'delete', 'view-archived', 'restore', 'force-delete'],
            'classrooms'=> ['view', 'create', 'edit', 'delete', 'view-archived', 'restore', 'force-delete'],
            'sections'  => ['view', 'create', 'edit', 'delete', 'view-archived', 'restore', 'force-delete'],
            'guardians' => ['view', 'create', 'edit', 'delete', 'view-archived', 'restore', 'force-delete'],
            'students'  => ['view', 'create', 'edit', 'delete', 'graduate', 'promote'],
            'teachers'  => ['view', 'create', 'edit', 'delete'],
            'invoices'  => ['view', 'create', 'edit', 'delete', 'print'],
        ];

        foreach ($permissions as $module => $actions) {
            foreach ($actions as $action) {
                Permission::create([
                    'name' => $action . '_' . $module,
                    'guard_name' => 'admin'
                ]);
            }
        }

        Role::create(['name' => 'Super Admin', 'guard_name' => 'admin']);
    }
}
