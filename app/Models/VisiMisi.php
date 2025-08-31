<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
// use App\Traits\HasUuid; // aktifkan kalau trait-mu mendukung $uuidColumn

class VisiMisi extends Model
{
    // Kalau HasUuid milikmu membaca $uuidColumn, boleh aktifkan:
    // use HasUuid;

    /**
     * Nama kolom UUID yang benar di DB.
     */
    protected string $uuidColumn = 'uuid_id';

    protected $fillable = [
        'uuid_id',            // <-- ganti dari 'uuid' ke 'uuid_id'
        'judul_section',
        'subjudul_section',
        'visi',
        'misi',
        'tujuan',
        'aktif',
    ];

    protected $casts = [
        'misi'   => 'array',
        'tujuan' => 'array',
        'aktif'  => 'boolean',
    ];

    /**
     * Pakai 'id' untuk route model binding (aman untuk Filament).
     */
    public function getRouteKeyName(): string
    {
        return 'uuid_id';
    }

    /**
     * Auto-generate uuid_id saat create jika belum ada.
     * (Penting kalau trait HasUuid kamu tidak otomatis isi uuid_id.)
     */
    protected static function booted(): void
    {
        static::creating(function (self $model) {
            $col = property_exists($model, 'uuidColumn') ? $model->uuidColumn : 'uuid_id';
            if (empty($model->{$col})) {
                $model->{$col} = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('aktif', true);
    }
}
