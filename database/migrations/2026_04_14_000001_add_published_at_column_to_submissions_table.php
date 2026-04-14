<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE submissions ADD COLUMN IF NOT EXISTS published_at timestamp null");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE submissions DROP COLUMN IF EXISTS published_at");
    }
};
