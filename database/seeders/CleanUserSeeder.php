<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CleanUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('=== CLEANING DUPLICATE USERS ===');
        
        // Email yang valid untuk di-keep
        $keepEmails = [
            'superadmin@smp5sangatta.sch.id',
            'admin@smp5sangatta.sch.id'
        ];
        
        // Get all users
        $allUsers = User::with('roles')->get();
        
        $this->command->info('Current users in database:');
        foreach ($allUsers as $user) {
            $roles = $user->roles->pluck('name')->join(', ');
            $this->command->info('- ' . $user->email . ' (' . $user->name . ') - Roles: ' . ($roles ?: 'No roles'));
        }
        
        // Find users to delete
        $usersToDelete = User::whereNotIn('email', $keepEmails)->get();
        
        if ($usersToDelete->count() > 0) {
            $this->command->info('');
            $this->command->info('Users to be deleted:');
            foreach ($usersToDelete as $user) {
                $this->command->info('- ' . $user->email . ' (' . $user->name . ')');
                
                // Remove all roles from user first
                $user->syncRoles([]);
                
                // Delete the user
                $user->delete();
                $this->command->info('  > User deleted: ' . $user->email);
            }
        } else {
            $this->command->info('No users to delete.');
        }
        
        $this->command->info('');
        $this->command->info('=== CLEANUP COMPLETED ===');
        
        // Show remaining users
        $remainingUsers = User::with('roles')->get();
        $this->command->info('Remaining users:');
        foreach ($remainingUsers as $user) {
            $roles = $user->roles->pluck('name')->join(', ');
            $this->command->info('- ' . $user->email . ' (' . $user->name . ') - Roles: ' . ($roles ?: 'No roles'));
        }
        
        $this->command->info('');
        $this->command->info('User cleanup completed successfully!');
    }
}
