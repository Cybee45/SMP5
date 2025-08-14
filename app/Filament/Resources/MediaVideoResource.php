<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaVideoResource\Pages;
use App\Filament\Resources\MediaVideoResource\RelationManagers;
use App\Models\MediaVideo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class MediaVideoResource extends Resource
{
    protected static ?string $model = MediaVideo::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    protected static ?string $navigationGroup = 'CMS Media';

    protected static ?string $navigationLabel = 'Video';
    
    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Video';

    protected static ?string $pluralModelLabel = 'Video Media';

    protected static ?string $recordRouteKeyName = 'uuid_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Video')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->label('Judul Video')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Selamat Datang di SMP 5 Sangatta Utara'),
                        
                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Deskripsi singkat tentang video ini...'),
                        
                        Forms\Components\TextInput::make('youtube_url')
                            ->label('YouTube URL')
                            ->required()
                            ->url()
                            ->placeholder('https://www.youtube.com/watch?v=...')
                            ->helperText('Masukkan URL lengkap video YouTube')
                            ->columnSpanFull(),
                        
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('Custom Thumbnail (Opsional)')
                            ->image()
                            ->directory('media/thumbnails')
                            ->visibility('public')
                            ->imageEditor()
                            ->helperText('Jika kosong, akan menggunakan thumbnail dari YouTube'),
                        
                        Forms\Components\TextInput::make('urutan')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0)
                            ->helperText('Angka kecil akan tampil lebih dulu'),
                        
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
                Tables\Columns\ImageColumn::make('thumbnail_url')
                    ->label('Thumbnail')
                    ->size(80),
                    
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->limit(40),
                    
                Tables\Columns\TextColumn::make('youtube_url')
                    ->label('YouTube URL')
                    ->limit(50)
                    ->url(fn ($record) => $record->youtube_url)
                    ->openUrlInNewTab(),
                    
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
        return [
            //
        ];
    }

    public static function canViewAny(): bool
    {
        return Auth::user()?->can('mediavideo_view') ?? false;
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->can('mediavideo_create') ?? false;
    }

    public static function canEdit($record): bool
    {
        return Auth::user()?->can('mediavideo_edit') ?? false;
    }

    public static function canDelete($record): bool
    {
        return Auth::user()?->can('mediavideo_delete') ?? false;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->can('mediavideo_view') ?? false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMediaVideos::route('/'),
            'create' => Pages\CreateMediaVideo::route('/create'),
            'edit' => Pages\EditMediaVideo::route('/{record}/edit'),
        ];
    }
}
