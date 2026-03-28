<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Independent / Lookups - Required Seeders
        $this->call(RoleSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(LookupsSeeder::class);
        $this->call(CurrencySeeder::class);

        $this->call(PaymentGatewaySeeder::class);
        $this->call(AcademicYearSeeder::class);

        // 2. Organization / HR Types
        $this->call(DepartmentSeeder::class);
        $this->call(DesignationSeeder::class);
        $this->call(SpecializationSeeder::class);

        // 3. Academics Structure
        $this->call(GradeSeeder::class);
        $this->call(ClassRoomSeeder::class);
        $this->call(SectionSeeder::class);
        $this->call(SubjectSeeder::class);

        // 4. Users
        $this->call(EmployeeSeeder::class);
        $this->call(GuardianSeeder::class);
        $this->call(StudentSeeder::class);

        $this->call(TeacherAssignmentSeeder::class);

        // 5. Students & Enrollment
        $this->call(StudentAccountsSeeder::class);
        $this->call(StudentEnrollmentSeeder::class);

        // 6. Finances Structure
        $this->call(FeeCategorySeeder::class);
        $this->call(FeeSeeder::class);

        // 7. Student Finances
        $this->call(InvoiceSeeder::class);
        $this->call(ReceiptSeeder::class);
        $this->call(PaymentVoucherSeeder::class);
        $this->call(StudentDiscountSeeder::class);

        // 8. Exams, Attendance, and Misc
        $this->call(OnlineClassSeeder::class);
        $this->call(AttendanceSeeder::class);
        $this->call(ExamSeeder::class);
        $this->call(QuestionSeeder::class);
        $this->call(QuestionOptionSeeder::class);
        $this->call(ExamAttemptSeeder::class);
        $this->call(AttemptQuestionSeeder::class);
        $this->call(StudentExamResultSeeder::class);
        $this->call(BookSeeder::class);
        $this->call(EmployeeAttachmentSeeder::class);
        $this->call(ActivityLogSeeder::class);
    }
}
