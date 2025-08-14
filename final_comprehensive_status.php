<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Permission;

echo "=== FINAL COMPREHENSIVE STATUS ===\n\n";

$user = User::where('email', 'admin@smp5sangatta.sch.id')->first();

echo "1. System Status:\n";
echo "   - Total Permissions: " . Permission::count() . "\n";
echo "   - User Test: {$user->email}\n";
echo "   - User Roles: " . $user->roles->pluck('name')->implode(', ') . "\n";
echo "   - User Total Permissions: " . $user->getAllPermissions()->count() . "\n\n";

echo "2. Critical Permission Tests:\n";
$criticalPermissions = [
    'admin_access',
    'cms_manage',
    'artikel_view',
    'galeri_view',
    'hero_view',
    'profil_view',
    'user_view',
    'role_view',
    'permission_view'
];

foreach ($criticalPermissions as $perm) {
    $has = $user->can($perm);
    echo "   {$perm}: " . ($has ? '✓' : '❌') . "\n";
}

echo "\n3. Resource Status Summary:\n";

// Check key resources that should be visible
$keyResources = [
    'ArtikelResource' => 'artikel_view',
    'GaleriResource' => 'galeri_view', 
    'HeroResource' => 'hero_view',
    'ProfilResource' => 'profil_view',
    'UserResource' => 'user_view',
    'KeunggulanResource' => 'keunggulan_view',
    'VisiMisiResource' => 'visimisi_view',
    'MediaGaleriResource' => 'mediagaleri_view',
    'MediaVideoResource' => 'mediavideo_view',
];

foreach ($keyResources as $resource => $permission) {
    $hasPermission = $user->can($permission);
    echo "   {$resource}: " . ($hasPermission ? '✓' : '❌') . " (needs {$permission})\n";
}

echo "\n4. Navigation Groups that should appear:\n";
echo "   - CMS Konten (Artikel & Berita, Galeri Foto)\n";
echo "   - CMS - Home (Hero Section, Profil Sekolah, Keunggulan)\n";
echo "   - CMS About (Visi & Misi)\n";
echo "   - CMS Media (Galeri, Video)\n";
echo "   - Manajemen Sistem (Pengguna)\n\n";

echo "5. Login Instructions:\n";
echo "   1. Start server: php artisan serve\n";
echo "   2. Go to: http://127.0.0.1:8000/admin\n";
echo "   3. Login with: admin@smp5sangatta.sch.id\n";
echo "   4. You should see all the menu groups above\n\n";

echo "✅ Setup Complete!\n";
echo "If menus still don't appear, try:\n";
echo "   - Clear browser cache\n";
echo "   - Logout and login again\n";
echo "   - Check browser console for errors\n";

echo "\nDone.\n";
