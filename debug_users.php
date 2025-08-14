<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "=== DEBUG USER ACCESS ISSUE ===\n\n";

// 1. Check all users
echo "1. ALL USERS:\n";
$users = User::with('roles')->get();
foreach($users as $user) {
    echo "   Email: {$user->email}\n";
    echo "   Active: " . ($user->is_active ? 'Yes' : 'No') . "\n";
    echo "   Roles: " . $user->roles->pluck('name')->implode(', ') . "\n";
    echo "   Has admin_access: " . ($user->can('admin_access') ? 'Yes' : 'No') . "\n";
    echo "   Is Admin: " . ($user->isAdmin() ? 'Yes' : 'No') . "\n";
    echo "   Is Locked: " . ($user->isLocked() ? 'Yes' : 'No') . "\n";
    echo "   ---\n";
}

// 2. Check roles and permissions
echo "\n2. ROLE PERMISSIONS:\n";
$roles = Role::with('permissions')->get();
foreach($roles as $role) {
    echo "   Role: {$role->name}\n";
    echo "   Permissions: " . $role->permissions->pluck('name')->implode(', ') . "\n";
    echo "   ---\n";
}

// 3. Check permissions
echo "\n3. ALL PERMISSIONS:\n";
$permissions = Permission::all();
foreach($permissions as $perm) {
    echo "   - {$perm->name}\n";
}

echo "\n=== DEBUG COMPLETE ===\n";
