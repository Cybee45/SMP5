<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpmhContentResource\Pages;
use App\Models\SpmhContent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class SpmhContentResource extends Resource
{
    protected static ?string $model = SpmhContent::class;

    protected static ?string $navigationIcon  = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'CMS SPMB';
    protected static ?string $navigationLabel = 'Konten SPMB';
    protected static ?int    $navigationSort  = 2;

    protected static ?string $modelLabel       = 'Konten SPMB';
    protected static ?string $pluralModelLabel = 'Konten SPMB';

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
            // ========= Informasi dasar =========
            Forms\Components\Section::make('Informasi Dasar')
                ->schema([
                    Forms\Components\Select::make('jenis')
                        ->label('Jenis Konten')
                        ->required()
                        ->options([
                            'persyaratan' => 'Persyaratan Pendaftaran',
                            'tata_cara'   => 'Tata Cara Pendaftaran',
                            'formulir'    => 'Formulir Download',
                        ])
                        ->searchable()
                        ->native(false)
                        ->live()
                        ->helperText('Pilih jenis konten yang akan ditampilkan di website SPMB')
                        ->afterStateUpdated(function (Forms\Set $set, $state) {
                            $titles = [
                                'persyaratan' => 'Persyaratan Pendaftaran',
                                'tata_cara'   => 'Tata Cara Pendaftaran',
                                'formulir'    => 'Unduh Formulir',
                            ];
                            $set('judul', $titles[$state] ?? '');
                        }),

                    Forms\Components\TextInput::make('judul')
                        ->label('Judul')
                        ->required()
                        ->placeholder('Contoh: Persyaratan Pendaftaran'),

                    Forms\Components\Textarea::make('deskripsi')
                        ->label('Deskripsi Singkat')
                        ->rows(2)
                        ->placeholder('Deskripsi singkat untuk kartu')
                        ->helperText('Akan ditampilkan di bawah judul kartu'),

                    Forms\Components\TextInput::make('urutan')
                        ->label('Urutan Tampil')
                        ->numeric()
                        ->minValue(1)
                        ->required()
                        ->default(fn () => (\App\Models\SpmhContent::max('urutan') ?? 0) + 1)
                        ->helperText('1 = Persyaratan, 2 = Tata Cara, 3 = Formulir'),

                    Forms\Components\Toggle::make('aktif')
                        ->label('Status Aktif')
                        ->default(true)
                        ->inline(false),
                ])->columns(2),

            // ========= Konten Persyaratan =========
            Forms\Components\Section::make('Konten Persyaratan')
                ->description('Atur dokumen dan persyaratan yang harus dipenuhi calon siswa')
                ->schema([
                    Forms\Components\RichEditor::make('deskripsi_pembuka')
                        ->label('Deskripsi Pembuka')
                        ->placeholder('Harap mempersiapkan dokumen-dokumen berikut dalam bentuk fisik dan digital...')
                        ->toolbarButtons(['bold', 'italic', 'underline'])
                        ->columnSpanFull(),

                    Forms\Components\Repeater::make('dokumen_wajib')
                        ->label('A. Dokumen Wajib')
                        ->schema([
                            Forms\Components\TextInput::make('item')
                                ->label('Dokumen')
                                ->placeholder('Fotokopi Akta Kelahiran yang telah dilegalisir (2 lembar)')
                                ->required()
                                ->columnSpanFull(),
                        ])
                        ->addActionLabel('Tambah Dokumen Wajib')
                        ->deleteAction(fn ($action) => $action->label('Hapus'))
                        ->defaultItems(7)
                        ->columnSpanFull(),

                    Forms\Components\Repeater::make('dokumen_pendukung')
                        ->label('B. Dokumen Pendukung')
                        ->schema([
                            Forms\Components\TextInput::make('item')
                                ->label('Dokumen')
                                ->placeholder('Fotokopi SHUN/Nilai UN SD/MI (jika ada)')
                                ->required()
                                ->columnSpanFull(),
                        ])
                        ->addActionLabel('Tambah Dokumen Pendukung')
                        ->deleteAction(fn ($action) => $action->label('Hapus'))
                        ->defaultItems(5)
                        ->columnSpanFull(),

                    Forms\Components\Repeater::make('ketentuan_berkas')
                        ->label('C. Ketentuan Berkas')
                        ->schema([
                            Forms\Components\TextInput::make('item')
                                ->label('Ketentuan')
                                ->placeholder('Semua berkas dimasukkan ke dalam map plastik berwarna...')
                                ->required()
                                ->columnSpanFull(),
                        ])
                        ->addActionLabel('Tambah Ketentuan')
                        ->deleteAction(fn ($action) => $action->label('Hapus'))
                        ->defaultItems(4)
                        ->columnSpanFull(),

                    Forms\Components\RichEditor::make('catatan_penting')
                        ->label('Catatan Penting (Warning Box)')
                        ->placeholder('Harap cek kembali kelengkapan berkas sebelum diserahkan...')
                        ->toolbarButtons(['bold', 'italic'])
                        ->columnSpanFull(),
                ])
                ->visible(fn (Forms\Get $get): bool => $get('jenis') === 'persyaratan')
                ->columnSpanFull(),

            // ========= Konten Tata Cara =========
            Forms\Components\Section::make('Konten Tata Cara')
                ->description('Atur langkah-langkah pendaftaran dan informasi penting lainnya')
                ->schema([
                    Forms\Components\RichEditor::make('deskripsi_pembuka')
                        ->label('Deskripsi Pembuka')
                        ->placeholder('Berikut adalah alur lengkap pendaftaran siswa baru...')
                        ->toolbarButtons(['bold', 'italic', 'underline'])
                        ->columnSpanFull(),

                    Forms\Components\Repeater::make('tahap_persiapan')
                        ->label('Tahap Persiapan')
                        ->schema([
                            Forms\Components\RichEditor::make('item')
                                ->label('Langkah')
                                ->placeholder('<strong>Unduh Formulir Pendaftaran:</strong> Calon siswa atau orang tua...')
                                ->required()
                                ->toolbarButtons(['bold', 'italic'])
                                ->columnSpanFull(),
                        ])
                        ->addActionLabel('Tambah Langkah Persiapan')
                        ->deleteAction(fn ($action) => $action->label('Hapus'))
                        ->defaultItems(3)
                        ->columnSpanFull(),

                    Forms\Components\Repeater::make('tahap_pendaftaran')
                        ->label('Tahap Pendaftaran')
                        ->schema([
                            Forms\Components\RichEditor::make('item')
                                ->label('Langkah')
                                ->placeholder('<strong>Isi Formulir:</strong> Cetak dan isi formulir pendaftaran...')
                                ->required()
                                ->toolbarButtons(['bold', 'italic'])
                                ->columnSpanFull(),
                        ])
                        ->addActionLabel('Tambah Langkah Pendaftaran')
                        ->deleteAction(fn ($action) => $action->label('Hapus'))
                        ->defaultItems(5)
                        ->columnSpanFull(),

                    Forms\Components\Repeater::make('tahap_seleksi')
                        ->label('Tahap Seleksi')
                        ->schema([
                            Forms\Components\RichEditor::make('item')
                                ->label('Langkah')
                                ->placeholder('<strong>Verifikasi Berkas:</strong> Panitia akan memverifikasi...')
                                ->required()
                                ->toolbarButtons(['bold', 'italic'])
                                ->columnSpanFull(),
                        ])
                        ->addActionLabel('Tambah Langkah Seleksi')
                        ->deleteAction(fn ($action) => $action->label('Hapus'))
                        ->defaultItems(3)
                        ->columnSpanFull(),

                    Forms\Components\Repeater::make('tahap_pengumuman')
                        ->label('Tahap Pengumuman')
                        ->schema([
                            Forms\Components\RichEditor::make('item')
                                ->label('Langkah')
                                ->placeholder('<strong>Pengumuman Hasil:</strong> Hasil seleksi akan diumumkan...')
                                ->required()
                                ->toolbarButtons(['bold', 'italic'])
                                ->columnSpanFull(),
                        ])
                        ->addActionLabel('Tambah Langkah Pengumuman')
                        ->deleteAction(fn ($action) => $action->label('Hapus'))
                        ->defaultItems(3)
                        ->columnSpanFull(),

                    Forms\Components\Repeater::make('jadwal_penting')
                        ->label('Jadwal Penting (Info Box Biru)')
                        ->schema([
                            Forms\Components\TextInput::make('item')
                                ->label('Jadwal')
                                ->placeholder('Pendaftaran dibuka mulai tanggal 1 Agustus 2025')
                                ->required()
                                ->columnSpanFull(),
                        ])
                        ->addActionLabel('Tambah Jadwal')
                        ->deleteAction(fn ($action) => $action->label('Hapus'))
                        ->defaultItems(4)
                        ->columnSpanFull(),

                    Forms\Components\Repeater::make('tips_sukses')
                        ->label('Tips Sukses (Box Hijau)')
                        ->schema([
                            Forms\Components\TextInput::make('item')
                                ->label('Tips')
                                ->placeholder('Siapkan berkas jauh-jauh hari untuk menghindari keterlambatan')
                                ->required()
                                ->columnSpanFull(),
                        ])
                        ->addActionLabel('Tambah Tips')
                        ->deleteAction(fn ($action) => $action->label('Hapus'))
                        ->defaultItems(4)
                        ->columnSpanFull(),
                ])
                ->visible(fn (Forms\Get $get): bool => $get('jenis') === 'tata_cara')
                ->columnSpanFull(),

            // ========= File & Dokumen (hanya tampil kalau BUKAN "formulir", biar ga dobel) =========
            Forms\Components\Section::make('File & Dokumen')
                ->description('Upload file pendukung untuk konten ini')
                ->schema([
                    Forms\Components\FileUpload::make('file_pdf')
                        ->label('Upload File')
                        ->disk('public')
                        ->directory('spmb-files')
                        ->acceptedFileTypes([
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        ])
                        ->maxSize(5120)
                        ->helperText('PDF/DOC/DOCX maks. 5MB')
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('nama_file')
                        ->label('Nama File untuk Download')
                        ->placeholder('contoh: Formulir-Pendaftaran-SMPN5-2025.pdf')
                        ->helperText('Nama file yang akan ditampilkan untuk download')
                        ->columnSpanFull(),
                ])
                ->visible(fn (Forms\Get $get): bool => $get('jenis') !== 'formulir')
                ->collapsible()
                ->columnSpanFull(),

            // ========= File Formulir (khusus jenis "formulir") =========
            Forms\Components\Section::make('File Formulir')
                ->description('Upload file PDF formulir pendaftaran')
                ->schema([
                    Forms\Components\FileUpload::make('file_pdf')
                        ->label('Upload Formulir PDF')
                        ->disk('public')
                        ->directory('spmb-files')
                        ->acceptedFileTypes(['application/pdf'])
                        ->maxSize(5120)
                        ->helperText('Upload file PDF formulir pendaftaran (maks. 5MB)')
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('nama_file')
                        ->label('Nama File untuk Download')
                        ->placeholder('Formulir-Pendaftaran-SMPN5-2025.pdf')
                        ->helperText('Nama file yang akan diunduh user')
                        ->columnSpanFull(),
                ])
                ->visible(fn (Forms\Get $get): bool => $get('jenis') === 'formulir')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('jenis')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'persyaratan' => 'success',
                        'tata_cara'   => 'info',
                        'formulir'    => 'warning',
                        default       => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'persyaratan' => 'Persyaratan',
                        'tata_cara'   => 'Tata Cara',
                        'formulir'    => 'Formulir',
                        default       => $state,
                    })
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->wrap(),

                Tables\Columns\TextColumn::make('urutan')
                    ->label('Urutan')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('aktif')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diupdate')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('urutan', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('jenis')
                    ->label('Jenis Konten')
                    ->options([
                        'persyaratan' => 'Persyaratan',
                        'tata_cara'   => 'Tata Cara',
                        'formulir'    => 'Formulir',
                    ]),

                Tables\Filters\TernaryFilter::make('aktif')
                    ->label('Status')
                    ->boolean()
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Lihat')
                    ->modalHeading(fn ($record) => 'Preview: ' . $record->judul)
                    ->modalContent(fn ($record) => view('filament.pages.spmh-content-preview', ['record' => $record]))
                    ->modalWidth('5xl'),
                Tables\Actions\EditAction::make()
                    ->label('Edit'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus Terpilih'),
                ]),
            ])
            ->emptyStateHeading('Belum ada konten SPMB')
            ->emptyStateDescription('Mulai dengan membuat konten persyaratan, tata cara, atau formulir pendaftaran.')
            ->emptyStateIcon('heroicon-o-document-text')
            ->headerActions([
                Tables\Actions\Action::make('lihat_website')
                    ->label('Lihat Halaman SPMB')
                    ->icon('heroicon-o-eye')
                    ->color('success')
                    ->url('/spmb')
                    ->openUrlInNewTab(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSpmhContents::route('/'),
            'create' => Pages\CreateSpmhContent::route('/create'),
            'edit'   => Pages\EditSpmhContent::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteKeyName(): string
    {
        return 'uuid_id';
    }
}
