<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update or rename layout_editor role to layout-editor
        DB::table('roles')->updateOrInsert(
            ['name' => 'layout-editor'],
            [
                'display_name' => 'Layout Editor',
                'description' => 'Edit and format accepted manuscripts',
                'updated_at' => now(),
            ]
        );

        // Delete old layout_editor role if it exists (with underscore)
        DB::table('roles')->where('name', 'layout_editor')->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to layout_editor if needed
        DB::table('roles')->updateOrInsert(
            ['name' => 'layout_editor'],
            [
                'display_name' => 'Layout Editor',
                'description' => 'Edit and format accepted manuscripts',
                'updated_at' => now(),
            ]
        );

        // Delete layout-editor role
        DB::table('roles')->where('name', 'layout-editor')->delete();
    }
};
