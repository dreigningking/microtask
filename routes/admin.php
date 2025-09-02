<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\EarningController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\CountrySettingsController;
use App\Http\Controllers\AnnouncementController;

Route::group(['prefix' => 'admin','as'=> 'admin.'], function () {
    Auth::routes();
});

Route::group(['prefix' => 'admin','as' => 'admin.','middleware'=> ['auth','check_user_active']], function () {
    
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::group(['prefix' => 'tasks','as' => 'tasks.','middleware' => ['permission:task_management']], function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::get('promotions', [PromotionController::class, 'index'])->name('promotions');
        Route::get('view/{task}', [TaskController::class, 'show'])->name('show');
        Route::post('approve', [TaskController::class, 'approve'])->name('approve');
        Route::post('disapprove', [TaskController::class, 'disapprove'])->name('disapprove');
        Route::post('delete', [TaskController::class, 'delete'])->name('delete');
    });
    Route::group(['middleware' => ['permission:finance_management']], function () {
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
            Route::post('/{id}/retry', [EarningController::class, 'retryWithdrawal'])->name('retry');
        });
    });
    
    Route::group(['prefix' => 'users','as' => 'users.','middleware' => ['permission:user_management']], function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('verifications', [UserController::class, 'verifications'])->name('verifications');
        Route::post('verifications/approve', [UserController::class, 'approveVerification'])->name('verifications.approve');
        Route::post('verifications/reject', [UserController::class, 'rejectVerification'])->name('verifications.reject');

        Route::get('show/{user}', [UserController::class, 'show'])->name('show');
        Route::post('suspend', [UserController::class, 'suspend'])->name('suspend');
        Route::post('enable', [UserController::class, 'enable'])->name('enable');
        Route::post('ban-from-tasks', [UserController::class, 'banFromTasks'])->name('ban-from-tasks');
        Route::post('delete', [UserController::class, 'destroy'])->name('delete');
        Route::post('wallet', [UserController::class, 'wallet'])->name('wallet.toggle');
    });

    Route::group(['prefix' => 'blog','as' => 'blog.','middleware' => ['permission:blog_management']], function () {
        Route::get('/', [BlogController::class, 'index'])->name('index');
        Route::get('create', [BlogController::class, 'create'])->name('create');
        Route::get('edit/{post}', [BlogController::class, 'edit'])->name('edit');
        Route::post('store', [BlogController::class, 'store'])->name('store');
        Route::post('update', [BlogController::class, 'update'])->name('update');
        Route::post('delete', [BlogController::class, 'destroy'])->name('destroy');
        Route::group(['prefix' => 'comments','as' => 'comments.'], function () {
            Route::get('/', [BlogController::class, 'comments'])->name('index');
            Route::post('approve', [BlogController::class, 'approveComment'])->name('approve');
            Route::post('reject', [BlogController::class, 'rejectComment'])->name('reject');
            Route::post('spam', [BlogController::class, 'markCommentAsSpam'])->name('spam');
            Route::post('delete', [BlogController::class, 'deleteComment'])->name('delete');
        });
    });

    Route::group(['prefix' => 'support','as' => 'support.','middleware' => ['permission:support_management']], function () {
        Route::group(['prefix' => 'tickets','as' => 'tickets.'], function () {
            Route::get('/', [TicketController::class, 'index'])->name('index');
            Route::get('view/{support}', [TicketController::class, 'show'])->name('show');
            Route::get('pending', [TicketController::class, 'pending'])->name('pending');
            Route::get('open', [TicketController::class, 'open'])->name('open');
            Route::get('closed', [TicketController::class, 'closed'])->name('closed');
            Route::post('add-comment', [TicketController::class, 'addComment'])->name('add-comment');
        });
        Route::group(['prefix' => 'disputes','as' => 'disputes.'], function () {
            Route::get('/', [TicketController::class, 'disputes'])->name('index');
            Route::get('pending', [TicketController::class, 'disputes_pending'])->name('pending');
            Route::get('open', [TicketController::class, 'disputes_open'])->name('open');
            Route::get('closed', [TicketController::class, 'disputes_closed'])->name('closed');
        });
    });

    Route::group(['prefix' => 'announcements','as' => 'announcements.','middleware' => ['permission:system_settings']], function () {
        Route::get('/', [AnnouncementController::class, 'index'])->name('index');
        Route::post('send', [AnnouncementController::class, 'send'])->name('send');
    });

    Route::group(['prefix' => 'settings','as' => 'settings.'], function () {
        Route::group(['middleware' => ['permission:system_settings']], function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');
            Route::post('core', [SettingController::class, 'saveCoreSettings'])->name('core.save');
            Route::post('notifications', [SettingController::class, 'saveNotificationSettings'])->name('notifications.save');
            Route::post('roles', [SettingController::class, 'storeRole'])->name('roles.store');
            Route::put('roles/{role}', [SettingController::class, 'updateRole'])->name('roles.update');
            Route::delete('roles/{role}', [SettingController::class, 'destroyRole'])->name('roles.destroy');

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
        });
        Route::group(['middleware' => ['permission:staff_management']], function () {
            Route::post('staff', [SettingController::class, 'staffStore'])->name('staff.store');
            Route::put('staff/{user}', [SettingController::class, 'staffUpdate'])->name('staff.update');
            Route::delete('staff/{user}', [SettingController::class, 'staffDestroy'])->name('staff.destroy');
        });
        Route::group(['middleware' => ['permission:country_settings']], function () {
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
});