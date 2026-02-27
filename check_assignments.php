<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$assignments = \App\Models\LayoutEditorAssignment::with('submission.author')->get();

echo "Total Assignments: " . count($assignments) . "\n";
echo str_repeat("-", 80) . "\n";
foreach ($assignments as $a) {
    echo "ID: {$a->id} | Submission: {$a->submission->title} | Layout Editor ID: {$a->layout_editor_id} | Status: {$a->status}\n";
}
echo str_repeat("-", 80) . "\n";
$users = \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'layout-editor'); })->get();
echo "\nLayout Editor Users:\n";
foreach ($users as $u) {
    echo "  - ID: {$u->id}, Name: {$u->name}, Email: {$u->email}\n";
}
