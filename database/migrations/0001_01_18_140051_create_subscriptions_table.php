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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('booster_id');
            $table->integer('cost')->default(0);
            $table->string('currency')->default('NGN');
            $table->integer('multiplier');
            $table->integer('duration_days');
            $table->timestamp('starts_at');
            $table->timestamp('expires_at');
            $table->string('billing_cycle')->default('monthly'); // weekly, monthly, annual
            $table->boolean('auto_renew')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
