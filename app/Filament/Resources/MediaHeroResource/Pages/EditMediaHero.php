<?php

namespace App\Filament\Resources\MediaHeroResource\Pages;

use App\Filament\Resources\MediaHeroResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMediaHero extends EditRecord
{
    protected static string $resource = MediaHeroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
