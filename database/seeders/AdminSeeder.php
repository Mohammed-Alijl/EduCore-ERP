<?php

namespace Database\Seeders;

use App\Models\Users\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new Admin;
        $admin->name = 'Mohammad Alajel';
        $admin->email = 'admin@admin.com';
        $admin->password = Hash::make('123456789');
        $admin->status = 1;
        $admin->roles_name = ['Super Admin'];
        $admin->email_verified_at = now();
        $admin->save();
        $admin->assignRole('Super Admin');
    }
}
