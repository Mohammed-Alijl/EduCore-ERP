<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Define the mapping of old model namespaces to new domain-based namespaces
        $modelMappings = [
            // Users models
            'App\\Models\\Admin' => 'App\\Models\\Users\\Admin',
            'App\\Models\\Student' => 'App\\Models\\Users\\Student',
            'App\\Models\\Teacher' => 'App\\Models\\Users\\Teacher',
            'App\\Models\\Guardian' => 'App\\Models\\Users\\Guardian',
            'App\\Models\\Employee' => 'App\\Models\\Users\\Employee',

            // Finance models
            'App\\Models\\Currency' => 'App\\Models\\Finance\\Currency',
            'App\\Models\\Fee' => 'App\\Models\\Finance\\Fee',
            'App\\Models\\FeeCategory' => 'App\\Models\\Finance\\FeeCategory',
            'App\\Models\\Invoice' => 'App\\Models\\Finance\\Invoice',
            'App\\Models\\PaymentGateway' => 'App\\Models\\Finance\\PaymentGateway',
            'App\\Models\\Receipt' => 'App\\Models\\Finance\\Receipt',
            'App\\Models\\PaymentVoucher' => 'App\\Models\\Finance\\PaymentVoucher',
            'App\\Models\\StudentAccount' => 'App\\Models\\Finance\\StudentAccount',
            'App\\Models\\StudentDiscount' => 'App\\Models\\Finance\\StudentDiscount',

            // Academic models
            'App\\Models\\AcademicYear' => 'App\\Models\\Academic\\AcademicYear',
            'App\\Models\\Book' => 'App\\Models\\Academic\\Book',
            'App\\Models\\ClassRoom' => 'App\\Models\\Academic\\ClassRoom',
            'App\\Models\\Grade' => 'App\\Models\\Academic\\Grade',
            'App\\Models\\Section' => 'App\\Models\\Academic\\Section',
            'App\\Models\\Specialization' => 'App\\Models\\Academic\\Specialization',
            'App\\Models\\StudentEnrollment' => 'App\\Models\\Academic\\StudentEnrollment',
            'App\\Models\\Subject' => 'App\\Models\\Academic\\Subject',

            // Assessments models
            'App\\Models\\Exam' => 'App\\Models\\Assessments\\Exam',
            'App\\Models\\ExamAttempt' => 'App\\Models\\Assessments\\ExamAttempt',
            'App\\Models\\Question' => 'App\\Models\\Assessments\\Question',
            'App\\Models\\StudentExamResult' => 'App\\Models\\Assessments\\StudentExamResult',
            'App\\Models\\QuestionOption' => 'App\\Models\\Assessments\\QuestionOption',
            'App\\Models\\AttemptQuestion' => 'App\\Models\\Assessments\\AttemptQuestion',

            // Attendance model
            'App\\Models\\Attendance' => 'App\\Models\\Attendance\\Attendance',

            // Scheduling models
            'App\\Models\\ClassPeriod' => 'App\\Models\\Scheduling\\ClassPeriod',
            'App\\Models\\OnlineClass' => 'App\\Models\\Scheduling\\OnlineClass',
            'App\\Models\\TeacherAssignment' => 'App\\Models\\Scheduling\\TeacherAssignment',
            'App\\Models\\Timetable' => 'App\\Models\\Scheduling\\Timetable',
            'App\\Models\\DayOfWeek' => 'App\\Models\\Scheduling\\DayOfWeek',

            // HumanResources models
            'App\\Models\\Department' => 'App\\Models\\HumanResources\\Department',
            'App\\Models\\Designation' => 'App\\Models\\HumanResources\\Designation',
            'App\\Models\\EmployeeAttachment' => 'App\\Models\\HumanResources\\EmployeeAttachment',

            // CMS models
            'App\\Models\\CmsPage' => 'App\\Models\\Cms\\CmsPage',
            'App\\Models\\CmsSection' => 'App\\Models\\Cms\\CmsSection',

            // Settings models
            'App\\Models\\ExternalApiSetting' => 'App\\Models\\Settings\\ExternalApiSetting',
            'App\\Models\\GeneralSetting' => 'App\\Models\\Settings\\GeneralSetting',

            // SystemData models
            'App\\Models\\Nationality' => 'App\\Models\\SystemData\\Nationality',
            'App\\Models\\Gender' => 'App\\Models\\SystemData\\Gender',
            'App\\Models\\Religion' => 'App\\Models\\SystemData\\Religion',
            'App\\Models\\TypeBlood' => 'App\\Models\\SystemData\\TypeBlood',
        ];

        // Update model_has_roles table (Spatie permissions)
        foreach ($modelMappings as $oldNamespace => $newNamespace) {
            DB::table('model_has_roles')
                ->where('model_type', $oldNamespace)
                ->update(['model_type' => $newNamespace]);
        }

        // Update model_has_permissions table (Spatie permissions)
        foreach ($modelMappings as $oldNamespace => $newNamespace) {
            DB::table('model_has_permissions')
                ->where('model_type', $oldNamespace)
                ->update(['model_type' => $newNamespace]);
        }

        // Update activity_log table (subject_type and causer_type)
        foreach ($modelMappings as $oldNamespace => $newNamespace) {
            DB::table('activity_log')
                ->where('subject_type', $oldNamespace)
                ->update(['subject_type' => $newNamespace]);

            DB::table('activity_log')
                ->where('causer_type', $oldNamespace)
                ->update(['causer_type' => $newNamespace]);
        }

        // Update notifications table (notifiable_type)
        foreach ($modelMappings as $oldNamespace => $newNamespace) {
            DB::table('notifications')
                ->where('notifiable_type', $oldNamespace)
                ->update(['notifiable_type' => $newNamespace]);
        }

        // Update student_accounts table (transactionable_type)
        foreach ($modelMappings as $oldNamespace => $newNamespace) {
            DB::table('student_accounts')
                ->where('transactionable_type', $oldNamespace)
                ->update(['transactionable_type' => $newNamespace]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Define the reverse mapping
        $modelMappings = [
            // Users models
            'App\\Models\\Users\\Admin' => 'App\\Models\\Admin',
            'App\\Models\\Users\\Student' => 'App\\Models\\Student',
            'App\\Models\\Users\\Teacher' => 'App\\Models\\Teacher',
            'App\\Models\\Users\\Guardian' => 'App\\Models\\Guardian',
            'App\\Models\\Users\\Employee' => 'App\\Models\\Employee',

            // Finance models
            'App\\Models\\Finance\\Currency' => 'App\\Models\\Currency',
            'App\\Models\\Finance\\Fee' => 'App\\Models\\Fee',
            'App\\Models\\Finance\\FeeCategory' => 'App\\Models\\FeeCategory',
            'App\\Models\\Finance\\Invoice' => 'App\\Models\\Invoice',
            'App\\Models\\Finance\\PaymentGateway' => 'App\\Models\\PaymentGateway',
            'App\\Models\\Finance\\Receipt' => 'App\\Models\\Receipt',
            'App\\Models\\Finance\\PaymentVoucher' => 'App\\Models\\PaymentVoucher',
            'App\\Models\\Finance\\StudentAccount' => 'App\\Models\\StudentAccount',
            'App\\Models\\Finance\\StudentDiscount' => 'App\\Models\\StudentDiscount',

            // Academic models
            'App\\Models\\Academic\\AcademicYear' => 'App\\Models\\AcademicYear',
            'App\\Models\\Academic\\Book' => 'App\\Models\\Book',
            'App\\Models\\Academic\\ClassRoom' => 'App\\Models\\ClassRoom',
            'App\\Models\\Academic\\Grade' => 'App\\Models\\Grade',
            'App\\Models\\Academic\\Section' => 'App\\Models\\Section',
            'App\\Models\\Academic\\Specialization' => 'App\\Models\\Specialization',
            'App\\Models\\Academic\\StudentEnrollment' => 'App\\Models\\StudentEnrollment',
            'App\\Models\\Academic\\Subject' => 'App\\Models\\Subject',

            // Assessments models
            'App\\Models\\Assessments\\Exam' => 'App\\Models\\Exam',
            'App\\Models\\Assessments\\ExamAttempt' => 'App\\Models\\ExamAttempt',
            'App\\Models\\Assessments\\Question' => 'App\\Models\\Question',
            'App\\Models\\Assessments\\StudentExamResult' => 'App\\Models\\StudentExamResult',
            'App\\Models\\Assessments\\QuestionOption' => 'App\\Models\\QuestionOption',
            'App\\Models\\Assessments\\AttemptQuestion' => 'App\\Models\\AttemptQuestion',

            // Attendance model
            'App\\Models\\Attendance\\Attendance' => 'App\\Models\\Attendance',

            // Scheduling models
            'App\\Models\\Scheduling\\ClassPeriod' => 'App\\Models\\ClassPeriod',
            'App\\Models\\Scheduling\\OnlineClass' => 'App\\Models\\OnlineClass',
            'App\\Models\\Scheduling\\TeacherAssignment' => 'App\\Models\\TeacherAssignment',
            'App\\Models\\Scheduling\\Timetable' => 'App\\Models\\Timetable',
            'App\\Models\\Scheduling\\DayOfWeek' => 'App\\Models\\DayOfWeek',

            // HumanResources models
            'App\\Models\\HumanResources\\Department' => 'App\\Models\\Department',
            'App\\Models\\HumanResources\\Designation' => 'App\\Models\\Designation',
            'App\\Models\\HumanResources\\EmployeeAttachment' => 'App\\Models\\EmployeeAttachment',

            // CMS models
            'App\\Models\\Cms\\CmsPage' => 'App\\Models\\CmsPage',
            'App\\Models\\Cms\\CmsSection' => 'App\\Models\\CmsSection',

            // Settings models
            'App\\Models\\Settings\\ExternalApiSetting' => 'App\\Models\\ExternalApiSetting',
            'App\\Models\\Settings\\GeneralSetting' => 'App\\Models\\GeneralSetting',

            // SystemData models
            'App\\Models\\SystemData\\Nationality' => 'App\\Models\\Nationality',
            'App\\Models\\SystemData\\Gender' => 'App\\Models\\Gender',
            'App\\Models\\SystemData\\Religion' => 'App\\Models\\Religion',
            'App\\Models\\SystemData\\TypeBlood' => 'App\\Models\\TypeBlood',
        ];

        // Reverse all updates
        foreach ($modelMappings as $newNamespace => $oldNamespace) {
            DB::table('model_has_roles')
                ->where('model_type', $newNamespace)
                ->update(['model_type' => $oldNamespace]);

            DB::table('model_has_permissions')
                ->where('model_type', $newNamespace)
                ->update(['model_type' => $oldNamespace]);

            DB::table('activity_log')
                ->where('subject_type', $newNamespace)
                ->update(['subject_type' => $oldNamespace]);

            DB::table('activity_log')
                ->where('causer_type', $newNamespace)
                ->update(['causer_type' => $oldNamespace]);

            DB::table('notifications')
                ->where('notifiable_type', $newNamespace)
                ->update(['notifiable_type' => $oldNamespace]);

            DB::table('student_accounts')
                ->where('transactionable_type', $newNamespace)
                ->update(['transactionable_type' => $oldNamespace]);
        }
    }
};
