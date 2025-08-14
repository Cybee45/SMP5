<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== FIXING RESOURCE PERMISSION METHODS ===\n\n";

// Find all Filament Resources
$resourceFiles = glob('app/Filament/Resources/*Resource.php');

foreach ($resourceFiles as $file) {
    $content = file_get_contents($file);
    $hasChanges = false;
    
    // Fix nullable return values
    $patterns = [
        '/return Auth::user\(\)\?\->can\(([^)]+)\);/' => 'return Auth::user()?->can($1) ?? false;',
        '/return Auth::user\(\)\?\->hasRole\(([^)]+)\);/' => 'return Auth::user()?->hasRole($1) ?? false;',
        '/return Auth::user\(\)\?\->canAccessPanel\(\);/' => 'return Auth::user()?->canAccessPanel() ?? false;',
    ];
    
    foreach ($patterns as $pattern => $replacement) {
        if (preg_match($pattern, $content)) {
            $content = preg_replace($pattern, $replacement, $content);
            $hasChanges = true;
        }
    }
    
    // Add missing permission methods for resources that don't have them
    if (!strpos($content, 'canViewAny()')) {
        $className = basename($file, '.php');
        $permissionBase = strtolower(str_replace('Resource', '', $className));
        
        // Insert before the form() method or at end of class
        $insertPoint = strpos($content, 'public static function form(');
        if ($insertPoint === false) {
            $insertPoint = strrpos($content, '}');
        }
        
        $permissionMethods = "
    public static function canViewAny(): bool
    {
        return Auth::user()?->can('{$permissionBase}_view') ?? false;
    }

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
        
        $content = substr_replace($content, $permissionMethods, $insertPoint, 0);
        $hasChanges = true;
    }
    
    // Make sure Auth is imported
    if (!strpos($content, 'use Illuminate\\Support\\Facades\\Auth;')) {
        $content = str_replace(
            'use Illuminate\\Support\\Facades\\',
            "use Illuminate\\Support\\Facades\\Auth;\nuse Illuminate\\Support\\Facades\\",
            $content
        );
        $hasChanges = true;
    }
    
    if ($hasChanges) {
        file_put_contents($file, $content);
        echo "✓ Updated " . basename($file) . "\n";
    }
}

echo "\nDone fixing resource permission methods!\n";
