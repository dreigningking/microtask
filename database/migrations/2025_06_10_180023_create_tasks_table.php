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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('template_id');
            $table->unsignedBigInteger('platform_id');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->longText('description')->nullable();
            $table->string('expected_completion_minutes')->nullable();
            $table->string('expected_budget')->nullable();
            $table->string('currency')->nullable();
            $table->timestamp('expiry_date')->nullable();
            $table->json('requirements')->nullable();
            $table->json('template_data')->nullable();
            $table->integer('number_of_people')->default(1);
            $table->enum('visibility', ['public','private'])->default('public');
            $table->string('budget_per_person')->default(0);
            $table->enum('monitoring_type', ['self_monitoring', 'admin_monitoring','system_monitoring'])->default('self_monitoring');
            $table->boolean('allow_multiple_submission')->default(0);
            $table->string('submission_interval_minutes')->default(60); //one off,
            $table->json('restricted_countries')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('template_id')->references('id')->on('task_templates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
