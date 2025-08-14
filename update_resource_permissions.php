<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== UPDATING RESOURCE PERMISSIONS ===\n\n";

// Define resource files and their permissions
$resourceUpdates = [
    'HeroResource.php' => [
        'permission_prefix' => 'hero',
        'navigation_group' => 'CMS - Home'
    ],
    'VisiMisiResource.php' => [
        'permission_prefix' => 'visi_misi',
        'navigation_group' => 'CMS - Home'
    ],
    'MediaGaleriResource.php' => [
        'permission_prefix' => 'galeri',
        'navigation_group' => 'CMS Media'
    ],
    'KeunggulanResource.php' => [
        'permission_prefix' => 'keunggulan',
        'navigation_group' => 'CMS Konten'
    ]
];

foreach ($resourceUpdates as $resourceFile => $config) {
    $filePath = "app/Filament/Resources/{$resourceFile}";
    
    if (file_exists($filePath)) {
        echo "✓ Found {$resourceFile}\n";
        
        $content = file_get_contents($filePath);
        
        // Check if it already has permission methods
        if (strpos($content, 'canViewAny()') === false) {
            echo "  - Adding permission methods\n";
            
            $prefix = $config['permission_prefix'];
            
            $permissionMethods = "
    public static function canViewAny(): bool
    {
        return Auth::user()?->can('{$prefix}_view');
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->can('{$prefix}_create');
    }

    public static function canEdit(\$record): bool
    {
        return Auth::user()?->can('{$prefix}_edit');
    }

    public static function canDelete(\$record): bool
    {
        return Auth::user()?->can('{$prefix}_delete');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->can('{$prefix}_view');
    }
";
            
            // Insert before public static function form
            $content = str_replace(
                'public static function form(Form $form): Form',
                $permissionMethods . "\n    public static function form(Form \$form): Form",
                $content
            );
            
            // Make sure Auth is imported
            if (strpos($content, 'use Illuminate\\Support\\Facades\\Auth;') === false) {
                $content = str_replace(
                    'use Illuminate\\Support\\Facades\\',
                    "use Illuminate\\Support\\Facades\\Auth;\nuse Illuminate\\Support\\Facades\\",
                    $content
                );
            }
            
            file_put_contents($filePath, $content);
            echo "  - Updated permissions\n";
        } else {
            echo "  - Already has permission methods\n";
        }
    } else {
        echo "✗ {$resourceFile} not found\n";
    }
}

echo "\nDone updating resource permissions!\n";
echo "Please clear cache and refresh admin panel.\n";
