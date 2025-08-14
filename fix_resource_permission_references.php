<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== FIXING RESOURCE PERMISSION REFERENCES ===\n\n";

// Define correct permission mapping
$resourcePermissionMap = [
    'KeunggulanResource' => 'keunggulan_view',
    'MediaGaleriResource' => 'mediagaleri_view', 
    'MediaVideoResource' => 'mediavideo_view',
    'PermissionResource' => 'permission_view',
    'PrestasiAboutResource' => 'prestasiabout_view',
    'RoleResource' => 'role_view',
    'SectionKeunggulanResource' => 'sectionkeunggulan_view',
    'StatistikResource' => 'statistik_view',
    'TimBirokrasiResource' => 'timbirokrasi_view',
    'VisiMisiResource' => 'visimisi_view',
];

foreach ($resourcePermissionMap as $resource => $permission) {
    $file = "app/Filament/Resources/{$resource}.php";
    
    if (!file_exists($file)) {
        echo "⚠️  File not found: {$file}\n";
        continue;
    }
    
    $content = file_get_contents($file);
    $originalContent = $content;
    
    echo "🔧 Fixing {$resource}...\n";
    
    // Fix canViewAny method
    $content = preg_replace(
        '/public static function canViewAny\(\): bool\s*\{[^}]+\}/',
        "public static function canViewAny(): bool
    {
        return Auth::user()?->can('{$permission}') ?? false;
    }",
        $content
    );
    
    // Fix shouldRegisterNavigation method  
    $content = preg_replace(
        '/public static function shouldRegisterNavigation\(\): bool\s*\{[^}]+\}/',
        "public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->can('{$permission}') ?? false;
    }",
        $content
    );
    
    // Add missing canCreate, canEdit, canDelete methods if not present
    $permissionBase = str_replace('_view', '', $permission);
    
    if (!strpos($content, 'public static function canCreate()')) {
        $newMethods = "
    public static function canCreate(): bool
    {
        return Auth::user()?->can('{$permissionBase}_create') ?? false;
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
        
        // Insert before last closing brace
        $lastBrace = strrpos($content, '}');
        $content = substr_replace($content, $newMethods, $lastBrace, 0);
    }
    
    if ($content !== $originalContent) {
        file_put_contents($file, $content);
        echo "   ✓ Updated permission references\n";
    } else {
        echo "   - No changes needed\n";
    }
}

echo "\nDone fixing resource permission references!\n";
echo "Now testing if permissions exist...\n\n";

// Check if all required permissions exist
use Spatie\Permission\Models\Permission;

$missingPermissions = [];
foreach ($resourcePermissionMap as $resource => $permission) {
    if (!Permission::where('name', $permission)->exists()) {
        $missingPermissions[] = $permission;
    }
    
    $permissionBase = str_replace('_view', '', $permission);
    $actions = ['create', 'edit', 'delete'];
    
    foreach ($actions as $action) {
        $permName = "{$permissionBase}_{$action}";
        if (!Permission::where('name', $permName)->exists()) {
            $missingPermissions[] = $permName;
        }
    }
}

if (!empty($missingPermissions)) {
    echo "Creating missing permissions:\n";
    foreach ($missingPermissions as $perm) {
        Permission::firstOrCreate(['name' => $perm]);
        echo "   ✓ Created: {$perm}\n";
    }
    
    // Assign to superadmin role
    $superadminRole = \Spatie\Permission\Models\Role::where('name', 'superadmin')->first();
    if ($superadminRole) {
        $superadminRole->syncPermissions(Permission::all());
        echo "   ✓ Assigned all permissions to superadmin\n";
    }
    
    // Assign content permissions to admin role  
    $adminRole = \Spatie\Permission\Models\Role::where('name', 'admin')->first();
    if ($adminRole) {
        $adminPermissions = Permission::where('name', 'not like', 'role_%')
            ->where('name', 'not like', 'permission_%')
            ->pluck('name')
            ->toArray();
        
        $adminPermissions[] = 'admin_access';
        $adminPermissions[] = 'cms_manage';
        $adminPermissions[] = 'dashboard_access';
        $adminPermissions[] = 'user_view';
        
        $adminRole->syncPermissions($adminPermissions);
        echo "   ✓ Updated admin permissions\n";
    }
} else {
    echo "All permissions already exist!\n";
}

echo "\nDone!\n";
