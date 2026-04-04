<?php

namespace App\Providers;

use App\Services\ExternalApiSettingService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class ExternalApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        try {
            if (! Schema::hasTable('external_api_settings')) {
                return;
            }

            $service = resolve(ExternalApiSettingService::class);
            
            // Mailgun Override
            $mailgun = $service->getBySlug('mailgun');
            if ($mailgun && $mailgun->is_active) {
                Config::set('services.mailgun.domain', $mailgun->credentials['domain'] ?? config('services.mailgun.domain'));
                Config::set('services.mailgun.secret', $mailgun->credentials['secret'] ?? config('services.mailgun.secret'));
                Config::set('services.mailgun.endpoint', $mailgun->credentials['endpoint'] ?? config('services.mailgun.endpoint'));
            }

            // Zoom Override
            $zoom = $service->getBySlug('zoom');
            if ($zoom && $zoom->is_active) {
                Config::set('services.zoom.client_id', $zoom->credentials['client_id'] ?? config('services.zoom.client_id'));
                Config::set('services.zoom.client_secret', $zoom->credentials['client_secret'] ?? config('services.zoom.client_secret'));
                Config::set('services.zoom.account_id', $zoom->credentials['account_id'] ?? config('services.zoom.account_id'));
            }
            
            // Firebase Override
            $firebase = $service->getBySlug('firebase');
            if ($firebase && $firebase->is_active) {
                Config::set('services.firebase.api_key', $firebase->credentials['api_key'] ?? config('services.firebase.api_key'));
                Config::set('services.firebase.project_id', $firebase->credentials['project_id'] ?? config('services.firebase.project_id'));
                Config::set('services.firebase.messaging_sender_id', $firebase->credentials['messaging_sender_id'] ?? config('services.firebase.messaging_sender_id'));
                Config::set('services.firebase.app_id', $firebase->credentials['app_id'] ?? config('services.firebase.app_id'));
            }

        } catch (\Exception $e) {
            logger($e->getMessage());
        }
    }
}
