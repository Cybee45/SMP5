<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->info('� Setting up admin system...');
        
        // Create roles
        $this->info('👥 Creating roles...');
        $superAdminRole = Role::updateOrCreate(['name' => 'super_admin']);
        $adminRole = Role::updateOrCreate(['name' => 'admin']);
        
        // Create permissions
        $this->info('🔐 Creating permissions...');
        $permissions = [
            // User Management
            'view_user',
            'view_any_user',
            'create_user',
            'update_user',
            'delete_user',
            'delete_any_user',
            
            // Role Management
            'view_role',
            'view_any_role',
            'create_role',
            'update_role',
            'delete_role',
            'delete_any_role',
            
            // Permission Management
            'view_permission',
            'view_any_permission',
            'create_permission',
            'update_permission',
            'delete_permission',
            'delete_any_permission',
            
            // Hero Management
            'view_hero',
            'view_any_hero',
            'create_hero',
            'update_hero',
            'delete_hero',
            'delete_any_hero',
            
            // Hero Blog Management
            'view_hero::blog',
            'view_any_hero::blog',
            'create_hero::blog',
            'update_hero::blog',
            'delete_hero::blog',
            'delete_any_hero::blog',
            
            // Artikel Management
            'view_artikel',
            'view_any_artikel',
            'create_artikel',
            'update_artikel',
            'delete_artikel',
            'delete_any_artikel',
            
            // Kategori Management
            'view_kategori',
            'view_any_kategori',
            'create_kategori',
            'update_kategori',
            'delete_kategori',
            'delete_any_kategori',
            
            // Visi Misi Management
            'view_visi::misi',
            'view_any_visi::misi',
            'create_visi::misi',
            'update_visi::misi',
            'delete_visi::misi',
            'delete_any_visi::misi',
            
            // Sejarah Management
            'view_sejarah',
            'view_any_sejarah',
            'create_sejarah',
            'update_sejarah',
            'delete_sejarah',
            'delete_any_sejarah',
            
            // Keunggulan Management
            'view_keunggulan',
            'view_any_keunggulan',
            'create_keunggulan',
            'update_keunggulan',
            'delete_keunggulan',
            'delete_any_keunggulan',
            
            // Staf Management
            'view_staf',
            'view_any_staf',
            'create_staf',
            'update_staf',
            'delete_staf',
            'delete_any_staf',
            
            // Struktur Organisasi Management
            'view_struktur::organisasi',
            'view_any_struktur::organisasi',
            'create_struktur::organisasi',
            'update_struktur::organisasi',
            'delete_struktur::organisasi',
            'delete_any_struktur::organisasi',
            
            // Galeri Management
            'view_galeri',
            'view_any_galeri',
            'create_galeri',
            'update_galeri',
            'delete_galeri',
            'delete_any_galeri',
            
            // Media Management
            'view_media',
            'view_any_media',
            'create_media',
            'update_media',
            'delete_media',
            'delete_any_media',
            
            // SPMB Management
            'view_spmb',
            'view_any_spmb',
            'create_spmb',
            'update_spmb',
            'delete_spmb',
            'delete_any_spmb',
            
            // Informasi SPMB Management
            'view_informasi::spmb',
            'view_any_informasi::spmb',
            'create_informasi::spmb',
            'update_informasi::spmb',
            'delete_informasi::spmb',
            'delete_any_informasi::spmb',
            
            // Jadwal SPMB Management
            'view_jadwal::spmb',
            'view_any_jadwal::spmb',
            'create_jadwal::spmb',
            'update_jadwal::spmb',
            'delete_jadwal::spmb',
            'delete_any_jadwal::spmb',
        ];
        
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }
        
        // Assign all permissions to super_admin
        $this->info('🛡️ Assigning permissions to super admin...');
        $superAdminRole->syncPermissions(Permission::all());
        
        // Assign most permissions to admin (except user/role/permission management)
        $this->info('👤 Assigning permissions to admin...');
        $adminPermissions = Permission::whereNotIn('name', [
            'view_user', 'view_any_user', 'create_user', 'update_user', 'delete_user', 'delete_any_user',
            'view_role', 'view_any_role', 'create_role', 'update_role', 'delete_role', 'delete_any_role',
            'view_permission', 'view_any_permission', 'create_permission', 'update_permission', 'delete_permission', 'delete_any_permission'
        ])->get();
        $adminRole->syncPermissions($adminPermissions);
        
        // Create super admin user
        $this->info('👑 Creating super admin user...');
        $superAdmin = User::updateOrCreate(
            ['username' => 'superadmin'],
            [
                'username' => 'superadmin',
                'name' => 'Super Administrator',
                'email' => 'superadmin@smp5.sch.id',
                'password' => Hash::make('admin'),
            ]
        );
        $superAdmin->assignRole('super_admin');
        
        // Create admin user
        $this->info('👤 Creating admin user...');
        $admin = User::updateOrCreate(
            ['username' => 'admin'],
            [
                'username' => 'admin',
                'name' => 'Administrator',
                'email' => 'admin@smp5.sch.id',
                'password' => Hash::make('admin'),
            ]
        );
        $admin->assignRole('admin');
        
        $this->info('✅ Admin system setup completed!');
        $this->info('📋 Login credentials:');
        $this->info('   Super Admin - Username: superadmin, Password: admin');
        $this->info('   Admin - Username: admin, Password: admin');
    }
    
    private function info($message)
    {
        echo $message . PHP_EOL;
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        
        // Define all permissions needed for the CMS
        $permissions = [
            // User Management
            'view_any_user',
            'view_user',
            'create_user',
            'update_user',
            'delete_user',
            
            // Role Management  
            'view_any_role',
            'view_role',
            'create_role',
            'update_role',
            'delete_role',
            
            // Permission Management
            'view_any_permission',
            'view_permission',
            'create_permission',
            'update_permission',
            'delete_permission',
            
            // Hero Home Management
            'view_any_hero',
            'view_hero',
            'create_hero',
            'update_hero',
            'delete_hero',
            
            // Hero Blog Management
            'view_any_hero::blog',
            'view_hero::blog',
            'create_hero::blog',
            'update_hero::blog',
            'delete_hero::blog',
            
            // Artikel Management
            'view_any_artikel',
            'view_artikel',
            'create_artikel',
            'update_artikel',
            'delete_artikel',
            
            // Kategori Management
            'view_any_kategori',
            'view_kategori',
            'create_kategori',
            'update_kategori',
            'delete_kategori',
            
            // Galeri Management
            'view_any_galeri',
            'view_galeri',
            'create_galeri',
            'update_galeri',
            'delete_galeri',
            
            // Keunggulan Management
            'view_any_keunggulan',
            'view_keunggulan',
            'create_keunggulan',
            'update_keunggulan',
            'delete_keunggulan',
            
            // Section Keunggulan Management
            'view_any_section::keunggulan',
            'view_section::keunggulan',
            'create_section::keunggulan',
            'update_section::keunggulan',
            'delete_section::keunggulan',
            
            // Statistik Management
            'view_any_statistik',
            'view_statistik',
            'create_statistik',
            'update_statistik',
            'delete_statistik',
            
            // Profil Management
            'view_any_profil',
            'view_profil',
            'create_profil',
            'update_profil',
            'delete_profil',
            
            // About Hero Management
            'view_any_about::hero',
            'view_about::hero',
            'create_about::hero',
            'update_about::hero',
            'delete_about::hero',
            
            // Prestasi About Management
            'view_any_prestasi::about',
            'view_prestasi::about',
            'create_prestasi::about',
            'update_prestasi::about',
            'delete_prestasi::about',
            
            // Tim Birokrasi Management
            'view_any_tim::birokrasi',
            'view_tim::birokrasi',
            'create_tim::birokrasi',
            'update_tim::birokrasi',
            'delete_tim::birokrasi',
            
            // Visi Misi Management
            'view_any_visi::misi',
            'view_visi::misi',
            'create_visi::misi',
            'update_visi::misi',
            'delete_visi::misi',
            
            // SPMB Hero Management
            'view_any_spmhhero',
            'view_spmhhero',
            'create_spmhhero',
            'update_spmhhero',
            'delete_spmhhero',
            
            // SPMB Content Management
            'view_any_spmhcontent',
            'view_spmhcontent',
            'create_spmhcontent',
            'update_spmhcontent',
            'delete_spmhcontent',
            
            // Media Video Management
            'view_any_media::video',
            'view_media::video',
            'create_media::video',
            'update_media::video',
            'delete_media::video',
            
            // Media Galeri Management
            'view_any_media::galeri',
            'view_media::galeri',
            'create_media::galeri',
            'update_media::galeri',
            'delete_media::galeri',
            
            // Media Hero Management
            'view_any_media::hero',
            'view_media::hero',
            'create_media::hero',
            'update_media::hero',
            'delete_media::hero',
        ];
        
        $this->info('📝 Creating ' . count($permissions) . ' permissions...');
        
        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        
        // Super Admin gets all permissions
        $this->info('👑 Assigning all permissions to Super Admin...');
        $superAdminRole->syncPermissions($permissions);
        
        // Admin gets CMS permissions (excluding user/role/permission management)
        $adminPermissions = array_filter($permissions, function ($permission) {
            return !str_contains($permission, 'user') && 
                   !str_contains($permission, 'role') && 
                   !str_contains($permission, 'permission');
        });
        
        $this->info('🛡️ Assigning ' . count($adminPermissions) . ' CMS permissions to Admin...');
        $adminRole->syncPermissions($adminPermissions);
        
        // Create Super Admin user
        $this->info('👤 Creating Super Admin user...');
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@smp5sangatta.sch.id'],
            [
                'name' => 'Super Administrator',
                'username' => 'superadmin',
                'password' => Hash::make('superadmin123'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole($superAdminRole);
        
        // Create Admin user
        $this->info('👨‍💼 Creating Admin user...');
        $admin = User::updateOrCreate(
            ['email' => 'admin@smp5sangatta.sch.id'],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole($adminRole);
        
        $this->info('✅ Admin setup completed successfully!');
        $this->info('');
        $this->info('🔑 Login Credentials:');
        $this->info('Super Admin: superadmin / superadmin123');
        $this->info('Admin: admin / admin123');
        $this->info('');
        $this->info('📊 Summary:');
        $this->info('• Total Permissions: ' . count($permissions));
        $this->info('• Super Admin Permissions: ' . count($permissions));
        $this->info('• Admin Permissions: ' . count($adminPermissions));
    }
    
    private function info($message)
    {
        echo $message . PHP_EOL;
    }
}
