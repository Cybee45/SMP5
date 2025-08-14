<?php

namespace App\Filament\Resources\MediaVideoResource\Pages;

use App\Filament\Resources\MediaVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMediaVideos extends ListRecords
{
    protected static string $resource = MediaVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
