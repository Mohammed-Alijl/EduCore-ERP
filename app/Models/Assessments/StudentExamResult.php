<?php

namespace App\Models\Assessments;

use App\Models\Assessments\Exam;
use App\Models\Users\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExamResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'student_id',
        'final_score',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
