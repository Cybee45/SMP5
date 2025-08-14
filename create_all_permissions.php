<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "=== CREATING MISSING PERMISSIONS ===\n\n";

// Define all needed permissions
$permissionsToCreate = [
    // Content management - Artikel
    'artikel_view' => 'View artikel',
    'artikel_create' => 'Create artikel', 
    'artikel_edit' => 'Edit artikel',
    'artikel_delete' => 'Delete artikel',
    
    // Content management - Galeri/Media
    'galeri_view' => 'View galeri',
    'galeri_create' => 'Create galeri',
    'galeri_edit' => 'Edit galeri', 
    'galeri_delete' => 'Delete galeri',
    
    // Content management - Hero Section
    'hero_view' => 'View hero section',
    'hero_create' => 'Create hero section',
    'hero_edit' => 'Edit hero section',
    'hero_delete' => 'Delete hero section',
    
    // Content management - Profil Sekolah
    'profil_view' => 'View profil sekolah',
    'profil_create' => 'Create profil sekolah', 
    'profil_edit' => 'Edit profil sekolah',
    'profil_delete' => 'Delete profil sekolah',
    
    // User management
    'user_view' => 'View users',
    'user_create' => 'Create users',
    'user_edit' => 'Edit users', 
    'user_delete' => 'Delete users',
    
    // Role & Permission management
    'role_view' => 'View roles',
    'role_create' => 'Create roles',
    'role_edit' => 'Edit roles',
    'role_delete' => 'Delete roles',
    
    'permission_view' => 'View permissions',
    'permission_create' => 'Create permissions',
    'permission_edit' => 'Edit permissions',
    'permission_delete' => 'Delete permissions',
    
    // Additional content permissions
    'visi_misi_view' => 'View visi misi',
    'visi_misi_edit' => 'Edit visi misi',
    
    'keunggulan_view' => 'View keunggulan',
    'keunggulan_create' => 'Create keunggulan',
    'keunggulan_edit' => 'Edit keunggulan',
    'keunggulan_delete' => 'Delete keunggulan',
    
    'prestasi_view' => 'View prestasi',
    'prestasi_create' => 'Create prestasi',
    'prestasi_edit' => 'Edit prestasi',
    'prestasi_delete' => 'Delete prestasi',
];

echo "1. Creating permissions...\n";
foreach ($permissionsToCreate as $name => $description) {
    $permission = Permission::firstOrCreate(['name' => $name]);
    echo "   ✓ {$name}\n";
}

echo "\n2. Assigning permissions to roles...\n";

// Get roles
$superadminRole = Role::where('name', 'superadmin')->first();
$adminRole = Role::where('name', 'admin')->first();

if ($superadminRole) {
    echo "   Assigning all permissions to superadmin role...\n";
    $superadminRole->syncPermissions(Permission::all());
    echo "   ✓ Superadmin now has all permissions\n";
}

if ($adminRole) {
    echo "   Assigning content permissions to admin role...\n";
    $adminPermissions = [
        'admin_access',
        'cms_manage', 
        'dashboard_access',
        'artikel_view', 'artikel_create', 'artikel_edit', 'artikel_delete',
        'galeri_view', 'galeri_create', 'galeri_edit', 'galeri_delete',
        'hero_view', 'hero_create', 'hero_edit', 'hero_delete',
        'profil_view', 'profil_create', 'profil_edit', 'profil_delete',
        'visi_misi_view', 'visi_misi_edit',
        'keunggulan_view', 'keunggulan_create', 'keunggulan_edit', 'keunggulan_delete',
        'prestasi_view', 'prestasi_create', 'prestasi_edit', 'prestasi_delete',
        'user_view', // Can view users but not create/edit/delete
    ];
    
    $adminRole->syncPermissions($adminPermissions);
    echo "   ✓ Admin now has content management permissions\n";
}

echo "\n3. Verifying user access...\n";
$users = User::with('roles')->get();
foreach ($users as $user) {
    echo "   User: {$user->email}\n";
    echo "   Can Access Panel: " . ($user->canAccessPanel() ? 'Yes' : 'No') . "\n";
    echo "   Can Manage CMS: " . ($user->can('cms_manage') ? 'Yes' : 'No') . "\n";
    echo "   Can Manage System: " . ($user->can('system_manage') ? 'Yes' : 'No') . "\n";
    echo "   Can View Articles: " . ($user->can('artikel_view') ? 'Yes' : 'No') . "\n";
    echo "   ---\n";
}

echo "\nDone! All permissions have been created and assigned.\n";
echo "Please refresh your admin panel to see all menus.\n";
