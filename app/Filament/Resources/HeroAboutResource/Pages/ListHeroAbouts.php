<?php

namespace App\Filament\Resources\HeroAboutResource\Pages;

use App\Filament\Resources\HeroAboutResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHeroAbouts extends ListRecords
{
    protected static string $resource = HeroAboutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
