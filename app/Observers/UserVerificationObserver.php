<?php

namespace App\Observers;

use App\Models\Moderation;
use App\Models\UserVerification;

class UserVerificationObserver
{
    /**
     * Handle the UserVerification "created" event.
     */
    public function created(UserVerification $user_verification): void
    {
        Moderation::create(['moderatable_type'=> get_class($user_verification),'moderatable_id'=> $user_verification->id,
        'purpose'=> 'created_user_verification','status'=> 'pending']);
    }

    /**
     * Handle the UserVerification "updated" event.
     */
    public function updated(UserVerification $user_verification): void
    {
        Moderation::create(['moderatable_type'=> get_class($user_verification),'moderatable_id'=> $user_verification->id,
        'purpose'=> 'updated_user_verification','status'=> 'pending']);
    }

    /**
     * Handle the UserVerification "deleted" event.
     */
    public function deleted(UserVerification $user_verification): void
    {
        //
    }

    /**
     * Handle the UserVerification "restored" event.
     */
    public function restored(UserVerification $user_verification): void
    {
        //
    }

    /**
     * Handle the UserVerification "force deleted" event.
     */
    public function forceDeleted(UserVerification $user_verification): void
    {
        //
    }
}
