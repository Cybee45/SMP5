<?php

namespace App\Filament\Resources\MediaKategoriResource\Pages;

use App\Filament\Resources\MediaKategoriResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMediaKategoris extends ListRecords
{
    protected static string $resource = MediaKategoriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
