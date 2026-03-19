<?php

use App\Services\Payments\BankTransferProcessor;
use App\Services\Payments\CashProcessor;
use App\Services\Payments\StripeProcessor;

return [

    /*
    |--------------------------------------------------------------------------
    | Payment Gateway Processors
    |--------------------------------------------------------------------------
    |
    | Map each gateway code (stored in payment_gateways.code) to its processor
    | class. To add a new gateway, create a class implementing
    | PaymentProcessorInterface and add a line here.
    |
    */

    'processors' => [
        'cash'          => [
            'class'  => CashProcessor::class,
            'icon'   => 'las la-money-bill-wave',
            'colors' => ['from' => '#10b981', 'to' => '#059669'],
        ],
        'bank_transfer' => [
            'class'  => BankTransferProcessor::class,
            'icon'   => 'las la-university',
            'colors' => ['from' => '#3b82f6', 'to' => '#2563eb'],
        ],
        'stripe'        => [
            'class'  => StripeProcessor::class,
            'icon'   => 'lab la-stripe-s',
            'colors' => ['from' => '#6366f1', 'to' => '#4f46e5'],
        ],
    ],

];
