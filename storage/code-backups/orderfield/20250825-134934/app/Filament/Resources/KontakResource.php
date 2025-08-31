<?php

namespace App\Filament\Resources;


use App\Support\OrderField;use App\Filament\Resources\KontakResource\Pages;
use App\Models\Kontak;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KontakResource extends Resource
{
    protected static ?string $model = Kontak::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';
    protected static ?string $navigationGroup = 'CMS Kontak';
    protected static ?string $navigationLabel = 'Kontak & Lokasi';
    protected static ?int $navigationSort = 60;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Header Section')
                    ->description('Judul dan deskripsi utama halaman kontak')
                    ->schema([
                        Forms\Components\TextInput::make('section_title')
                            ->label('Judul Section')
                            ->required()
                            ->maxLength(255)
                            ->default('Hubungi & Kunjungi Kami'),

                        Forms\Components\Textarea::make('section_description')
                            ->label('Deskripsi Section')
                            ->required()
                            ->rows(3)
                            ->default('Punya pertanyaan atau ingin datang langsung? Informasi lengkapnya ada di bawah ini.'),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Email Information')
                    ->description('Informasi kontak email')
                    ->schema([
                        Forms\Components\TextInput::make('email_title')
                            ->label('Judul Email')
                            ->required()
                            ->maxLength(255)
                            ->default('Email Pertanyaan'),

                        Forms\Components\Textarea::make('email_description')
                            ->label('Deskripsi Email')
                            ->required()
                            ->rows(2)
                            ->default('Untuk pertanyaan umum, pendaftaran, atau informasi lainnya.'),

                        Forms\Components\TextInput::make('email_address')
                            ->label('Alamat Email')
                            ->required()
                            ->email()
                            ->maxLength(255)
                            ->default('info@smpn5sangatta.sch.id'),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Phone Information')
                    ->description('Informasi kontak telepon')
                    ->schema([
                        Forms\Components\TextInput::make('phone_title')
                            ->label('Judul Telepon')
                            ->required()
                            ->maxLength(255)
                            ->default('Telepon & WhatsApp'),

                        Forms\Components\Textarea::make('phone_description')
                            ->label('Deskripsi Telepon')
                            ->required()
                            ->rows(2)
                            ->default('Hubungi kami di jam kerja (08:00 - 17:00 WITA).'),

                        Forms\Components\TextInput::make('phone_number')
                            ->label('Nomor Telepon')
                            ->required()
                            ->maxLength(255)
                            ->default('+62 832-8907-4832'),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Location Information')
                    ->description('Informasi lokasi dan peta')
                    ->schema([
                        Forms\Components\TextInput::make('location_title')
                            ->label('Judul Lokasi')
                            ->required()
                            ->maxLength(255)
                            ->default('Kunjungi Sekolah Kami'),

                        Forms\Components\Textarea::make('location_address')
                            ->label('Alamat Lengkap')
                            ->required()
                            ->rows(3)
                            ->default('SMP Negeri 5 Sangatta Utara, Jl. Poros Kabo, Swarga Bara, Kec. Sangatta Utara, Kabupaten Kutai Timur, Kalimantan Timur.'),

                        Forms\Components\Textarea::make('map_embed')
                            ->label('Google Maps Embed URL')
                            ->required()
                            ->rows(4)
                            ->helperText('Masukkan URL embed dari Google Maps')
                            ->default('https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5148.134314454969!2d117.53354207598979!3d0.4869592637395554!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x320a359185a0ccdd%3A0xd75f2288aa912a2e!2sSMP%20NEGERI%205%20SANGATTA%20UTARA!5e1!3m2!1sen!2sid!4v1754648855319!5m2!1sen!2sid'),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Settings')
                    ->description('Pengaturan tampilan')
                    ->schema([
                        Forms\Components\OrderField::make('kontaks', 'Urutan')
                            ->label('Urutan')
                            ->numeric()
                            ->minValue(1)
                            ->required()
                            ->default(fn () => (\App\Models\Kontak::max('urutan') ?? 0) + 1)
                            ->helperText('Urutan tampilan (semakin kecil, semakin atas)'),

                        Forms\Components\Toggle::make('aktif')
                            ->label('Status Aktif')
                            ->default(true)
                            ->helperText('Hanya data aktif yang akan ditampilkan di website'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('section_title')
                    ->label('Judul Section')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email_address')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Telepon')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('urutan')
                    ->label('Urutan')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('aktif')
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
                    ->label('Diupdate')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('aktif')
                    ->label('Status')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),
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
            ->defaultSort('urutan');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListKontaks::route('/'),
            'create' => Pages\CreateKontak::route('/create'),
            'edit'   => Pages\EditKontak::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteKeyName(): string
    {
        return 'uuid_id';
    }
}
