<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Header Information -->
        <x-filament::section>
            <x-slot name="heading">
                Permission Management
            </x-slot>
            <x-slot name="description">
                Manage roles and permissions for your application. Create new roles, assign permissions, and control access to different parts of the system.
            </x-slot>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-primary-50 dark:bg-primary-900/20 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-heroicon-o-users class="h-8 w-8 text-primary-600 dark:text-primary-400" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Roles</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ \Spatie\Permission\Models\Role::count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-success-50 dark:bg-success-900/20 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-heroicon-o-shield-check class="h-8 w-8 text-success-600 dark:text-success-400" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Permissions</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ \Spatie\Permission\Models\Permission::count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-warning-50 dark:bg-warning-900/20 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-heroicon-o-user-group class="h-8 w-8 text-warning-600 dark:text-warning-400" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ \App\Models\User::count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </x-filament::section>

        <!-- Permissions List -->
        <x-filament::section>
            <x-slot name="heading">
                System Permissions
            </x-slot>
            <x-slot name="description">
                Available permissions in the system. These can be assigned to roles to control access.
            </x-slot>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3">
                @foreach(\Spatie\Permission\Models\Permission::all() as $permission)
                    <div class="bg-gray-50 dark:bg-gray-800 px-3 py-2 rounded-md">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $permission->name }}
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 bg-gray-200 dark:bg-gray-700 px-2 py-1 rounded">
                                {{ $permission->roles()->count() }} roles
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-filament::section>

        <!-- Roles and Permissions Table -->
        <x-filament::section>
            <x-slot name="heading">
                Roles Management
            </x-slot>
            <x-slot name="description">
                Manage roles and their associated permissions. You can create new roles, edit existing ones, and assign permissions.
            </x-slot>
            
            {{ $this->table }}
        </x-filament::section>
    </div>
</x-filament-panels::page>
