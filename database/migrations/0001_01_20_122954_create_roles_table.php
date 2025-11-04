<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->nullable();
            $table->timestamps();
        });

        // Seed roles
        DB::table('roles')->insert([
            ['name' => 'Super Admin', 'slug' => 'super-admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Country Manager', 'slug' => 'country-manager', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'User Support', 'slug' => 'user-support', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Financial Analyst', 'slug' => 'financial-analyst', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
}; 