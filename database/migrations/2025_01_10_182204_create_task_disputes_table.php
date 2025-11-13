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
        Schema::create('task_disputes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_submission_id');
            $table->string('desired_outcome')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->string('resolution')->nullable(); //full-payment, partial-payment
            $table->string('resolution_value')->nullable(); //500
            $table->timestamps();
            $table->foreign('task_submission_id')->references('id')->on('task_submissions')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_disputes');
    }
};
