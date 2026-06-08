<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::user()->user_id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::user()->user_id)
            ->where('notification_id', $id)
            ->firstOrFail();

        $notification->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::user()->user_id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function destroy($id)
    {
        $notification = Notification::where('user_id', Auth::user()->user_id)
            ->where('notification_id', $id)
            ->firstOrFail();

        $notification->delete();

        return redirect()->back()->with('success', 'Notification deleted successfully.');
    }

    /**
     * Delete all notifications for the authenticated user.
     */
    public function destroyAll()
    {
        Notification::where('user_id', Auth::user()->user_id)->delete();

        return redirect()->back()->with('success', 'All notifications deleted successfully.');
    }

    /**
     * Send a notification to a user.
     */
    public static function send($userId, $title, $message, $type = 'info', $assignmentId = null)
    {
        Notification::create([
            'user_id' => $userId,
            'assignment_id' => $assignmentId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'is_read' => false
        ]);
    }
}
