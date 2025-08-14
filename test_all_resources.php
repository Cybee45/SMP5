<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;

echo "=== TESTING ALL RESOURCES AFTER UPDATE ===\n\n";

// Login as admin user
$user = User::where('email', 'admin@smp5sangatta.sch.id')->first();
Auth::login($user);

echo "Testing with user: {$user->email}\n\n";

// All resources that should be registered
$allResources = [
    // Home/Beranda Resources
    'HeroResource' => 'CMS Beranda',
    'KeunggulanResource' => 'CMS Beranda', 
    'StatistikResource' => 'CMS Beranda',
    'SectionKeunggulanResource' => 'CMS Beranda',
    
    // About/Profil Resources
    'ProfilResource' => 'CMS Profil',
    'AboutHeroResource' => 'CMS Profil',
    'PrestasiAboutResource' => 'CMS Profil',
    'TimBirokrasiResource' => 'CMS Profil',
    'VisiMisiResource' => 'CMS Profil',
    
    // SPMB Resources
    'SpmhHeroResource' => 'CMS SPMB',
    'SpmhContentResource' => 'CMS SPMB',
    
    // Artikel Resources
    'ArtikelResource' => 'CMS Artikel',
    
    // Media/Galeri Resources
    'GaleriResource' => 'CMS Media',
    'MediaGaleriResource' => 'CMS Media',
    'MediaHeroResource' => 'CMS Media',
    'MediaVideoResource' => 'CMS Media',
    
    // System Resources
    'UserResource' => 'System',
    'RoleResource' => 'System',
    'PermissionResource' => 'System',
    'ProfileSettingsResource' => 'System',
];

$totalResources = count($allResources);
$workingResources = 0;
$notWorkingResources = [];

echo "Testing {$totalResources} resources:\n\n";

foreach ($allResources as $resource => $expectedGroup) {
    $fullClassName = "App\\Filament\\Resources\\{$resource}";
    
    echo "📁 {$resource} ({$expectedGroup}):\n";
    
    if (!class_exists($fullClassName)) {
        echo "   ❌ Class not found\n";
        $notWorkingResources[] = $resource . " (Class not found)";
        continue;
    }
    
    try {
        $canView = $fullClassName::canViewAny();
        $shouldRegister = $fullClassName::shouldRegisterNavigation();
        
        $willShow = $canView && $shouldRegister;
        
        if ($willShow) {
            echo "   ✅ WORKING - Will show in menu\n";
            $workingResources++;
        } else {
            echo "   ❌ NOT WORKING - canViewAny: " . ($canView ? '✓' : '❌') . 
                 ", shouldRegister: " . ($shouldRegister ? '✓' : '❌') . "\n";
            $notWorkingResources[] = $resource . " (Permission issue)";
        }
        
    } catch (Exception $e) {
        echo "   ❌ ERROR: " . $e->getMessage() . "\n";
        $notWorkingResources[] = $resource . " (Error: " . $e->getMessage() . ")";
    }
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "SUMMARY:\n";
echo "✅ Working Resources: {$workingResources}/{$totalResources}\n";

if (!empty($notWorkingResources)) {
    echo "❌ Not Working Resources:\n";
    foreach ($notWorkingResources as $broken) {
        echo "   - {$broken}\n";
    }
} else {
    echo "🎉 ALL RESOURCES ARE WORKING!\n";
}

echo "\nNote: Refresh your admin panel to see all menus!\n";
