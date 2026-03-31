<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ClassPeriod extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'grade_id',
        'is_break',
        'order',
        'duration',
    ];

    public $translatable = ['name'];

    protected $casts = [
        'is_break' => 'boolean',
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
