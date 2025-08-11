<?php

namespace App\Filament\Resources\HeroAboutResource\Pages;

use App\Filament\Resources\HeroAboutResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHeroAbout extends EditRecord
{
    protected static string $resource = HeroAboutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
