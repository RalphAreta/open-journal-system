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
        Schema::table('revision_requests', function (Blueprint $table) {
            // Add revision_stage to track where revision was requested
            $table->enum('revision_stage', ['initial_screening', 'review', 'post_review'])->default('review')->after('revision_type');
            // Add current_stage_assignee to track who should handle revision
            $table->foreignId('current_stage_assignee_id')->nullable()->constrained('users')->nullOnDelete()->after('revision_stage');
            // Track reviewer re-review completion count
            $table->integer('review_cycles')->default(0)->after('current_stage_assignee_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('revision_requests', function (Blueprint $table) {
            $table->dropColumn(['revision_stage', 'current_stage_assignee_id', 'review_cycles']);
        });
    }
};
