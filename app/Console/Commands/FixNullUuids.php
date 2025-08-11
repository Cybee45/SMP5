<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixNullUuids extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uuid:fix-nulls';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix NULL UUIDs in database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Memperbaiki NULL UUIDs...');
        
        $models = [
            \App\Models\Hero::class,
            \App\Models\Statistik::class,
            \App\Models\Keunggulan::class,
            \App\Models\Profil::class,
            \App\Models\Galeri::class,
        ];
        
        foreach ($models as $modelClass) {
            $modelName = class_basename($modelClass);
            $this->line("📝 Processing {$modelName}...");
            
            $nullRecords = $modelClass::whereNull('uuid')->get();
            
            if ($nullRecords->count() > 0) {
                foreach ($nullRecords as $record) {
                    $record->uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
                    $record->save();
                }
                $this->info("   ✅ Updated {$nullRecords->count()} records for {$modelName}");
            } else {
                $this->info("   ✅ All {$modelName} records already have UUID");
            }
        }
        
        $this->info('🎉 Semua NULL UUIDs berhasil diperbaiki!');
        
        return 0;
    }
}
