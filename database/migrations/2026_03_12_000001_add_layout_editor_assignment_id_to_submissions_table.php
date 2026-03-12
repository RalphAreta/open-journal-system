<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->foreignId('layout_editor_assignment_id')
                ->nullable()
                ->constrained('layout_editor_assignments')
                ->nullOnDelete()
                ->after('published_at');
        });
    }

    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropForeignIdFor('layout_editor_assignments', 'layout_editor_assignment_id');
            $table->dropColumn('layout_editor_assignment_id');
        });
    }
};
