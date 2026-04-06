<?php

namespace App\Models\SystemData;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Religion extends Model
{
    use HasTranslations;

    protected $fillable = ['name'];
    public $translatable = ['name'];
}
