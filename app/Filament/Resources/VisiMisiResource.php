<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisiMisiResource\Pages;
use App\Models\VisiMisi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class VisiMisiResource extends Resource
{
    protected static ?string $model = VisiMisi::class;

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    protected static ?string $navigationGroup = 'CMS About';

    protected static ?string $navigationLabel = 'Visi & Misi';
    
    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Visi & Misi';

    protected static ?string $pluralModelLabel = 'Visi & Misi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Header Section')
                    ->schema([
                        Forms\Components\TextInput::make('subjudul_section')
                            ->label('Sub Judul Section')
                            ->required()
                            ->maxLength(255)
                            ->default('Arah & Fokus'),
                        
                        Forms\Components\TextInput::make('judul_section')
                            ->label('Judul Section')
                            ->required()
                            ->maxLength(255)
                            ->default('Visi, Misi, & Tujuan Sekolah'),
                    ])->columns(2),

                Forms\Components\Section::make('Konten Visi')
                    ->schema([
                        Forms\Components\Textarea::make('visi')
                            ->label('Visi Sekolah')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull()
                            ->placeholder('Tulis visi sekolah di sini...'),
                    ]),

                Forms\Components\Section::make('Konten Misi')
                    ->schema([
                        Forms\Components\Repeater::make('misi')
                            ->label('Misi Sekolah')
                            ->schema([
                                Forms\Components\Textarea::make('item')
                                    ->label('Poin Misi')
                                    ->required()
                                    ->rows(2)
                                    ->placeholder('Tulis satu poin misi...')
                            ])
                            ->addActionLabel('+ Tambah Misi')
                            ->defaultItems(1)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Konten Tujuan (Opsional)')
                    ->schema([
                        Forms\Components\Repeater::make('tujuan')
                            ->label('Tujuan Sekolah')
                            ->schema([
                                Forms\Components\Textarea::make('item')
                                    ->label('Poin Tujuan')
                                    ->required()
                                    ->rows(2)
                                    ->placeholder('Tulis satu poin tujuan...')
                            ])
                            ->addActionLabel('+ Tambah Tujuan')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Toggle::make('aktif')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Hanya satu visi misi yang boleh aktif'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subjudul_section')
                    ->label('Sub Judul')
                    ->searchable()
                    ->limit(20),
                    
                Tables\Columns\TextColumn::make('judul_section')
                    ->label('Judul Section')
                    ->searchable()
                    ->limit(30),
                    
                Tables\Columns\TextColumn::make('visi')
                    ->label('Visi')
                    ->limit(50)
                    ->wrap(),
                    
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
        return Auth::user()?->can('visimisi_view') ?? false;
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->can('visimisi_create') ?? false;
    }

    public static function canEdit($record): bool
    {
        return Auth::user()?->can('visimisi_edit') ?? false;
    }

    public static function canDelete($record): bool
    {
        return Auth::user()?->can('visimisi_delete') ?? false;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->can('visimisi_view') ?? false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVisiMisis::route('/'),
            'create' => Pages\CreateVisiMisi::route('/create'),
            'edit' => Pages\EditVisiMisi::route('/{record}/edit'),
        ];
    }
}
