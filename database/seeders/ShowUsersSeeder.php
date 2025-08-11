<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class ShowUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('=== CURRENT USERS IN DATABASE ===');
        
        $users = User::with('roles')->get();
        
        foreach ($users as $user) {
            $roles = $user->roles->pluck('name')->join(', ');
            $this->command->info('- ' . $user->email . ' (' . $user->name . ') - Roles: ' . ($roles ?: 'No roles'));
        }
        
        $this->command->info('');
        $this->command->info('Total users: ' . $users->count());
    }
}
