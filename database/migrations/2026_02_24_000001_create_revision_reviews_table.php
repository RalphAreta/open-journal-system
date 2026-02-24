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
        Schema::create('revision_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('revision_request_id')->constrained('revision_requests')->cascadeOnDelete();
            $table->foreignId('reviewer_id')->constrained('users')->cascadeOnDelete();
            $table->string('status')->default('assigned'); // assigned, completed, declined
            $table->text('recommendation')->nullable(); // accept, minor_revisions, major_revisions, reject
            $table->text('comments_for_author')->nullable();
            $table->text('comments_for_editor')->nullable();
            $table->integer('rating')->nullable();
            $table->timestamp('assigned_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('due_at')->nullable();
            $table->timestamps();
            $table->unique(['revision_request_id', 'reviewer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revision_reviews');
    }
};
