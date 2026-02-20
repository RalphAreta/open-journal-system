<?php

namespace App\Mail;

use App\Models\Submission;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InitialScreeningNotification extends Mailable
{
    use SerializesModels;

    public function __construct(
        public Submission $submission
    ) {}

    public function envelope(): Envelope
    {
        $status = $this->submission->hasPassedInitialScreening() ? 'Passed' : 'Failed';
        return new Envelope(
            subject: "Submission Status Update: Initial Screening {$status}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.initial-screening-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
