<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "=== FIXING ADMIN ACCESS ===\n\n";

// Create admin_access permission if it doesn't exist
echo "1. Creating admin_access permission...\n";
$adminAccess = Permission::firstOrCreate(['name' => 'admin_access']);
echo "   admin_access permission created/found: {$adminAccess->id}\n";

// Assign admin_access permission to admin and superadmin roles
echo "\n2. Assigning admin_access to admin and superadmin roles...\n";
$adminRole = Role::where('name', 'admin')->first();
$superadminRole = Role::where('name', 'superadmin')->first();

if ($adminRole) {
    $adminRole->givePermissionTo('admin_access');
    echo "   admin_access assigned to admin role\n";
}

if ($superadminRole) {
    $superadminRole->givePermissionTo('admin_access');
    echo "   admin_access assigned to superadmin role\n";
}

// Test users again
echo "\n3. Testing users access after fix:\n";
$users = User::with('roles')->get();
foreach ($users as $user) {
    echo "   User: {$user->email}\n";
    echo "   Can Access Panel: " . ($user->canAccessPanel() ? 'Yes' : 'No') . "\n";
    echo "   Has admin_access permission: " . ($user->can('admin_access') ? 'Yes' : 'No') . "\n";
    echo "   ---\n";
}

echo "\nDone. Admin access should now work!\n";
