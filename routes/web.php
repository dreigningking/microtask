<?php

use App\Livewire\LandingArea\Welcome;
use Illuminate\Support\Facades\Route;
use App\Livewire\LandingArea\AboutPage;
use App\Livewire\LandingArea\TopEarners;
use App\Livewire\DashboardArea\Dashboard;
use App\Livewire\LandingArea\ContactPage;
use App\Livewire\LandingArea\JobCreators;
use App\Http\Controllers\PaymentController;
use App\Livewire\DashboardArea\Jobs\EditJob;
use App\Livewire\DashboardArea\Jobs\PostJob;
use App\Livewire\DashboardArea\Jobs\ViewJob;
use App\Livewire\DashboardArea\Transactions;
use App\Livewire\LandingArea\Blog\BlogIndex;
use App\Livewire\DashboardArea\Jobs\ListJobs;
use App\Livewire\DashboardArea\Subscriptions;
use App\Livewire\LandingArea\Blog\BlogSingle;
use App\Livewire\DashboardArea\Tasks\ViewTask;
use App\Livewire\DashboardArea\Support\Tickets;
use App\Livewire\DashboardArea\Tasks\ListTasks;
use App\Livewire\DashboardArea\Settings\Profile;
use App\Livewire\LandingArea\Policies\Disclaimer;
use App\Livewire\LandingArea\Policies\PrivacyPolicy;
use App\Livewire\DashboardArea\Earnings\ListEarnings;
use App\Livewire\DashboardArea\Payments\UserPayments;
use App\Livewire\DashboardArea\Referrals\InviteesList;
use App\Livewire\LandingArea\Policies\DigitalMillenium;
use App\Livewire\LandingArea\Policies\TermsAndConditions;
use App\Livewire\LandingArea\ExploreTasks\ExploreTaskList;
use App\Livewire\LandingArea\ExploreTasks\ExploreTaskShow;
use App\Livewire\DashboardArea\Notifications\ListNotifications;
use App\Livewire\LandingArea\Policies\PaymentDisputeChargebacks;

Route::get('/', Welcome::class)->name('index');
Route::get('explore', ExploreTaskList::class)->name('explore');
Route::get('explore/{task}',ExploreTaskShow::class)->name('explore.task');
Route::get('creators', JobCreators::class)->name('creators');
Route::get('about', AboutPage::class)->name('about');
Route::get('contact', ContactPage::class)->name('contact');
Route::get('blog', BlogIndex::class)->name('blog');
Route::get('blog/post/{post}', BlogSingle::class)->name('blog.show');
Route::group(['as'=> 'legal.'],function(){
    Route::get('disclaimer', Disclaimer::class)->name('disclaimer');
    Route::get('privacy-policy', PrivacyPolicy::class)->name('privacy-policy');
    Route::get('terms-and-conditions', TermsAndConditions::class)->name('terms-conditions');
    Route::get('digital-millenium-copyright-act', DigitalMillenium::class)->name('dcma');
    Route::get('payment-dispute-chargeback-protection-policy', PaymentDisputeChargebacks::class)->name('payment-chargeback');
});

Route::get('top-earners', TopEarners::class)->name('top_earners');
Route::view('review','post-job-review');



Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => ['email_verified','two_factor']], function () {
        /* Task Master */
        Route::group(['prefix' => 'jobs','as'=>'jobs.'], function () {
            Route::get('/', ListJobs::class)->name('index');
            Route::get('view/{task}', ViewJob::class)->name('view');
            Route::get('create', PostJob::class)->name('create');
            Route::get('edit/{task}', EditJob::class)->name('edit');
        });

        /* Task Worker */
        Route::group(['prefix' => 'tasks','as'=>'tasks.'], function () {
            Route::get('/', ListTasks::class)->name('index');
            Route::get('view/{task}', ViewTask::class)->name('view');
        });

        Route::get('earnings', ListEarnings::class)->name('earnings');

        /* General */
        Route::get('notifications', ListNotifications::class)->name('notifications');
        Route::get('dashboard', Dashboard::class)->name('dashboard');
        Route::get('profile', Profile::class)->name('profile');
        Route::get('invitees',InviteesList::class)->name('invitees');
        Route::get('payments',UserPayments::class)->name('payments');
        Route::get('payment/callback',[PaymentController::class,'paymentcallback'])->name('payment.callback');
        Route::get('subscriptions', Subscriptions::class)->name('subscriptions');
        Route::get('transactions', Transactions::class)->name('transactions');
        Route::get('support', Tickets::class)->name('support');
    });
});


require __DIR__.'/auth.php';
require __DIR__.'/admin.php';

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
