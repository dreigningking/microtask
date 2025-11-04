<?php

namespace App\Observers;

use App\Models\Moderation;
use App\Models\Comment;

class CommentObserver
{
    /**
     * Handle the Comment "created" event.
     */
    public function created(Comment $comment): void
    {
        Moderation::create(['moderatable_type'=> get_class($comment),'moderatable_id'=> $comment->id,
        'purpose'=> 'created_content','status'=> 'pending']);
    }

    /**
     * Handle the Comment "updated" event.
     */
    public function updated(Comment $comment): void
    {
        Moderation::create(['moderatable_type'=> get_class($comment),'moderatable_id'=> $comment->id,
        'purpose'=> 'updated_content','status'=> 'pending']);
    }

    /**
     * Handle the Comment "deleted" event.
     */
    public function deleted(Comment $comment): void
    {
        //
    }

    /**
     * Handle the Comment "restored" event.
     */
    public function restored(Comment $comment): void
    {
        //
    }

    /**
     * Handle the Comment "force deleted" event.
     */
    public function forceDeleted(Comment $comment): void
    {
        //
    }
}
