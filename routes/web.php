<?php

use App\Livewire\Explore;
use App\Livewire\Welcome;
use App\Livewire\AboutPage;
use App\Livewire\Dashboard;
use App\Livewire\TopEarners;
use App\Livewire\ContactPage;
use App\Livewire\Jobs\EditJob;
use App\Livewire\Jobs\PostJob;
use App\Livewire\Jobs\ViewJob;
use App\Livewire\Transactions;
use App\Livewire\Jobs\ListJobs;
use App\Livewire\Subscriptions;
use App\Livewire\Blog\BlogIndex;
use App\Livewire\Tasks\ShowPage;
use App\Livewire\Tasks\ViewTask;
use App\Livewire\Blog\BlogSingle;
use App\Livewire\Tasks\ListTasks;
use App\Http\Traits\PaystackTrait;
use App\Livewire\Settings\Profile;
use App\Livewire\Policies\Disclaimer;
use Illuminate\Support\Facades\Route;
use App\Livewire\Earnings\ListEarnings;
use App\Livewire\Payments\UserPayments;
use App\Livewire\Policies\PrivacyPolicy;
use App\Livewire\Referrals\InviteesList;
use App\Http\Controllers\PaymentController;
use App\Livewire\Policies\DigitalMillenium;
use App\Livewire\Policies\TermsAndConditions;
use App\Livewire\Notifications\ListNotifications;
use App\Livewire\Policies\PaymentDisputeChargebacks;
use App\Notifications\WelcomeNotification;

Route::get('test',function(){
    $country = \App\Models\Country::find(161);
    dd($country->status);
    // $template = \App\Models\TaskTemplate::find(1);
    // dd($template->prices->firstWhere('country_id',$country->id));
    return 'done';
});
Route::get('/', Welcome::class)->name('index');
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
    Route::get('my-jobs/edit/{task}', EditJob::class)->name('my_jobs.edit');
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
