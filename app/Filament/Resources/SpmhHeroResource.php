<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpmhHeroResource\Pages;
use App\Filament\Resources\SpmhHeroResource\RelationManagers;
use App\Models\SpmhHero;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SpmhHeroResource extends Resource
{
    protected static ?string $model = SpmhHero::class;

    protected static ?string $navigationIcon  = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Hero SPMB';
    protected static ?string $navigationGroup = 'CMS SPMB';
    protected static ?int    $navigationSort  = 1;

    protected static ?string $modelLabel       = 'Hero SPMB';
    protected static ?string $pluralModelLabel = 'Hero SPMB';

    public static function canAccess(): bool
    {
        return Auth::user()?->can('spmb_management') ?? false;
    }

    public static function canViewAny(): bool
    {
        return Auth::user()?->can('spmb_management') ?? false;
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->can('spmb_management') ?? false;
    }

    public static function canEdit($record): bool
    {
        return Auth::user()?->can('spmb_management') ?? false;
    }

    public static function canDelete($record): bool
    {
        return Auth::user()?->can('spmb_management') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Konten Hero SPMB')
                ->schema([
                    Forms\Components\TextInput::make('subtitle')
                        ->label('Subtitle')
                        ->placeholder('SEKOLAH MENENGAH UNGGULAN DI SANGATTA UTARA')
                        ->columnSpanFull(),

                    Forms\Components\RichEditor::make('title')
                        ->label('Judul Utama')
                        ->required()
                        ->placeholder('Belajar, berprestasi, dan raih ilmu untuk masa depan')
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('description')
                        ->label('Deskripsi')
                        ->required()
                        ->rows(3)
                        ->placeholder('Kita ciptakan lingkungan belajar yang patut diacungi jempol...')
                        ->columnSpanFull(),

                    Forms\Components\Toggle::make('active')
                        ->label('Status Aktif')
                        ->default(true)
                        ->inline(false),
                ])->columns(2),

            Forms\Components\Section::make('Media & Gambar')
                ->schema([
                    Forms\Components\FileUpload::make('image_utama')
                        ->label('Gambar Utama Hero')
                        ->image()
                        ->directory('spmb/hero')
                        ->visibility('public')
                        ->imageEditor()
                        ->helperText('Gambar utama untuk hero section SPMB')
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subtitle')
                    ->label('Subtitle')
                    ->limit(50)
                    ->searchable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->html()
                    ->limit(100)
                    ->searchable(),

                Tables\Columns\ImageColumn::make('image_utama')
                    ->label('Gambar Utama')
                    ->size(60),

                Tables\Columns\IconColumn::make('active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('active')
                    ->label('Status')
                    ->placeholder('Semua Status')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSpmhHeroes::route('/'),
            'create' => Pages\CreateSpmhHero::route('/create'),
            'edit'   => Pages\EditSpmhHero::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteKeyName(): string
    {
        return 'uuid_id';
    }
}
