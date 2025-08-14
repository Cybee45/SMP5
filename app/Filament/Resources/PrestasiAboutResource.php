<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrestasiAboutResource\Pages;
use App\Filament\Resources\PrestasiAboutResource\RelationManagers;
use App\Models\PrestasiAbout;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PrestasiAboutResource extends Resource
{
    protected static ?string $model = PrestasiAbout::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationGroup = 'CMS About';

    protected static ?string $navigationLabel = 'Prestasi Sekolah';
    
    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'Prestasi';

    protected static ?string $pluralModelLabel = 'Prestasi Sekolah';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Prestasi')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->label('Judul Prestasi')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Juara 1 Lomba Cerdas Cermat'),
                        
                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi Prestasi')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull()
                            ->placeholder('Jelaskan detail prestasi yang diraih...'),
                    ])->columns(2),

                Forms\Components\Section::make('Media & Pengaturan')
                    ->schema([
                        Forms\Components\FileUpload::make('gambar')
                            ->label('Foto Prestasi')
                            ->image()
                            ->required()
                            ->directory('prestasi-about')
                            ->visibility('public')
                            ->imageEditor()
                            ->columnSpanFull(),
                        
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
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul Prestasi')
                    ->searchable()
                    ->limit(40),
                    
                Tables\Columns\ImageColumn::make('gambar')
                    ->label('Foto')
                    ->square()
                    ->size(60),
                    
                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->wrap(),
                    
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
        return Auth::user()?->can('prestasiabout_view') ?? false;
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->can('prestasiabout_create') ?? false;
    }

    public static function canEdit($record): bool
    {
        return Auth::user()?->can('prestasiabout_edit') ?? false;
    }

    public static function canDelete($record): bool
    {
        return Auth::user()?->can('prestasiabout_delete') ?? false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrestasiAbouts::route('/'),
            'create' => Pages\CreatePrestasiAbout::route('/create'),
            'edit' => Pages\EditPrestasiAbout::route('/{record}/edit'),
        ];
    }
}
