<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->string('research_field')->nullable()->after('keywords');
            $table->foreignId('assigned_editor_id')->nullable()->after('editor_id')->constrained('users')->onDelete('set null');
            $table->timestamp('chief_editor_review_at')->nullable()->after('submitted_at');
            $table->text('chief_editor_notes')->nullable()->after('editor_notes');
        });
    }

    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\User::class, 'assigned_editor_id');
            $table->dropColumn(['research_field', 'assigned_editor_id', 'chief_editor_review_at', 'chief_editor_notes']);
        });
    }
};
