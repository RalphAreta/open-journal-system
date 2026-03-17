<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Make notifiable_id and notifiable_type nullable to support 
     * role-based notifications that don't reference specific models.
     */
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('notifiable_id')->nullable()->change();
            $table->string('notifiable_type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('notifiable_id')->nullable(false)->change();
            $table->string('notifiable_type')->nullable(false)->change();
        });
    }
};
