<?php

namespace App\Console\Commands;

use App\Models\LayoutEditorAssignment;
use Illuminate\Console\Command;

class ClearLayoutEditorAssignments extends Command
{
    protected $signature = 'clear:layout-editor-assignments';

    protected $description = 'Clear all layout editor assignments (for testing)';

    public function handle()
    {
        $count = LayoutEditorAssignment::count();

        if ($count === 0) {
            $this->info('No assignments to clear.');
            return;
        }

        if ($this->confirm("Delete all {$count} layout editor assignments?")) {
            LayoutEditorAssignment::truncate();
            $this->info("Cleared all {$count} layout editor assignments.");
        } else {
            $this->info('Cancelled.');
        }
    }
}
