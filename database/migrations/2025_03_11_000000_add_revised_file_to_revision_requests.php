<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('revision_requests', function (Blueprint $table) {
            $table->string('revised_file_path')->nullable()->after('revision_notes');
            $table->string('revised_file_name')->nullable()->after('revised_file_path');
        });
    }

    public function down(): void
    {
        Schema::table('revision_requests', function (Blueprint $table) {
            $table->dropColumn(['revised_file_path', 'revised_file_name']);
        });
    }
};