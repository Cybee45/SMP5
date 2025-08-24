<?php

namespace App\Filament\Resources\HeroBlogResource\Pages;

use App\Filament\Resources\HeroBlogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHeroBlog extends EditRecord
{
    protected static string $resource = HeroBlogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
