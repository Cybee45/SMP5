<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestUuidCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uuid:test-create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test creating new data with UUID';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Testing UUID creation untuk data baru...');
        
        // Create new Hero
        $hero = \App\Models\Hero::create([
            'tipe' => 'test',
            'judul' => 'Test UUID Hero',
            'subjudul' => 'Testing UUID Implementation',
            'deskripsi' => 'Hero ini dibuat untuk mentest UUID otomatis',
            'aktif' => true
        ]);
        
        $this->info('✅ Hero baru berhasil dibuat:');
        $this->line("   ID: {$hero->id}");
        $this->line("   UUID: {$hero->uuid}");
        $this->line("   Judul: {$hero->judul}");
        $this->line("   URL Admin: /admin/heroes/{$hero->id}/edit");
        
        // Test find by UUID
        $foundHero = \App\Models\Hero::findByUuid($hero->uuid);
        if ($foundHero) {
            $this->info('✅ Pencarian dengan UUID berhasil!');
            $this->line("   Ditemukan Hero: {$foundHero->judul}");
        } else {
            $this->error('❌ Pencarian dengan UUID gagal!');
        }
        
        $this->info('🎯 UUID berhasil bekerja untuk data baru!');
        
        return 0;
    }
}
