<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfilResource\Pages;
use App\Models\Profil;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Actions\EditAction;
use Illuminate\Support\Facades\Auth;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;

class ProfilResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Profil::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationLabel = 'Profil Sekolah';
    protected static ?string $pluralModelLabel = 'Profil Sekolah';
    protected static ?string $navigationGroup = 'CMS - Home';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('judul')
                ->label('Judul Section')
                ->required()
                ->maxLength(255)
                ->placeholder('Contoh: Profil Singkat Sekolah')
                ->columnSpanFull(),

            Textarea::make('deskripsi_1')
                ->label('Deskripsi Paragraf 1')
                ->required()
                ->rows(3)
                ->placeholder('Contoh: SMP 5 Sangatta Utara adalah sekolah menengah unggulan...')
                ->columnSpanFull(),

            Textarea::make('deskripsi_2')
                ->label('Deskripsi Paragraf 2')
                ->rows(3)
                ->placeholder('Contoh: Kami berkomitmen penuh untuk mencetak generasi berprestasi...')
                ->columnSpanFull(),

            FileUpload::make('gambar')
                ->label('Gambar Profil')
                ->image()
                ->directory('profil')
                ->imageEditor()
                ->columnSpanFull(),

            TextInput::make('link_selengkapnya')
                ->label('Link Selengkapnya')
                ->url()
                ->placeholder('Contoh: #tentang-kami')
                ->columnSpanFull(),

            Toggle::make('aktif')
                ->label('Tampilkan di Website')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->circular(),

                ToggleColumn::make('aktif')
                    ->label('Aktif'),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->actions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfils::route('/'),
            'create' => Pages\CreateProfil::route('/create'),
            'edit' => Pages\EditProfil::route('/{record}/edit'),
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
        return Auth::user()?->can('cms_manage');
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->can('cms_manage');
    }

    public static function canEdit($record): bool
    {
        return Auth::user()?->can('cms_manage');
    }

    public static function canDelete($record): bool
    {
        return Auth::user()?->can('cms_manage');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->can('cms_manage');
    }
}
