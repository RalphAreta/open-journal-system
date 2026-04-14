<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE reviews DROP CONSTRAINT IF EXISTS reviews_recommendation_check");
        DB::statement("ALTER TABLE reviews ADD CONSTRAINT reviews_recommendation_check 
            CHECK (recommendation IN ('accept','minor_revisions','moderate_revisions','major_revisions','reject'))");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE reviews DROP CONSTRAINT IF EXISTS reviews_recommendation_check");
        DB::statement("ALTER TABLE reviews ADD CONSTRAINT reviews_recommendation_check 
            CHECK (recommendation IN ('accept','minor_revisions','major_revisions','reject'))");
    }
};