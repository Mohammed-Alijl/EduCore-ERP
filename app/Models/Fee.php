<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class Fee extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'amount',
        'fee_type',
        'academic_year_id',
        'grade_id',
        'classroom_id',
        'description',
    ];

    protected $translatable = ['title'];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    // --------------------------------------------------------
    // Relationships
    // --------------------------------------------------------

    public function feeCategory(): BelongsTo
    {
        return $this->belongsTo(FeeCategory::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class);
    }
}
