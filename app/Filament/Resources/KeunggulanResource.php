<?php

namespace App\Filament\Resources;


use App\Support\OrderField;
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

class KeunggulanResource extends Resource
{
    protected static ?string $model = Keunggulan::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationLabel = 'Item Keunggulan';
    protected static ?string $pluralModelLabel = 'Item Keunggulan';
    protected static ?string $navigationGroup = 'CMS Home';
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
                ->required() // ⬅️ WAJIB ISI
                ->maxLength(1000)
                ->dehydrateStateUsing(fn ($state) => $state ?? '') // ⬅️ kalau kosong, jadikan '' (bukan null)
                ->placeholder('Contoh: Sekolah kami memiliki laboratorium, perpustakaan, dan ruang kelas multimedia.'),

            OrderField::make('keunggulans', 'Urutan')
                ->label('Urutan Tampil')
                ->numeric()
                ->minValue(1)
                ->required()
                ->default(fn () => (\App\Models\Keunggulan::max('urutan') ?? 0) + 1)
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
                ->numeric()
                ->sortable(),

            ToggleColumn::make('aktif')
                ->label('Aktif')
                ->disabled(fn () => !Auth::user()?->hasRole(['superadmin', 'admin'])), // hanya admin/superadmin yang bisa toggle
        ];

        return $table
            ->columns($columns)
            ->defaultSort('urutan')
            ->actions([
                \Filament\Tables\Actions\EditAction::make()
                    ->visible(fn () => Auth::user()?->hasRole(['superadmin', 'admin'])),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    \Filament\Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => Auth::user()?->hasRole(['superadmin', 'admin'])),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListKeunggulans::route('/'),
            'create' => Pages\CreateKeunggulan::route('/create'),
            'edit'   => Pages\EditKeunggulan::route('/{record}/edit'),
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
