<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ Check muna kung may data column bago i-alter
        if (Schema::hasColumn('notifications', 'data')) {
            DB::statement('ALTER TABLE notifications ALTER COLUMN data DROP NOT NULL');
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('notifications', 'data')) {
            DB::statement("UPDATE notifications SET data = '' WHERE data IS NULL");
            DB::statement('ALTER TABLE notifications ALTER COLUMN data SET NOT NULL');
        }
    }
};