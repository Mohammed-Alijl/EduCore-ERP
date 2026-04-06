<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Subject extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    /**
     * The attributes that are translatable.
     */
    public array $translatable = ['name'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'specialization_id',
        'grade_id',
        'classroom_id',
        'status',
        'admin_id',
    ];

    // ─── Scopes ────────────────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class);
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
