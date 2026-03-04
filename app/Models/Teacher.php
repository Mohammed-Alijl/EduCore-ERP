<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Spatie\Translatable\HasTranslations;

class Teacher extends Authenticatable
{
    use HasFactory, SoftDeletes, HasTranslations;

    protected $fillable = [
        'teacher_code',
        'name',
        'email',
        'national_id',
        'password',
        'phone',
        'address',
        'joining_date',
        'gender_id',
        'specialization_id',
        'blood_type_id',
        'nationality_id',
        'religion_id',
        'status',
        'image',
    ];

    public $translatable = ['name'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'joining_date' => 'date',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getImageUrlAttribute()
    {
        if (!empty($this->image)) {
            return asset('storage/' . $this->image);
        }
        return asset('assets/admin/img/faces/admin.png');
    }

    protected static function booted()
    {
        static::creating(function ($teacher) {
            $prefix = 'TCH-' . date('Y') . '-';
            $lastTeacher = self::withTrashed()->where('teacher_code', 'like', $prefix . '%')
                ->orderBy('id', 'desc')
                ->first();

            if ($lastTeacher) {
                $lastNumber = str_replace($prefix, '', $lastTeacher->teacher_code);
                $nextNumber = str_pad((int)$lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $nextNumber = '0001';
            }
            $teacher->teacher_code = $prefix . $nextNumber;
        });
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function gender(): BelongsTo {
        return $this->belongsTo(Gender::class);
    }

    public function attachments(): HasMany {
        return $this->hasMany(TeacherAttachment::class,'teacher_id');
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

    public function specialization()
    {
        return $this->belongsTo(Specialization::class, 'specialization_id');
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    /**
     * Only active teachers.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

}
