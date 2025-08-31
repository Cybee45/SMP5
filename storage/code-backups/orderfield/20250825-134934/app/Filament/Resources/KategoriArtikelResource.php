<?php

namespace App\Filament\Resources;


use App\Support\OrderField;use App\Filament\Resources\KategoriArtikelResource\Pages;
use App\Models\KategoriArtikel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class KategoriArtikelResource extends Resource
{
    protected static ?string $model = KategoriArtikel::class;

    protected static ?string $navigationIcon  = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'CMS Konten';
    protected static ?string $navigationLabel = 'Kategori Artikel';
    protected static ?int    $navigationSort  = 1;

    protected static ?string $modelLabel       = 'Kategori';
    protected static ?string $pluralModelLabel = 'Kategori Artikel';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Data Kategori')
                ->schema([
                    Forms\Components\TextInput::make('nama')
                        ->label('Nama Kategori')
                        ->required()
                        ->maxLength(191)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),

                    Forms\Components\TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->maxLength(191)
                        ->unique(KategoriArtikel::class, 'slug', ignoreRecord: true),

                    Forms\Components\Textarea::make('deskripsi')
                        ->label('Deskripsi')
                        ->rows(3)
                        ->nullable(),

                    Forms\Components\OrderField::make('kategori_artikels', 'Urutan')
                        ->label('Urutan')
                        ->numeric()
                        ->minValue(1)
                        ->required()
                        ->default(fn () => (KategoriArtikel::max('urutan') ?? 0) + 1),

                    Forms\Components\Toggle::make('aktif')
                        ->label('Aktif')
                        ->default(true),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->copyable()
                    ->copyMessage('Slug disalin')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('urutan')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable()
                    ->alignRight(),

                Tables\Columns\IconColumn::make('aktif')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('artikel_count')
                    ->label('Jumlah Artikel')
                    ->state(fn (KategoriArtikel $record) => $record->artikels()->count())
                    ->sortable()
                    ->alignRight(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('aktif')
                    ->label('Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Kategori')
                    ->modalDescription('Menghapus kategori akan mempengaruhi artikel yang terhubung. Pastikan tidak ada artikel penting yang masih memakai kategori ini.'),
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
            'index'  => Pages\ListKategoriArtikels::route('/'),
            'create' => Pages\CreateKategoriArtikel::route('/create'),
            'edit'   => Pages\EditKategoriArtikel::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteKeyName(): string
    {
        return 'uuid_id';
    }
}
