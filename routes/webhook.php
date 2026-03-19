<?php

use App\Http\Controllers\Webhooks\PaymentWebhookController;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Webhook Routes
|--------------------------------------------------------------------------
|
| These routes handle incoming webhooks from external services such as
| payment gateways. They are registered without the "web" middleware
| group so CSRF verification is naturally excluded. SubstituteBindings
| is required for route model binding to resolve gateway models.
|
*/

Route::middleware(SubstituteBindings::class)
    ->prefix('webhooks')
    ->name('webhooks.')
    ->group(function () {

        Route::post('payments/{gateway:code}', PaymentWebhookController::class)
            ->name('handle');
    });
