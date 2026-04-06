<?php

namespace App\Models\Finance;

use App\Contracts\PaymentProcessorInterface;
use App\Services\Payments\PaymentGatewayManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class PaymentGateway extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'code',
        'settings',
        'surcharge_percentage',
        'status',
    ];

    protected $translatable = ['name'];

    protected $casts = [
        'settings' => 'array',
        'surcharge_percentage' => 'decimal:2',
        'status' => 'boolean',
    ];

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }

    public function paymentVouchers(): HasMany
    {
        return $this->hasMany(PaymentVoucher::class);
    }

    public function processor(): PaymentProcessorInterface
    {
        return app(PaymentGatewayManager::class)->resolveFromGateway($this);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
