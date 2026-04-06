<?php

namespace App\Models\Assessments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    // ───  Grading Method ────────────────────────────────────────────────────────

    public const GRADING_HIGHEST = 1;
    public const GRADING_LATEST = 2;
    public const GRADING_AVERAGE = 3;


    // ───  Result Visibility ────────────────────────────────────────────────────────
    public const VISIBILITY_HIDDEN = 1;
    public const VISIBILITY_IMMEDIATE = 2;
    public const VISIBILITY_AFTER_ATTEMPTS = 3;
    public const VISIBILITY_AFTER_DATE = 4;

    protected $fillable = [
        'title',
        'subject_id',
        'teacher_id',
        'academic_year_id',
        'start_time',
        'end_time',
        'duration_minutes',
        'total_questions',
        'total_marks',
        'max_attempts',
        'grading_method',
        'result_visibility',
        'is_published'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_published' => 'boolean',
    ];

    //─── Relationships ────────────────────────────────────────────────────────
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Employee::class, 'teacher_id');
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'exam_section');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_questions');
    }

    public function attempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }

    public function finalResults()
    {
        return $this->hasMany(StudentExamResult::class);
    }

    public function AcademicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
