<?php

namespace App\Observers;

use App\Models\CountrySetting;
use App\Models\Referral;
use App\Models\Settlement;
use App\Models\TaskWorker;
use App\Models\User;

class TaskWorkerObserver
{
    /**
     * Handle the TaskWorker "created" event.
     */
    public function created(TaskWorker $taskWorker): void
    {
        //
    }

    /**
     * Handle the TaskWorker "updated" event.
     */
    public function updated(TaskWorker $taskWorker): void
    {
        // Check if the task has just been marked as completed and paid
        if ($taskWorker->wasRecentlyCreated || $taskWorker->wasChanged()) {
            // Check if there's a completed submission for this task worker
            $completedSubmission = $taskWorker->taskSubmissions()->whereNotNull('completed_at')->first();
            
            if ($completedSubmission) {
                $worker = $taskWorker->user;

                // 1. Check if it's the worker's first completed job
                $completedJobsCount = TaskWorker::where('user_id', $worker->id)
                    ->whereHas('taskSubmissions', function($q) {
                        $q->whereNotNull('completed_at');
                    })
                    ->count();

                if ($completedJobsCount === 1) {
                    // 2. Check if the worker's email is in the referrals table
                    $referral = Referral::where('email', $worker->email)
                        ->latest()
                        ->first();

                    if ($referral) {
                        // 3. Check if the referrer has also completed the same job
                        $referrerWorker = TaskWorker::where('user_id', $referral->referrer_id)
                            ->where('task_id', $taskWorker->task_id)
                            ->whereHas('taskSubmissions', function($q) {
                                $q->whereNotNull('completed_at');
                            })
                            ->first();
                        
                        if ($referrerWorker) {
                            $countrySettings = CountrySetting::where('country_id', $taskWorker->task->user->country_id)->first();
                            
                            if ($countrySettings) {
                                $commissionRate = 0;
                                // 4. Check if the referral is internal or external and get the correct rate
                                if ($referral->type === 'internal') {
                                    $commissionRate = $countrySettings->invitee_commission_percentage;
                                } else { // 'external'
                                    $commissionRate = $countrySettings->referral_earnings_percentage;
                                }

                                if ($commissionRate > 0) {
                                    // 5. Calculate the commission and create a settlement record
                                    $commission = ($taskWorker->task->budget_per_person * $commissionRate) / 100;

                                    Settlement::create([
                                        'user_id' => $referral->referrer_id,
                                        'amount' => $commission,
                                        'settlementable_id' => $referral->id,
                                        'settlementable_type' => Referral::class,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Handle the TaskWorker "deleted" event.
     */
    public function deleted(TaskWorker $taskWorker): void
    {
        //
    }

    /**
     * Handle the TaskWorker "restored" event.
     */
    public function restored(TaskWorker $taskWorker): void
    {
        //
    }

    /**
     * Handle the TaskWorker "force deleted" event.
     */
    public function forceDeleted(TaskWorker $taskWorker): void
    {
        //
    }
} 