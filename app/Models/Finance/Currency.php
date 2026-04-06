<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class Currency extends Model
{
    use HasFactory, HasTranslations, LogsActivity;

    protected $fillable = [
        'code',
        'name',
        'is_default',
        'exchange_rate',
        'status',
        'sort_order'
    ];

    public $translatable = ['name'];

    protected $casts = [
        'exchange_rate' => 'decimal:4',
        'is_default'    => 'boolean',
    ];

    //─── Scopes ────────────────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', 1)->orderBy('sort_order', 'asc');
    }

    //─── Mutators ────────────────────────────────────────────────────────
    protected function code(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => strtoupper($value),
        );
    }

    /**
     * determine which attributes to log and how.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['code', 'name', 'is_default', 'exchange_rate', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('Finance - Currencies');
    }


    // --------------------------------------------------------
    // Relationship
    // --------------------------------------------------------
    public function paymentVouchers()
    {
        return $this->hasMany(PaymentVoucher::class, 'currency_code', 'code');
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class, 'currency_code', 'code');
    }
}
