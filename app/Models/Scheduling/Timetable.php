<?php

namespace App\Models\Scheduling;

use App\Models\Academic\AcademicYear;
use App\Models\Academic\Section;
use App\Models\Academic\Subject;
use App\Models\Scheduling\ClassPeriod;
use App\Models\Scheduling\DayOfWeek;
use App\Models\Users\Employee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Timetable extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'day_of_week_id',
        'class_period_id',
        'subject_id',
        'teacher_id',
        'academic_year_id',
    ];

    // ===============================================================
    // ======================== RELATIONSHIPS ========================
    // ===============================================================

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function dayOfWeek(): BelongsTo
    {
        return $this->belongsTo(DayOfWeek::class);
    }

    public function classPeriod(): BelongsTo
    {
        return $this->belongsTo(ClassPeriod::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'teacher_id');
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    // ===============================================================
    // ========================== SCOPES =============================
    // ===============================================================

    public function scopeForSection(Builder $query, int $sectionId): Builder
    {
        return $query->where('section_id', $sectionId);
    }

    public function scopeForAcademicYear(Builder $query, int $academicYearId): Builder
    {
        return $query->where('academic_year_id', $academicYearId);
    }

    public function scopeForTeacher(Builder $query, int $teacherId): Builder
    {
        return $query->where('teacher_id', $teacherId);
    }

    public function scopeForDay(Builder $query, int $dayOfWeekId): Builder
    {
        return $query->where('day_of_week_id', $dayOfWeekId);
    }

    public function scopeForPeriod(Builder $query, int $classPeriodId): Builder
    {
        return $query->where('class_period_id', $classPeriodId);
    }
}
