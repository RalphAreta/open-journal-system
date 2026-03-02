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
    Schema::table('submissions', function (Blueprint $table) {
        $table->string('ctf_file_path')->nullable()->after('ctf_sent_at');
        $table->string('ctf_file_name')->nullable()->after('ctf_file_path');
    });
}

public function down(): void
{
    Schema::table('submissions', function (Blueprint $table) {
        $table->dropColumn(['ctf_file_path', 'ctf_file_name']);
    });
}
};
