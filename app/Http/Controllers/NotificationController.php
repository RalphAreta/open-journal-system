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
        
        // Filter by active role if set
        if ($activeRole) {
            $notifications->where(function($q) use ($activeRole) {
                $q->where('role', $activeRole)
                  ->orWhereNull('role'); // Include role-agnostic notifications
            });
        }
        
        $notifications = $notifications->latest()->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function markAllRead(Request $request)
    {
        $activeRole = session('active_role');
        
        $query = Notification::where('user_id', auth()->id())
            ->whereNull('read_at');
        
        // Filter by active role if set
        if ($activeRole) {
            $query->where(function($q) use ($activeRole) {
                $q->where('role', $activeRole)
                  ->orWhereNull('role');
            });
        }
        
        $query->update(['read_at' => now()]);

        // Return JSON if AJAX request
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

    /**
     * Get unread notification count (for AJAX polls)
     */
    public function getUnreadCount(): JsonResponse
    {
        $activeRole = session('active_role');
        
        $count = Notification::where('user_id', auth()->id())
            ->whereNull('read_at');
        
        // Filter by active role if set
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