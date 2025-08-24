<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SectionAkreditasi extends Model
{
    protected $guarded = [];

    protected $casts = [
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

    // 🔗 Relasi: satu Section punya banyak Prestasi
    public function prestasi()
    {
        return $this->hasMany(\App\Models\PrestasiAbout::class, 'section_akreditasi_id');
    }

    // Opsional: biar gampang panggil yang aktif & urut
    public function scopeActive($q)  { return $q->where('aktif', true); }
    public function scopeOrdered($q) { return $q->orderBy('urutan'); }
}
