<?php

namespace App\Jobs;

use App\Models\Subscription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SubscriptionExpiringNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Subscription::where('expires_at', '<=', now()->addDays(3))
            ->where('notified_expiring', false)
            ->each(function ($subscription) {
                // Logic to send notification to the user about expiring subscription
                // For example, you can use Notification facade to send an email notification

                // Mark as notified
                $subscription->notified_expiring = true;
                $subscription->save();
            });
    }
}
