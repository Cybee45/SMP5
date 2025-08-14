<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// Get the superadmin role
$role = Role::where('name', 'superadmin')->first();

// Give cms_manage permission to superadmin
$role->givePermissionTo('cms_manage');

echo "cms_manage permission given to superadmin role\n";
