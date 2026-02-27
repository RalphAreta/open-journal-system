<?php

namespace App\Console\Commands;

use App\Models\LayoutEditorAssignment;
use App\Models\User;
use Illuminate\Console\Command;

class DiagnoseLayoutEditor extends Command
{
    protected $signature = 'diagnose:layout-editor';

    protected $description = 'Diagnose layout editor assignment issues';

    public function handle()
    {
        $this->info('=== LAYOUT EDITOR ASSIGNMENT DIAGNOSIS ===');
        $this->newLine();

        // Check all assignments
        $allAssignments = LayoutEditorAssignment::with('submission')->get();
        $this->info("Total Assignments in Database: " . count($allAssignments));
        $this->newLine();

        foreach ($allAssignments as $a) {
            $hasFile = $a->submission && $a->submission->file_path ? '✓' : '✗';
            $this->line("  ID: {$a->id} | Editor ID: {$a->layout_editor_id} | Submission: {$a->submission->title} | File: {$hasFile}");
        }

        $this->newLine();
        $this->info("Layout Editors (Users with layout-editor role):");

        $layoutEditors = User::whereHas('roles', function($q) {
            $q->where('name', 'layout-editor');
        })->with('layoutEditorAssignments.submission')->get();

        foreach ($layoutEditors as $editor) {
            $assignmentCount = $editor->layoutEditorAssignments()->count();
            $this->line("  ID: {$editor->id} | Name: {$editor->name} | Email: {$editor->email} | Assignments: {$assignmentCount}");

            foreach ($editor->layoutEditorAssignments as $a) {
                $fileStatus = $a->submission && $a->submission->file_path ? 'EXISTS' : 'MISSING';
                $filePath = $a->submission ? $a->submission->file_path : 'N/A';
                $this->line("    ↳ {$a->submission->title} ({$a->status}) - File: {$fileStatus} ({$filePath})");
            }
        }
    }
}
