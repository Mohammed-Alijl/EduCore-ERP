<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Designation;
use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all departments
        $academic = Department::where('name', 'Academic')->first();
        $administration = Department::where('name', 'Administration')->first();
        $finance = Department::where('name', 'Finance')->first();
        $it = Department::where('name', 'IT & Technology')->first();
        $library = Department::where('name', 'Library')->first();
        $security = Department::where('name', 'Security')->first();
        $maintenance = Department::where('name', 'Maintenance')->first();
        $transportation = Department::where('name', 'Transportation')->first();

        $designations = [
            // Academic Department - Teaching Positions
            [
                'name' => 'Senior Teacher',
                'description' => 'Experienced teacher with 5+ years of experience',
                'can_teach' => true,
                'department_id' => $academic->id,
                'default_salary' => 5000.00,
            ],
            [
                'name' => 'Teacher',
                'description' => 'Regular teaching position',
                'can_teach' => true,
                'department_id' => $academic->id,
                'default_salary' => 3500.00,
            ],
            [
                'name' => 'Junior Teacher',
                'description' => 'Entry-level teaching position',
                'can_teach' => true,
                'department_id' => $academic->id,
                'default_salary' => 2500.00,
            ],
            [
                'name' => 'Subject Coordinator',
                'description' => 'Coordinates a specific subject across all grades',
                'can_teach' => true,
                'department_id' => $academic->id,
                'default_salary' => 4500.00,
            ],
            [
                'name' => 'Lab Assistant',
                'description' => 'Assists with laboratory activities and experiments',
                'can_teach' => false,
                'department_id' => $academic->id,
                'default_salary' => 2000.00,
            ],

            // Administration Department
            [
                'name' => 'Principal',
                'description' => 'School principal and chief administrative officer',
                'can_teach' => false,
                'department_id' => $administration->id,
                'default_salary' => 8000.00,
            ],
            [
                'name' => 'Vice Principal',
                'description' => 'Assistant to the principal',
                'can_teach' => false,
                'department_id' => $administration->id,
                'default_salary' => 6500.00,
            ],
            [
                'name' => 'Administrative Officer',
                'description' => 'Handles administrative tasks and documentation',
                'can_teach' => false,
                'department_id' => $administration->id,
                'default_salary' => 3000.00,
            ],
            [
                'name' => 'Receptionist',
                'description' => 'Front desk receptionist',
                'can_teach' => false,
                'department_id' => $administration->id,
                'default_salary' => 1800.00,
            ],

            // Finance Department
            [
                'name' => 'Chief Accountant',
                'description' => 'Head of finance department',
                'can_teach' => false,
                'department_id' => $finance->id,
                'default_salary' => 5500.00,
            ],
            [
                'name' => 'Accountant',
                'description' => 'Handles financial records and transactions',
                'can_teach' => false,
                'department_id' => $finance->id,
                'default_salary' => 3500.00,
            ],
            [
                'name' => 'Cashier',
                'description' => 'Handles cash transactions',
                'can_teach' => false,
                'department_id' => $finance->id,
                'default_salary' => 2200.00,
            ],

            // IT & Technology Department
            [
                'name' => 'IT Manager',
                'description' => 'Manages technology infrastructure',
                'can_teach' => false,
                'department_id' => $it->id,
                'default_salary' => 5000.00,
            ],
            [
                'name' => 'IT Support Specialist',
                'description' => 'Provides technical support',
                'can_teach' => false,
                'department_id' => $it->id,
                'default_salary' => 3000.00,
            ],

            // Library Department
            [
                'name' => 'Head Librarian',
                'description' => 'Manages library operations',
                'can_teach' => false,
                'department_id' => $library->id,
                'default_salary' => 3500.00,
            ],
            [
                'name' => 'Librarian',
                'description' => 'Assists with library services',
                'can_teach' => false,
                'department_id' => $library->id,
                'default_salary' => 2500.00,
            ],

            // Security Department
            [
                'name' => 'Security Supervisor',
                'description' => 'Supervises security team',
                'can_teach' => false,
                'department_id' => $security->id,
                'default_salary' => 2800.00,
            ],
            [
                'name' => 'Security Guard',
                'description' => 'Provides security services',
                'can_teach' => false,
                'department_id' => $security->id,
                'default_salary' => 2000.00,
            ],

            // Maintenance Department
            [
                'name' => 'Maintenance Supervisor',
                'description' => 'Supervises maintenance staff',
                'can_teach' => false,
                'department_id' => $maintenance->id,
                'default_salary' => 2800.00,
            ],
            [
                'name' => 'Janitor',
                'description' => 'Handles cleaning and basic maintenance',
                'can_teach' => false,
                'department_id' => $maintenance->id,
                'default_salary' => 1500.00,
            ],
            [
                'name' => 'Maintenance Worker',
                'description' => 'Performs maintenance and repairs',
                'can_teach' => false,
                'department_id' => $maintenance->id,
                'default_salary' => 2000.00,
            ],

            // Transportation Department
            [
                'name' => 'Transportation Manager',
                'description' => 'Manages transportation services',
                'can_teach' => false,
                'department_id' => $transportation->id,
                'default_salary' => 3500.00,
            ],
            [
                'name' => 'Bus Driver',
                'description' => 'Drives school buses',
                'can_teach' => false,
                'department_id' => $transportation->id,
                'default_salary' => 2200.00,
            ],
            [
                'name' => 'Bus Attendant',
                'description' => 'Assists bus driver and students',
                'can_teach' => false,
                'department_id' => $transportation->id,
                'default_salary' => 1600.00,
            ],
        ];

        foreach ($designations as $designation) {
            Designation::create($designation);
        }
    }
}
