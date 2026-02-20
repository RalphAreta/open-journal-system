<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            // Check if columns don't already exist before adding
            if (!Schema::hasColumn('submissions', 'initial_screening_status')) {
                $table->string('initial_screening_status')->default('pending')->after('status');
            }
            if (!Schema::hasColumn('submissions', 'initial_screening_comments')) {
                $table->text('initial_screening_comments')->nullable()->after('initial_screening_status');
            }
            if (!Schema::hasColumn('submissions', 'initial_screening_by')) {
                $table->foreignId('initial_screening_by')->nullable()->constrained('users')->nullOnDelete()->after('initial_screening_comments');
            }
            if (!Schema::hasColumn('submissions', 'initial_screening_at')) {
                $table->timestamp('initial_screening_at')->nullable()->after('initial_screening_by');
                $table->index(['initial_screening_status']);
            }
        });
    }

    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            if (Schema::hasColumn('submissions', 'initial_screening_status')) {
                $table->dropColumn(['initial_screening_status', 'initial_screening_comments', 'initial_screening_by', 'initial_screening_at']);
            }
        });
    }
};
