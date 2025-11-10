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
            $table->unsignedBigInteger('platform_id');
            $table->unsignedBigInteger('platform_template_id');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->longText('description')->nullable();
            $table->string('average_completion_minutes')->nullable();
            $table->json('requirements')->nullable();
            $table->enum('visibility', ['public','private'])->default('public');
            $table->json('template_data')->nullable();
            $table->enum('restriction',['allow','deny'])->nullable();
            $table->json('task_countries')->nullable();
            $table->string('expected_budget')->nullable();
            $table->timestamp('expiry_date')->nullable();
            $table->boolean('allow_multiple_submissions')->default(0);
            $table->integer('number_of_submissions')->default(1);
            $table->string('budget_per_submission')->default(0);
            $table->enum('submission_review_type', ['self_review', 'admin_review','system_review'])->default('self_review');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('platform_template_id')->references('id')->on('platform_templates')->onDelete('cascade');
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
