<?php

namespace App\Filament\Resources\MediaHeroResource\Pages;

use App\Filament\Resources\MediaHeroResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMediaHeroes extends ListRecords
{
    protected static string $resource = MediaHeroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
