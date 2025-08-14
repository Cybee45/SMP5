<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "=== CHECKING USER PERMISSIONS ===\n\n";

$user = User::where('email', 'admin@smp5sangatta.sch.id')->first();

echo "User: {$user->email}\n";
echo "Roles: " . $user->roles->pluck('name')->implode(', ') . "\n\n";

echo "Direct permissions:\n";
foreach ($user->getDirectPermissions() as $permission) {
    echo "  - {$permission->name}\n";
}

echo "\nPermissions via roles:\n";
foreach ($user->getPermissionsViaRoles() as $permission) {
    echo "  - {$permission->name}\n";
}

echo "\nAll permissions (total " . $user->getAllPermissions()->count() . "):\n";
$allPermissions = $user->getAllPermissions();
foreach ($allPermissions->take(20) as $permission) {
    echo "  - {$permission->name}\n";
}

if ($allPermissions->count() > 20) {
    echo "  ... and " . ($allPermissions->count() - 20) . " more\n";
}

echo "\nTesting specific permissions:\n";
$testPermissions = [
    'artikel_view',
    'galeri_view', 
    'hero_view',
    'profil_view',
    'user_view',
    'keunggulan_view'
];

foreach ($testPermissions as $perm) {
    $hasPermission = $user->can($perm);
    echo "  {$perm}: " . ($hasPermission ? '✓' : '❌') . "\n";
}

echo "\nDone.\n";
