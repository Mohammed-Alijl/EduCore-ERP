<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PaymentVoucher extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'student_id',
        'academic_year_id',
        'payment_gateway_id',
        'amount',
        'currency_code',
        'exchange_rate',
        'base_amount',
        'date',
        'reference_number',
        'description',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * determine which attributes to log and how.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['amount', 'date', 'description'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('Finance - Payment Vouchers');
    }

    // --------------------------------------------------------
    // Relationship
    // --------------------------------------------------------
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function paymentGateway(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function studentAccount(): MorphOne
    {
        return $this->morphOne(StudentAccount::class, 'transactionable');
    }
}
