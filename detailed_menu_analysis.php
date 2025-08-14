<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;

echo "=== DETAILED MENU ANALYSIS ===\n\n";

// Login sebagai user untuk testing
$user = User::where('email', 'admin@smp5sangatta.sch.id')->first();
Auth::login($user);

echo "1. Testing with authenticated user: {$user->email}\n";
echo "   Roles: " . $user->roles->pluck('name')->implode(', ') . "\n\n";

// Find all resource files
$resourceFiles = glob('app/Filament/Resources/*Resource.php');
echo "2. Found " . count($resourceFiles) . " resource files:\n\n";

$menuGroups = [];

foreach ($resourceFiles as $file) {
    $className = basename($file, '.php');
    $fullClassName = "App\\Filament\\Resources\\{$className}";
    
    echo "📁 {$className}:\n";
    
    try {
        if (!class_exists($fullClassName)) {
            echo "   ❌ Class not found or autoload issue\n";
            echo "   File exists but class may be broken\n";
            continue;
        }
        
        $reflection = new ReflectionClass($fullClassName);
        
        // Get navigation properties
        $navGroup = null;
        $navLabel = null;
        $navSort = null;
        
        if ($reflection->hasProperty('navigationGroup')) {
            $navGroup = $reflection->getStaticPropertyValue('navigationGroup');
        }
        
        if ($reflection->hasProperty('navigationLabel')) {
            $navLabel = $reflection->getStaticPropertyValue('navigationLabel');
        }
        
        if ($reflection->hasProperty('navigationSort')) {
            $navSort = $reflection->getStaticPropertyValue('navigationSort');
        }
        
        echo "   Group: " . ($navGroup ?: 'None') . "\n";
        echo "   Label: " . ($navLabel ?: 'Default') . "\n";
        echo "   Sort: " . ($navSort ?: 'Default') . "\n";
        
        // Check permission methods
        $hasCanViewAny = $reflection->hasMethod('canViewAny');
        $hasShouldRegister = $reflection->hasMethod('shouldRegisterNavigation');
        
        echo "   Has canViewAny(): " . ($hasCanViewAny ? '✓' : '❌') . "\n";
        echo "   Has shouldRegisterNavigation(): " . ($hasShouldRegister ? '✓' : '❌') . "\n";
        
        // Test actual permission checks
        $canView = false;
        $shouldRegister = true;
        
        if ($hasCanViewAny) {
            try {
                $canView = $fullClassName::canViewAny();
                echo "   canViewAny() result: " . ($canView ? '✓' : '❌') . "\n";
            } catch (Exception $e) {
                echo "   canViewAny() ERROR: " . $e->getMessage() . "\n";
            }
        }
        
        if ($hasShouldRegister) {
            try {
                $shouldRegister = $fullClassName::shouldRegisterNavigation();
                echo "   shouldRegisterNavigation() result: " . ($shouldRegister ? '✓' : '❌') . "\n";
            } catch (Exception $e) {
                echo "   shouldRegisterNavigation() ERROR: " . $e->getMessage() . "\n";
            }
        }
        
        // Final determination
        $willShowInMenu = $canView && $shouldRegister;
        echo "   🎯 WILL SHOW IN MENU: " . ($willShowInMenu ? '✅ YES' : '❌ NO') . "\n";
        
        if ($willShowInMenu && $navGroup) {
            if (!isset($menuGroups[$navGroup])) {
                $menuGroups[$navGroup] = [];
            }
            $menuGroups[$navGroup][] = $navLabel ?: $className;
        }
        
    } catch (Exception $e) {
        echo "   ❌ Error analyzing: " . $e->getMessage() . "\n";
    }
    
    echo "   ---\n";
}

echo "\n3. EXPECTED MENU STRUCTURE:\n";
foreach ($menuGroups as $group => $items) {
    echo "   📂 {$group}:\n";
    foreach ($items as $item) {
        echo "      • {$item}\n";
    }
    echo "\n";
}

echo "4. TOTAL MENU ITEMS THAT SHOULD APPEAR: " . array_sum(array_map('count', $menuGroups)) . "\n\n";

echo "5. RECOMMENDATIONS:\n";
if (count($menuGroups) < 5) {
    echo "   ⚠️  Too few menu groups detected\n";
    echo "   ⚠️  Expected: CMS Konten, CMS - Home, CMS About, CMS Media, Manajemen Sistem\n";
}

if (array_sum(array_map('count', $menuGroups)) < 10) {
    echo "   ⚠️  Too few menu items detected\n";
    echo "   ⚠️  Expected at least 10-15 menu items\n";
}

echo "\nDone.\n";
