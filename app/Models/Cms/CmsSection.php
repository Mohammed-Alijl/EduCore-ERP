<?php

namespace App\Models\Cms;

use App\Models\Cms\CmsPage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class CmsSection extends Model
{
    use HasTranslations;

    protected $fillable = [
        'cms_page_id',
        'section_key',
        'title',
        'subtitle',
        'content',
        'images',
        'settings',
        'sort_order',
        'is_visible',
    ];

    public array $translatable = ['title', 'subtitle'];

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'images' => 'array',
            'settings' => 'array',
            'is_visible' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    // ===============================================================
    // ======================== RELATIONSHIPS ========================
    // ===============================================================

    public function page(): BelongsTo
    {
        return $this->belongsTo(CmsPage::class, 'cms_page_id');
    }

    // ===============================================================
    // =========================== SCOPES ===========================
    // ===============================================================

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_visible', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }

    public function scopeByKey(Builder $query, string $key): Builder
    {
        return $query->where('section_key', $key);
    }

    // ===============================================================
    // =========================== HELPERS ==========================
    // ===============================================================

    /**
     * Get a content value with a fallback.
     */
    public function getContentValue(string $key, mixed $default = null): mixed
    {
        return data_get($this->content, $key, $default);
    }
}
