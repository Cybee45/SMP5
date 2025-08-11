<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Hero;
use App\Models\Statistik;
use App\Models\Keunggulan;
use App\Models\Profil;

class ShowUuidDemo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uuid:demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Demonstrasi penggunaan UUID di CMS Filament';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🎯 Demonstrasi UUID pada CMS Filament SMP 5');
        $this->newLine();

        // Heroes dengan UUID
        $this->info('📋 HEROES dengan UUID:');
        $heroes = Hero::all();
        foreach ($heroes as $hero) {
            $this->line("• ID: {$hero->id} | UUID: {$hero->uuid} | Judul: {$hero->judul}");
        }
        $this->newLine();

        // Statistik dengan UUID
        $this->info('📊 STATISTIK dengan UUID:');
        $statistiks = Statistik::all();
        foreach ($statistiks as $stat) {
            $this->line("• ID: {$stat->id} | UUID: {$stat->uuid} | {$stat->judul}: {$stat->jumlah}");
        }
        $this->newLine();

        // Keunggulan dengan UUID
        $this->info('⭐ KEUNGGULAN dengan UUID:');
        $keunggulans = Keunggulan::all();
        foreach ($keunggulans as $keunggulan) {
            $this->line("• ID: {$keunggulan->id} | UUID: {$keunggulan->uuid} | {$keunggulan->judul}");
        }
        $this->newLine();

        // Profil dengan UUID
        $this->info('🏫 PROFIL dengan UUID:');
        $profils = Profil::all();
        foreach ($profils as $profil) {
            $this->line("• ID: {$profil->id} | UUID: {$profil->uuid} | {$profil->judul}");
        }
        $this->newLine();

        // Demonstrasi pencarian dengan UUID
        $this->info('🔍 Demonstrasi pencarian dengan UUID:');
        $heroWithUuid = Hero::whereNotNull('uuid')->first();
        if ($heroWithUuid && $heroWithUuid->uuid) {
            $foundByUuid = Hero::findByUuid($heroWithUuid->uuid);
            $this->line("✅ Pencarian berhasil dengan UUID: {$heroWithUuid->uuid}");
            $this->line("   Ditemukan: {$foundByUuid->judul}");
        } else {
            $this->line("ℹ️  Belum ada data dengan UUID, silakan buat data baru");
        }
        $this->newLine();

        // Keamanan UUID
        $this->info('🔐 KEAMANAN UUID:');
        $this->line('• UUID menggantikan ID auto-increment yang mudah ditebak');
        $this->line('• URL menjadi: /admin/heroes/{uuid} bukan /admin/heroes/{id}');
        $this->line('• Lebih aman dari serangan enumeration');
        $this->line('• UUID bersifat global unique');
        $this->newLine();

        $this->info('✅ UUID berhasil diimplementasikan pada CMS Filament!');
        
        return Command::SUCCESS;
    }
}
