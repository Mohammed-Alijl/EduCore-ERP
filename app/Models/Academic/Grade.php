<?php

namespace App\Models\Academic;

use App\Models\Users\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Grade extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;

    protected $fillable = [
        'name',
        'notes',
        'status',
        'sort_order',
        'image',
    ];

    public $translatable = ['name'];

    public function scopeActive($query)
    {
        return $query->where('status', 1)->orderBy('sort_order', 'asc');
    }

    // ===============================================================
    // ======================== RELATIONSHIPS ========================
    // ===============================================================
    public function classrooms(): HasMany
    {
        return $this->hasMany(ClassRoom::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }
}
