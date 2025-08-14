<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;

echo "=== CHECKING SPMB MENU ===\n\n";

// Login as admin user
$user = User::where('email', 'admin@smp5sangatta.sch.id')->first();
Auth::login($user);

echo "Testing with user: {$user->email}\n\n";

// Check for SPMB resources
$spmhResources = [
    'SpmhContentResource',
    'SpmhHeroResource'
];

echo "1. Checking SPMB Resources:\n";
foreach ($spmhResources as $resource) {
    $fullClassName = "App\\Filament\\Resources\\{$resource}";
    
    echo "📁 {$resource}:\n";
    
    if (!class_exists($fullClassName)) {
        echo "   ❌ Class not found\n";
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
    
    // Test permissions
    try {
        $canView = $fullClassName::canViewAny();
        $canCreate = $fullClassName::canCreate();
        $shouldRegister = $fullClassName::shouldRegisterNavigation();
        
        echo "   canViewAny(): " . ($canView ? '✓' : '❌') . "\n";
        echo "   canCreate(): " . ($canCreate ? '✓' : '❌') . "\n";
        echo "   shouldRegisterNavigation(): " . ($shouldRegister ? '✓' : '❌') . "\n";
        
        $willShow = $canView && $shouldRegister;
        echo "   🎯 WILL SHOW IN MENU: " . ($willShow ? '✅ YES' : '❌ NO') . "\n";
        
    } catch (Exception $e) {
        echo "   ❌ Error: " . $e->getMessage() . "\n";
    }
    
    echo "   ---\n";
}

echo "\n2. Checking SPMB permissions:\n";
$spmhPermissions = [
    'spmhcontent_view',
    'spmhcontent_create',
    'spmhhero_view', 
    'spmhhero_create'
];

foreach ($spmhPermissions as $perm) {
    $has = $user->can($perm);
    echo "   {$perm}: " . ($has ? '✓' : '❌') . "\n";
}

echo "\n3. Checking if SPMB models exist:\n";
$spmhModels = [
    'App\\Models\\SpmhContent',
    'App\\Models\\SpmhHero'
];

foreach ($spmhModels as $model) {
    $exists = class_exists($model);
    echo "   {$model}: " . ($exists ? '✓' : '❌') . "\n";
}

echo "\n4. Looking for other SPMB-related files:\n";
$spmhFiles = glob('app/Models/Spmh*.php');
echo "   SPMB Model files found: " . count($spmhFiles) . "\n";
foreach ($spmhFiles as $file) {
    echo "   - " . basename($file) . "\n";
}

$spmhResourceFiles = glob('app/Filament/Resources/Spmh*.php');
echo "   SPMB Resource files found: " . count($spmhResourceFiles) . "\n";
foreach ($spmhResourceFiles as $file) {
    echo "   - " . basename($file) . "\n";
}

// Check if there are migrations for SPMB
$spmhMigrations = glob('database/migrations/*spmh*.php');
echo "   SPMB Migration files found: " . count($spmhMigrations) . "\n";
foreach ($spmhMigrations as $file) {
    echo "   - " . basename($file) . "\n";
}

echo "\nDone.\n";
