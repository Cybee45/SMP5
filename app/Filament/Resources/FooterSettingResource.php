<?php

namespace App\Filament\Resources;

use App\Support\OrderField;
use App\Filament\Resources\FooterSettingResource\Pages;
use App\Models\FooterSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FooterSettingResource extends Resource
{
    protected static ?string $model = FooterSetting::class;

    protected static ?string $navigationIcon    = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel   = 'Footer Settings';
    protected static ?string $modelLabel        = 'Footer Setting';
    protected static ?string $pluralModelLabel  = 'Footer Settings';
    protected static ?string $navigationGroup   = 'CMS Footer';
    protected static ?int    $navigationSort    = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Sekolah')
                    ->schema([
                        Forms\Components\TextInput::make('nama_sekolah')
                            ->required()
                            ->maxLength(255)
                            ->default('SMP Negeri 5 Sangatta Utara'),

                        Forms\Components\Textarea::make('deskripsi_sekolah')
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('logo_sekolah')
                            ->image()
                            ->directory('footer-logos'),

                        Forms\Components\TextInput::make('alamat')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('telepon_1')
                            ->tel()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('telepon_2')
                            ->tel()
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Media Sosial')
                    ->schema([
                        Forms\Components\TextInput::make('instagram_url')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://instagram.com/username'),

                        Forms\Components\TextInput::make('whatsapp_url')
                            ->maxLength(255)
                            ->placeholder('https://wa.me/6281234567890'),

                        Forms\Components\TextInput::make('facebook_url')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://facebook.com/username'),

                        Forms\Components\TextInput::make('youtube_url')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://youtube.com/@username'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Menu Footer')
                    ->schema([
                        Forms\Components\Repeater::make('menu_items')
                            ->schema([
                                Forms\Components\TextInput::make('nama_menu')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('url')
                                    ->maxLength(255)
                                    ->placeholder('#'),

                                Forms\Components\TextInput::make('route_name')
                                    ->maxLength(255)
                                    ->placeholder('home'),

                                Forms\Components\TextInput::make('icon')
                                    ->maxLength(255)
                                    ->placeholder('heroicon-o-home'),

                                Forms\Components\Toggle::make('aktif')
                                    ->default(true),

                                // (Opsional) kalau tetap mau angka manual per item:
                                // Forms\Components\TextInput::make('order')
                                //     ->label('Urutan Item')
                                //     ->numeric()
                                //     ->minValue(1),
                            ])
                            ->reorderableWithButtons() // gunakan fitur bawaan untuk urutkan item
                            ->columns(3)
                            ->defaultItems(0)
                            ->addActionLabel('Tambah Menu')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\TextInput::make('copyright_text')
                            ->required()
                            ->maxLength(255)
                            ->default('© 2024 Afaja Company. All Rights Reserved.'),

                        Forms\Components\Toggle::make('aktif')
                            ->required()
                            ->default(true),

                        // Pakai komponen kustom kamu (App\Support\OrderField)
                        OrderField::make('footer_settings', 'Urutan') // <- argumen pertama = nama tabel untuk auto-bounds
                            ->label('Urutan')
                            ->default(fn () => (FooterSetting::max('urutan') ?? 0) + 1),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_sekolah')
                    ->searchable()
                    ->label('Nama Sekolah'),

                Tables\Columns\ImageColumn::make('logo_sekolah')
                    ->label('Logo')
                    ->square()
                    ->defaultImageUrl(asset('assets/logo/logo.png')),

                Tables\Columns\TextColumn::make('telepon_1')
                    ->searchable()
                    ->label('Telepon 1'),

                Tables\Columns\TextColumn::make('alamat')
                    ->searchable()
                    ->limit(50),

                Tables\Columns\IconColumn::make('aktif')
                    ->boolean()
                    ->label('Status'),

                Tables\Columns\TextColumn::make('urutan')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('aktif')
                    ->label('Status')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif')
                    ->placeholder('Semua'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListFooterSettings::route('/'),
            'create' => Pages\CreateFooterSetting::route('/create'),
            'edit'   => Pages\EditFooterSetting::route('/{record}/edit'),
        ];
    }

    /**
     * Pakai uuid_id untuk route binding
     */
    public static function getRecordRouteKeyName(): string
    {
        return 'uuid_id';
    }
}
