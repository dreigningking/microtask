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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->morphs('commentable'); // support, post, task, dispute, user_verification
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // who made the comment
            $table->string('title')->nullable();
            $table->longText('body');
            $table->text('attachments')->nullable();
            $table->boolean('is_flag')->default(0);
            $table->softDeletes(); // allow soft deleting comments
            $table->timestamps(); 
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
