<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroAboutResource\Pages;
use App\Models\Hero;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Facades\Auth;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Illuminate\Database\Eloquent\Builder;

class HeroAboutResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Hero::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Hero About';
    protected static ?string $pluralModelLabel = 'Hero About';
    protected static ?string $navigationGroup = 'CMS About';
    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('tipe', 'about');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Hidden::make('tipe')
                ->default('about'),

            TextInput::make('subjudul')
                ->label('Subjudul')
                ->maxLength(255)
                ->placeholder('Contoh: Tentang Kami'),

            TextInput::make('judul')
                ->label('Judul Utama')
                ->required()
                ->maxLength(255)
                ->placeholder('Contoh: Profil SMP 5 Sangatta Utara'),

            Textarea::make('deskripsi')
                ->label('Deskripsi')
                ->rows(4)
                ->maxLength(1000)
                ->placeholder('Contoh: Mengenal lebih dekat sejarah dan visi misi sekolah.'),

            TextInput::make('tombol_teks')
                ->label('Teks Tombol')
                ->placeholder('Contoh: Lihat Sejarah'),

            TextInput::make('tombol_link')
                ->label('Link Tombol')
                ->url()
                ->placeholder('Contoh: /sejarah'),

            FileUpload::make('gambar')
                ->label('Gambar Hero')
                ->image()
                ->directory('hero')
                ->preserveFilenames()
                ->nullable(),

            Toggle::make('aktif')
                ->label('Tampilkan di Halaman About')
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
                    ->label('Judul')
                    ->limit(50)
                    ->sortable()
                    ->searchable(),

                ToggleColumn::make('aktif')
                    ->label('Aktif'),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHeroAbouts::route('/'),
            'create' => Pages\CreateHeroAbout::route('/create'),
            'edit' => Pages\EditHeroAbout::route('/{record}/edit'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
        ];
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
