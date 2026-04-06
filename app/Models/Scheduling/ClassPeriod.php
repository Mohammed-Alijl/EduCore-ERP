<?php

namespace App\Models\Scheduling;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'sort_order',
        'duration',
        'status',
    ];

    public array $translatable = ['name'];

    protected function casts(): array
    {
        return [
            'is_break' => 'boolean',
            'status' => 'boolean',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
        ];
    }

    // ===============================================================
    // ========================== SCOPES =============================
    // ===============================================================

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order', 'asc');
    }

    public function scopeBreaks(Builder $query): Builder
    {
        return $query->where('is_break', true);
    }

    public function scopeRegular(Builder $query): Builder
    {
        return $query->where('is_break', false);
    }

    public function scopeForGrade(Builder $query, ?int $gradeId): Builder
    {
        if ($gradeId) {
            return $query->where(function ($q) use ($gradeId) {
                $q->where('grade_id', $gradeId)->orWhereNull('grade_id');
            });
        }

        return $query->whereNull('grade_id');
    }

    // ===============================================================
    // ======================== RELATIONSHIPS ========================
    // ===============================================================

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    // ===============================================================
    // ========================= ACCESSORS ===========================
    // ===============================================================

    public function getFormattedTimeRangeAttribute(): string
    {
        return $this->start_time->format('H:i') . ' - ' . $this->end_time->format('H:i');
    }
}
