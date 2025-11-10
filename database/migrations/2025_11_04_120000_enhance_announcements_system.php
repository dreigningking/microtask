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
        // Enhance the existing announcements table
        Schema::table('announcements', function (Blueprint $table) {
            // Add targeting fields
            $table->string('target_segment')->nullable()->after('via'); // e.g., 'all_users', 'task_workers', etc.
            $table->json('target_criteria')->nullable()->after('target_segment'); // Additional targeting criteria
            
            // Add scheduling fields
            $table->timestamp('scheduled_at')->nullable()->after('target_criteria');
            $table->timestamp('sent_at')->nullable()->after('scheduled_at');
            $table->timestamp('expires_at')->nullable()->after('sent_at');
            
            // Add delivery tracking fields
            $table->integer('emails_sent')->default(0)->after('expires_at');
            $table->integer('emails_delivered')->default(0)->after('emails_sent');
            $table->integer('emails_failed')->default(0)->after('emails_delivered');
            $table->integer('database_notifications_sent')->default(0)->after('emails_failed');
            $table->integer('database_notifications_read')->default(0)->after('database_notifications_sent');
            
            // Add priority and urgency fields
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal')->after('database_notifications_read');
            $table->boolean('is_archived')->default(false)->after('priority');
            
            // Add additional metadata
            $table->json('metadata')->nullable()->after('is_archived'); // For storing additional data like template variables, etc.
            
            // Add indexes
            $table->index(['target_segment', 'created_at']);
            $table->index(['scheduled_at', 'status']);
            $table->index(['expires_at']);
            $table->index('priority');
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
        });

        // Create index for cleanup job
        Schema::table('announcement_recipients', function (Blueprint $table) {
            $table->index('cleanup_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop announcement_recipients table
        Schema::dropIfExists('announcement_recipients');
        
        // Remove enhancements from announcements table
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn([
                'target_segment',
                'target_criteria',
                'scheduled_at',
                'sent_at',
                'expires_at',
                'emails_sent',
                'emails_delivered',
                'emails_failed',
                'database_notifications_sent',
                'database_notifications_read',
                'priority',
                'is_archived',
                'metadata'
            ]);
        });
    }
};