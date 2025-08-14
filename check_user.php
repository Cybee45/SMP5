<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "=== CHECKING USER PERMISSIONS ===\n";

// Find user with email admin@admin.com
$user = User::where('email', 'admin@admin.com')->first();

if (!$user) {
    echo "❌ User admin@admin.com not found!\n";
    
    // Show all users
    echo "\n=== ALL USERS ===\n";
    foreach(User::all() as $u) {
        echo "- {$u->email} (active: " . ($u->is_active ? 'YES' : 'NO') . ")\n";
    }
    exit;
}

echo "✅ User found: {$user->email}\n";
echo "Active: " . ($user->is_active ? 'YES' : 'NO') . "\n";
echo "Locked: " . ($user->isLocked() ? 'YES' : 'NO') . "\n";

echo "\n=== USER ROLES ===\n";
foreach($user->roles as $role) {
    echo "- {$role->name}\n";
}

echo "\n=== USER PERMISSIONS ===\n";
foreach($user->getAllPermissions() as $perm) {
    echo "- {$perm->name}\n";
}

echo "\n=== CHECKING ACCESS METHODS ===\n";
echo "isAdmin(): " . ($user->isAdmin() ? 'YES' : 'NO') . "\n";
echo "can('admin_access'): " . ($user->can('admin_access') ? 'YES' : 'NO') . "\n";
echo "canAccessPanel(): " . ($user->canAccessPanel() ? 'YES' : 'NO') . "\n";

// Check if superadmin role exists and has admin_access permission
echo "\n=== CHECKING SUPERADMIN ROLE ===\n";
$superadmin = Role::where('name', 'superadmin')->first();
if ($superadmin) {
    echo "✅ Superadmin role exists\n";
    echo "Permissions count: " . $superadmin->permissions->count() . "\n";
    $hasAdminAccess = $superadmin->hasPermissionTo('admin_access');
    echo "Has admin_access permission: " . ($hasAdminAccess ? 'YES' : 'NO') . "\n";
    
    if (!$hasAdminAccess) {
        echo "🔧 Fixing: Adding admin_access permission to superadmin...\n";
        $adminAccessPerm = Permission::where('name', 'admin_access')->first();
        if ($adminAccessPerm) {
            $superadmin->givePermissionTo($adminAccessPerm);
            echo "✅ admin_access permission added to superadmin role\n";
        }
    }
} else {
    echo "❌ Superadmin role not found!\n";
}

// Assign superadmin role to user if not assigned
if (!$user->hasRole('superadmin')) {
    echo "\n🔧 Fixing: Assigning superadmin role to user...\n";
    $user->assignRole('superadmin');
    echo "✅ Superadmin role assigned to user\n";
}

// Final check
echo "\n=== FINAL CHECK ===\n";
$user->refresh();
echo "Can access panel: " . ($user->canAccessPanel() ? 'YES' : 'NO') . "\n";
