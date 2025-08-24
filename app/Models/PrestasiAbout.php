<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;
use App\Traits\AutoOrder;

class PrestasiAbout extends Model
{
    use HasUuid, AutoOrder;

    // Kolom UUID yang kamu pakai
    protected $uuidColumn = 'uuid_id';

    // Kolom urutan (boleh di-skip; default di trait = 'urutan')
    protected string $orderColumn = 'urutan';

    // Grouping urutan (opsional). Misal: per section akreditasi
    protected array $orderGroupColumns = ['section_akreditasi_id'];

    protected $fillable = [
        'uuid_id',        // pakai nama yang benar sesuai DB-mu
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

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function scopeActive($q)  { return $q->where('aktif', true); }
    public function scopeOrdered($q) { return $q->orderBy('urutan'); }

    public function sectionAkreditasi()
    {
        return $this->belongsTo(\App\Models\SectionAkreditasi::class, 'section_akreditasi_id');
    }
}
