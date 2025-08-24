<?php

namespace App\Filament\Resources;

use App\Models\Statistik;
use App\Filament\Resources\StatistikResource\Pages;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Facades\Auth;

class StatistikResource extends Resource
{
    protected static ?string $model = Statistik::class;

    protected static ?string $navigationIcon  = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Statistik';
    protected static ?string $pluralModelLabel = 'Statistik';
    protected static ?string $navigationGroup = 'CMS Home';
    protected static ?int    $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('judul')
                ->label('Judul Statistik')
                ->required()
                ->maxLength(191),

            TextInput::make('jumlah')
                ->label('Jumlah')
                ->numeric()
                ->minValue(0)
                ->required(),

            TextInput::make('deskripsi')
                ->label('Keterangan')
                ->nullable()
                ->maxLength(255),

            TextInput::make('urutan')
                ->label('Urutan')
                ->numeric()
                ->minValue(1)
                ->required()
                ->default(fn () => (\App\Models\Statistik::max('urutan') ?? 0) + 1),

            Toggle::make('aktif')
                ->label('Aktif')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul')
                    ->label('Judul')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->sortable(),

                TextColumn::make('urutan')
                    ->label('Urutan')
                    ->sortable(),

                ToggleColumn::make('aktif')
                    ->label('Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('urutan');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListStatistiks::route('/'),
            'create' => Pages\CreateStatistik::route('/create'),
            'edit'   => Pages\EditStatistik::route('/{record}/edit'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return ['view_any', 'create', 'update', 'delete'];
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->can('cms_home') ?? false;
    }

    public static function canEdit($record): bool
    {
        return Auth::user()?->can('cms_home') ?? false;
    }

    public static function canDelete($record): bool
    {
        return Auth::user()?->can('cms_home') ?? false;
    }

    public static function canViewAny(): bool
    {
        return Auth::user()?->can('cms_home') ?? false;
    }

    public static function canAccess(): bool
    {
        return static::canViewAny();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->can('cms_home') ?? false;
    }

    public static function getRecordRouteKeyName(): string
    {
        return 'uuid_id';
    }
}
