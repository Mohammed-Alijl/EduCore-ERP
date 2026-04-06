<?php

namespace App\Models\Assessments;

use App\Models\Assessments\AttemptQuestion;
use App\Models\Assessments\Exam;
use App\Models\Users\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    use HasFactory;

    public const STATUS_IN_PROGRESS = 1;

    public const STATUS_COMPLETED = 2;

    public const STATUS_TIMEOUT = 3;

    protected $fillable = [
        'exam_id',
        'student_id',
        'status',
        'score',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function attemptQuestions()
    {
        return $this->hasMany(AttemptQuestion::class);
    }
}
