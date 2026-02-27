<?php

namespace App\Console\Commands;

use App\Models\LayoutEditorAssignment;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Console\Command;

class CreateLayoutEditorTestData extends Command
{
    protected $signature = 'create:layout-editor-test {user_id : The ID of the layout editor user}';

    protected $description = 'Create test layout editor assignments for a specific user';

    public function handle()
    {
        $userId = $this->argument('user_id');
        $user = User::find($userId);

        if (!$user) {
            $this->error("User with ID {$userId} not found");
            return;
        }

        if (!$user->hasRole('layout-editor')) {
            $this->error("User {$user->email} does not have layout-editor role");
            return;
        }

        // Get some submitted submissions to create assignments from
        $submissions = Submission::whereIn('status', ['accepted', 'revision_approved'])
            ->limit(5)
            ->get();

        if ($submissions->isEmpty()) {
            $this->info('No submissions available to create assignments from');
            return;
        }

        $statuses = [
            LayoutEditorAssignment::STATUS_PENDING,
            LayoutEditorAssignment::STATUS_IN_PROGRESS,
            LayoutEditorAssignment::STATUS_COMPLETED,
        ];

        $count = 0;
        foreach ($submissions as $submission) {
            // Check if assignment already exists
            $exists = LayoutEditorAssignment::where('submission_id', $submission->id)
                ->where('layout_editor_id', $userId)
                ->exists();

            if ($exists) {
                continue;
            }

            LayoutEditorAssignment::create([
                'submission_id' => $submission->id,
                'layout_editor_id' => $userId,
                'assigned_at' => now()->subDays(rand(1, 30)),
                'started_at' => rand(0, 1) ? now()->subDays(rand(1, 20)) : null,
                'completed_at' => rand(0, 1) ? now()->subDays(rand(1, 10)) : null,
                'status' => $statuses[array_rand($statuses)],
                'notes' => 'Test assignment created for demonstration',
            ]);
            $count++;
        }

        $this->info("Created {$count} test assignments for {$user->email}");
    }
}
