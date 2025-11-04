<?php

namespace App\Observers;

use App\Models\Moderation;
use App\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        Moderation::create(['moderatable_type'=> get_class($post),'moderatable_id'=> $post->id,
        'purpose'=> 'created_content','status'=> 'pending']);
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        Moderation::create(['moderatable_type'=> get_class($post),'moderatable_id'=> $post->id,
        'purpose'=> 'updated_content','status'=> 'pending']);
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        //
    }
}
