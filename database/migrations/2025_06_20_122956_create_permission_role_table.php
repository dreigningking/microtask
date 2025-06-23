<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permission_role', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('permission_id');
            $table->timestamps();
            $table->unique(['role_id', 'permission_id']);
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        });

        // Assign all permissions to Super Admin (role_id=1)
        $permissionIds = DB::table('permissions')->pluck('id');
        $now = now();
        $rows = $permissionIds->map(function($pid) use ($now) {
            return [
                'role_id' => 1,
                'permission_id' => $pid,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        });
        if ($rows->count()) {
            DB::table('permission_role')->insert($rows->toArray());
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('permission_role');
    }
}; 