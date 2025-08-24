<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'kontaks';

    protected $fillable = [
        'section_title',
        'section_description',
        'email_title',
        'email_description',
        'email_address',
        'phone_title',
        'phone_description',
        'phone_number',
        'location_title',
        'location_address',
        'map_embed',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'urutan' => 'integer',
    ];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }
}
