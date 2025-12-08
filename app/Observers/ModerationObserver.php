<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Moderation;
use App\Http\Traits\HelperTrait;
use App\Notifications\General\Moderation\PostModerationNotification;
use App\Notifications\General\Moderation\TaskModerationNotification;
use App\Notifications\General\Moderation\BankAccountModerationNotification;
use App\Notifications\General\Moderation\PostCommentModerationNotification;
use App\Notifications\General\Moderation\UserVerificationModerationNotification;


class ModerationObserver
{
    use HelperTrait;
    /**
     * Handle the Moderation "created" event.
     */
    public function created(Moderation $moderation): void {
        switch ($moderation->moderatable_type) {
            case ('App\Models\Task'):
                $this->getAdmin()->notify(new TaskModerationNotification($moderation,'admin'));
            break;
            case ('App\Models\Post'):
                $this->getAdmin()->notify(new PostModerationNotification($moderation,'admin'));
            break;
            case ('App\Models\Comment'):
                $this->getAdmin()->notify(new PostCommentModerationNotification($moderation,'admin'));
            break;
            case('App\Models\UserVerification'):
                $this->getAdmin()->notify(new UserVerificationModerationNotification($moderation,'admin'));
            break;
            case('App\Models\BankAccount'):
                $this->getAdmin()->notify(new BankAccountModerationNotification($moderation,'admin'));
            break;
        }
    }

    

    /**
     * Handle the Moderation "updated" event.
     */
    public function updated(Moderation $moderation): void
    {
        if ($moderation->isDirty('status')) {
            switch ($moderation->moderatable_type) {
                case ('App\Models\Task'):
                    $moderation->moderatable->user->notify(new TaskModerationNotification($moderation,'author'));
                    break;
                case ('App\Models\Post'):
                    $moderation->moderatable->user->notify(new PostModerationNotification($moderation,'author'));
                    break;
                case ('App\Models\Comment'):
                    if($moderation->status == 'approved'){
                        if($moderation->moderatable->parent_id){
                            //notify the parent of the comment
                            $moderation->moderatable->parent->user->notify(new PostCommentModerationNotification($moderation,'parent'));
                        }
                    }
                    $moderation->moderatable->user->notify(new PostCommentModerationNotification($moderation,'author'));
                    break;
                case('App\Models\UserVerification'):
                        $moderation->moderatable->user->notify(new UserVerificationModerationNotification($moderation,'author'));
                    break;
                case('App\Models\BankAccount'):
                        $moderation->moderatable->user->notify(new BankAccountModerationNotification($moderation,'author'));
                    break;
            }
        }
    }

    /**
     * Handle the Moderation "deleted" event.
     */
    public function deleted(Moderation $moderation): void
    {
        //
    }

    /**
     * Handle the Moderation "restored" event.
     */
    public function restored(Moderation $moderation): void
    {
        //
    }

    /**
     * Handle the Moderation "force deleted" event.
     */
    public function forceDeleted(Moderation $moderation): void
    {
        //
    }
}
