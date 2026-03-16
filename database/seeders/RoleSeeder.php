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
            'admins'            => ['view', 'create', 'edit', 'delete'],
            'roles'             => ['view', 'create', 'edit', 'delete'],
            'grades'            => ['view', 'create', 'edit', 'delete', 'view-archived', 'restore', 'force-delete'],
            'years'             => ['view', 'create', 'edit'],
            'classrooms'        => ['view', 'create', 'edit', 'delete', 'view-archived', 'restore', 'force-delete'],
            'sections'          => ['view', 'create', 'edit', 'delete', 'view-archived', 'restore', 'force-delete'],
            'guardians'         => ['view', 'create', 'edit', 'delete', 'view-archived', 'restore', 'force-delete'],
            'students'          => ['view', 'create', 'edit', 'delete', 'view-archived', 'restore', 'force-delete', 'graduate', 'promote'],
            'teachers'          => ['view', 'create', 'edit', 'delete', 'view-archived', 'restore', 'force-delete',],
            'specializations'   => ['view', 'create', 'edit', 'delete'],
            'subjects'          => ['view', 'create', 'print', 'delete', 'view-archived', 'restore', 'force-delete',],
            'attendances'       => ['view', 'create', 'print'],
            'online_classes'    => ['view', 'delete'],
            'exams'             => ['view', 'view-student-attempts', 'reset-attempts'],
            'fees'              => ['view', 'create', 'edit', 'delete'],
            'invoices'          => ['view', 'create', 'delete', 'print'],
            'receipts'          => ['view', 'create', 'delete', 'print'],
            'currencies'        => ['view', 'create', 'edit', 'delete'],
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
