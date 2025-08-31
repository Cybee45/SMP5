<?php

namespace App\Filament\Resources;


use App\Support\OrderField;use App\Models\Statistik;
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
use Illuminate\Support\Facades\Schema;

class StatistikResource extends Resource
{
    protected static ?string $model = Statistik::class;

    protected static ?string $navigationIcon  = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Statistik';
    protected static ?string $pluralModelLabel = 'Statistik';
    protected static ?string $navigationGroup = 'CMS Home';
    protected static ?int    $navigationSort = 2;

    /** Batas aman default untuk kolom INT MySQL. Ubah jika kolommu BIGINT/SMALLINT. */
    private const URUTAN_MAX = 100;

    public static function form(Form $form): Form
    {
        // Base fields
        $fields = [
            TextInput::make('judul')
                ->label('Judul Statistik')
                ->required()
                ->maxLength(255),

            TextInput::make('jumlah')
                ->label('Jumlah')
                ->numeric()
                ->inputMode('numeric')
                ->minValue(0)
                ->rule('integer')
                ->required(),
        ];

        // Opsional: hanya tambahkan 'deskripsi' jika kolom ada di DB
        if (Schema::hasColumn('statistiks', 'deskripsi')) {
            $fields[] = TextInput::make('deskripsi')
                ->label('Keterangan')
                ->maxLength(255)
                ->dehydrateStateUsing(fn ($state) => $state ?? '');
        }

        // Field urutan dengan validasi ketat + pesan ramah
        $fields[] = OrderField::make('statistiks', 'Urutan')
            ->label('Urutan')
            ->numeric()
            ->inputMode('numeric')
            ->minValue(1)
            ->maxValue(self::URUTAN_MAX)
            ->required()
            // validasi server-side ekstra
            ->rule('integer')
            ->rule('between:1,' . self::URUTAN_MAX)
            ->validationAttribute('Urutan')
            ->helperText('Masukkan angka 1 – ' . number_format(self::URUTAN_MAX, 0, ',', '.'))
            ->placeholder('contoh: 1')
            ->default(fn () => (\App\Models\Statistik::max('urutan') ?? 0) + 1);

        $fields[] = Toggle::make('aktif')
            ->label('Aktif')
            ->default(true);

        return $form->schema($fields);
    }

    public static function table(Table $table): Table
    {
        // Base columns
        $columns = [
            TextColumn::make('judul')
                ->label('Judul')
                ->sortable()
                ->searchable(),

            TextColumn::make('jumlah')
                ->label('Jumlah')
                ->sortable(),
        ];

        // Tampilkan kolom deskripsi hanya jika ada di DB
        if (Schema::hasColumn('statistiks', 'deskripsi')) {
            $columns[] = TextColumn::make('deskripsi')
                ->label('Keterangan')
                ->limit(60)
                ->toggleable();
        }

        // Lanjutan
        $columns[] = TextColumn::make('urutan')
            ->label('Urutan')
            ->sortable();

        $columns[] = ToggleColumn::make('aktif')
            ->label('Aktif');

        return $table
            ->columns($columns)
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
