<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "🔧 Creating cms_spmb permission...\n";

// Create cms_spmb permission
$permission = \Spatie\Permission\Models\Permission::firstOrCreate([
    'name' => 'cms_spmb',
    'guard_name' => 'web'
]);

echo "✅ Permission 'cms_spmb' created/found\n";

// Get admin user
$admin = \App\Models\User::where('email', 'admin@example.com')->first();

if (!$admin) {
    echo "❌ Admin user not found!\n";
    exit;
}

// Give permission to admin
if (!$admin->hasPermissionTo('cms_spmb')) {
    $admin->givePermissionTo('cms_spmb');
    echo "✅ Permission 'cms_spmb' granted to admin\n";
} else {
    echo "ℹ️ Admin already has 'cms_spmb' permission\n";
}

// Also give it to super_admin role if exists
$superAdminRole = \Spatie\Permission\Models\Role::where('name', 'super_admin')->first();
if ($superAdminRole && !$superAdminRole->hasPermissionTo('cms_spmb')) {
    $superAdminRole->givePermissionTo('cms_spmb');
    echo "✅ Permission 'cms_spmb' granted to super_admin role\n";
}

echo "\n🔍 Verifying permission:\n";
$hasPermission = $admin->fresh()->can('cms_spmb');
echo "Admin can access cms_spmb: " . ($hasPermission ? '✅ YES' : '❌ NO') . "\n";
