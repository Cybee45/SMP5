<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaHeroResource\Pages;
use App\Filament\Resources\MediaHeroResource\RelationManagers;
use App\Models\MediaHero;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class MediaHeroResource extends Resource
{
    protected static ?string $model = MediaHero::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationGroup = 'CMS Media';

    protected static ?string $navigationLabel = 'Hero Section';
    
    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'Hero Section';

    protected static ?string $pluralModelLabel = 'Hero Sections';

    protected static ?string $recordRouteKeyName = 'uuid_id';

    
    public static function canViewAny(): bool
    {
        return Auth::user()?->can('mediahero_view') ?? false;
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->can('mediahero_create') ?? false;
    }

    public static function canEdit($record): bool
    {
        return Auth::user()?->can('mediahero_edit') ?? false;
    }

    public static function canDelete($record): bool
    {
        return Auth::user()?->can('mediahero_delete') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Konten Hero Section')
                    ->schema([
                        Forms\Components\TextInput::make('judul_utama')
                            ->label('Judul Utama')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Kami hadirkan aktivitas dan momen kampus dalam foto, video, dan tulisan.')
                            ->columnSpanFull(),
                        
                        Forms\Components\TextInput::make('subjudul')
                            ->label('Sub Judul')
                            ->maxLength(255)
                            ->placeholder('Sekolah Menengah Unggulan di Sangatta Utara'),
                        
                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->required()
                            ->rows(4)
                            ->placeholder('Kita ciptakan lingkungan belajar yang patut diacungi jempol...')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Gambar Hero Section')
                    ->schema([
                        Forms\Components\FileUpload::make('gambar_hero')
                            ->label('Gambar Hero Utama')
                            ->image()
                            ->directory('media/hero')
                            ->visibility('public')
                            ->imageEditor()
                            ->helperText('Jika kosong, akan menggunakan gambar default'),
                        
                        Forms\Components\FileUpload::make('gambar_globe')
                            ->label('Gambar Globe (Dekorasi)')
                            ->image()
                            ->directory('media/hero')
                            ->visibility('public')
                            ->imageEditor()
                            ->helperText('Gambar dekorasi globe'),
                        
                        Forms\Components\FileUpload::make('gambar_wave')
                            ->label('Gambar Wave (Background)')
                            ->image()
                            ->directory('media/hero')
                            ->visibility('public')
                            ->imageEditor()
                            ->helperText('Gambar background wave'),
                        
                        Forms\Components\Toggle::make('aktif')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Hanya satu hero section yang bisa aktif'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar_hero')
                    ->label('Hero Image')
                    ->disk('public')
                    ->size(60)
                    ->square(),

                Tables\Columns\TextColumn::make('subjudul')
                    ->label('Sub Judul')
                    ->limit(30)
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('judul_utama')
                    ->label('Judul Utama')
                    ->limit(50)
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                Tables\Columns\IconColumn::make('aktif')
                    ->label('Status')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('aktif')
                    ->label('Status Aktif')
                    ->boolean()
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Belum Ada Hero Section')
            ->emptyStateDescription('Buat hero section pertama untuk halaman utama website.')
            ->emptyStateIcon('heroicon-o-star');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMediaHeroes::route('/'),
            'create' => Pages\CreateMediaHero::route('/create'),
            'edit' => Pages\EditMediaHero::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteKeyName(): string
    {
        return 'uuid_id';
    }
}
