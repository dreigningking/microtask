<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Seed permissions
        DB::table('permissions')->insert([
            ['name' => 'System Settings','slug'=> 'system_settings', 'description' => 'Manage system-wide settings', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Country Settings', 'slug'=> 'country_settings', 'description' => 'Manage country-specific settings', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Task Management','slug'=> 'task_management',  'description' => 'Manage tasks and jobs', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'User Management','slug'=> 'user_management',  'description' => 'Manage users', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Staff Management','slug'=> 'staff_management',  'description' => 'Manage staff accounts', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Finance Management','slug'=> 'finance_management',  'description' => 'Manage financial records', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Support Management', 'slug'=> 'support_management', 'description' => 'Support users', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Blog Management', 'slug'=> 'blog_management', 'description' => 'Manage blog', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
}; 