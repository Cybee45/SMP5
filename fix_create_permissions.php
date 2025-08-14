<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

echo "=== FIXING MISSING CREATE PERMISSIONS ===\n\n";

// Resource yang membutuhkan CREATE permission
$resourcesNeedingCreate = [
    'AboutHeroResource' => 'heroabout_create',
    'HeroResource' => 'hero_create',
    'KeunggulanResource' => 'keunggulan_create',
    'MediaGaleriResource' => 'mediagaleri_create',
    'MediaVideoResource' => 'mediavideo_create',
    'PermissionResource' => 'permission_create',
    'PrestasiAboutResource' => 'prestasiabout_create',
    'RoleResource' => 'role_create',
    'SectionKeunggulanResource' => 'sectionkeunggulan_create',
    'StatistikResource' => 'statistik_create',
    'TimBirokrasiResource' => 'timbirokrasi_create',
    'VisiMisiResource' => 'visimisi_create',
];

echo "1. Checking and creating missing permissions...\n";
foreach ($resourcesNeedingCreate as $resource => $permission) {
    $perm = Permission::firstOrCreate(['name' => $permission]);
    if ($perm->wasRecentlyCreated) {
        echo "   ✓ Created permission: {$permission}\n";
    } else {
        echo "   - Permission already exists: {$permission}\n";
    }
}

echo "\n2. Updating role permissions...\n";

// Update superadmin role
$superadminRole = Role::where('name', 'superadmin')->first();
if ($superadminRole) {
    $superadminRole->syncPermissions(Permission::all());
    echo "   ✓ Superadmin has all " . Permission::count() . " permissions\n";
}

// Update admin role - give content creation permissions but not system management
$adminRole = Role::where('name', 'admin')->first();
if ($adminRole) {
    $adminPermissions = Permission::where('name', 'not like', 'role_%')
        ->where('name', 'not like', 'permission_%')
        ->where('name', 'not like', 'user_create')
        ->where('name', 'not like', 'user_edit')
        ->where('name', 'not like', 'user_delete')
        ->pluck('name')
        ->toArray();
    
    // Add basic admin permissions
    $adminPermissions[] = 'admin_access';
    $adminPermissions[] = 'cms_manage';
    $adminPermissions[] = 'dashboard_access';
    $adminPermissions[] = 'user_view';  // Can view users but not manage
    
    $adminRole->syncPermissions($adminPermissions);
    echo "   ✓ Admin has " . count($adminPermissions) . " content management permissions\n";
}

echo "\n3. Checking specific user permissions...\n";
$user = User::where('email', 'admin@smp5sangatta.sch.id')->first();
echo "   User: {$user->email}\n";
echo "   Roles: " . $user->roles->pluck('name')->implode(', ') . "\n";
echo "   Total permissions: " . $user->getAllPermissions()->count() . "\n";

echo "\n4. Testing some CREATE permissions:\n";
$testCreatePermissions = [
    'hero_create',
    'keunggulan_create', 
    'mediagaleri_create',
    'statistik_create'
];

foreach ($testCreatePermissions as $perm) {
    $has = $user->can($perm);
    echo "   {$perm}: " . ($has ? '✓' : '❌') . "\n";
}

echo "\n5. Fixing resources that don't have canCreate() methods...\n";

foreach ($resourcesNeedingCreate as $resource => $permission) {
    $file = "app/Filament/Resources/{$resource}.php";
    
    if (!file_exists($file)) {
        echo "   ⚠️  File not found: {$file}\n";
        continue;
    }
    
    $content = file_get_contents($file);
    
    // Check if canCreate method exists
    if (!strpos($content, 'function canCreate()')) {
        echo "   🔧 Adding canCreate() method to {$resource}...\n";
        
        $permissionBase = str_replace('_create', '', $permission);
        
        $newMethods = "
    public static function canCreate(): bool
    {
        return Auth::user()?->can('{$permission}') ?? false;
    }

    public static function canEdit(\$record): bool
    {
        return Auth::user()?->can('{$permissionBase}_edit') ?? false;
    }

    public static function canDelete(\$record): bool
    {
        return Auth::user()?->can('{$permissionBase}_delete') ?? false;
    }
";
        
        // Insert before the form() method or before last closing brace
        $insertPoint = strpos($content, 'public static function form(');
        if ($insertPoint === false) {
            $insertPoint = strrpos($content, '}');
        }
        
        $content = substr_replace($content, $newMethods, $insertPoint, 0);
        
        // Make sure Auth is imported
        if (!strpos($content, 'use Illuminate\\Support\\Facades\\Auth;')) {
            $content = str_replace(
                'use Illuminate\\Support\\Facades\\',
                "use Illuminate\\Support\\Facades\\Auth;\nuse Illuminate\\Support\\Facades\\",
                $content
            );
        }
        
        file_put_contents($file, $content);
        echo "   ✓ Added CRUD methods to {$resource}\n";
    } else {
        echo "   - {$resource} already has canCreate() method\n";
    }
}

echo "\nDone! All resources should now have CREATE permissions.\n";
echo "Please refresh your admin panel to see the Create buttons.\n";
