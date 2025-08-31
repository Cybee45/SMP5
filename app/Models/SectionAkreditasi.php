<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\HasUuid; // <- pakai trait kamu yang sudah ada

class SectionAkreditasi extends Model
{
    use HasUuid;

    /**
     * Pakai kolom uuid_id & gunakan UUID untuk route binding.
     */
    protected string $uuidColumn = 'uuid_id';
    protected bool   $routeKeyUsesUuid = true;

    // kalau kamu suka mass-assign semua field, biarkan guarded kosong
    protected $guarded = [];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    /**
     * Kalau kamu sudah pakai HasUuid, SEBENARNYA tidak perlu boot() manual.
     * Tapi kalau mau tetap aman untuk data lama, boleh biarkan block ini.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid_id)) {
                $model->uuid_id = (string) Str::uuid();
            }
        });
    }

    // 🔗 Relasi: satu Section punya banyak Prestasi
    public function prestasi()
    {
        return $this->hasMany(\App\Models\PrestasiAbout::class, 'section_akreditasi_id');
    }

    // Scopes
    public function scopeActive($q)  { return $q->where('aktif', true); }
    public function scopeOrdered($q) { return $q->orderBy('urutan'); }
}
