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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->text('message');
            $table->text('via'); //['email','database']
            $table->string('target_segment')->nullable(); // e.g., 'all_users', 'task_workers', etc.
            $table->json('target_criteria')->nullable(); // Additional targeting criteria
            // Add scheduling fields
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            // Add delivery tracking fields
            $table->integer('emails_sent')->default(0);
            $table->integer('emails_delivered')->default(0);
            $table->integer('emails_failed')->default(0);
            $table->integer('database_notifications_sent')->default(0);
            $table->integer('database_notifications_read')->default(0);

            // Add priority and urgency fields
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->boolean('is_archived')->default(false);

            // Add additional metadata
            $table->json('metadata')->nullable(); // For storing additional data like template variables, etc.

            $table->unsignedBigInteger('sent_by');
            $table->integer('recipients_count')->default(0);
            $table->enum('status', ['sent', 'failed'])->default('sent');

            
            // Add indexes
            $table->index(['target_segment', 'created_at']);
            $table->index(['scheduled_at', 'status']);
            $table->index(['expires_at']);
            $table->index('priority');
            $table->timestamps();

            $table->foreign('sent_by')->references('id')->on('users')->onDelete('cascade');
            $table->index(['status', 'created_at']);
        });

        // Create announcement_recipients table for tracking individual deliveries
        Schema::create('announcement_recipients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('announcement_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            
            // Delivery tracking
            $table->timestamp('email_sent_at')->nullable();
            $table->timestamp('email_delivered_at')->nullable();
            $table->timestamp('email_failed_at')->nullable();
            $table->text('email_failure_reason')->nullable();
            
            $table->timestamp('database_notification_sent_at')->nullable();
            $table->timestamp('database_notification_read_at')->nullable();
            $table->timestamp('first_viewed_at')->nullable();
            
            // User interaction tracking
            $table->boolean('clicked_link')->default(false);
            $table->timestamp('clicked_at')->nullable();
            $table->json('interaction_data')->nullable(); // Store interaction details
            
            // Status tracking
            $table->enum('status', ['pending', 'sent', 'delivered', 'failed', 'read', 'clicked'])->default('pending');
            $table->timestamp('completed_at')->nullable(); // When user has read/clicked
            
            // Cleanup fields
            $table->timestamp('cleanup_at')->nullable(); // When record can be cleaned up
            $table->boolean('is_archived')->default(false);
            
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('announcement_id')->references('id')->on('announcements')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Unique constraint to prevent duplicate recipients for same announcement
            $table->unique(['announcement_id', 'user_id']);
            
            // Indexes for performance
            $table->index(['status', 'created_at']);
            $table->index(['cleanup_at', 'is_archived']);
            $table->index(['user_id', 'status']);
            $table->index('cleanup_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('announcement_recipients');
        
    }
};
