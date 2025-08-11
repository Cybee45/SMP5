<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Hero;
use App\Models\Statistik;
use App\Models\Keunggulan;
use App\Models\Profil;
use App\Models\Galeri;
use App\Models\Kategori;
use Ramsey\Uuid\Uuid;

class GenerateUuidForExistingData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uuid:generate-existing {--force : Force generate UUID for all records}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate UUID untuk data existing yang belum memiliki UUID';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $force = $this->option('force');
        
        if (!$force && !$this->confirm('Apakah Anda yakin ingin generate UUID untuk semua data existing?')) {
            $this->info('Operasi dibatalkan.');
            return Command::SUCCESS;
        }

        $this->info('🚀 Memulai generate UUID untuk data existing...');
        $this->newLine();

        $models = [
            'Hero' => Hero::class,
            'Statistik' => Statistik::class,
            'Keunggulan' => Keunggulan::class,
            'Profil' => Profil::class,
            'Galeri' => Galeri::class,
            'Kategori' => Kategori::class,
        ];

        $totalUpdated = 0;

        foreach ($models as $name => $model) {
            $this->info("📝 Processing {$name}...");
            
            $records = $model::whereNull('uuid')->get();
            $updated = 0;

            if ($records->isEmpty()) {
                $this->line("   ✅ Semua {$name} sudah memiliki UUID");
                continue;
            }

            foreach ($records as $record) {
                try {
                    $record->update(['uuid' => Uuid::uuid4()->toString()]);
                    $updated++;
                } catch (\Exception $e) {
                    $this->error("   ❌ Error updating {$name} ID {$record->id}: " . $e->getMessage());
                }
            }

            $this->line("   ✅ Updated {$updated} records untuk {$name}");
            $totalUpdated += $updated;
        }

        $this->newLine();
        $this->info("🎉 Selesai! Total {$totalUpdated} records berhasil di-update dengan UUID.");
        
        // Show summary
        $this->newLine();
        $this->info('📊 Summary:');
        foreach ($models as $name => $model) {
            $total = $model::count();
            $withUuid = $model::whereNotNull('uuid')->count();
            $percentage = $total > 0 ? round(($withUuid / $total) * 100, 2) : 0;
            $this->line("   • {$name}: {$withUuid}/{$total} ({$percentage}%) memiliki UUID");
        }

        return Command::SUCCESS;
    }
}
