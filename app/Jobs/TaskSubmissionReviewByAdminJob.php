<?php

namespace App\Jobs;

use App\Models\Moderation;
use App\Models\Setting;
use App\Models\TaskSubmission;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskSubmissionReviewByAdminJob implements ShouldQueue
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
        $deadlineHours = Setting::where('name', 'submission_review_deadline')->value('value') ?? 24;
        $submissions = TaskSubmission::whereNull('reviewed_at')->whereRaw('(TIMESTAMPDIFF(HOUR, created_at, NOW()) >= ?)', [$deadlineHours])->get();
        foreach ($submissions as $submission) {
            if($submission->moderations->isNotEmpty() && $submission->moderations->where('purpose', 'admin_review_submission')->isNotEmpty() && $submission->moderations->where('purpose', 'admin_review_submission')->first()->status !='pending') {
                continue; // Skip if already reviewed by admin
            }
            Moderation::create([
                'moderatable_type' => get_class($submission),
                'moderatable_id' => $submission->id,
                'purpose' => 'admin_review_submission',
                'status' => 'pending',
            ]);
        }
    }
}
