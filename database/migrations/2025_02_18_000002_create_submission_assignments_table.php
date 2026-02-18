<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submission_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained()->onDelete('cascade');
            $table->foreignId('assigned_to_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('assigned_by_user_id')->constrained('users')->onDelete('set null')->nullable();
            $table->string('expertise_field')->nullable();
            $table->text('assignment_notes')->nullable();
            $table->timestamp('assigned_at');
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submission_assignments');
    }
};
