<?php

namespace App\Filament\Resources\KategoriArtikelResource\Pages;

use App\Filament\Resources\KategoriArtikelResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListKategoriArtikels extends ListRecords
{
    protected static string $resource = KategoriArtikelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Kategori'),
        ];
    }
}
