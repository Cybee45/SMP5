<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class PermissionManager extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'System Management';
    protected static ?string $navigationGroup = 'Manajemen Sistem';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.permission-manager';

    public static function canAccess(): bool
    {
        return Auth::user()?->hasRole('superadmin');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Role::query())
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Role Name')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('permissions_count')
                    ->label('Total Permissions')
                    ->counts('permissions')
                    ->badge()
                    ->color('success'),
                    
                Tables\Columns\TextColumn::make('users_count')
                    ->label('Total Users')
                    ->counts('users')
                    ->badge()
                    ->color('primary'),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make('create_permission')
                    ->label('Create Permission')
                    ->icon('heroicon-m-plus')
                    ->form([
                        TextInput::make('name')
                            ->label('Permission Name')
                            ->required()
                            ->unique(Permission::class, 'name')
                            ->placeholder('e.g., cms_manage, user_create'),
                        TextInput::make('guard_name')
                            ->label('Guard Name')
                            ->default('web')
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        Permission::create($data);
                        Notification::make()
                            ->title('Permission created successfully')
                            ->success()
                            ->send();
                    }),
                    
                Tables\Actions\CreateAction::make('create_role')
                    ->label('Create Role')
                    ->icon('heroicon-m-user-group')
                    ->form([
                        TextInput::make('name')
                            ->label('Role Name')
                            ->required()
                            ->unique(Role::class, 'name')
                            ->placeholder('e.g., editor, moderator'),
                        TextInput::make('guard_name')
                            ->label('Guard Name')
                            ->default('web')
                            ->required(),
                        Select::make('permissions')
                            ->label('Permissions')
                            ->multiple()
                            ->options(Permission::all()->pluck('name', 'name'))
                            ->searchable()
                            ->preload(),
                    ])
                    ->action(function (array $data) {
                        $permissions = $data['permissions'] ?? [];
                        unset($data['permissions']);
                        
                        $role = Role::create($data);
                        if (!empty($permissions)) {
                            $role->givePermissionTo($permissions);
                        }
                        
                        Notification::make()
                            ->title('Role created successfully')
                            ->success()
                            ->send();
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('manage_permissions')
                    ->label('Manage Permissions')
                    ->icon('heroicon-m-cog-6-tooth')
                    ->form([
                        Select::make('permissions')
                            ->label('Permissions')
                            ->multiple()
                            ->options(Permission::all()->pluck('name', 'name'))
                            ->default(fn (Role $record) => $record->permissions->pluck('name')->toArray())
                            ->searchable()
                            ->preload(),
                    ])
                    ->action(function (Role $record, array $data) {
                        $record->syncPermissions($data['permissions'] ?? []);
                        Notification::make()
                            ->title('Permissions updated successfully')
                            ->success()
                            ->send();
                    }),
                    
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (Role $record) => $record->name !== 'superadmin'),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('refresh_permissions')
                ->label('Refresh Cache')
                ->icon('heroicon-m-arrow-path')
                ->action(function () {
                    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
                    Notification::make()
                        ->title('Permission cache cleared successfully')
                        ->success()
                        ->send();
                }),
        ];
    }
}
