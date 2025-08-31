<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaGaleriResource\Pages;
use App\Models\MediaGaleri;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class MediaGaleriResource extends Resource
{
    protected static ?string $model = MediaGaleri::class;

    protected static ?string $navigationIcon  = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'CMS Media';
    protected static ?string $navigationLabel = 'Galeri';
    protected static ?int    $navigationSort  = 2;

    protected static ?string $modelLabel       = 'Foto';
    protected static ?string $pluralModelLabel = 'Galeri Media';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Galeri')->schema([
                Forms\Components\TextInput::make('judul')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255),

                // Pilih kategori dari master (relasi)
                Forms\Components\Select::make('media_kategori_id')
                    ->label('Kategori')
                    ->relationship('kategoriRef', 'nama')
                    ->required()
                    ->preload()
                    ->searchable()
                    ->native(false),

                Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('gambar')
                    ->label('Gambar')
                    ->image()
                    ->required()
                    ->directory('media/galeri')
                    ->visibility('public')
                    ->imageEditor()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('urutan')
                    ->label('Urutan Tampil')
                    ->numeric()
                    ->minValue(1)
                    ->required()
                    ->default(fn () => (\App\Models\MediaGaleri::max('urutan') ?? 0) + 1),

                Forms\Components\Toggle::make('aktif')
                    ->label('Aktif')
                    ->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('gambar')
                ->label('Gambar')
                ->size(80),

            Tables\Columns\TextColumn::make('judul')
                ->label('Judul')
                ->searchable()
                ->limit(30),

            // kategori dari relasi master
            Tables\Columns\TextColumn::make('kategoriRef.nama')
                ->label('Kategori')
                ->badge()
                ->formatStateUsing(fn ($state) => $state ?: 'Umum'),

            Tables\Columns\TextColumn::make('urutan')
                ->label('Urutan')
                ->badge()
                ->sortable(),

            Tables\Columns\IconColumn::make('aktif')
                ->label('Status')
                ->boolean()
                ->trueIcon('heroicon-m-check-circle')
                ->falseIcon('heroicon-m-x-circle')
                ->trueColor('success')
                ->falseColor('danger'),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Dibuat')
                ->dateTime('d/m/Y H:i')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('media_kategori_id')
                ->label('Kategori')
                ->relationship('kategoriRef', 'nama')
                ->preload()
                ->searchable()
                ->native(false),

            Tables\Filters\TernaryFilter::make('aktif')
                ->label('Status Aktif')
                ->boolean()
                ->trueLabel('Aktif')
                ->falseLabel('Tidak Aktif')
                ->native(false),
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
        ->defaultSort('urutan', 'asc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    // Gate (samakan dengan policy/permission-mu)
    public static function canViewAny(): bool           { return Auth::user()?->can('cms_gallery') ?? false; }
    public static function canAccess(): bool            { return static::canViewAny(); }
    public static function canCreate(): bool            { return Auth::user()?->can('cms_gallery') ?? false; }
    public static function canEdit($record): bool       { return Auth::user()?->can('cms_gallery') ?? false; }
    public static function canDelete($record): bool     { return Auth::user()?->can('cms_gallery') ?? false; }
    public static function shouldRegisterNavigation(): bool { return Auth::user()?->can('cms_gallery') ?? false; }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListMediaGaleris::route('/'),
            'create' => Pages\CreateMediaGaleri::route('/create'),
            'edit'   => Pages\EditMediaGaleri::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteKeyName(): string
    {
        return 'uuid_id';
    }
}
