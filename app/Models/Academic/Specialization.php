<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Specialization extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name'];

    protected $fillable = ['name'];

    // ─── Relationships ────────────────────────────────────────────────────────
    public function employees()
    {
        return $this->hasMany(Employee::class, 'specialization_id');
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'specialization_id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'specialization_id');
    }
}
