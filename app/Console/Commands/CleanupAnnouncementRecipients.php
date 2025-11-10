<?php

namespace App\Console\Commands;

use App\Jobs\CleanupAnnouncementRecipients as CleanupJob;
use Illuminate\Console\Command;

class CleanupAnnouncementRecipients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'announcements:cleanup 
                            {--days=30 : Number of days old records should be before cleanup}
                            {--force : Run cleanup without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old announcement recipient records and update statistics';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $days = $this->option('days');
        $force = $this->option('force');

        if (!$force) {
            $confirmation = $this->confirm(
                "This will clean up announcement recipient records older than {$days} days. Continue?"
            );

            if (!$confirmation) {
                $this->info('Cleanup cancelled.');
                return self::SUCCESS;
            }
        }

        $this->info('Starting announcement recipients cleanup...');
        $this->line("Records older than {$days} days will be removed.");

        // Dispatch the job
        CleanupJob::dispatch($days);

        $this->info('Cleanup job has been queued successfully.');
        $this->line('You can monitor the job progress in the queue: php artisan queue:work');

        return self::SUCCESS;
    }
}