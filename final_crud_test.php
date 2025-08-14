<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;

echo "=== FINAL CRUD TEST ===\n\n";

// Login as admin user
$user = User::where('email', 'admin@smp5sangatta.sch.id')->first();
Auth::login($user);

echo "Testing with user: {$user->email}\n\n";

// Test specific resources that were showing issues
$problematicResources = [
    'HeroResource',
    'KeunggulanResource', 
    'MediaGaleriResource',
    'StatistikResource'
];

foreach ($problematicResources as $resourceName) {
    $fullClassName = "App\\Filament\\Resources\\{$resourceName}";
    
    echo "🔍 Testing {$resourceName}:\n";
    
    try {
        if (!class_exists($fullClassName)) {
            echo "   ❌ Class not found\n";
            continue;
        }
        
        // Test each CRUD operation directly
        $canView = $fullClassName::canViewAny();
        $canCreate = $fullClassName::canCreate();
        
        echo "   canViewAny(): " . ($canView ? '✓' : '❌') . "\n";
        echo "   canCreate(): " . ($canCreate ? '✓' : '❌') . "\n";
        
        // Also test the underlying permissions directly
        $resourceLower = strtolower(str_replace('Resource', '', $resourceName));
        $viewPerm = "{$resourceLower}_view";
        $createPerm = "{$resourceLower}_create";
        
        // Special handling for some resources
        if ($resourceName === 'MediaGaleriResource') {
            $viewPerm = 'mediagaleri_view';
            $createPerm = 'mediagaleri_create';
        }
        
        $hasViewPerm = $user->can($viewPerm);
        $hasCreatePerm = $user->can($createPerm);
        
        echo "   User has {$viewPerm}: " . ($hasViewPerm ? '✓' : '❌') . "\n";
        echo "   User has {$createPerm}: " . ($hasCreatePerm ? '✓' : '❌') . "\n";
        
        // Check what the canCreate method is actually checking
        echo "   Method check result: ";
        if ($canCreate && $hasCreatePerm) {
            echo "✅ WORKING - Can create records\n";
        } elseif (!$canCreate && !$hasCreatePerm) {
            echo "❌ MISSING - No create permission\n";
        } elseif (!$canCreate && $hasCreatePerm) {
            echo "🔧 METHOD ISSUE - Has permission but method returns false\n";
        } else {
            echo "⚠️  INCONSISTENT - Method true but no permission\n";
        }
        
    } catch (Exception $e) {
        echo "   ❌ Error: " . $e->getMessage() . "\n";
    }
    
    echo "   ---\n";
}

echo "\n🎯 QUICK FIX TEST:\n";
echo "If any methods show 'METHOD ISSUE', we need to check the method implementations.\n\n";

// Check a working resource for comparison
echo "Checking working resource for comparison:\n";
try {
    $canView = \App\Filament\Resources\ArtikelResource::canViewAny();
    $canCreate = \App\Filament\Resources\ArtikelResource::canCreate();
    echo "ArtikelResource - View: " . ($canView ? '✓' : '❌') . " Create: " . ($canCreate ? '✓' : '❌') . "\n";
} catch (Exception $e) {
    echo "ArtikelResource error: " . $e->getMessage() . "\n";
}

echo "\nDone.\n";
