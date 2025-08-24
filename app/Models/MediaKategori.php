<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MediaKategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid_id',
        'nama',
        'slug',
        'color',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif'  => 'boolean',
        'urutan' => 'integer',
    ];

    /** Pakai uuid_id untuk route model binding (URL {record}) */
    public function getRouteKeyName(): string
    {
        return 'uuid_id';
    }

    /** Isi uuid_id & jaga slug unik */
    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->uuid_id)) {
                $model->uuid_id = (string) Str::uuid();
            }
            if (empty($model->slug) && !empty($model->nama)) {
                $model->slug = self::uniqueSlug($model->nama);
            }
        });

        static::updating(function (self $model) {
            if ($model->isDirty('nama') && empty($model->slug)) {
                $model->slug = self::uniqueSlug($model->nama, $model->id);
            }
        });
    }

    /** Generator slug unik */
    protected static function uniqueSlug(string $nama, ?int $ignoreId = null): string
    {
        $base = Str::slug($nama) ?: 'kategori';
        $slug = $base;
        $n = 1;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $n++;
        }

        return $slug;
    }

    /** Relasi */
    public function galeris()
    {
        return $this->hasMany(MediaGaleri::class, 'media_kategori_id');
    }

    /** Scopes */
    public function scopeActive($q)  { return $q->where('aktif', true); }
    public function scopeOrdered($q) { return $q->orderBy('urutan')->orderBy('nama'); }
}
