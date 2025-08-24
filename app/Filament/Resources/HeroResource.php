<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroResource\Pages;
use App\Models\Hero;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class HeroResource extends Resource
{
    protected static ?string $model = Hero::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Hero Section';
    protected static ?string $pluralModelLabel = 'Hero Section';
    protected static ?string $navigationGroup = 'CMS Home';
    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('tipe', 'home');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Hidden::make('tipe')
                ->default('home'->required()),

            TextInput::make('subjudul')
                ->label('Subjudul')
                ->maxLength(255)
                ->placeholder('Contoh: Sambutan Hangat Kami'),

            TextInput::make('judul')
                ->label('Judul Utama'->required())
                ->required()
                ->maxLength(255)
                ->placeholder('Contoh: Selamat Datang di SMP 5 Sangatta Utara'),

            Textarea::make('deskripsi')
                ->label('Deskripsi')
                ->rows(4)
                ->maxLength(1000)
                ->placeholder('Contoh: Sekolah unggulan yang mengutamakan karakter dan prestasi akademik.'),

            TextInput::make('tombol_teks')
                ->label('Teks Tombol')
                ->placeholder('Contoh: Selengkapnya'),

            TextInput::make('tombol_link')
                ->label('Link Tombol')
                ->placeholder('Contoh: /spmb atau https://example.com')
                ->helperText('Bisa menggunakan path relatif (/halaman) atau URL lengkap (https://...)')
                ->rule('nullable')
                ->rule(function () {
                    return function (string $attribute, $value, \Closure $fail) {
                        if ($value && !filter_var($value, FILTER_VALIDATE_URL) && !str_starts_with($value, '/')) {
                            $fail('Link harus berupa URL lengkap (https://...) atau path relatif yang dimulai dengan /');
                        }
                    };
                }),

            FileUpload::make('gambar')
                ->label('Gambar Hero')
                ->image()
                ->directory('hero')
                ->preserveFilenames()
                ->nullable(),

            Toggle::make('aktif')
                ->label('Tampilkan di Halaman Home'->required())
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('subjudul')
                    ->label('Subjudul')
                    ->limit(30)
                    ->sortable()
                    ->searchable(),

                TextColumn::make('judul')
                    ->label('Judul'->required())
                    ->limit(50)
                    ->sortable()
                    ->searchable(),

                ToggleColumn::make('aktif')
                    ->label('Aktif'->required()),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHeroes::route('/'),
            'create' => Pages\CreateHero::route('/create'),
            'edit' => Pages\EditHero::route('/{record}/edit'),
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

    public static function canViewAny(): bool
    {
        return Auth::user()?->can('cms_home') ?? false;
    }

    public static function canAccess(): bool
    {
        return static::canViewAny();
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

    public static function getRecordRouteKeyName(): string
    {
        return 'uuid_id';
    }

}
