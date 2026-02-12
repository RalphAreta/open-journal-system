<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reviewer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('review_assignment_id')->nullable()->constrained()->nullOnDelete();
            $table->string('recommendation'); // accept, minor_revisions, major_revisions, reject
            $table->text('comments_for_author')->nullable();
            $table->text('comments_for_editor')->nullable();
            $table->unsignedTinyInteger('rating')->nullable(); // 1-5 optional
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
            $table->unique(['submission_id', 'reviewer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
