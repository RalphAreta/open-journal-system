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
        $table->string('ctf_signed_file_path')->nullable()->after('ctf_file_name');
        $table->string('ctf_signed_file_name')->nullable()->after('ctf_signed_file_path');
        $table->timestamp('ctf_returned_at')->nullable()->after('ctf_signed_file_name');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            //
        });
    }
};
