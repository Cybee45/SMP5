<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileSettingsResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ProfileSettingsResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon   = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel  = 'Pengaturan Profile';
    protected static ?string $pluralModelLabel = 'Pengaturan Profile';
    protected static ?string $navigationGroup  = 'Pengaturan Akun';
    protected static ?int    $navigationSort   = 99;

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::check();
    }

    public static function canViewAny(): bool
    {
        return Auth::user()?->can('profilesettings_view') ?? false;
    }

    public static function canAccess(): bool
    {
        return static::canViewAny();
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->can('profilesettings_create') ?? false;
    }

    public static function canEdit($record): bool
    {
        return Auth::user()?->can('profilesettings_edit') ?? false;
    }

    public static function canDelete($record): bool
    {
        return Auth::user()?->can('profilesettings_delete') ?? false;
    }

    public static function form(Form $form): Form
    {
        $user = Auth::user();

        return $form->schema([
            Section::make('Data Diri')
                ->schema([
                    TextInput::make('name')
                        ->label('Nama Lengkap')
                        ->required()
                        ->maxLength(255)
                        ->default($user?->name),

                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->default($user?->email),

                    FileUpload::make('profile_photo_path')
                        ->label('Foto Profil')
                        ->image()
                        ->directory('profile-photos')
                        ->maxSize(2048),
                        // ->imageEditor() // aktifkan jika kamu pakai plugin editor gambar
                ]),

            Section::make('Keamanan')
                ->schema([
                    TextInput::make('password')
                        ->label('Password Baru')
                        ->password()
                        ->minLength(8)
                        ->maxLength(255)
                        ->rule('confirmed')               // validasi laravel: butuh field *_confirmation
                        ->dehydrated(fn ($state) => filled($state)) // jangan simpan kalau kosong
                        ->dehydrateStateUsing(fn ($state) => $state ? bcrypt($state) : null)
                        ->helperText('Isi jika ingin mengganti password'),

                    TextInput::make('password_confirmation')
                        ->label('Konfirmasi Password Baru')
                        ->password()
                        ->minLength(8)
                        ->maxLength(255)
                        ->dehydrated(false), // jangan disimpan ke DB
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(fn (Builder $query) => $query->whereKey(Auth::id()))
            ->columns([
                ImageColumn::make('profile_photo_path')
                    ->label('Foto Profil'),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
            ])
            ->actions([
                EditAction::make()->label('Edit Profile'),
            ])
            ->defaultSort('name', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfileSettings::route('/'),
            'edit'  => Pages\EditProfileSettings::route('/{record}/edit'),
        ];
    }
}
