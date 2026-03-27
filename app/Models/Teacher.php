<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Employee
{
    protected $table = 'employees';

    protected static function booted(): void
    {
        static::addGlobalScope('teacher', function (Builder $builder) {
            $builder->whereHas('designation', function ($query) {
                $query->where('can_teach', true);
            });
        });

        static::creating(function (Teacher $teacher) {
            $prefix = 'TCH-'.date('Y').'-';
            $lastTeacher = self::withoutGlobalScope('teacher')
                ->withTrashed()
                ->where('employee_code', 'like', $prefix.'%')
                ->orderBy('id', 'desc')
                ->first();

            if ($lastTeacher) {
                $lastNumber = str_replace($prefix, '', $lastTeacher->employee_code);
                $nextNumber = str_pad((int) $lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $nextNumber = '0001';
            }
            $teacher->employee_code = $prefix.$nextNumber;
        });
    }

    // ─── Teacher-Specific Relationships ──────────────────────────────────────

    public function assignments(): HasMany
    {
        return $this->hasMany(TeacherAssignment::class, 'teacher_id');
    }
}
