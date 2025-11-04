<?php

namespace App\Observers;

use App\Models\Payment;
use App\Jobs\BroadcastTaskJob;
use App\Models\TaskPromotion;

class PaymentObserver
{
    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "updated" event.
     */
    public function updated(Payment $payment): void
    {
        if ($payment->isDirty('status') && $payment->status === 'success') {
            
            $order = $payment->order;
            if (!$order){
                return;
            } 
            
            foreach ($order->items as $index => $item) {
                // if(!$index) continue;
                // dd($item);
                if ($item->orderable_type === 'App\Models\TaskPromotion') {
                    $promotion = TaskPromotion::find($item->orderable_id);
                    if ($promotion && $promotion->type === 'broadcast') {
                        dispatch(new BroadcastTaskJob($promotion));
                    }
                }
            }
        }
    }

    /**
     * Handle the Payment "deleted" event.
     */
    public function deleted(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "restored" event.
     */
    public function restored(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     */
    public function forceDeleted(Payment $payment): void
    {
        //
    }
}
