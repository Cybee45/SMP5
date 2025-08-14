<?php

namespace App\Filament\Resources\MediaGaleriResource\Pages;

use App\Filament\Resources\MediaGaleriResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMediaGaleris extends ListRecords
{
    protected static string $resource = MediaGaleriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
