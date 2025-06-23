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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->enum('type',['taskmaster','worker']);
            $table->boolean('featured_promotion')->default(0); //for taskmaster
            $table->boolean('urgency_promotion')->default(0); //for taskmaster
            $table->string('active_tasks_per_hour')->default(1); //for worker
            $table->string('withdrawal_maximum_multiplier'); //x3 for worker
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
