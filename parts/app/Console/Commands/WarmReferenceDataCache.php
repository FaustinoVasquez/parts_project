<?php

namespace App\Console\Commands;

use App\Services\ReferenceDataCache;
use Illuminate\Console\Command;

class WarmReferenceDataCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:warm-reference-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Warm up reference data cache (WorkCenter, Category, SubCategory, Country)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Warming up reference data cache...');
        $this->newLine();

        try {
            // Warm up work centers cache
            $this->info('Loading WorkCenters...');
            $workCenters = ReferenceDataCache::workCenters();
            $this->line('  ✓ Cached ' . $workCenters->count() . ' work centers');

            // Warm up categories cache
            $this->info('Loading Categories...');
            $categories = ReferenceDataCache::categories();
            $this->line('  ✓ Cached ' . $categories->count() . ' categories');

            // Warm up sub-categories cache
            $this->info('Loading SubCategories...');
            $subCategories = ReferenceDataCache::subCategories();
            $this->line('  ✓ Cached ' . $subCategories->count() . ' sub-categories');

            // Warm up countries cache
            $this->info('Loading Countries...');
            $countries = ReferenceDataCache::countries();
            $this->line('  ✓ Cached ' . $countries->count() . ' countries');

            $this->newLine();
            $this->info('✓ Reference data cache warmed successfully!');
            $this->line('Cache TTL: 24 hours');

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Failed to warm cache: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
