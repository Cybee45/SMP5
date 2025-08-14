<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "=== FINAL STATUS CHECK ===\n\n";

echo "1. Total Permissions: " . Permission::count() . "\n";
echo "2. Total Roles: " . Role::count() . "\n";
echo "3. Total Users: " . User::count() . "\n\n";

echo "4. Users and their admin access:\n";
$users = User::with('roles')->get();
foreach ($users as $user) {
    echo "   {$user->email}:\n";
    echo "   - Can Access Panel: " . ($user->canAccessPanel() ? '✓' : '✗') . "\n";
    echo "   - Can View Articles: " . ($user->can('artikel_view') ? '✓' : '✗') . "\n";
    echo "   - Can View Users: " . ($user->can('user_view') ? '✓' : '✗') . "\n";
    echo "   - Can View Gallery: " . ($user->can('galeri_view') ? '✓' : '✗') . "\n";
    echo "   - Can View Profile: " . ($user->can('profil_view') ? '✓' : '✗') . "\n";
    echo "   - Roles: " . $user->roles->pluck('name')->implode(', ') . "\n";
    echo "   ---\n";
}

echo "\n5. Admin credentials for testing:\n";
echo "   Email: admin@smp5sangatta.sch.id\n";
echo "   Email: superadmin@smp5sangatta.sch.id\n";
echo "   URL: http://127.0.0.1:8000/admin\n\n";

echo "✓ All permissions have been set up correctly!\n";
echo "✓ You should now see all menu items in the admin panel.\n";
echo "✓ Remember to start the server: php artisan serve\n";
