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
        Schema::create('exchanges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('base_currency', 10);
            $table->string('target_currency', 10);

            // The exchange rate between base and target currency at the time of exchange
            $table->decimal('exchange_rate', 18, 8);

            // Amounts exchanged
            $table->decimal('base_amount', 18, 8);   // Amount in base currency
            $table->decimal('target_amount', 18, 8); // Amount in target currency

            // Wallets involved (assuming these are wallet IDs from another table)
            $table->unsignedBigInteger('base_wallet_id');
            $table->unsignedBigInteger('target_wallet_id');

            // Optional: status of the exchange (pending, completed, failed, etc.)
            $table->string('status', 20)->default('completed');

            // Optional: reference or transaction id for tracking
            $table->string('reference')->nullable();

            $table->timestamps();

            // Indexes and foreign keys
            $table->foreign('base_wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            $table->foreign('target_wallet_id')->references('id')->on('wallets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchanges');
    }
};
