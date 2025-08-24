<?php

namespace App\Filament\Resources\ArtikelResource\Pages;

use App\Filament\Resources\ArtikelResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\KategoriArtikel;

class CreateArtikel extends CreateRecord
{
    protected static string $resource = ArtikelResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Kalau user nggak pilih kategori, kita fallback ke 'Umum'
        if (empty($data['kategori_id'])) {
            $defaultKategori = KategoriArtikel::firstOrCreate(
                ['slug' => 'umum'],
                ['nama' => 'Umum', 'aktif' => true]
            );
            $data['kategori_id'] = $defaultKategori->id;
        }

        $data['aktif'] = (bool)($data['aktif'] ?? true);

        return $data;
    }
}
