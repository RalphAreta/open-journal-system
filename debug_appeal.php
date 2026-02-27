<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Debugging Submission #40 Appeal Issue\n";
echo "====================================\n\n";

$submission = \App\Models\Submission::find(40);

if (!$submission) {
    echo "ERROR: Submission #40 not found!\n";
    exit(1);
}

echo "Submission Details:\n";
echo "  ID: {$submission->id}\n";
echo "  Title: {$submission->title}\n";
echo "  Author ID: {$submission->author_id}\n";
echo "  Author Name: {$submission->author->name}\n";
echo "  Status: {$submission->status}\n";
echo "  Screening Status: {$submission->initial_screening_status}\n";
echo "  Screening Status Constant: " . \App\Models\Submission::SCREENING_STATUS_FAILED . "\n";
echo "  Status Match: " . ($submission->initial_screening_status === \App\Models\Submission::SCREENING_STATUS_FAILED ? "YES" : "NO") . "\n";

echo "\n\nAppeal Status for Submission #40:\n";
$appeal = \App\Models\Appeal::where('submission_id', $submission->id)->first();
if ($appeal) {
    echo "  Appeal exists: YES\n";
    echo "  Appeal ID: {$appeal->id}\n";
    echo "  Appeal Status: {$appeal->status}\n";
} else {
    echo "  Appeal exists: NO\n";
    echo "  *This is the problem - appeal should exist but doesn't*\n";
}

echo "\n\nChecking if Submission #40 is eligible for appeal:\n";
echo "  Passes auth check: YES (we're checking server-side)\n";
echo "  initial_screening_status = 'failed': " . ($submission->initial_screening_status === 'failed' ? "YES" : "NO") . "\n";
echo "  No existing appeal: " . (!$appeal ? "YES" : "NO") . "\n";
echo "  ----\n";
echo "  ELIGIBLE FOR APPEAL: " . (!$appeal && $submission->initial_screening_status === 'failed' ? "YES" : "NO") . "\n";

echo "\n\nPotential Issues:\n";
if ($submission->initial_screening_status !== 'failed') {
    echo "  ❌ Submission screening status is NOT 'failed' - form wouldn't show and appeal creation would be blocked\n";
} else {
    echo "  ✓ Submission screening status IS 'failed'\n";
}

if ($appeal) {
    echo "  ❌ Appeal already exists - this should have prevented a second appeal from being created\n";
} else {
    echo "  ✓ No appeal exists yet\n";
}

echo "\n\nConclusion:\n";
if ($appeal) {
    echo "The appeal exists but has status: {$appeal->status}\n";
    echo "The dashboard is filtering for status = 'pending', so if it's '{$appeal->status}', it won't show.\n";
} else {
    echo "The appeal was never created. The form submission didn't save the appeal to the database.\n";
    echo "Possible causes:\n";
    echo "  1. Form validation failed and returned errors (user would see error messages)\n";
    echo "  2. Database insert failed (check application logs)\n";
    echo "  3. User wasn't authenticated as the submission author\n";
    echo "  4. Submitted form data with insufficient text length (min 50 chars)\n";
}
