<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('country_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id');
            $table->string('gateway')->nullable();
            $table->integer('account_length')->default(0);
            $table->json('banking_fields')->nullable();  // Structure: { "fields":, "digits": "VAT" }             
            $table->boolean('bank_verification_required')->default(true);      // Bank account verification required
            $table->string('bank_verification_method')->default('manual'); // manual or provider, for bank account verification
            $table->string('bank_account_storage')->default('on_premises');
            $table->json('verification_fields')->nullable(); // JSON array of required verification fields (e.g. government_id, selfie, etc)
            $table->string('verification_provider')->nullable(); // Name of provider if using provider
            $table->boolean('verifications_can_expire')->default(false);
            $table->string('tax_rate')->default(0);
            $table->string('feature_rate')->nullable();
            $table->string('urgent_rate')->nullable();
            $table->decimal('usd_exchange_rate_percentage', 5, 2)->default(0); // percentage markup to add to API rate
            $table->json('transaction_charges')->nullable();// Structure:{ "percentage": 10, "fixed": 10000, "cap": 100000 }          
            $table->json('withdrawal_charges')->nullable();// Structure:{ "percentage": 10, "fixed": 10000, "cap": 100000 }          
            $table->string('min_withdrawal', 18, 2)->nullable();
            $table->string('max_withdrawal', 18, 2)->nullable();
            $table->string('wallet_status')->nullable(); // enabled/disabled
            $table->string('payout_method')->default('manual'); //manual or gateway
            $table->boolean('weekend_payout')->default(0); 
            $table->boolean('holiday_payout')->default(0); 
            $table->decimal('admin_monitoring_cost', 12, 2)->nullable();
            $table->decimal('system_monitoring_cost', 12, 2)->nullable();
            $table->decimal('invitee_commission_percentage', 5, 2)->nullable();
            $table->decimal('referral_earnings_percentage', 5, 2)->nullable();
            $table->json('notification_emails')->nullable(); // Associative array of notification emails
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country_settings');
    }
};
