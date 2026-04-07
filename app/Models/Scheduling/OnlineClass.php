<?php

namespace App\Models\Scheduling;

use App\Models\Academic\AcademicYear;
use App\Models\Academic\ClassRoom;
use App\Models\Academic\Grade;
use App\Models\Academic\Section;
use App\Models\Academic\Subject;
use App\Models\Users\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OnlineClass extends Model
{
    use HasFactory;

    public const INTEGRATION_ZOOM = 1;

    public const INTEGRATION_MANUAL = 2;

    protected $fillable = [
        'integration_type',
        'academic_year_id',
        'grade_id',
        'classroom_id',
        'section_id',
        'teacher_id',
        'subject_id',
        'topic',
        'start_at',
        'duration',
        'meeting_id',
        'start_url',
        'join_url',
    ];

    protected $casts = [
        'start_at' => 'datetime',
    ];

    // --------------------------------------------------------
    // Relationships
    // --------------------------------------------------------

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'teacher_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}
