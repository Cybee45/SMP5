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
        return Auth::user()?->can('system_manage');
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        if (!$user) return false;
        
        $hasRole = $user->hasRole('super_admin');
        $hasPermission = $user->can('system_manage');
        
        // Debugging (hapus setelah testing)
        Log::info('UserResource Navigation Check:', [
            'user_id' => $user->id,
            'email' => $user->email,
            'roles' => $user->roles->pluck('name'),
            'has_super_admin_role' => $hasRole,
            'has_system_manage_permission' => $hasPermission,
            'should_register' => $hasRole && $hasPermission
        ]);
        
        return $hasRole && $hasPermission;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),

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
            TextColumn::make('name')->searchable(),
            TextColumn::make('email')->searchable(),
            BooleanColumn::make('is_active')->label('Aktif'),
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
