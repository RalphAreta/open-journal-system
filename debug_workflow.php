<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Current System State ===\n\n";

// Check submissions
$accepted = \App\Models\Submission::where('status', 'accepted')->get();
echo "Accepted Submissions: " . count($accepted) . "\n";
if (count($accepted) > 0) {
    foreach ($accepted->take(3) as $sub) {
        echo "  - ID: {$sub->id}, Title: {$sub->title}, File: {$sub->file_path}\n";
    }
}

// Check layout editors
$layoutEditors = \App\Models\User::whereHas('roles', function($q) {
    $q->where('name', 'layout-editor');
})->get();
echo "\nLayout Editor Users: " . count($layoutEditors) . "\n";
foreach ($layoutEditors as $editor) {
    echo "  - ID: {$editor->id}, Name: {$editor->name}, Email: {$editor->email}\n";
}

// Check editors
$editors = \App\Models\User::whereHas('roles', function($q) {
    $q->where('name', 'editor');
})->get();
echo "\nEditor Users: " . count($editors) . "\n";
foreach ($editors as $editor) {
    echo "  - ID: {$editor->id}, Name: {$editor->name}, Email: {$editor->email}\n";
}

// Check layout assignments
$assignments = \App\Models\LayoutEditorAssignment::all();
echo "\nLayout Editor Assignments: " . count($assignments) . "\n";
if (count($assignments) > 0) {
    foreach ($assignments as $assign) {
        echo "  - ID: {$assign->id}, Submission: {$assign->submission_id}, Editor ID: {$assign->layout_editor_id}, Status: {$assign->status}\n";
    }
} else {
    echo "  No assignments found\n";
}

echo "\n=== Assignment Details (if any) ===\n";
$latestAssign = \App\Models\LayoutEditorAssignment::latest()->first();
if ($latestAssign) {
    echo "Latest Assignment ID: {$latestAssign->id}\n";
    echo "  Layout Editor ID: {$latestAssign->layout_editor_id}\n";
    echo "  Submission ID: {$latestAssign->submission_id}\n";
    echo "  Status: {$latestAssign->status}\n";
    echo "  Assigned at: {$latestAssign->assigned_at}\n";
}
