<?php

namespace App\Filament\Resources\MediaKategoriResource\Pages;

use App\Filament\Resources\MediaKategoriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMediaKategori extends EditRecord
{
    protected static string $resource = MediaKategoriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
