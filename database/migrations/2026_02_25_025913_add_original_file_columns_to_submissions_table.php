<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            // Only add if it doesn't exist to avoid "Duplicate Column" errors
            if (!Schema::hasColumn('submissions', 'original_file_path')) {
                $table->string('original_file_path')->nullable();
            }

            if (!Schema::hasColumn('submissions', 'original_file_name')) {
                $table->string('original_file_name')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropColumn(['original_file_path', 'original_file_name']);
        });
    }
};
