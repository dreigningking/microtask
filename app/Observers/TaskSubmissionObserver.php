<?php

namespace App\Observers;

use App\Models\Task;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Referral;
use App\Models\Invitation;
use App\Models\Settlement;
use App\Models\CountrySetting;
use App\Models\Moderation;
use App\Models\TaskSubmission;
use Illuminate\Support\Facades\DB;
use App\Notifications\TaskMaster\TaskSubmissionNotification;
use App\Notifications\TaskWorker\TaskSubmissionReviewNotification;

class TaskSubmissionObserver
{
    /**
     * Handle the TaskSubmission "created" event.
     */
    public function created(TaskSubmission $taskSubmission): void
    {
        if ($taskSubmission->task->submission_review_type == 'self_review') {
            $taskSubmission->task->user->notify(new TaskSubmissionNotification($taskSubmission));
        }else{
            // Notify admins for review
            Moderation::create([
                'moderatable_type' => get_class($taskSubmission),
                'moderatable_id' => $taskSubmission->id,
                'purpose' => 'admin_review_submission',
                'status' => 'pending',
            ]);
        }
    }

    /**
     * Handle the TaskSubmission "updated" event.
     */
    public function updated(TaskSubmission $taskSubmission): void
    {
        // Check if the task has just been marked as completed and paid
        if ($taskSubmission->isDirty('reviewed_at') && $taskSubmission->reviewed_at) {
            $taskSubmission->user->notify(new TaskSubmissionReviewNotification($taskSubmission));
        }
        if ($taskSubmission->isDirty('accepted') && $taskSubmission->accepted) {

            $user = $taskSubmission->user;
            $isFirstTask = TaskSubmission::where('user_id', $user->id)->where('accepted', true)->count() == 1;
            // Check invitations for signup referral bonus
            $invitation = Invitation::where('email', $user->email)
                ->where('status', 'registered')
                ->where('expire_at', '>', now())
                ->first();

            if ($isFirstTask && $invitation) {
                $this->makeInvitation($user, $isFirstTask, $invitation, $taskSubmission);
            } else {
                // Check referrals for task referral bonus
                $referral = Referral::where('user_id', $taskSubmission->user_id)
                    ->where('task_id', $taskSubmission->task_id)
                    ->where('status', 'pending')
                    ->first();

                if ($referral) {
                    $this->makeReferral($referral, $taskSubmission);
                }
            }
            // if this is the last accepted submission, mark the task as completed
            if($taskSubmission->task->taskSubmissions->where('accepted', true)->count() == $taskSubmission->task->number_of_submissions) {
                $taskSubmission->task->update(['completed_at' => now()]);
                if($taskSubmission->task->submission_review_type == 'self_review') {
                    $this->refundTaskPayment($taskSubmission->task);
                }
            }
        }
    }

    public function makeInvitation(User $user, bool $isFirstTask, Invitation $invitation, TaskSubmission $taskSubmission): void
    {
        if ($isFirstTask) {
            // Award signup referral commission to inviter
            $countrySettings = CountrySetting::where('country_id', $taskSubmission->task->user->country_id)->first();

            if ($countrySettings && isset($countrySettings->referral_settings['signup_referral_commission_percentage'])) {
                $commissionRate = $countrySettings->referral_settings['signup_referral_commission_percentage'];

                if ($commissionRate > 0) {
                    $commission = ($taskSubmission->task->budget_per_submission * $commissionRate) / 100;

                    DB::beginTransaction();
                    try {
                        $wallet = Wallet::where('user_id', $invitation->user_id)
                            ->where('currency', $taskSubmission->task->user->currency)
                            ->lockForUpdate()
                            ->first();

                        if (!$wallet) {
                            $wallet = new Wallet([
                                'user_id' => $invitation->user_id,
                                'currency' => $taskSubmission->task->user->currency,
                                'balance' => 0
                            ]);
                        }

                        $wallet->balance += $commission;
                        $wallet->save();

                        Settlement::create([
                            'user_id' => $invitation->user_id,
                            'description' => 'Signup referral earning',
                            'amount' => $commission,
                            'currency' => $taskSubmission->task->user->currency,
                            'status' => 'paid',
                            'settlementable_id' => $invitation->id,
                            'settlementable_type' => Invitation::class
                        ]);

                        $invitation->status = 'completed';
                        $invitation->save();

                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        throw $e;
                    }
                }
            }

            // Delete conflicting referral record
            Referral::where('task_id', $taskSubmission->task_id)
                ->where('user_id', $invitation->user_id)
                ->where('referree_id', $user->id)
                ->delete();
        }
    }

    public function makeReferral(Referral $referral, TaskSubmission $taskSubmission): void
    {
        $countrySettings = CountrySetting::where('country_id', $taskSubmission->task->user->country_id)->first();

        if ($countrySettings && isset($countrySettings->referral_settings['task_referral_commission_percentage'])) {
            $commissionRate = $countrySettings->referral_settings['task_referral_commission_percentage'];

            if ($commissionRate > 0) {
                $commission = ($taskSubmission->task->budget_per_submission * $commissionRate) / 100;

                DB::beginTransaction();
                try {
                    $wallet = Wallet::where('user_id', $referral->user_id)
                        ->where('currency', $taskSubmission->task->user->currency)
                        ->lockForUpdate()
                        ->first();

                    if (!$wallet) {
                        $wallet = new Wallet([
                            'user_id' => $referral->user_id,
                            'currency' => $taskSubmission->task->user->currency,
                            'balance' => 0
                        ]);
                    }

                    $wallet->balance += $commission;
                    $wallet->save();

                    Settlement::create([
                        'user_id' => $referral->user_id,
                        'description' => 'Task referral earning',
                        'amount' => $commission,
                        'currency' => $taskSubmission->task->user->currency,
                        'status' => 'paid',
                        'settlementable_id' => $referral->id,
                        'settlementable_type' => Referral::class,
                    ]);

                    // Update referral status to completed
                    $referral->status = 'completed';
                    $referral->save();

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
            }
        }
    }

    public function refundTaskPayment(Task $task): void
    {
        // Logic to refund the task payment to the task creator
        $refund_total = $task->budget_per_submission * $task->number_of_submissions;
        $number_of_admin_revision = $task->taskSubmissions()->where('reviewed_by', '!=', $task->user_id)->count();
        $deductible_amount = $number_of_admin_revision * $task->budget_per_submission;
        $final_refund_amount = $refund_total - $deductible_amount;
        if($final_refund_amount <= 0) {
            return;
        }
        DB::beginTransaction();
        try {
            $wallet = Wallet::where('user_id', $task->user_id)
                ->where('currency', $task->user->currency)
                ->lockForUpdate()
                ->first();

            if (!$wallet) {
                $wallet = new Wallet([
                    'user_id' => $task->user_id,
                    'currency' => $task->user->currency,
                    'balance' => 0
                ]);
            }

            $wallet->balance += $final_refund_amount;
            $wallet->save();

            Settlement::create([
                'user_id' => $task->user_id,
                'description' => 'Task Review refund',
                'amount' => $final_refund_amount,
                'currency' => $task->user->currency,
                'status' => 'paid',
                'settlementable_id' => $task->id,
                'settlementable_type' => Task::class
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
                
        // Refund logic here
    }

    /**
     * Handle the TaskSubmission "deleted" event.
     */
    public function deleted(TaskSubmission $taskSubmission): void
    {
        //
    }

    /**
     * Handle the TaskSubmission "restored" event.
     */
    public function restored(TaskSubmission $taskSubmission): void
    {
        //
    }

    /**
     * Handle the TaskSubmission "force deleted" event.
     */
    public function forceDeleted(TaskSubmission $taskSubmission): void
    {
        //
    }
}
