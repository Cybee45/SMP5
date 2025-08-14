<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutHeroResource\Pages;
use App\Filament\Resources\AboutHeroResource\RelationManagers;
use App\Models\AboutHero;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class AboutHeroResource extends Resource
{
    protected static ?string $model = AboutHero::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'CMS About';

    protected static ?string $navigationLabel = 'Hero About';
    
    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Hero About';

    protected static ?string $pluralModelLabel = 'Hero About';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Konten Hero About')
                    ->schema([
                        Forms\Components\TextInput::make('subjudul')
                            ->label('Sub Judul')
                            ->required()
                            ->maxLength(255)
                            ->default('Sekolah Menengah Unggulan di Sangatta Utara'),
                        
                        Forms\Components\TextInput::make('judul')
                            ->label('Judul Utama')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Gali ilmu, ukir prestasi, sambut masa depan gemilang.'),
                        
                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull()
                            ->placeholder('Deskripsi tentang sekolah...'),
                    ])->columns(2),

                Forms\Components\Section::make('Media & Status')
                    ->schema([
                        Forms\Components\FileUpload::make('gambar')
                            ->label('Gambar Hero')
                            ->image()
                            ->directory('hero-about')
                            ->visibility('public')
                            ->imageEditor()
                            ->columnSpanFull(),
                        
                        Forms\Components\Toggle::make('aktif')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Hanya satu hero yang boleh aktif'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subjudul')
                    ->label('Sub Judul')
                    ->searchable()
                    ->limit(30),
                    
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul Utama')
                    ->searchable()
                    ->limit(40),
                    
                Tables\Columns\ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->circular()
                    ->size(50),
                    
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
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canViewAny(): bool
    {
        return Auth::user()?->can('cms_manage') || Auth::user()?->can('cms_about');
    }

    public static function canCreate(): bool
    {
        return (Auth::user()?->can('cms_manage') || Auth::user()?->can('cms_about')) 
               && Auth::user()?->can('content_create');
    }

    public static function canEdit($record): bool
    {
        return (Auth::user()?->can('cms_manage') || Auth::user()?->can('cms_about')) 
               && Auth::user()?->can('content_edit');
    }

    public static function canDelete($record): bool
    {
        return (Auth::user()?->can('cms_manage') || Auth::user()?->can('cms_about')) 
               && Auth::user()?->can('content_delete');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAboutHeroes::route('/'),
            'create' => Pages\CreateAboutHero::route('/create'),
            'edit' => Pages\EditAboutHero::route('/{record}/edit'),
        ];
    }
}
