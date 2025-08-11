<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class HybridUuidDemo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uuid:hybrid-demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Demonstrate hybrid UUID implementation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🎯 HYBRID UUID IMPLEMENTATION DEMO');
        $this->line('');
        
        $hero = \App\Models\Hero::first();
        
        if (!$hero) {
            $this->error('No hero found! Please run seeder first.');
            return 1;
        }
        
        $this->info("📋 Using Hero: {$hero->judul}");
        $this->line("   ID: {$hero->id}");
        $this->line("   UUID: {$hero->uuid}");
        $this->line('');
        
        $this->info('🏛️ ADMIN PANEL URLs (menggunakan ID):');
        $this->line("   ✅ Admin Edit: /admin/heroes/{$hero->id}/edit");
        $this->line("   ✅ Admin View: /admin/heroes/{$hero->id}");
        $this->line("   📈 Benefits: Fast queries, Filament compatible, easy debugging");
        $this->line('');
        
        $this->info('🌍 PUBLIC URLs (menggunakan UUID):');
        $this->line("   🔒 Public View: /hero/{$hero->uuid}");
        $this->line("   🔒 API Endpoint: /api/heroes/{$hero->uuid}");
        $this->line("   🛡️ Benefits: Security, anti-enumeration, global unique");
        $this->line('');
        
        $this->info('⚡ PERFORMANCE COMPARISON:');
        
        // Test performa query ID vs UUID
        $start = microtime(true);
        for ($i = 0; $i < 1000; $i++) {
            \App\Models\Hero::find($hero->id);
        }
        $timeId = round((microtime(true) - $start) * 1000, 2);
        
        $start = microtime(true);
        for ($i = 0; $i < 1000; $i++) {
            \App\Models\Hero::where('uuid', $hero->uuid)->first();
        }
        $timeUuid = round((microtime(true) - $start) * 1000, 2);
        
        $this->line("   🏃 ID Query (1000x): {$timeId}ms");
        $this->line("   🚶 UUID Query (1000x): {$timeUuid}ms");
        $this->line("   📊 Ratio: " . round($timeUuid / $timeId, 1) . "x slower");
        $this->line('');
        
        $this->info('🎪 DEMO URLs to test:');
        $this->line("   Admin: http://127.0.0.1:8000/admin/heroes (login required)");
        $this->line("   Public: http://127.0.0.1:8000/hero/{$hero->uuid}");
        $this->line("   Demo: http://127.0.0.1:8000/uuid-demo");
        $this->line('');
        
        $this->info('🏆 RECOMMENDATION: Use this hybrid approach!');
        $this->line('   ✅ Admin panel: Fast & compatible');
        $this->line('   ✅ Public routes: Secure & professional');
        $this->line('   ✅ Best of both worlds! 🌟');
        
        return 0;
    }
}
