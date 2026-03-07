<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function classroom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
