<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== FIXING BROKEN CRUD METHODS ===\n\n";

// Resources that need fixing
$resourcesToFix = [
    'KeunggulanResource' => 'keunggulan',
    'MediaGaleriResource' => 'mediagaleri',
    'MediaVideoResource' => 'mediavideo',
    'StatistikResource' => 'statistik',
    'VisiMisiResource' => 'visimisi',
    'TimBirokrasiResource' => 'timbirokrasi',
    'PrestasiAboutResource' => 'prestasiabout',
    'SectionKeunggulanResource' => 'sectionkeunggulan',
];

foreach ($resourcesToFix as $resource => $permissionBase) {
    $file = "app/Filament/Resources/{$resource}.php";
    
    if (!file_exists($file)) {
        echo "⚠️  File not found: {$file}\n";
        continue;
    }
    
    $content = file_get_contents($file);
    $originalContent = $content;
    
    echo "🔧 Fixing {$resource}...\n";
    
    // Fix canCreate method
    $content = preg_replace(
        '/public static function canCreate\(\): bool\s*\{[^}]+\}/',
        "public static function canCreate(): bool
    {
        return Auth::user()?->can('{$permissionBase}_create') ?? false;
    }",
        $content
    );
    
    // Fix canEdit method
    $content = preg_replace(
        '/public static function canEdit\([^)]*\): bool\s*\{[^}]+\}/',
        "public static function canEdit(\$record): bool
    {
        return Auth::user()?->can('{$permissionBase}_edit') ?? false;
    }",
        $content
    );
    
    // Fix canDelete method
    $content = preg_replace(
        '/public static function canDelete\([^)]*\): bool\s*\{[^}]+\}/',
        "public static function canDelete(\$record): bool
    {
        return Auth::user()?->can('{$permissionBase}_delete') ?? false;
    }",
        $content
    );
    
    // Fix shouldRegisterNavigation method
    $content = preg_replace(
        '/public static function shouldRegisterNavigation\(\): bool\s*\{[^}]+\}/',
        "public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->can('{$permissionBase}_view') ?? false;
    }",
        $content
    );
    
    if ($content !== $originalContent) {
        file_put_contents($file, $content);
        echo "   ✓ Fixed CRUD methods\n";
    } else {
        echo "   - No changes needed\n";
    }
}

echo "\nDone fixing CRUD methods!\n";
echo "Now testing the fixes...\n\n";

// Test the fixed resources
use App\Models\User;
use Illuminate\Support\Facades\Auth;

$user = User::where('email', 'admin@smp5sangatta.sch.id')->first();
Auth::login($user);

foreach ($resourcesToFix as $resource => $permissionBase) {
    $fullClassName = "App\\Filament\\Resources\\{$resource}";
    
    if (!class_exists($fullClassName)) {
        echo "❌ {$resource}: Class not found\n";
        continue;
    }
    
    try {
        $canView = $fullClassName::canViewAny();
        $canCreate = $fullClassName::canCreate();
        
        echo "✅ {$resource}: View=" . ($canView ? '✓' : '❌') . " Create=" . ($canCreate ? '✓' : '❌') . "\n";
    } catch (Exception $e) {
        echo "❌ {$resource}: Error - " . $e->getMessage() . "\n";
    }
}

echo "\nAll CRUD methods should now work correctly!\n";
