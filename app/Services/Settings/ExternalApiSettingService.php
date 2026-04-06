<?php

namespace App\Services\Settings;

use App\Models\Settings\ExternalApiSetting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class ExternalApiSettingService
{
    private const CACHE_KEY = 'external_api_settings';

    private const CACHE_TTL = 86400;

    /**
     * Get all external API settings.
     */
    public function getAll(): Collection
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return ExternalApiSetting::all();
        });
    }

    /**
     * Get a specific API setting by slug.
     */
    public function getBySlug(string $slug): ?ExternalApiSetting
    {
        return $this->getAll()->where('slug', $slug)->first();
    }

    /**
     * Update an API setting.
     */
    public function update(ExternalApiSetting $setting, array $data): ExternalApiSetting
    {
        $setting->update($data);
        $this->clearCache();

        return $setting->fresh();
    }

    /**
     * Toggle the active status of an API.
     */
    public function toggleStatus(ExternalApiSetting $setting): ExternalApiSetting
    {
        $setting->update(['is_active' => ! $setting->is_active]);
        $this->clearCache();

        return $setting->fresh();
    }

    /**
     * Clear the settings cache.
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
