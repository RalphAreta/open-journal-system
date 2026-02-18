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
        Schema::create('revision_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('submissions')->cascadeOnDelete();
            $table->foreignId('requested_by_user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('revision_type', ['minor', 'major'])->default('minor');
            $table->text('reason')->nullable();
            $table->timestamp('requested_at');
            $table->foreignId('revised_submission_id')->nullable()->constrained('submissions')->nullOnDelete();
            $table->timestamp('revised_at')->nullable();
            $table->text('revision_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revision_requests');
    }
};
