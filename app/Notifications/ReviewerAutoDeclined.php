<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\ReviewAssignment;

class ReviewerAutoDeclined extends Notification
{
    use Queueable;

    public function __construct(public ReviewAssignment $assignment) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $reviewer = $this->assignment->reviewer->name ?? 'A reviewer';
        $title    = $this->assignment->submission->title ?? 'Untitled';

        return [
            'message'       => "{$reviewer} was auto-declined (no response within 7 days) for: \"{$title}\".",
            'submission_id' => $this->assignment->submission_id,
            'assignment_id' => $this->assignment->id,
            'type'          => 'auto_decline',
        ];
    }
}