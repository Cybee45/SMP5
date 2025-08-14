<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "=== TESTING ACCESS ===\n";

$users = User::with('roles', 'permissions')->get();

foreach($users as $user) {
    echo "\n--- User: {$user->email} ---\n";
    echo "Active: " . ($user->is_active ? 'YES' : 'NO') . "\n";
    echo "Locked: " . ($user->isLocked() ? 'YES' : 'NO') . "\n";
    echo "Admin Access Permission: " . ($user->can('admin_access') ? 'YES' : 'NO') . "\n";
    echo "Can Access Panel (no param): " . ($user->canAccessPanel() ? 'YES' : 'NO') . "\n";
    
    // Test with panel parameter (simulated)
    try {
        $mockPanel = new \stdClass(); // Simple mock
        echo "Can Access Panel (with param): " . ($user->canAccessPanel($mockPanel) ? 'YES' : 'NO') . "\n";
    } catch(Exception $e) {
        echo "Panel test failed: " . $e->getMessage() . "\n";
    }
    
    echo "Roles: " . $user->roles->pluck('name')->join(', ') . "\n";
}
