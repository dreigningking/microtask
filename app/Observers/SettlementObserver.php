<?php

namespace App\Observers;

use App\Models\Settlement;
use Illuminate\Support\Facades\DB;
use App\Notifications\TaskWorker\EarningsNotification;

class SettlementObserver
{
    /**
     * Handle the Settlement "created" event.
     */
    public function created(Settlement $settlement): void
    {
        $user = $settlement->user;
        $currency = $settlement->currency;
        $amount = (float) $settlement->amount;

        DB::transaction(function () use ($user, $currency, $amount) {
            $wallet = $user->wallets()->where('currency', $currency)->lockForUpdate()->first();
            if ($wallet) {
                $wallet->increment('balance', $amount);
            } else {
                $user->wallets()->create([
                    'currency' => $currency,
                    'balance' => $amount,
                ]);
            }
        });

        // Send earnings notification
        $description = $this->getEarningDescription($settlement);
        $user->notify(new EarningsNotification($amount, $currency, $description));
    }

    /**
     * Handle the Settlement "updated" event.
     */
    public function updated(Settlement $settlement): void
    {
        //
    }

    /**
     * Handle the Settlement "deleted" event.
     */
    public function deleted(Settlement $settlement): void
    {
        //
    }

    /**
     * Handle the Settlement "restored" event.
     */
    public function restored(Settlement $settlement): void
    {
        //
    }

    /**
     * Handle the Settlement "force deleted" event.
     */
    public function forceDeleted(Settlement $settlement): void
    {
        //
    }

    /**
     * Get a description of the earning based on the settlement type
     */
    private function getEarningDescription(Settlement $settlement): string
    {
        $type = $settlement->settlementable_type;
        
        if (str_contains($type, 'Referral')) {
            return 'Referral Bonus';
        } elseif (str_contains($type, 'Task')) {
            $task = $settlement->settlementable;
            return $task ? 'Task: ' . $task->title : 'Task Completion';
        }
        
        return 'Earning';
    }
}
