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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('bank_name');
            $table->string('bank_code')->nullable();
            $table->string('account_name');
            $table->string('account_number');
            $table->string('routing_number')->nullable();
            $table->string('swift_code')->nullable();
            $table->string('branch_code')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
