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
            $table->unsignedBigInteger('gateway_id')->nullable();
            $table->json('banking_settings')->nullable();
            $table->json('banking_fields')->nullable();
            $table->json('verification_fields')->nullable();
            $table->json('verification_settings')->nullable();
            $table->json('promotion_settings')->nullable(); //{"feature_rate","broadcast_rate"}
            $table->json('transaction_settings')->nullable();// Structure:{ "percentage": 10, "fixed": 10000, "cap": 100000."tax": }          
            $table->json('withdrawal_settings')->nullable();
            $table->json('wallet_settings')->nullable(); //{"wallet_status":enabled/disabled, "exchange_markup_percentage":123}
            $table->json('referral_settings')->nullable(); //{"signup_referral_earnings_percentage","task_referral_commission_percentage"}
            $table->json('review_settings')->nullable(); //{"admin_review_cost","system_review_cost"}
            $table->json('security_settings')->nullable();
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
