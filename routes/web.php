<?php

use App\Livewire\Explore;
use App\Livewire\Welcome;
use App\Livewire\Dashboard;
use App\Livewire\TopEarners;
use App\Livewire\Jobs\PostJob;
use App\Livewire\Jobs\ViewJob;
use App\Livewire\Transactions;
use App\Livewire\Jobs\ListJobs;
use App\Livewire\Subscriptions;
use App\Livewire\Tasks\ShowPage;
use App\Livewire\Tasks\ViewTask;
use App\Livewire\Tasks\ListTasks;
use App\Http\Traits\PaystackTrait;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Earnings\ListEarnings;
use App\Livewire\Payments\UserPayments;
use App\Livewire\Referrals\InviteesList;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Notification;
use App\Livewire\Notifications\ListNotifications;
use App\Notifications\UrgentTaskPromotionNotification;

Route::get('test',function(){
    $promotion = \App\Models\TaskPromotion::find(8);
        if (!$promotion) return 'no promotion';
        $task = $promotion->task;
        if (!$task) return 'no tasks';
        $platformId = $task->platform_id;
        $countryId = $task->user->country_id;

        // Step 5: user_location
        $userLocationIds = \App\Models\UserLocation::where('country_id', $countryId)->pluck('user_id')->toArray();
        if (empty($userLocationIds)) return 'no location ids';
        // Step 6: platform_user
        $platformUserIds = \App\Models\PlatformUser::where('platform_id', $platformId)->pluck('user_id')->toArray();
        if (empty($platformUserIds)) return 'no platform ids';
        // Step 7: intersection
        $notifyUserIds = array_values(array_intersect($userLocationIds, $platformUserIds));
        if (empty($notifyUserIds)) return 'no user to notify';
        // Step 8: notify
        $users = \App\Models\User::whereIn('id', $notifyUserIds)->get();
        Notification::send($users, new UrgentTaskPromotionNotification($task));
    return 'done';
});
Route::get('/', Welcome::class)->name('index');
Route::get('explore', Explore::class)->name('explore');
Route::get('explore/{task}',ShowPage::class)->name('explore.task');
Route::get('top-earners', TopEarners::class)->name('top_earners');
Route::view('review','post-job-review');
Route::get('post-job', PostJob::class)->name('post_job');
Route::group(['middleware' => 'auth'], function () {
    // Route::get('home', Home::class)->name('home');
    Route::get('my-tasks', ListTasks::class)->name('my_tasks');
    Route::get('my-tasks/{task}', ViewTask::class)->name('my_tasks.view');

    Route::get('my-jobs', ListJobs::class)->name('my_jobs');
    Route::get('my-jobs/{task}', ViewJob::class)->name('my_jobs.view');
    Route::get('my-jobs/edit/{task}', PostJob::class)->name('my_jobs.edit');
    Route::get('my-earnings', ListEarnings::class)->name('my_earnings');
    Route::get('notifications', ListNotifications::class)->name('notifications');
    Route::get('dashboard', Dashboard::class)->name('dashboard');
    Route::get('profile', Profile::class)->name('profile');
    Route::get('invitees',InviteesList::class)->name('invitees');
    Route::get('payments',UserPayments::class)->name('payments');
    Route::get('payment/callback',[PaymentController::class,'paymentcallback'])->name('payment.callback');
    Route::get('subscriptions', Subscriptions::class)->name('subscriptions');
    Route::get('transactions', Transactions::class)->name('transactions');
});


require __DIR__.'/auth.php';
require __DIR__.'/admin.php';

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
