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
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Seed permissions
        DB::table('permissions')->insert([
            ['name' => 'System Settings', 'description' => 'Manage system-wide settings', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Country Settings', 'description' => 'Manage country-specific settings', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Task Management', 'description' => 'Manage tasks and jobs', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'User Management', 'description' => 'Manage users', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Staff Management', 'description' => 'Manage staff accounts', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Finance Management', 'description' => 'Manage financial records', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Support Management', 'description' => 'Support users', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
}; 