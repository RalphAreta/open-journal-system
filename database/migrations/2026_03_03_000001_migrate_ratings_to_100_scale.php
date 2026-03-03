<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Create rating criteria table to store the criteria definitions
        Schema::create('rating_criterias', function (Blueprint $table) {
            $table->id();
            $table->string('role'); // reviewer, editor, layout_editor, revision_reviewer
            $table->string('context')->default('general'); // general, submission, revision, layout
            $table->string('band'); // 1-10, 11-20, ..., 91-100
            $table->string('label'); // Outstanding, Excellent, etc.
            $table->text('description');
            $table->json('characteristics')->nullable(); // Array of characteristics
            $table->integer('score_min'); // Minimum score for this band (e.g., 1 for 1-10)
            $table->integer('score_max'); // Maximum score for this band (e.g., 10 for 1-10)
            $table->timestamps();
            
            // Unique combination of role, context, and band
            $table->unique(['role', 'context', 'band']);
            $table->index(['role', 'context']);
        });

        // Update existing rating columns to support 1-100
        // For reviews table
        Schema::table('reviews', function (Blueprint $table) {
            // Change rating to nullable unsignedSmallInteger to support 1-100
            $table->unsignedSmallInteger('rating')->nullable()->change();
        });

        // For revision_reviews table - already supports integer, just verify it's nullable
        Schema::table('revision_reviews', function (Blueprint $table) {
            $table->unsignedSmallInteger('rating')->nullable()->change();
        });

        // Convert existing 1-5 ratings to 1-100 scale
        $this->convertExistingRatings();
    }

    protected function convertExistingRatings(): void
    {
        // Mapping: 1->20, 2->40, 3->60, 4->75, 5->90
        $mapping = [
            1 => 20,
            2 => 40,
            3 => 60,
            4 => 75,
            5 => 90,
        ];

        foreach ($mapping as $old => $new) {
            // Update reviews table
            DB::table('reviews')
                ->where('rating', $old)
                ->update(['rating' => $new]);

            // Update revision_reviews table
            DB::table('revision_reviews')
                ->where('rating', $old)
                ->update(['rating' => $new]);
        }
    }

    public function down(): void
    {
        // Revert existing 1-100 ratings back to 1-5
        $mapping = [
            20 => 1,
            40 => 2,
            60 => 3,
            75 => 4,
            90 => 5,
        ];

        foreach ($mapping as $new => $old) {
            // Revert reviews table
            DB::table('reviews')
                ->where('rating', $new)
                ->update(['rating' => $old]);

            // Revert revision_reviews table
            DB::table('revision_reviews')
                ->where('rating', $new)
                ->update(['rating' => $old]);
        }

        // Revert rating column changes
        Schema::table('reviews', function (Blueprint $table) {
            $table->unsignedTinyInteger('rating')->nullable()->change();
        });

        Schema::table('revision_reviews', function (Blueprint $table) {
            $table->unsignedTinyInteger('rating')->nullable()->change();
        });

        Schema::dropIfExists('rating_criterias');
    }
};
