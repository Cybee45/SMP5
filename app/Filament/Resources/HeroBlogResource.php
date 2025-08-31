<?php

namespace App\Filament\Resources;

use App\Support\OrderField;
use App\Filament\Resources\HeroBlogResource\Pages;
use App\Models\HeroBlog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class HeroBlogResource extends Resource
{
    protected static ?string $model = HeroBlog::class;

    protected static ?string $navigationIcon  = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'CMS Konten';
    protected static ?string $navigationLabel = 'Hero Halaman Blog';
    protected static ?int    $navigationSort  = 3;

    public static function canViewAny(): bool
    {
        return Auth::user()?->can('cms_articles') ?? false;
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

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Hero Blog Information')
                ->schema([
                    Forms\Components\TextInput::make('judul')
                        ->label('Judul')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('subjudul')
                        ->label('Sub Judul')
                        ->maxLength(255),

                    Forms\Components\Textarea::make('deskripsi')
                        ->label('Deskripsi')
                        ->rows(3)
                        ->required(), // hapus ->required() jika kolom deskripsi nullable di DB

                    Forms\Components\FileUpload::make('gambar_utama')
                        ->label('Gambar Utama')
                        ->image()
                        ->directory('hero-blog'),

                    // Pakai komponen kustom kamu — table: 'hero_blogs', label: 'Urutan', max 10
                    OrderField::make('hero_blogs', 'Urutan', 10),
                    
                    Forms\Components\Toggle::make('aktif')
                        ->label('Aktif')
                        ->default(true),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar_utama')
                    ->label('Gambar')
                    ->circular(),

                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('subjudul')
                    ->label('Sub Judul')
                    ->searchable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('urutan')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('aktif')
                    ->label('Status'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('urutan')
            ->filters([
                Tables\Filters\TernaryFilter::make('aktif')
                    ->label('Status')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif')
                    ->placeholder('Semua'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListHeroBlogs::route('/'),
            'create' => Pages\CreateHeroBlog::route('/create'),
            'edit'   => Pages\EditHeroBlog::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteKeyName(): string
    {
        return 'uuid_id';
    }
}
