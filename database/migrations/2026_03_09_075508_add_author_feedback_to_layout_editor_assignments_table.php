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
    Schema::table('layout_editor_assignments', function (Blueprint $table) {
        $table->text('author_feedback')->nullable()->after('notes');
        $table->timestamp('author_feedback_at')->nullable()->after('author_feedback');
        $table->string('author_status')->nullable()->after('author_feedback_at');
        // confirmed | revision_requested
    });
}

public function down(): void
{
    Schema::table('layout_editor_assignments', function (Blueprint $table) {
        $table->dropColumn(['author_feedback', 'author_feedback_at', 'author_status']);
    });
}
};
