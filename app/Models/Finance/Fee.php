<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class Fee extends Model
{
    use HasFactory, HasTranslations, LogsActivity;

    protected $fillable = [
        'title',
        'amount',
        'fee_category_id',
        'academic_year_id',
        'grade_id',
        'classroom_id',
        'description',
    ];

    protected $translatable = ['title'];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * determine which attributes to log and how.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'amount', 'fee_category_id', 'academic_year_id', 'grade_id', 'classroom_id', 'description'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('Finance - Fees');
    }

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
