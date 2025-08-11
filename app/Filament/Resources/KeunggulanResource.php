<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KeunggulanResource\Pages;
use App\Models\Keunggulan;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Facades\Auth;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;

class KeunggulanResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Keunggulan::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationLabel = 'Item Keunggulan';
    protected static ?string $pluralModelLabel = 'Item Keunggulan';
    protected static ?string $navigationGroup = 'CMS - Home';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        $schema = [
            TextInput::make('judul')
                ->label('Judul Keunggulan')
                ->required()
                ->maxLength(100)
                ->placeholder('Contoh: Fasilitas Lengkap'),

            Textarea::make('deskripsi')
                ->label('Deskripsi')
                ->maxLength(1000)
                ->placeholder('Contoh: Sekolah kami memiliki laboratorium, perpustakaan, dan ruang kelas multimedia.'),

            TextInput::make('urutan')
                ->label('Urutan Tampil')
                ->numeric()
                ->default(0)
                ->placeholder('Contoh: 1'),

            Toggle::make('aktif')
                ->label('Tampilkan di Website')
                ->default(true),
        ];

        return $form->schema($schema);
    }

    public static function table(Table $table): Table
    {
        $columns = [
            TextColumn::make('judul')
                ->label('Judul')
                ->searchable()
                ->sortable(),

            TextColumn::make('deskripsi')
                ->label('Deskripsi')
                ->limit(50)
                ->searchable(),

            TextColumn::make('urutan')
                ->label('Urutan')
                ->sortable(),

            ToggleColumn::make('aktif')
                ->label('Aktif')
                ->disabled(fn () => !Auth::user()?->hasRole(['super_admin', 'admin'])), // Admin dan superadmin bisa toggle
        ];

        return $table
            ->columns($columns)
            ->defaultSort('urutan')
            ->actions([
                // Admin dan superadmin bisa edit
                \Filament\Tables\Actions\EditAction::make()
                    ->visible(fn () => Auth::user()?->hasRole(['super_admin', 'admin'])),
            ])
            ->bulkActions([
                // Admin dan superadmin bisa delete
                \Filament\Tables\Actions\BulkActionGroup::make([
                    \Filament\Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => Auth::user()?->hasRole(['super_admin', 'admin'])),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKeunggulans::route('/'),
            'create' => Pages\CreateKeunggulan::route('/create'),
            'edit' => Pages\EditKeunggulan::route('/{record}/edit'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view_any',
            'create', 
            'update',
            'delete',
        ];
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->hasRole(['super_admin', 'admin']);
    }

    public static function canEdit($record): bool
    {
        return Auth::user()?->hasRole(['super_admin', 'admin']);
    }

    public static function canDelete($record): bool
    {
        return Auth::user()?->hasRole(['super_admin', 'admin']);
    }

    public static function canViewAny(): bool
    {
        return Auth::user()?->can('cms_manage');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->can('cms_manage');
    }
}
