<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'starts_at',
        'ends_at',
        'is_current',
    ];

    protected $casts = [
        'starts_at' => 'date',
        'ends_at' => 'date',
        'is_current' => 'boolean',
    ];

    public function enrollmentsTo()
    {
        return $this->hasMany(StudentEnrollment::class, 'to_academic_year');
    }

    public function enrollmentsFrom()
    {
        return $this->hasMany(StudentEnrollment::class, 'from_academic_year');
    }

    public function graduatedStudents()
    {
        return $this->hasMany(Student::class, 'graduation_academic_year_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
