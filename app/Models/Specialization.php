<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Specialization extends Model
{
    use HasTranslations;

    public $translatable = ['name'];
    protected $fillable = ['name'];


    // ─── Relationships ────────────────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    // ─── Relationships ────────────────────────────────────────────────────────
    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'specialization_id');
    }

    public function subjects()
    {
        return $this->hasMany(Specialization::class, 'specialization_id');
    }
}
