<?php

use GuzzleHttp\Client;
use App\Livewire\Welcome;
use App\Livewire\Boosters;
use App\Livewire\Dashboard;
use GuzzleHttp\Psr7\Request;
use Ixudra\Curl\Facades\Curl;
use App\Livewire\Transactions;
use App\Livewire\Blog\BlogIndex;
use App\Livewire\Tasks\TaskEdit;
use App\Livewire\Tasks\TaskList;
use App\Livewire\Tasks\TaskShow;
use App\Livewire\Blog\BlogSingle;
use App\Livewire\Settings\Profile;
use App\Livewire\Tasks\TaskCreate;
use App\Livewire\Tasks\TaskManage;
use App\Livewire\Tasks\PostedTasks;
use App\Livewire\Tasks\TaskDispute;
use App\Livewire\Tasks\AppliedTasks;
use Illuminate\Support\Facades\Route;
use App\Livewire\LandingArea\AboutPage;
use App\Http\Controllers\HomeController;
use App\Livewire\LandingArea\TopEarners;
use App\Livewire\LandingArea\ContactPage;
use App\Livewire\LandingArea\JobCreators;
use App\Http\Controllers\PaymentController;
use App\Livewire\DashboardArea\Support\Tickets;
use App\Livewire\LandingArea\Policies\Disclaimer;
use App\Livewire\DashboardArea\Support\TicketView;
use App\Livewire\LandingArea\Policies\PrivacyPolicy;
use App\Livewire\DashboardArea\Earnings\ListEarnings;
use App\Livewire\DashboardArea\Referrals\InviteesList;
use App\Livewire\LandingArea\Policies\DigitalMillenium;
use App\Livewire\LandingArea\Policies\TermsAndConditions;
use App\Livewire\DashboardArea\Notifications\ListNotifications;
use App\Livewire\LandingArea\Policies\PaymentDisputeChargebacks;
use App\Models\CountrySetting;


Route::get('run', function () {
    $settings = CountrySetting::all();
    foreach($settings as $setting){
        $setting->banking_settings = json_decode($setting->banking_settings);
        $setting->banking_fields = json_decode($setting->banking_fields);
        $setting->verification_fields = json_decode($setting->verification_fields);
        $setting->verification_settings = json_decode($setting->verification_settings);
        $setting->promotion_settings = json_decode($setting->promotion_settings);
        $setting->transaction_settings = json_decode($setting->transaction_settings);
        $setting->withdrawal_settings = json_decode($setting->withdrawal_settings);
        $setting->wallet_settings = json_decode($setting->wallet_settings);
        $setting->referral_settings = json_decode($setting->referral_settings);
        $setting->review_settings = json_decode($setting->review_settings);
        $setting->security_settings = json_decode($setting->security_settings);  
        $setting->save();
    }
    return 'done';
});

Route::get('/', Welcome::class)->name('index');
Route::get('browse', TaskList::class)->name('explore');
Route::get('task/{task}', TaskShow::class)->name('explore.task');
Route::get('creators', JobCreators::class)->name('creators');
Route::get('about', AboutPage::class)->name('about');
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
            Route::get('dispute/{task}', TaskDispute::class)->name('dispute');
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
        Route::get('profile', Profile::class)->name('profile');
        Route::get('invitees', InviteesList::class)->name('invitees');
        Route::get('transactions', Transactions::class)->name('transactions');
        Route::get('payment/callback', [PaymentController::class, 'paymentcallback'])->name('payment.callback');
        Route::get('account-booster', Boosters::class)->name('boosters');

        Route::get('support', Tickets::class)->name('support');
        Route::get('support/ticket/{ticket}', TicketView::class)->name('support.ticket');
    });
});


require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';

Route::get('/home', [HomeController::class, 'index'])->name('home');
