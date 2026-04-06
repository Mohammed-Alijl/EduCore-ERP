<?php

namespace App\Models\Scheduling;

use App\Models\Academic\Section;
use App\Models\Academic\Subject;
use App\Models\Users\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherAssignment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'teacher_id',
        'subject_id',
        'section_id',
        'academic_year',
    ];

    /**
     * Get the teacher that owns the assignment.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'teacher_id');
    }

    /**
     * Get the subject associated with the assignment.
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    /**
     * Get the section associated with the assignment.
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
