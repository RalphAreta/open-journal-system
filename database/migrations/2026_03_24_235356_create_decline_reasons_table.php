<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('decline_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('reason');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        DB::table('decline_reasons')->insert([
            ['reason' => 'Too busy at the moment',             'is_active' => true, 'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['reason' => 'Unable to meet the review deadline', 'is_active' => true, 'sort_order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['reason' => 'Outside my area of expertise',       'is_active' => true, 'sort_order' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['reason' => 'Conflict of interest',               'is_active' => true, 'sort_order' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['reason' => 'On leave / unavailable',             'is_active' => true, 'sort_order' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['reason' => 'Already reviewing many manuscripts', 'is_active' => true, 'sort_order' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['reason' => 'Other (please specify)',             'is_active' => true, 'sort_order' => 7, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('decline_reasons');
    }
};