<?php

namespace App\Observers;

use App\Models\CountrySetting;
use App\Models\Referral;
use App\Models\Settlement;
use App\Models\TaskWorker;
use App\Models\User;

class TaskWorkerObserver
{
    /**
     * Handle the TaskWorker "created" event.
     */
    public function created(TaskWorker $taskWorker): void
    {
        //
    }

    /**
     * Handle the TaskWorker "updated" event.
     */
    public function updated(TaskWorker $taskWorker): void
    {
        
    }

    /**
     * Handle the TaskWorker "deleted" event.
     */
    public function deleted(TaskWorker $taskWorker): void
    {
        //
    }

    /**
     * Handle the TaskWorker "restored" event.
     */
    public function restored(TaskWorker $taskWorker): void
    {
        //
    }

    /**
     * Handle the TaskWorker "force deleted" event.
     */
    public function forceDeleted(TaskWorker $taskWorker): void
    {
        //
    }
} 