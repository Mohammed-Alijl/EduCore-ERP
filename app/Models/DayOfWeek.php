<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class DayOfWeek extends Model
{
    use HasTranslations;

    protected $table = 'days_of_week';

    protected $fillable = [
        'key',
        'day_number',
        'name',
        'is_active',
        'is_weekend',
    ];

    public array $translatable = ['name'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_weekend' => 'boolean',
        ];
    }

    /**
     * Scope to get only active days.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get only weekend days.
     */
    public function scopeWeekend($query)
    {
        return $query->where('is_weekend', true);
    }

    /**
     * Scope to get only working days (non-weekend).
     */
    public function scopeWorkingDays($query)
    {
        return $query->where('is_weekend', false);
    }

    /**
     * Get days ordered by day number.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('day_number');
    }
}
