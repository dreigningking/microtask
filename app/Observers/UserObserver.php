<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Country;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $country = Country::find($user->country_id);
        Wallet::create(['user_id'=> $user->id,'balance'=> 0,'currency'=> $country->currency,'is_frozen'=> false]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
