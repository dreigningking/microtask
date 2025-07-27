<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::table('user_verifications', function (Blueprint $table) {
            $table->string('document_name')->nullable()->after('document_type');
        });
    }

    public function down(): void
    {
        Schema::table('user_verifications', function (Blueprint $table) {
            $table->dropColumn('document_name');
        });
    }
};