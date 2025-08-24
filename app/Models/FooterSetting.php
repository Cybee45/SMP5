<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FooterSetting extends Model
{
    protected $guarded = [];

    protected $casts = [
        'menu_items' => 'array',
        'aktif' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid_id)) {
                $model->uuid_id = Str::uuid();
            }
        });
    }
}
