<?php

namespace App\Enums;

enum EmployeeType: string
{
    case Teacher = 'teacher';
    case Staff = 'staff';
    case Accountant = 'accountant';
    case Librarian = 'librarian';
    case SecurityGuard = 'security_guard';
    case Driver = 'driver';
    case Cleaner = 'cleaner';

    public function label(): string
    {
        return match ($this) {
            self::Teacher => __('admin.employees.types.teacher'),
            self::Staff => __('admin.employees.types.staff'),
            self::Accountant => __('admin.employees.types.accountant'),
            self::Librarian => __('admin.employees.types.librarian'),
            self::SecurityGuard => __('admin.employees.types.security_guard'),
            self::Driver => __('admin.employees.types.driver'),
            self::Cleaner => __('admin.employees.types.cleaner'),
        };
    }

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
