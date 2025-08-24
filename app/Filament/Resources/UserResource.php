<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use App\Filament\Resources\UserResource\Pages;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Pengguna';
    protected static ?string $pluralModelLabel = 'Pengguna';
    protected static ?string $navigationGroup = 'Manajemen Sistem';
    protected static ?int $navigationSort = 1;

    public static function canViewAny(): bool
    {
        return Auth::user()?->can('user_management') ?? false;
    }

    public static function canAccess(): bool
    {
        return static::canViewAny();
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->can('user_management') ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::user()?->can('user_management') ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()?->can('user_management') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Nama Lengkap')
                ->required()
                ->maxLength(255),

            TextInput::make('username')
                ->label('Username')
                ->required()
                ->unique(User::class, 'username', ignoreRecord: true)
                ->maxLength(255)
                ->alphaDash()
                ->helperText('Username hanya boleh berisi huruf, angka, dash, dan underscore'),

            TextInput::make('password')
                ->label('Password')
                ->password()
                ->maxLength(255)
                ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                ->dehydrated(fn ($state) => filled($state))
                ->required(fn (string $context) => $context === 'create')
                ->same('password_confirmation'),

            TextInput::make('password_confirmation')
                ->label('Konfirmasi Password')
                ->password()
                ->maxLength(255)
                ->required(fn (string $context) => $context === 'create')
                ->visible(fn (string $context) => $context === 'create'),

            Checkbox::make('is_active')
                ->label('Aktif')
                ->default(true),

            Select::make('roles')
                ->label('Roles')
                ->relationship('roles', 'name')
                ->multiple()
                ->preload()
                ->searchable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')
                ->label('Nama')
                ->searchable()
                ->sortable(),

            TextColumn::make('username')
                ->label('Username')
                ->searchable()
                ->sortable(),

            TextColumn::make('roles.name')
                ->label('Role')
                ->badge()
                ->separator(', ')
                ->color(fn (string $state): string => match ($state) {
                    'super_admin' => 'danger',
                    'admin' => 'warning',
                    default => 'gray',
                }),

            BooleanColumn::make('is_active')
                ->label('Aktif')
                ->sortable(),

            TextColumn::make('created_at')
                ->label('Dibuat')
                ->dateTime()
                ->sortable(),

            TextColumn::make('last_login_at')
                ->label('Login Terakhir')
                ->dateTime()
                ->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('roles')
                ->relationship('roles', 'name')
                ->label('Filter by Role'),

            Tables\Filters\TernaryFilter::make('is_active')
                ->label('Status Aktif'),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
