<?php

use App\Livewire\Welcome;
use App\Livewire\Boosters;
use App\Livewire\AboutPage;
use App\Livewire\Dashboard;
use App\Livewire\TopEarners;
use App\Livewire\ContactPage;
use App\Livewire\JobCreators;
use App\Livewire\InviteesList;
use App\Livewire\ListEarnings;
use App\Livewire\Transactions;
use App\Livewire\Blog\BlogIndex;
use App\Livewire\Tasks\TaskEdit;
use App\Livewire\Tasks\TaskList;
use App\Livewire\Tasks\TaskShow;
use App\Livewire\Blog\BlogSingle;
use App\Livewire\Support\Tickets;
use App\Livewire\Settings\Profile;
use App\Livewire\Tasks\TaskCreate;
use App\Livewire\Tasks\TaskManage;
use App\Livewire\Tasks\PostedTasks;
use App\Livewire\Settings\Interests;
use App\Livewire\Support\TicketView;
use App\Livewire\Tasks\AppliedTasks;
use App\Livewire\Policies\Disclaimer;
use Illuminate\Support\Facades\Route;
use App\Livewire\Settings\BankAccounts;
use App\Http\Controllers\HomeController;
use App\Livewire\Policies\PrivacyPolicy;
use App\Livewire\Settings\Verifications;
use App\Http\Controllers\PaymentController;
use App\Livewire\Policies\DigitalMillenium;
use App\Livewire\Policies\TermsAndConditions;
use App\Livewire\Tasks\TaskSubmissionDispute;
use App\Livewire\Notifications\ListNotifications;
use App\Livewire\Policies\PaymentDisputeChargebacks;
use App\Livewire\Settings\DeleteAccount;

Route::get('run', function () {
    $countries = \App\Models\CountrySetting::all();
    
    return 'done';
});
// Route::get('payment/test', [PaymentController::class, 'test']);

Route::get('/', Welcome::class)->name('index');
Route::get('about', AboutPage::class)->name('about');
Route::get('browse', TaskList::class)->name('explore');
Route::get('task/{task}', TaskShow::class)->name('explore.task');
Route::get('creators', JobCreators::class)->name('creators');

Route::get('contact', ContactPage::class)->name('contact');
Route::get('blog', BlogIndex::class)->name('blog');
Route::get('blog/post/{post}', BlogSingle::class)->name('blog.show');
Route::group(['as' => 'legal.'], function () {
    Route::get('disclaimer', Disclaimer::class)->name('disclaimer');
    Route::get('privacy-policy', PrivacyPolicy::class)->name('privacy-policy');
    Route::get('terms-and-conditions', TermsAndConditions::class)->name('terms-conditions');
    Route::get('digital-millenium-copyright-act', DigitalMillenium::class)->name('dcma');
    Route::get('payment-dispute-chargeback-protection-policy', PaymentDisputeChargebacks::class)->name('payment-chargeback');
});

Route::get('top-earners', TopEarners::class)->name('top_earners');
Route::view('review', 'post-job-review');



Route::group(['middleware' => ['auth', 'check_user_active']], function () {
    Route::group(['middleware' => ['email_verified', 'two_factor']], function () {
        /* Task Worker */
        Route::group(['prefix' => 'tasks', 'as' => 'tasks.'], function () {
            Route::get('applied', AppliedTasks::class)->name('applied');
            Route::get('posted', PostedTasks::class)->name('posted');
            Route::get('create', TaskCreate::class)->name('create');
            Route::get('edit/{task}', TaskEdit::class)->name('edit');
            Route::get('manage/{task}', TaskManage::class)->name('manage');
            Route::get('dispute/{taskSubmission}', TaskSubmissionDispute::class)->name('dispute');
        });
        /* Earnings */
        Route::group(['prefix' => 'earnings', 'as' => 'earnings.'], function () {
            Route::get('settlements', ListEarnings::class)->name('settlements');
            Route::get('withdrawals', ListEarnings::class)->name('withdrawals');
            Route::get('exchanges', ListEarnings::class)->name('exchanges');
        });
        /* General */
        Route::get('notifications', ListNotifications::class)->name('notifications');
        Route::get('dashboard', Dashboard::class)->name('dashboard');
        Route::get('invitees', InviteesList::class)->name('invitees');
        Route::get('transactions', Transactions::class)->name('transactions');
        Route::get('payment/callback', [PaymentController::class, 'paymentcallback'])->name('payment.callback');
        Route::get('account-booster', Boosters::class)->name('boosters');
        
        Route::get('profile', Profile::class)->name('profile');
        Route::get('profile/bank-account', BankAccounts::class)->name('profile.bank-account');
        Route::get('profile/verifications', Verifications::class)->name('profile.verifications');
        Route::get('profile/interests', Interests::class)->name('profile.interests');
        Route::get('profile/security', Interests::class)->name('profile.security');
        Route::get('profile/notifications', Interests::class)->name('profile.notifications');
        Route::get('profile/delete', DeleteAccount::class)->name('profile.delete');
        

        Route::get('support', Tickets::class)->name('support');
        Route::get('support/ticket/{ticket}', TicketView::class)->name('support.ticket');
    });
});


require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';

Route::get('/home', [HomeController::class, 'index'])->name('home');
