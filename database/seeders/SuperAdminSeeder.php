<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar lengkap permissions untuk semua fitur CMS
        $permissions = [
            // Dashboard
            'view_dashboard',
            
            // Users Management
            'view_any_user',
            'view_user',
            'create_user',
            'update_user',
            'delete_user',
            'force_delete_user',
            'restore_user',
            
            // Roles & Permissions
            'view_any_role',
            'view_role',
            'create_role',
            'update_role',
            'delete_role',
            'view_any_permission',
            'view_permission',
            'create_permission',
            'update_permission',
            'delete_permission',
            
            // CMS Home/Beranda
            'view_any_hero',
            'view_hero',
            'create_hero',
            'update_hero',
            'delete_hero',
            'view_any_keunggulan',
            'view_keunggulan',
            'create_keunggulan',
            'update_keunggulan',
            'delete_keunggulan',
            'view_any_statistik',
            'view_statistik',
            'create_statistik',
            'update_statistik',
            'delete_statistik',
            'view_any_section_keunggulan',
            'view_section_keunggulan',
            'create_section_keunggulan',
            'update_section_keunggulan',
            'delete_section_keunggulan',
            'view_any_section_artikel',
            'view_section_artikel',
            'create_section_artikel',
            'update_section_artikel',
            'delete_section_artikel',
            'view_any_section_galeri',
            'view_section_galeri',
            'create_section_galeri',
            'update_section_galeri',
            'delete_section_galeri',
            
            // CMS About
            'view_any_about_hero',
            'view_about_hero',
            'create_about_hero',
            'update_about_hero',
            'delete_about_hero',
            'view_any_visi_misi',
            'view_visi_misi',
            'create_visi_misi',
            'update_visi_misi',
            'delete_visi_misi',
            'view_any_prestasi_about',
            'view_prestasi_about',
            'create_prestasi_about',
            'update_prestasi_about',
            'delete_prestasi_about',
            'view_any_tim_birokrasi',
            'view_tim_birokrasi',
            'create_tim_birokrasi',
            'update_tim_birokrasi',
            'delete_tim_birokrasi',
            'view_any_section_akreditasi',
            'view_section_akreditasi',
            'create_section_akreditasi',
            'update_section_akreditasi',
            'delete_section_akreditasi',
            
            // CMS SPMB
            'view_any_spmh_hero',
            'view_spmh_hero',
            'create_spmh_hero',
            'update_spmh_hero',
            'delete_spmh_hero',
            'view_any_spmh_content',
            'view_spmh_content',
            'create_spmh_content',
            'update_spmh_content',
            'delete_spmh_content',
            
            // CMS Media
            'view_any_media_hero',
            'view_media_hero',
            'create_media_hero',
            'update_media_hero',
            'delete_media_hero',
            'view_any_media_galeri',
            'view_media_galeri',
            'create_media_galeri',
            'update_media_galeri',
            'delete_media_galeri',
            'view_any_media_video',
            'view_media_video',
            'create_media_video',
            'update_media_video',
            'delete_media_video',
            
            // CMS Artikel/Blog
            'view_any_artikel',
            'view_artikel',
            'create_artikel',
            'update_artikel',
            'delete_artikel',
            'view_any_kategori_artikel',
            'view_kategori_artikel',
            'create_kategori_artikel',
            'update_kategori_artikel',
            'delete_kategori_artikel',
            
            // CMS Footer
            'view_any_footer_setting',
            'view_footer_setting',
            'create_footer_setting',
            'update_footer_setting',
            'delete_footer_setting',
            
            // CMS Kontak
            'view_any_kontak',
            'view_kontak',
            'create_kontak',
            'update_kontak',
            'delete_kontak',
            
            // Profile Settings
            'view_any_profile_settings',
            'view_profile_settings',
            'create_profile_settings',
            'update_profile_settings',
            'delete_profile_settings',
        ];

        // Buat permissions jika belum ada
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat Super Admin role
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);

        // Berikan semua permission ke Super Admin role
        $superAdminRole->syncPermissions($permissions);

        // Cari user yang sudah ada atau buat baru
        $existingUser = User::where('email', 'admin@smpn5sangattautara.sch.id')->first();
        
        if ($existingUser) {
            // Update user yang sudah ada
            $existingUser->update([
                'name' => 'Super Administrator',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]);
            $superAdmin = $existingUser;
        } else {
            // Buat user baru dengan username unik
            $username = 'superadmin_' . time();
            $superAdmin = User::create([
                'name' => 'Super Administrator',
                'username' => $username,
                'email' => 'admin@smpn5sangattautara.sch.id',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]);
        }

        // Assign Super Admin role ke user
        $superAdmin->syncRoles(['super_admin']);

        $this->command->info("✅ Super Admin berhasil dibuat/diperbarui!");
        $this->command->info("📧 Email: admin@smpn5sangattautara.sch.id");
        $this->command->info("🔑 Password: admin123");
        $this->command->info("🛡️ Total Permissions: " . count($permissions));
        $this->command->info("👤 User ID: " . $superAdmin->id);
        $this->command->info("📝 Username: " . $superAdmin->username);
    }
}