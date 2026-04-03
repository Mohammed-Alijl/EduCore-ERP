<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class CmsPage extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'slug',
        'type',
        'content',
        'meta_description',
        'is_published',
    ];

    public array $translatable = ['title', 'content', 'meta_description'];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    // ===============================================================
    // ======================== RELATIONSHIPS ========================
    // ===============================================================

    public function sections(): HasMany
    {
        return $this->hasMany(CmsSection::class)->orderBy('sort_order');
    }

    // ===============================================================
    // =========================== SCOPES ===========================
    // ===============================================================

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeLegal(Builder $query): Builder
    {
        return $query->where('type', 'legal');
    }

    public function scopeLanding(Builder $query): Builder
    {
        return $query->where('type', 'landing');
    }

    public function scopeBySlug(Builder $query, string $slug): Builder
    {
        return $query->where('slug', $slug);
    }
}
