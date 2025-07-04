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
        Schema::create('disputes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_submission_id');
            $table->unsignedBigInteger('worker_id');
            $table->unsignedBigInteger('taskmaster_id');
            $table->longText('winner')->nullable(); //worker, taskmaster
            $table->string('status')->default('open'); //open or closed
            $table->timestamps();
            $table->foreign('task_submission_id')->references('id')->on('task_submissions')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disputes');
    }
};
