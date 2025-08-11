<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class CleanRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting database cleanup...');
        
        // Get roles yang akan di-keep
        $keepRoles = ['superadmin', 'admin'];
        
        // Get all roles
        $allRoles = Role::all();
        
        $this->command->info('Current roles in database:');
        foreach ($allRoles as $role) {
            $this->command->info('- ' . $role->name . ' (Users: ' . $role->users->count() . ')');
        }
        
        // Find roles to delete
        $rolesToDelete = Role::whereNotIn('name', $keepRoles)->get();
        
        if ($rolesToDelete->count() > 0) {
            $this->command->info('');
            $this->command->info('Roles to be deleted:');
            foreach ($rolesToDelete as $role) {
                $this->command->info('- ' . $role->name);
                
                // Remove role from users first
                foreach ($role->users as $user) {
                    $user->removeRole($role);
                    $this->command->info('  > Removed role from user: ' . $user->email);
                }
                
                // Delete the role
                $role->delete();
                $this->command->info('  > Role deleted: ' . $role->name);
            }
        } else {
            $this->command->info('No roles to delete. Only keeping: ' . implode(', ', $keepRoles));
        }
        
        $this->command->info('');
        $this->command->info('=== CLEANUP COMPLETED ===');
        
        // Show remaining roles
        $remainingRoles = Role::all();
        $this->command->info('Remaining roles:');
        foreach ($remainingRoles as $role) {
            $this->command->info('- ' . $role->name . ' (Users: ' . $role->users->count() . ', Permissions: ' . $role->permissions->count() . ')');
        }
        
        $this->command->info('');
        $this->command->info('Database cleanup completed successfully!');
    }
}
