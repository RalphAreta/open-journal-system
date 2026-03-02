<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->foreignId('managing_editor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('managing_editor_status')->nullable(); // pending, ctf_sent, forwarded
            $table->timestamp('managing_editor_assigned_at')->nullable();
            $table->timestamp('ctf_sent_at')->nullable();
            $table->timestamp('forwarded_to_layout_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropForeign(['managing_editor_id']);
            $table->dropColumn([
                'managing_editor_id',
                'managing_editor_status',
                'managing_editor_assigned_at',
                'ctf_sent_at',
                'forwarded_to_layout_at',
            ]);
        });
    }
};