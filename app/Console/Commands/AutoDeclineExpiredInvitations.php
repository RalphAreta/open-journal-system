<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ReviewAssignment;
use Carbon\Carbon;

class AutoDeclineExpiredInvitations extends Command
{
    protected $signature   = 'invitations:auto-decline';
    protected $description = 'Auto-decline review invitations not accepted within 7 days';

    public function handle()
    {
        $expired = ReviewAssignment::where('status', 'pending')
            ->where('created_at', '<=', Carbon::now()->subDays(7))
            ->get();

        foreach ($expired as $assignment) {
            $assignment->update([
                'status'         => 'declined',
                'decline_reason' => 'Auto-declined: no response within 7 days.',
                'declined_at'    => now(),
            ]);

           foreach ($expired as $assignment) {
    $assignment->update([
        'status'         => 'declined',
        'decline_reason' => 'Auto-declined: no response within 7 days.',
        'declined_at'    => now(),
    ]);

    // Notify the editor
    $editor = $assignment->submission->editor ?? 
              $assignment->submission->assignedEditor ?? 
              null;

    if ($editor) {
        $editor->notify(new \App\Notifications\ReviewerAutoDeclined($assignment));
    }
}
}

        $this->info("Auto-declined {$expired->count()} invitation(s).");
    }
}