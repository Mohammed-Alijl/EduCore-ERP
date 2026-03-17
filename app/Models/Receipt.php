<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Receipt extends Model
{
    protected $fillable = [
        'student_id',
        'academic_year_id',
        'paid_amount',
        'currency_code',
        'exchange_rate',
        'base_amount',
        'surcharge_amount',
        'payment_gateway_id',
        'transaction_id',
        'date',
        'description',
    ];

    protected $casts = [
        'paid_amount'   => 'decimal:2',
        'exchange_rate' => 'decimal:4',
        'base_amount'      => 'decimal:2',
        'surcharge_amount' => 'decimal:2',
        'date'             => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_code', 'code');
    }

    public function studentAccount(): MorphOne
    {
        return $this->morphOne(StudentAccount::class, 'transactionable');
    }

    public function paymentGateway(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class);
    }
}
