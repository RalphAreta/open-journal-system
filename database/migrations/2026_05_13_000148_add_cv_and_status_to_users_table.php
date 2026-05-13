<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cv_path')->nullable()->after('password');
            $table->enum('status', ['approved', 'pending', 'rejected'])
                  ->default('approved')
                  ->after('cv_path');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cv_path', 'status']);
        });
    }
};