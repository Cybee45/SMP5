<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Spatie\Permission\Models\Role;
use App\Filament\Resources\RoleResource\pages;


class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'Role & Permission';
    protected static ?string $navigationGroup = 'Manajemen Sistem';
    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        return Auth::user()?->can('system_manage');
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->can('system_manage');
    }

    public static function canEdit($record): bool
    {
        return Auth::user()?->can('system_manage');
    }

    public static function canDelete($record): bool
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
        Log::info('RoleResource Navigation Check:', [
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
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Role')
                    ->required(),

                Select::make('permissions')
                    ->label('Permissions')
                    ->relationship('permissions', 'name')
                    ->multiple()
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Role'),
                TextColumn::make('permissions.name')
                    ->label('Permissions')
                    ->badge()
                    ->limit(3),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
