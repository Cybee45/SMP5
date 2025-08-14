<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "=== CHECKING CURRENT PERMISSIONS SETUP ===\n\n";

// Get current permissions
echo "1. Current permissions in database:\n";
$permissions = Permission::all();
foreach ($permissions as $permission) {
    echo "   - {$permission->name}\n";
}

echo "\n2. Current roles and their permissions:\n";
$roles = Role::with('permissions')->get();
foreach ($roles as $role) {
    echo "   Role: {$role->name}\n";
    echo "   Permissions: " . $role->permissions->pluck('name')->implode(', ') . "\n";
    echo "   ---\n";
}

echo "\n3. Checking what permissions might be missing...\n";

// Define expected permissions based on common CMS needs
$expectedPermissions = [
    'admin_access',      // Already created
    'cms_manage',        // Already exists  
    'system_manage',     // Already exists
    'dashboard_access',  // Already exists
    
    // Content management
    'artikel_view',
    'artikel_create', 
    'artikel_edit',
    'artikel_delete',
    
    'galeri_view',
    'galeri_create',
    'galeri_edit', 
    'galeri_delete',
    
    'hero_view',
    'hero_create',
    'hero_edit',
    'hero_delete',
    
    'profil_view',
    'profil_create', 
    'profil_edit',
    'profil_delete',
    
    // User management
    'user_view',
    'user_create',
    'user_edit', 
    'user_delete',
    
    // Role & Permission management
    'role_view',
    'role_create',
    'role_edit',
    'role_delete',
    
    'permission_view',
    'permission_create',
    'permission_edit',
    'permission_delete',
];

$currentPermissions = $permissions->pluck('name')->toArray();
$missingPermissions = array_diff($expectedPermissions, $currentPermissions);

if (empty($missingPermissions)) {
    echo "   All expected permissions exist!\n";
} else {
    echo "   Missing permissions:\n";
    foreach ($missingPermissions as $missing) {
        echo "   - {$missing}\n";
    }
}

echo "\nDone.\n";
