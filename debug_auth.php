<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Debugging Assignment Access ===\n\n";

// Get assignment 2
$assignment = \App\Models\LayoutEditorAssignment::find(2);
if (!$assignment) {
    echo "ERROR: Assignment 2 not found!\n";
    exit(1);
}

echo "Assignment 2 Details:\n";
echo "  ID: {$assignment->id}\n";
echo "  Layout Editor ID: {$assignment->layout_editor_id}\n";
echo "  Submission ID: {$assignment->submission_id}\n";
echo "  Status: {$assignment->status}\n";
echo "  Type: " . gettype($assignment->layout_editor_id) . "\n";

// Get the layout editor user
$user = \App\Models\User::find(12);
if (!$user) {
    echo "\nERROR: User 12 not found!\n";
    exit(1);
}

echo "\nUser 12 Details:\n";
echo "  ID: {$user->id}\n";
echo "  Type: " . gettype($user->id) . "\n";
echo "  Name: {$user->name}\n";
echo "  Email: {$user->email}\n";
echo "  Roles: " . $user->roles->pluck('name')->implode(', ') . "\n";
echo "  Has layout-editor role: " . ($user->hasRole('layout-editor') ? "YES" : "NO") . "\n";

// Check authorization
echo "\nAuthorization Check:\n";
echo "  assignment->layout_editor_id !== user->id: " . ($assignment->layout_editor_id !== $user->id ? "TRUE" : "FALSE") . "\n";
echo "  assignment->layout_editor_id == user->id: " . ($assignment->layout_editor_id == $user->id ? "TRUE" : "FALSE") . "\n";
echo "  Values: {$assignment->layout_editor_id} vs {$user->id}\n";

// Check submission
$submission = $assignment->submission;
echo "\nSubmission Details:\n";
if (!$submission) {
    echo "  ERROR: Submission not loaded!\n";
} else {
    echo "  ID: {$submission->id}\n";
    echo "  Title: {$submission->title}\n";
    echo "  File Path: {$submission->file_path}\n";
    
    // Check if file exists
    $disk = \Illuminate\Support\Facades\Storage::disk('local');
    $exists = $disk->exists($submission->file_path);
    echo "  File Exists: " . ($exists ? "YES" : "NO") . "\n";
}
