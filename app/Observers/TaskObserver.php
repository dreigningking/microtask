<?php

namespace App\Observers;

use App\Models\Moderation;
use App\Models\Task;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        Moderation::create(['moderatable_type'=> get_class($task),'moderatable_id'=> $task->id,
        'purpose'=> 'created_task','status'=> 'pending']);
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        Moderation::create(['moderatable_type'=> get_class($task),'moderatable_id'=> $task->id,
        'purpose'=> 'updated_task','status'=> 'pending']);
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
