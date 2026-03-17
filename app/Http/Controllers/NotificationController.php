<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    public function index()
    {
        $activeRole = session('active_role');

        $notifications = Notification::where('user_id', auth()->id());

        if ($activeRole) {
            $notifications->where(function($q) use ($activeRole) {
                $q->where('role', $activeRole)
                  ->orWhereNull('role');
            });
        }

        $notifications = $notifications->latest()->paginate(7);

        return view('notifications.index', compact('notifications'));
    }

    public function markAllRead(Request $request)
    {
        $activeRole = session('active_role');

        $query = Notification::where('user_id', auth()->id())
            ->whereNull('read_at');

        if ($activeRole) {
            $query->where(function($q) use ($activeRole) {
                $q->where('role', $activeRole)
                  ->orWhereNull('role');
            });
        }

        $query->update(['read_at' => now()]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'All notifications marked as read.',
                'unread_count' => 0,
            ]);
        }

        return back()->with('success', 'All notifications marked as read.');
    }

    public function read(Notification $notification)
    {
        abort_if($notification->user_id !== auth()->id(), 403);
        $notification->markAsRead();
        return back();
    }

    public function getUnreadCount(): JsonResponse
    {
        $activeRole = session('active_role');

        $count = Notification::where('user_id', auth()->id())
            ->whereNull('read_at');

        if ($activeRole) {
            $count->where(function($q) use ($activeRole) {
                $q->where('role', $activeRole)
                  ->orWhereNull('role');
            });
        }

        $count = $count->count();

        return response()->json([
            'unread_count' => $count,
        ]);
    }
}