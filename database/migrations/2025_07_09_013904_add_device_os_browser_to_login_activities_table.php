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
        Schema::table('login_activities', function (Blueprint $table) {
            $table->string('device')->nullable()->after('browser');
            $table->string('os')->nullable()->after('device');
            $table->string('browser_name')->nullable()->after('os');
            $table->string('browser_version')->nullable()->after('browser_name');
            $table->string('platform')->nullable()->after('browser_version');
            $table->string('platform_version')->nullable()->after('platform');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('login_activities', function (Blueprint $table) {
            $table->dropColumn(['device', 'os', 'browser_name', 'browser_version', 'platform', 'platform_version']);
        });
    }
};
