<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AboutHero extends Model
{
    protected string $uuidColumn = 'uuid_id';

    protected $fillable = [
        'uuid_id',
        'subjudul',
        'judul',
        'deskripsi',
        'gambar',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    /** Pakai uuid_id untuk route binding */
    public function getRouteKeyName(): string
    {
        return 'uuid_id';
    }

    /** Auto-generate uuid_id saat create */
    protected static function booted(): void
    {
        static::creating(function (self $model) {
            $col = property_exists($model, 'uuidColumn') ? $model->uuidColumn : 'uuid_id';
            if (empty($model->{$col})) {
                $model->{$col} = (string) Str::uuid();
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('aktif', true);
    }
}
