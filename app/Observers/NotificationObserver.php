<?php
namespace App\Observers;

use App\Models\Notification;
use App\Mail\NotificationEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationObserver
{
    public function created(Notification $notification): void
    {
        Log::info('Observer triggered! Notification ID: ' . $notification->id);

        try {
            $user = $notification->user;
            $actor = auth()->user();

            Log::info('User: ' . $user?->email . ' | Actor: ' . $actor?->email);

            // Tanggalin ang actor check — send palagi kung may user
            if ($user && $user->email) {
                Mail::to($user->email)->send(
                    new NotificationEmail($notification, $user, $actor)
                );
                Log::info('Email sent to: ' . $user->email);
            }

        } catch (\Exception $e) {
            Log::error('NotificationObserver error: ' . $e->getMessage());
        }
    }
}