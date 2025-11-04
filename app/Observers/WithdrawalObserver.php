<?php

namespace App\Observers;

use App\Models\Moderation;
use App\Models\Withdrawal;

class WithdrawalObserver
{
    /**
     * Handle the Withdrawal "created" event.
     */
    public function created(Withdrawal $withdrawal): void
    {
        Moderation::create(['moderatable_type'=> get_class($withdrawal),'moderatable_id'=> $withdrawal->id,
        'purpose'=> 'created_content','status'=> 'pending']);
    }

    /**
     * Handle the Withdrawal "updated" event.
     */
    public function updated(Withdrawal $withdrawal): void
    {
        Moderation::create(['moderatable_type'=> get_class($withdrawal),'moderatable_id'=> $withdrawal->id,
        'purpose'=> 'updated_content','status'=> 'pending']);
    }

    /**
     * Handle the Withdrawal "deleted" event.
     */
    public function deleted(Withdrawal $withdrawal): void
    {
        //
    }

    /**
     * Handle the Withdrawal "restored" event.
     */
    public function restored(Withdrawal $withdrawal): void
    {
        //
    }

    /**
     * Handle the Withdrawal "force deleted" event.
     */
    public function forceDeleted(Withdrawal $withdrawal): void
    {
        //
    }
}
