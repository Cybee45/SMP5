<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "=== CREATING ALL MISSING PERMISSIONS ===\n\n";

// Define all resource permissions based on the files found
$resourcePermissions = [
    // Content Management
    'artikel' => ['view', 'create', 'edit', 'delete'],
    'galeri' => ['view', 'create', 'edit', 'delete'],
    'hero' => ['view', 'create', 'edit', 'delete'],
    'kategori' => ['view', 'create', 'edit', 'delete'],
    'keunggulan' => ['view', 'create', 'edit', 'delete'],
    'profil' => ['view', 'create', 'edit', 'delete'],
    'visimisi' => ['view', 'edit'],
    
    // About Section
    'heroabout' => ['view', 'create', 'edit', 'delete'],
    'prestasiabout' => ['view', 'create', 'edit', 'delete'],
    
    // Media Management
    'mediagaleri' => ['view', 'create', 'edit', 'delete'],
    'mediahero' => ['view', 'create', 'edit', 'delete'],
    'mediavideo' => ['view', 'create', 'edit', 'delete'],
    
    // System Management
    'user' => ['view', 'create', 'edit', 'delete'],
    'role' => ['view', 'create', 'edit', 'delete'],
    'permission' => ['view', 'create', 'edit', 'delete'],
    
    // Settings
    'profilesettings' => ['view', 'edit'],
    'statistik' => ['view', 'create', 'edit', 'delete'],
    'timbirokrasi' => ['view', 'create', 'edit', 'delete'],
    
    // Sections
    'sectionberita' => ['view', 'create', 'edit', 'delete'],
    'sectionkeunggulan' => ['view', 'create', 'edit', 'delete'],
    
    // SPMH (Sekolah Menengah)
    'spmhcontent' => ['view', 'create', 'edit', 'delete'],
    'spmhhero' => ['view', 'create', 'edit', 'delete'],
];

$createdCount = 0;

foreach ($resourcePermissions as $resource => $actions) {
    foreach ($actions as $action) {
        $permissionName = "{$resource}_{$action}";
        $permission = Permission::firstOrCreate(['name' => $permissionName]);
        if ($permission->wasRecentlyCreated) {
            $createdCount++;
            echo "✓ Created: {$permissionName}\n";
        }
    }
}

echo "\nCreated {$createdCount} new permissions.\n\n";

// Assign permissions to roles
echo "Assigning permissions to roles...\n";

$superadminRole = Role::where('name', 'superadmin')->first();
$adminRole = Role::where('name', 'admin')->first();

if ($superadminRole) {
    $superadminRole->syncPermissions(Permission::all());
    echo "✓ Superadmin has all permissions\n";
}

if ($adminRole) {
    // Admin gets content management permissions (not system management)
    $adminPermissions = Permission::where('name', 'not like', 'user_%')
        ->where('name', 'not like', 'role_%')
        ->where('name', 'not like', 'permission_%')
        ->pluck('name')
        ->toArray();
    
    // But add basic user view permission
    $adminPermissions[] = 'user_view';
    $adminPermissions[] = 'admin_access';
    $adminPermissions[] = 'cms_manage';
    $adminPermissions[] = 'dashboard_access';
    
    $adminRole->syncPermissions($adminPermissions);
    echo "✓ Admin has content management permissions\n";
}

echo "\nTotal permissions now: " . Permission::count() . "\n";
echo "Done!\n";
