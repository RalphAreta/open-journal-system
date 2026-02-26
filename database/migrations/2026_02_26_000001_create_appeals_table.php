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
        Schema::create('appeals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained()->onDelete('cascade');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->text('reason'); // Author's appeal reason
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('editor_response')->nullable(); // Editor's response to the appeal
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null'); // Editor who reviewed the appeal
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appeals');
    }
};
