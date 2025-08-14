<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "=== DEBUG ADMIN ACCESS ===\n\n";

// Check if users exist
echo "1. Users in database:\n";
$users = User::with('roles')->get();
if ($users->count() == 0) {
    echo "   No users found!\n";
} else {
    foreach ($users as $user) {
        echo "   ID: {$user->id}\n";
        echo "   Email: {$user->email}\n";
        echo "   Active: " . ($user->is_active ? 'Yes' : 'No') . "\n";
        echo "   Locked: " . ($user->isLocked() ? 'Yes' : 'No') . "\n";
        echo "   Roles: " . $user->roles->pluck('name')->implode(', ') . "\n";
        echo "   Can Access Panel: " . ($user->canAccessPanel() ? 'Yes' : 'No') . "\n";
        echo "   Has admin_access permission: " . ($user->can('admin_access') ? 'Yes' : 'No') . "\n";
        echo "   ---\n";
    }
}

echo "\n2. Roles in database:\n";
$roles = Role::all();
if ($roles->count() == 0) {
    echo "   No roles found!\n";
} else {
    foreach ($roles as $role) {
        echo "   - {$role->name}\n";
    }
}

echo "\n3. Permissions in database:\n";
$permissions = Permission::all();
if ($permissions->count() == 0) {
    echo "   No permissions found!\n";
} else {
    foreach ($permissions as $permission) {
        echo "   - {$permission->name}\n";
    }
}

echo "\n4. Check if admin_access permission exists:\n";
$adminAccess = Permission::where('name', 'admin_access')->first();
if ($adminAccess) {
    echo "   admin_access permission EXISTS\n";
} else {
    echo "   admin_access permission NOT FOUND!\n";
}

echo "\nDone.\n";
