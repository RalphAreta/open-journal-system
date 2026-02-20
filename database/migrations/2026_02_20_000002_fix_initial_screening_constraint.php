<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop the existing check constraint if it exists
        try {
            DB::statement('ALTER TABLE submissions DROP CONSTRAINT IF EXISTS submissions_initial_screening_status_check');
        } catch (\Exception $e) {
            // Constraint doesn't exist, continue
        }

        // Add the correct check constraint that accepts 'pending', 'passed', and 'failed'
        DB::statement("ALTER TABLE submissions ADD CONSTRAINT submissions_initial_screening_status_check CHECK (initial_screening_status IN ('pending', 'passed', 'failed'))");
    }

    public function down(): void
    {
        try {
            DB::statement('ALTER TABLE submissions DROP CONSTRAINT IF EXISTS submissions_initial_screening_status_check');
        } catch (\Exception $e) {
            // Constraint doesn't exist
        }
    }
};
