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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            // Basic post information
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            // Publishing and status
            $table->boolean('is_active')->default(false);
            
            // SEO and meta fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            // Engagement and analytics
            $table->integer('views_count')->default(0);
            // Tags (JSON for flexibility)
            $table->json('tags')->nullable();
            
            // Reading time and difficulty
            $table->integer('reading_time')->nullable(); // in minutes
            // Social sharing
            $table->boolean('allow_comments')->default(true);
            $table->boolean('featured')->default(false);
            // Timestamps
            $table->timestamps();
            
            // Indexes for performance
            $table->index('views_count');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
