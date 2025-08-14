<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Permission;

echo "=== DETAILED MENU CHECK ===\n\n";

// Get current user for testing
$user = User::where('email', 'admin@smp5sangatta.sch.id')->first();
if (!$user) {
    echo "User not found!\n";
    exit;
}

echo "Testing with user: {$user->email}\n";
echo "User roles: " . $user->roles->pluck('name')->implode(', ') . "\n\n";

// Find all Filament Resources
$resourceFiles = glob('app/Filament/Resources/*Resource.php');

echo "Found " . count($resourceFiles) . " resource files:\n\n";

foreach ($resourceFiles as $file) {
    $className = basename($file, '.php');
    $fullClassName = "App\\Filament\\Resources\\{$className}";
    
    echo "📁 {$className}:\n";
    
    try {
        if (!class_exists($fullClassName)) {
            echo "   ❌ Class not found\n";
            continue;
        }
        
        $reflection = new ReflectionClass($fullClassName);
        
        // Check if it has navigation properties
        if ($reflection->hasProperty('navigationGroup')) {
            $navGroup = $reflection->getStaticPropertyValue('navigationGroup');
            echo "   Group: {$navGroup}\n";
        }
        
        if ($reflection->hasProperty('navigationLabel')) {
            $navLabel = $reflection->getStaticPropertyValue('navigationLabel');
            echo "   Label: {$navLabel}\n";
        }
        
        // Check permission methods
        $hasCanViewAny = $reflection->hasMethod('canViewAny');
        $hasShouldRegister = $reflection->hasMethod('shouldRegisterNavigation');
        
        echo "   Has canViewAny(): " . ($hasCanViewAny ? '✓' : '❌') . "\n";
        echo "   Has shouldRegisterNavigation(): " . ($hasShouldRegister ? '✓' : '❌') . "\n";
        
        // Test if user can access
        if ($hasCanViewAny) {
            $canView = $fullClassName::canViewAny();
            echo "   User can view: " . ($canView ? '✓' : '❌') . "\n";
        }
        
        if ($hasShouldRegister) {
            $shouldRegister = $fullClassName::shouldRegisterNavigation();
            echo "   Should show in nav: " . ($shouldRegister ? '✓' : '❌') . "\n";
        }
        
    } catch (Exception $e) {
        echo "   ❌ Error: " . $e->getMessage() . "\n";
    }
    
    echo "   ---\n";
}

echo "\nDone.\n";
