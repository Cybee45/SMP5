<?php

// Simple check tanpa bootstrap penuh
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Get admin user
$admin = \App\Models\User::where('email', 'admin@example.com')->first();

if (!$admin) {
    echo "❌ Admin user not found!\n";
    exit;
}

echo "🔍 Checking SPMB permissions for admin user:\n\n";

// Check main SPMB permission
$permissions_to_check = [
    'cms_spmb',
    'spmhhero_view',
    'spmhhero_create', 
    'spmhhero_edit',
    'spmhhero_delete',
    'spmhcontent_view',
    'spmhcontent_create',
    'spmhcontent_edit', 
    'spmhcontent_delete'
];

foreach ($permissions_to_check as $permission) {
    $hasPermission = $admin->can($permission);
    echo sprintf("%-20s: %s\n", $permission, $hasPermission ? '✅ YES' : '❌ NO');
}

// Check all permissions yang ada
echo "\n🔍 All SPMB-related permissions in database:\n";
$allPermissions = \Spatie\Permission\Models\Permission::where('name', 'like', '%spmb%')
    ->orWhere('name', 'like', '%spmh%')
    ->get();

foreach ($allPermissions as $perm) {
    echo "  📋 {$perm->name}\n";
}

if ($allPermissions->isEmpty()) {
    echo "❌ No SPMB permissions found in database!\n";
}
