<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

class GeneralSetting extends Model
{
    use HasTranslations;

    protected $fillable = [
        'school_name',
        'email',
        'phone',
        'fax',
        'website',
        'address',
        'logo',
        'current_academic_year_id',
        'social_media',
    ];

    public array $translatable = ['school_name', 'address'];

    protected function casts(): array
    {
        return [
            'social_media' => 'array',
        ];
    }

    // ===============================================================
    // ========================= ACCESSORS ===========================
    // ===============================================================

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? Storage::disk('public')->url($this->logo) : null;
    }

    // ===============================================================
    // ======================== RELATIONSHIPS ========================
    // ===============================================================

    public function currentAcademicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'current_academic_year_id');
    }

    // ===============================================================
    // ========================== METHODS ============================
    // ===============================================================

    /**
     * Get the singleton instance of settings.
     */
    public static function instance(): self
    {
        return static::firstOrCreate([], [
            'school_name' => ['en' => 'School Name', 'ar' => 'اسم المدرسة'],
        ]);
    }
}
