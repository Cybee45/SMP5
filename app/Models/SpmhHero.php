<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SpmhHero extends Model
{
    // Jika tabel kamu bernama `spmh_heroes` ini opsional, tapi aman ditulis eksplisit
    protected $table = 'spmh_heroes';

    protected $fillable = [
        'uuid_id',
        'subtitle',
        'title',
        'description',
        'image_utama',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /* ========= Route model binding pakai UUID ========= */
    public function getRouteKeyName(): string
    {
        return 'uuid_id';
    }

    // Kompatibel: terima juga ID numerik agar URL lama /1/edit tetap bekerja
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('uuid_id', $value)
            ->orWhere('id', $value)
            ->first();
    }
    /* ================================================== */

    /* ====== Auto-isi uuid_id saat create ====== */
    protected static function booted(): void
    {
        static::creating(function (self $m) {
            if (blank($m->uuid_id)) {
                $m->uuid_id = (string) Str::uuid();
            }
        });
    }

    /* ============ Scopes ============ */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
