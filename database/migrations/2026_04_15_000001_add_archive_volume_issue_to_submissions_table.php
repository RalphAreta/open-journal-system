<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->string('archive_volume')->nullable()->after('published_at');
            $table->string('archive_issue')->nullable()->after('archive_volume');
            $table->index(['archive_volume', 'archive_issue']);
        });
    }

    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropIndex(['archive_volume', 'archive_issue']);
            $table->dropColumn(['archive_volume', 'archive_issue']);
        });
    }
};
