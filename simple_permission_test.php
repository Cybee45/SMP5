<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;

$user = User::where('email', 'admin@smp5sangatta.sch.id')->first();
Auth::login($user);

echo "Testing permissions for user: {$user->email}\n\n";

$testPermissions = [
    'keunggulan_create',
    'mediagaleri_create', 
    'hero_create',
    'statistik_create'
];

foreach ($testPermissions as $perm) {
    $has = $user->can($perm);
    echo "{$perm}: " . ($has ? 'YES' : 'NO') . "\n";
}

echo "\nTesting resource methods directly:\n";

try {
    $result = \App\Filament\Resources\KeunggulanResource::canCreate();
    echo "KeunggulanResource::canCreate(): " . ($result ? 'YES' : 'NO') . "\n";
} catch (Exception $e) {
    echo "KeunggulanResource::canCreate(): ERROR - " . $e->getMessage() . "\n";
}

try {
    $result = \App\Filament\Resources\HeroResource::canCreate();
    echo "HeroResource::canCreate(): " . ($result ? 'YES' : 'NO') . "\n";
} catch (Exception $e) {
    echo "HeroResource::canCreate(): ERROR - " . $e->getMessage() . "\n";
}
