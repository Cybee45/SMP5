<?php

namespace App\Filament\Resources\SpmhHeroResource\Pages;

use App\Filament\Resources\SpmhHeroResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSpmhHero extends EditRecord
{
    protected static string $resource = SpmhHeroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
