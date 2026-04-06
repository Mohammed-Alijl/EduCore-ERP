<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class ClassRoom extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;

    protected $fillable = ['name', 'grade_id', 'status', 'sort_order', 'notes'];

    public $translatable = ['name'];

    // ======================== SCOPES ========================
    public function scopeActive($query)
    {
        return $query->where('status', 1)->orderBy('sort_order', 'asc');
    }

    // ===============================================================
    // ======================== RELATIONSHIPS ========================
    // ===============================================================
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class, 'classroom_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'classroom_id');
    }
}
