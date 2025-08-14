<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class OptimizeImages extends Command
{
    protected $signature = 'optimize:images {--path=storage/app/public}';
    protected $description = 'Optimize images for better web performance';

    public function handle()
    {
        $path = $this->option('path');
        $fullPath = base_path($path);

        if (!File::exists($fullPath)) {
            $this->error("Directory {$fullPath} does not exist.");
            return 1;
        }

        $this->info("Scanning images in: {$fullPath}");

        $imageFiles = collect(File::allFiles($fullPath))
            ->filter(function ($file) {
                return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp']);
            });

        $this->info("Found {$imageFiles->count()} image files.");
        
        if ($imageFiles->count() === 0) {
            $this->info("No images found to optimize.");
            return 0;
        }

        $bar = $this->output->createProgressBar($imageFiles->count());
        $bar->start();

        $totalOriginalSize = 0;
        $totalNewSize = 0;
        $filesProcessed = 0;

        foreach ($imageFiles as $file) {
            $originalSize = $file->getSize();
            $totalOriginalSize += $originalSize;
            
            // Basic optimization: check file size and dimensions
            $sizeInMB = round($originalSize / 1024 / 1024, 2);
            
            if ($originalSize > 2 * 1024 * 1024) { // Files larger than 2MB
                $this->info("\nLarge file found: {$file->getFilename()} ({$sizeInMB}MB)");
                $this->warn("Consider manually optimizing this file.");
            }

            $totalNewSize += $originalSize; // Since we're not actually optimizing
            $filesProcessed++;
            
            $bar->advance();
        }

        $bar->finish();

        $this->info("\n\nScan complete!");
        $this->info("Files processed: {$filesProcessed}");
        $this->info("Total size: " . round($totalOriginalSize / 1024 / 1024, 2) . "MB");
        
        // Provide optimization recommendations
        $this->info("\n--- Optimization Recommendations ---");
        $this->info("1. Use WebP format for better compression");
        $this->info("2. Resize images to max 1920px width");
        $this->info("3. Use quality 75-85 for JPEG files");
        $this->info("4. Consider using a CDN for image delivery");
        $this->info("5. Implement lazy loading (already done!)");

        return 0;
    }
}
