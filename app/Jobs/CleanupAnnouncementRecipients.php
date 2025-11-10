<?php

namespace App\Jobs;

use App\Services\AnnouncementTargetingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CleanupAnnouncementRecipients implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of days old records should be before cleanup
     */
    protected $daysOld;

    /**
     * Create a new job instance.
     */
    public function __construct(int $daysOld = 30)
    {
        $this->daysOld = $daysOld;
        $this->onQueue('announcements'); // Put in a dedicated queue for announcements
    }

    /**
     * Execute the job.
     */
    public function handle(AnnouncementTargetingService $targetingService): void
    {
        try {
            Log::info('Starting announcement recipients cleanup', [
                'days_old' => $this->daysOld,
                'started_at' => now()
            ]);

            $cleanedCount = $targetingService->cleanupOldRecipients($this->daysOld);

            Log::info('Announcement recipients cleanup completed', [
                'cleaned_count' => $cleanedCount,
                'days_old' => $this->daysOld,
                'completed_at' => now()
            ]);

            // Additional cleanup tasks
            $this->archiveOldAnnouncements();
            $this->updateAnnouncementStatistics();

        } catch (\Exception $e) {
            Log::error('Error during announcement recipients cleanup', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'days_old' => $this->daysOld
            ]);

            throw $e;
        }
    }

    /**
     * Archive old announcements that have expired
     */
    private function archiveOldAnnouncements(): void
    {
        $expiredAnnouncements = \App\Models\Announcement::where('expires_at', '<', now()->subDays(7))
            ->where('is_archived', false)
            ->get();

        foreach ($expiredAnnouncements as $announcement) {
            $announcement->update(['is_archived' => true]);
            
            Log::info('Archived expired announcement', [
                'announcement_id' => $announcement->id,
                'subject' => $announcement->subject,
                'expired_at' => $announcement->expires_at
            ]);
        }

        if ($expiredAnnouncements->isNotEmpty()) {
            Log::info('Archived expired announcements', [
                'count' => $expiredAnnouncements->count()
            ]);
        }
    }

    /**
     * Update announcement statistics for accuracy
     */
    private function updateAnnouncementStatistics(): void
    {
        // Get announcements that have been sent but statistics may be outdated
        $announcements = \App\Models\Announcement::where('status', 'sent')
            ->where('sent_at', '>=', now()->subDays(7)) // Only recent ones
            ->get();

        foreach ($announcements as $announcement) {
            // Update delivery statistics
            $announcement->updateDeliveryStats();
        }

        if ($announcements->isNotEmpty()) {
            Log::info('Updated announcement statistics', [
                'count' => $announcements->count()
            ]);
        }
    }

    /**
     * Get the tags that should be assigned to the job.
     */
    public function tags(): array
    {
        return ['announcements', 'cleanup'];
    }

    /**
     * Determine the time at which the job should timeout.
     */
    public function timeout(): int
    {
        return 3600; // 1 hour timeout
    }

    /**
     * Determine the number of times the job may be attempted.
     */
    public function tries(): int
    {
        return 3;
    }

    /**
     * Calculate the number of seconds to wait before retrying the job.
     */
    public function backoff(): array
    {
        return [60, 300, 900]; // 1 minute, 5 minutes, 15 minutes
    }
}