<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EarningController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\CountrySettingsController;

Route::group(['prefix' => 'admin','as'=> 'admin.'], function () {
    Auth::routes();
    // Route::view('dashboard', 'backend.dashboard')->name('dashboard');
    // Route::view('users', 'backend.users')->name('users');
    // Route::view('jobs', 'backend.jobs')->name('jobs');
    // // Route::view('tasks', 'backend.tasks')->name('tasks');
    // Route::view('earnings', 'backend.earnings')->name('earnings');
    // Route::view('withdrawals', 'backend.withdrawals')->name('withdrawals');
    // Route::view('notifications', 'backend.notifications')->name('notifications');
    // Route::view('profile', 'backend.profile')->name('profile');
    // Route::view('settings', 'backend.settings')->name('settings');
});

Route::group(['prefix' => 'admin','as' => 'admin.','middleware'=> 'auth'], function () {
    
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::group(['prefix' => 'tasks','as' => 'tasks.'], function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::get('promotions', [TaskController::class, 'promotions'])->name('promotions');
        Route::get('view/{task}', [TaskController::class, 'show'])->name('show');
        Route::post('approve', [TaskController::class, 'approve'])->name('approve');
        Route::post('disapprove', [TaskController::class, 'disapprove'])->name('disapprove');
        Route::post('delete', [TaskController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'earnings','as' => 'earnings.'], function () {
        Route::get('/', [EarningController::class, 'earnings'])->name('index');
    });
    Route::group(['prefix' => 'exchanges','as' => 'exchanges.'], function () {
        Route::get('/', [EarningController::class, 'exchanges'])->name('index');
    });
    Route::group(['prefix' => 'payments','as' => 'payments.'], function () {
        Route::get('/', [EarningController::class, 'payments'])->name('index');
    });
    Route::group(['prefix' => 'withdrawals','as' => 'withdrawals.'],function(){
        Route::get('/', [EarningController::class, 'withdrawals'])->name('index');
        Route::get('view/{withdrawal}', [EarningController::class, 'withdrawal_view'])->name('view');
        Route::post('withdrawal/process', [EarningController::class, 'withdrawal_process'])->name('process');
        Route::post('/{id}/approve', [EarningController::class, 'approveWithdrawal'])->name('approve');
        Route::post('/{id}/disapprove', [EarningController::class, 'disapproveWithdrawal'])->name('disapprove');
    });
    
    Route::group(['prefix' => 'users','as' => 'users.'], function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('verifications', [UserController::class, 'verifications'])->name('verifications');
        Route::post('verifications/approve', [UserController::class, 'approveVerification'])->name('verifications.approve');
        Route::post('verifications/reject', [UserController::class, 'rejectVerification'])->name('verifications.reject');

        Route::get('show/{user}', [UserController::class, 'show'])->name('show');
        Route::post('suspend', [UserController::class, 'suspend'])->name('suspend');
        Route::post('delete', [UserController::class, 'destroy'])->name('delete');
        Route::post('wallet', [UserController::class, 'wallet'])->name('wallet.toggle');
    });

    Route::group(['prefix' => 'blog','as' => 'blog.'], function () {
        Route::get('/', [BlogController::class, 'index'])->name('index');
        Route::get('create', [BlogController::class, 'create'])->name('create');
        Route::get('edit/{post}', [BlogController::class, 'edit'])->name('edit');
        Route::post('store', [BlogController::class, 'store'])->name('store');
        Route::post('update', [BlogController::class, 'update'])->name('update');
        Route::post('delete', [BlogController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'settings','as' => 'settings.'], function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('core', [SettingController::class, 'saveCoreSettings'])->name('core.save');
        Route::post('notifications', [SettingController::class, 'saveNotificationSettings'])->name('notifications.save');
        Route::post('roles', [SettingController::class, 'storeRole'])->name('roles.store');
        Route::put('roles/{role}', [SettingController::class, 'updateRole'])->name('roles.update');
        Route::delete('roles/{role}', [SettingController::class, 'destroyRole'])->name('roles.destroy');

        Route::post('staff', [SettingController::class, 'staffStore'])->name('staff.store');
        Route::put('staff/{user}', [SettingController::class, 'staffUpdate'])->name('staff.update');
        Route::delete('staff/{user}', [SettingController::class, 'staffDestroy'])->name('staff.destroy');

        Route::get('plans', [SettingController::class, 'plans'])->name('plans');
        Route::post('plans/store', [SettingController::class, 'store_plans'])->name('plans.store');
        Route::post('plans/update', [SettingController::class, 'update_plans'])->name('plans.update');
        Route::post('plans/delete', [SettingController::class, 'destroy_plans'])->name('plans.destroy');

        Route::get('/templates', [SettingController::class, 'templates'])->name('templates');
        Route::post('templates/store', [SettingController::class, 'store_templates'])->name('templates.store');
        Route::post('templates/update', [SettingController::class, 'update_templates'])->name('templates.update');
        Route::post('templates/delete', [SettingController::class, 'destroy_templates'])->name('templates.destroy');
        
        Route::get('/platforms', [SettingController::class, 'platforms'])->name('platforms');
        Route::post('platforms/store', [SettingController::class, 'store_platforms'])->name('platforms.store');
        Route::post('platforms/update', [SettingController::class, 'update_platforms'])->name('platforms.update');
        Route::post('platforms/delete', [SettingController::class, 'destroy_platforms'])->name('platforms.destroy');
        
        Route::get('countries', [CountrySettingsController::class, 'countries'])->name('countries');
        Route::get('country/config/{country}', [CountrySettingsController::class, 'country'])->name('country');
        Route::post('countries/banking', [CountrySettingsController::class, 'saveBanking'])->name('countries.banking');
        Route::post('countries/transactions', [CountrySettingsController::class, 'saveTransactions'])->name('countries.transactions');
        Route::post('countries/tasks', [CountrySettingsController::class, 'saveTasks'])->name('countries.tasks');
        Route::post('countries/notification-emails', [CountrySettingsController::class, 'saveNotificationEmails'])->name('countries.notification_emails');
        Route::post('countries/template-prices', [CountrySettingsController::class, 'saveTemplatePrices'])->name('countries.template_prices');
        Route::post('countries/plan-prices', [CountrySettingsController::class, 'savePlanPrices'])->name('countries.plan_prices');
        Route::post('countries/verification-settings', [CountrySettingsController::class, 'saveVerificationSettings'])->name('countries.verification_settings');
        
    });


    
});