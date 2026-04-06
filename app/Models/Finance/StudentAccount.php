<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class StudentAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'transactionable_type',
        'transactionable_id',
        'debit',
        'credit',
        'description',
        'date',
    ];

    protected $casts = [
        'debit' => 'decimal:2',
        'credit' => 'decimal:2',
        'date' => 'date',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }
}
