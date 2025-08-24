<?php

namespace App\Filament\Resources\ArtikelResource\Pages;

use App\Filament\Resources\ArtikelResource;
use Filament\Resources\Pages\EditRecord;
use App\Models\KategoriArtikel;

class EditArtikel extends EditRecord
{
    protected static string $resource = ArtikelResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
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
