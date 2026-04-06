<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

class Guardian extends Authenticatable
{
    use HasFactory, HasTranslations, Notifiable, SoftDeletes;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $translatable = [
        'name_father',
        'job_father',
        'name_mother',
        'job_mother',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::url($this->image);
        }

        return asset('assets/guardian/img/faces/default-avatar.png');
    }

    public function nationalityFather()
    {
        return $this->belongsTo(Nationality::class, 'nationality_father_id');
    }

    public function bloodTypeFather()
    {
        return $this->belongsTo(TypeBlood::class, 'blood_type_father_id');
    }

    public function religionFather()
    {
        return $this->belongsTo(Religion::class, 'religion_father_id');
    }

    public function nationalityMother()
    {
        return $this->belongsTo(Nationality::class, 'nationality_mother_id');
    }

    public function bloodTypeMother()
    {
        return $this->belongsTo(TypeBlood::class, 'blood_type_mother_id');
    }

    public function religionMother()
    {
        return $this->belongsTo(Religion::class, 'religion_mother_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'guardian_id');
    }
}
