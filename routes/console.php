<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\TaskSubmissionReviewByAdminJob;
use App\Jobs\SubscriptionExpiringNotificationJob;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new TaskSubmissionReviewByAdminJob)->hourly();
Schedule::job(new SubscriptionExpiringNotificationJob)->hourly();