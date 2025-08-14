<?php

namespace App\Filament\Resources\ProfileSettingsResource\Pages;

use App\Filament\Resources\ProfileSettingsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProfileSettings extends EditRecord
{
    protected static string $resource = ProfileSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Tidak ada tombol delete karena user tidak boleh hapus akun sendiri
        ];
    }
}
