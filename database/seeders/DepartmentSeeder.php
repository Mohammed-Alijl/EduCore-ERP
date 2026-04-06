<?php

namespace Database\Seeders;

use App\Models\HumanResources\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Academic',
                'description' => 'Department responsible for teaching and academic activities',
            ],
            [
                'name' => 'Administration',
                'description' => 'Department handling administrative tasks and management',
            ],
            [
                'name' => 'Finance',
                'description' => 'Department managing financial operations and accounting',
            ],
            [
                'name' => 'IT & Technology',
                'description' => 'Department handling technology infrastructure and support',
            ],
            [
                'name' => 'Library',
                'description' => 'Department managing library resources and services',
            ],
            [
                'name' => 'Security',
                'description' => 'Department responsible for school security and safety',
            ],
            [
                'name' => 'Maintenance',
                'description' => 'Department handling cleaning, maintenance, and facility management',
            ],
            [
                'name' => 'Transportation',
                'description' => 'Department managing school transportation services',
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
