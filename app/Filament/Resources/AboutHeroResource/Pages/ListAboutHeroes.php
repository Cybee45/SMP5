<?php

namespace App\Filament\Resources\AboutHeroResource\Pages;

use App\Filament\Resources\AboutHeroResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAboutHeroes extends ListRecords
{
    protected static string $resource = AboutHeroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
