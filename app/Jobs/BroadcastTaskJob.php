<?php

namespace App\Jobs;

use App\Models\TaskPromotion;
use App\Models\Task;
use App\Models\PreferredLocation;
use App\Models\PlatformUser;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TaskWorker\BroadcastTaskPromotionNotification;

class BroadcastTaskJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $promotionId;

    /**
     * Create a new job instance.
     */
    public function __construct(TaskPromotion $promotion)
    {
        $this->promotionId = $promotion->id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $promotion = TaskPromotion::find($this->promotionId);
        if (!$promotion) return;
        $task = $promotion->task;
        if (!$task) return;
        $platformId = $task->platform_id;
        $countryId = $task->user->country_id;

        // Step 5: preferred_location
        $preferredLocationIds = PreferredLocation::where('country_id', $countryId)->pluck('user_id')->toArray();
        if (empty($preferredLocationIds)) return;
        // Step 6: platform_user
        $platformUserIds = PlatformUser::where('platform_id', $platformId)->pluck('user_id')->toArray();
        if (empty($platformUserIds)) return;
        // Step 7: intersection
        $notifyUserIds = array_values(array_intersect($preferredLocationIds, $platformUserIds));
        if (empty($notifyUserIds)) return;

        // Step 7b: Limit to number_of_submissions
        $limit = (int) ($task->number_of_submissions ?? 1);
        $notifyUserIds = array_slice($notifyUserIds, 0, $limit);
        
        // Step 8: notify
        $users = User::whereIn('id', $notifyUserIds)->get();
        Notification::send($users, new BroadcastTaskPromotionNotification($task));
    }
}
