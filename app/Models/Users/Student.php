<?php

namespace App\Models\Users;

use App\Models\Academic\AcademicYear;
use App\Models\Academic\ClassRoom;
use App\Models\Academic\Grade;
use App\Models\Academic\Section;
use App\Models\Academic\StudentEnrollment;
use App\Models\Attendance\Attendance;
use App\Models\Finance\Invoice;
use App\Models\Finance\PaymentVoucher;
use App\Models\Finance\Receipt;
use App\Models\Finance\StudentAccount;
use App\Models\Finance\StudentDiscount;
use App\Models\SystemData\Gender;
use App\Models\SystemData\Nationality;
use App\Models\SystemData\Religion;
use App\Models\SystemData\TypeBlood;
use App\Models\Users\Admin;
use App\Models\Users\Guardian;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Spatie\Translatable\HasTranslations;

class Student extends Authenticatable
{
    use HasFactory, HasTranslations, SoftDeletes;

    public $translatable = ['name'];

    protected $fillable = [
        'name',
        'student_code',
        'email',
        'password',
        'national_id',
        'date_of_birth',
        'grade_id',
        'classroom_id',
        'section_id',
        'academic_year',
        'guardian_id',
        'blood_type_id',
        'nationality_id',
        'religion_id',
        'gender_id',
        'status',
        'is_graduated',
        'graduated_at',
        'graduation_academic_year_id',
        'image',
        'attachments',
        'admin_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'attachments' => 'array',
        'date_of_birth' => 'date',
        'email_verified_at' => 'datetime',
        'is_graduated' => 'boolean',
        'graduated_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getImageUrlAttribute()
    {
        if (! empty($this->image)) {
            return asset('storage/' . $this->image);
        }
        $gender = $this->gender->getTranslation('name', 'en');

        return $gender === 'Female'
            ? asset('assets/student/img/faces/girl_student.png')
            : asset('assets/student/img/faces/boy_student.png');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($student) {
            $currentYear = date('Y');
            $lastStudent = self::withTrashed()->where('student_code', 'like', $currentYear . '%')
                ->orderBy('student_code', 'desc')
                ->first();

            if ($lastStudent) {
                $lastSequence = (int) substr($lastStudent->student_code, 4);
                $newSequence = str_pad($lastSequence + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $newSequence = '0001';
            }
            $student->student_code = $currentYear . $newSequence;
        });
    }

    // ======================== RELATIONSHIPS ========================
    public function guardian()
    {
        return $this->belongsTo(Guardian::class, 'guardian_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function classroom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'nationality_id');
    }

    public function bloodType()
    {
        return $this->belongsTo(TypeBlood::class, 'blood_type_id');
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class, 'religion_id');
    }

    public function addedBy()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function enrollments()
    {
        return $this->hasMany(StudentEnrollment::class);
    }

    public function graduationAcademicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'graduation_academic_year_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }

    public function discounts()
    {
        return $this->hasMany(StudentDiscount::class);
    }

    public function paymentVouchers()
    {
        return $this->hasMany(PaymentVoucher::class);
    }

    public function studentAccounts()
    {
        return $this->hasMany(StudentAccount::class);
    }

    // ======================== SCOPES ========================

    public function scopeActive($query)
    {
        return $query->where('status', 1)->where('is_graduated', false);
    }

    public function scopeGraduated($query)
    {
        return $query->where('is_graduated', true);
    }

    public function scopeCurrentlyEnrolled($query)
    {
        return $query->whereNotNull('grade_id')
            ->whereNotNull('classroom_id')
            ->whereNotNull('section_id');
    }
}
