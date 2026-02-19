<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory, SoftDeletes, HasTranslations;

    public $translatable = ['name'];

    protected $fillable = [
        'name',
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
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    //======================== RELATIONSHIPS ========================
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
        return $this->belongsTo(Classroom::class, 'classroom_id');
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
}
