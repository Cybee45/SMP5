<?php

namespace App\Filament\Resources\SpmhHeroResource\Pages;

use App\Filament\Resources\SpmhHeroResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSpmhHeroes extends ListRecords
{
    protected static string $resource = SpmhHeroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
