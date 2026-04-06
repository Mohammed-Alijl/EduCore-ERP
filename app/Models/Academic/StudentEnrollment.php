<?php

namespace App\Models\Academic;

use App\Enums\EnrollmentStatus;
use App\Models\Academic\AcademicYear;
use App\Models\Academic\ClassRoom;
use App\Models\Academic\Grade;
use App\Models\Academic\Section;
use App\Models\Users\Admin;
use App\Models\Users\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentEnrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'from_grade',
        'from_classroom',
        'from_section',
        'from_academic_year',
        'to_grade',
        'to_classroom',
        'to_section',
        'to_academic_year',
        'enrollment_status',
        'admin_id',
    ];

    protected function casts(): array
    {
        return [
            'enrollment_status' => EnrollmentStatus::class,
        ];
    }

    // ======================== RELATIONSHIPS ========================

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    // FROM relationships
    public function fromGrade(): BelongsTo
    {
        return $this->belongsTo(Grade::class, 'from_grade');
    }

    public function fromClassroom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class, 'from_classroom');
    }

    public function fromSection(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'from_section');
    }

    public function fromAcademicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'from_academic_year');
    }

    // TO relationships
    public function toGrade(): BelongsTo
    {
        return $this->belongsTo(Grade::class, 'to_grade');
    }

    public function toClassroom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class, 'to_classroom');
    }

    public function toSection(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'to_section');
    }

    public function toAcademicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'to_academic_year');
    }

    // ======================== SCOPES ========================

    public function scopePromoted(Builder $query): Builder
    {
        return $query->where('enrollment_status', EnrollmentStatus::Promoted);
    }

    public function scopeRepeating(Builder $query): Builder
    {
        return $query->where('enrollment_status', EnrollmentStatus::Repeating);
    }

    public function scopeGraduated(Builder $query): Builder
    {
        return $query->where('enrollment_status', EnrollmentStatus::Graduated);
    }

    public function scopeForAcademicYear(Builder $query, int $yearId): Builder
    {
        return $query->where('to_academic_year', $yearId);
    }
}
