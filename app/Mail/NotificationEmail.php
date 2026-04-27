<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Notification;
use App\Models\User;

class NotificationEmail extends Mailable  // ← Inalis ang "implements ShouldQueue"
{
    use Queueable, SerializesModels;

    public function __construct(
        public Notification $notification,
        public User $user,
        public ?User $actor = null
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: $this->actor ? [$this->actor->email] : [],
            subject: '[Notification] ' . $this->notification->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.notification',
        );
    }
}