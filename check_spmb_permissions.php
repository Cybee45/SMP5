<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Config;

// Bootstrap Laravel
$app = new Application(realpath(__DIR__));
$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);
$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);
$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

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

echo "\n🔍 Checking if resources can be accessed:\n\n";

// Test SpmhHeroResource
$canAccessHero = \App\Filament\Resources\SpmhHeroResource::canAccess();
$canViewHero = \App\Filament\Resources\SpmhHeroResource::canViewAny();

echo "SpmhHeroResource:\n";
echo "  canAccess(): " . ($canAccessHero ? '✅ YES' : '❌ NO') . "\n";
echo "  canViewAny(): " . ($canViewHero ? '✅ YES' : '❌ NO') . "\n";

// Test SpmhContentResource
$canAccessContent = \App\Filament\Resources\SpmhContentResource::canAccess();
$canViewContent = \App\Filament\Resources\SpmhContentResource::canViewAny();

echo "\nSpmhContentResource:\n";
echo "  canAccess(): " . ($canAccessContent ? '✅ YES' : '❌ NO') . "\n";
echo "  canViewAny(): " . ($canViewContent ? '✅ YES' : '❌ NO') . "\n";

echo "\n🔍 All permissions for admin:\n";
$allPermissions = $admin->getPermissionsViaRoles()->pluck('name')->toArray();
$spmb_permissions = array_filter($allPermissions, function($perm) {
    return strpos($perm, 'spmb') !== false || strpos($perm, 'spmh') !== false;
});

if (empty($spmb_permissions)) {
    echo "❌ No SPMB-related permissions found!\n";
} else {
    foreach ($spmb_permissions as $perm) {
        echo "  ✅ $perm\n";
    }
}
