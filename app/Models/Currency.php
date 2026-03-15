<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Currency extends Model
{
    use HasFactory, HasTranslations;

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
}
