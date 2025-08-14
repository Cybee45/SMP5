<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Permission;

echo "=== FIXING ROLE AND PERMISSION RESOURCE ACCESS ===\n\n";

// Get admin user
$user = User::where('email', 'admin@smp5sangatta.sch.id')->first();

// Create missing permissions if they don't exist
$missingPermissions = [
    'role_view',
    'role_create', 
    'role_edit',
    'role_delete',
    'permission_view',
    'permission_create',
    'permission_edit', 
    'permission_delete'
];

echo "Creating missing permissions:\n";
foreach ($missingPermissions as $permissionName) {
    $permission = Permission::firstOrCreate(['name' => $permissionName]);
    echo "   ✓ {$permissionName}\n";
}

echo "\nAssigning permissions to admin user:\n";
foreach ($missingPermissions as $permissionName) {
    if (!$user->hasPermissionTo($permissionName)) {
        $user->givePermissionTo($permissionName);
        echo "   ✓ Gave {$permissionName} to admin\n";
    } else {
        echo "   - Admin already has {$permissionName}\n";
    }
}

echo "\nTesting access after fix:\n";

// Test RoleResource
try {
    $canViewRoles = \App\Filament\Resources\RoleResource::canViewAny();
    $shouldRegisterRoles = \App\Filament\Resources\RoleResource::shouldRegisterNavigation();
    echo "   RoleResource - canViewAny: " . ($canViewRoles ? '✓' : '❌') . 
         ", shouldRegister: " . ($shouldRegisterRoles ? '✓' : '❌') . "\n";
} catch (Exception $e) {
    echo "   RoleResource ERROR: " . $e->getMessage() . "\n";
}

// Test PermissionResource
try {
    $canViewPerms = \App\Filament\Resources\PermissionResource::canViewAny();
    $shouldRegisterPerms = \App\Filament\Resources\PermissionResource::shouldRegisterNavigation();
    echo "   PermissionResource - canViewAny: " . ($canViewPerms ? '✓' : '❌') . 
         ", shouldRegister: " . ($shouldRegisterPerms ? '✓' : '❌') . "\n";
} catch (Exception $e) {
    echo "   PermissionResource ERROR: " . $e->getMessage() . "\n";
}

echo "\nDone! All resources should now be accessible.\n";
