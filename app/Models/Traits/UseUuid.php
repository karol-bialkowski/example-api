<?php

declare(strict_types=1);

namespace App\Models\Traits;
use Illuminate\Support\Str;

trait UseUuid
{
    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Str::uuid();
        });
    }
}
