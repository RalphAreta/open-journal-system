<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('editorial_board_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title')->nullable();           // Dr., Prof., Engr., Mr., etc.
            $table->string('role');                        // editor_in_chief, guest_editor, editor, etc.
            $table->string('affiliation')->nullable();     // University / Institution
            $table->string('location')->nullable();        // City, Country
            $table->string('expertise')->nullable();       // Research field / specialization
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('editorial_board_members');
    }
};