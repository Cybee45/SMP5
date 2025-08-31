<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;
use App\Traits\AutoOrder;

class PrestasiAbout extends Model
{
    use HasUuid, AutoOrder;

    /** kolom UUID yang dipakai */
    protected string $uuidColumn = 'uuid_id';

    /** routing menggunakan UUID */
    protected bool $routeKeyUsesUuid = true;

    protected $fillable = [
        'uuid_id',
        'judul',
        'deskripsi',
        'gambar',
        'urutan',
        'aktif',
        'section_akreditasi_id',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    // scopes & relasi lain tetap aman
    public function scopeActive($q)  { return $q->where('aktif', true); }
    public function scopeOrdered($q) { return $q->orderBy('urutan'); }

    public function sectionAkreditasi()
    {
        return $this->belongsTo(\App\Models\SectionAkreditasi::class, 'section_akreditasi_id');
    }
}
