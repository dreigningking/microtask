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
        Schema::create('platform_templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('platform_id');
            $table->string('name');
            $table->string('description');
            $table->json('task_fields');
            $table->json('submission_fields');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->foreign('platform_id')->references('id')->on('platforms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platform_templates');
    }
};
