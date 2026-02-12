<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('abstract');
            $table->string('keywords')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('status')->default('submitted'); // submitted, under_review, revisions_requested, accepted, rejected
            $table->foreignId('editor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('editor_decision_at')->nullable();
            $table->text('editor_notes')->nullable();
            $table->timestamps();
            $table->index(['status', 'author_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
