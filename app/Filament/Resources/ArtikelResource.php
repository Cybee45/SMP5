<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtikelResource\Pages;
use App\Models\Artikel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ArtikelResource extends Resource
{
    protected static ?string $model = Artikel::class;

    protected static ?string $navigationIcon  = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'CMS Konten';
    protected static ?string $navigationLabel = 'Artikel & Berita';
    protected static ?int    $navigationSort  = 2;
    protected static ?string $modelLabel       = 'Artikel';
    protected static ?string $pluralModelLabel = 'Artikel & Berita';

    public static function canViewAny(): bool { return Auth::user()?->can('cms_articles') ?? false; }
    public static function canAccess(): bool   { return static::canViewAny(); }
    public static function canCreate(): bool   { return Auth::user()?->can('cms_articles') ?? false; }
    public static function canEdit($record): bool { return Auth::user()?->can('cms_articles') ?? false; }
    public static function canDelete($record): bool { return Auth::user()?->can('cms_articles') ?? false; }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Artikel')->schema([
                Forms\Components\Hidden::make('user_id')->default(fn () => Auth::id()),

                Forms\Components\TextInput::make('judul')
                    ->label('Judul Artikel')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state)))
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(Artikel::class, 'slug', ignoreRecord: true),

                Forms\Components\RichEditor::make('konten')
                    ->label('Konten Artikel')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('gambar')
                    ->label('Gambar Utama')
                    ->image()
                    ->directory('artikel')
                    ->imageEditor()
                    ->deletable()
                    ->nullable()
                    ->columnSpanFull(),

                Forms\Components\Select::make('kategori_id')
                    ->label('Kategori')
                    ->relationship('kategori', 'nama')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->rules(['required', 'exists:kategori_artikels,id'])
                    ->placeholder('— Pilih kategori —'),

                // ⬇️ Fix utama: wajib saat published, default now() jika kosong
                Forms\Components\DateTimePicker::make('tanggal_publikasi')
                    ->label('Tanggal Publikasi')
                    ->seconds(false)
                    ->nullable() // tetap boleh null untuk draft/archived
                    ->required(fn (Get $get) => $get('status') === 'published')
                    ->default(fn (Get $get) => $get('status') === 'published' ? now() : null)
                    ->dehydrateStateUsing(function ($state, Get $get) {
                        // Safety net: kalau published & state kosong → isi now()
                        if ($get('status') === 'published' && empty($state)) {
                            return now();
                        }
                        return $state;
                    }),

                Forms\Components\Select::make('status')
                    ->label('Status Artikel')
                    ->options([
                        'draft'     => 'Draft',
                        'published' => 'Published',
                        'archived'  => 'Archived',
                    ])
                    ->default('published')
                    ->required(),

                Forms\Components\Toggle::make('aktif')
                    ->label('Status Publikasi')
                    ->default(true),
            ])->columns(2),
            // CATATAN: Tidak ada field "urutan" di form.
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar')->label('Gambar'),
                Tables\Columns\TextColumn::make('judul')->label('Judul')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('kategori.nama')->label('Kategori'),
                Tables\Columns\TextColumn::make('tanggal_publikasi')
                    ->label('Tanggal Publikasi')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'secondary' => 'draft',
                        'success'   => 'published',
                        'warning'   => 'archived',
                    ]),
                Tables\Columns\IconColumn::make('aktif')->label('Aktif')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime()->sortable(),
            ])
            // Urutkan TERBARU terlebih dahulu berdasarkan tanggal_publikasi
            ->defaultSort('tanggal_publikasi', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('aktif')->label('Aktif'),
                Tables\Filters\SelectFilter::make('kategori')->relationship('kategori', 'nama')->label('Kategori'),
                Tables\Filters\SelectFilter::make('status')->label('Status')->options([
                    'draft' => 'Draft',
                    'published' => 'Published',
                    'archived' => 'Archived',
                ]),
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
            'index'  => Pages\ListArtikels::route('/'),
            'create' => Pages\CreateArtikel::route('/create'),
            'edit'   => Pages\EditArtikel::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteKeyName(): string
    {
        return 'uuid_id';
    }
}
