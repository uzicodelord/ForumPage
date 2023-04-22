<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->latest()->paginate(10);
        $user->notifications_count = 0;
        $user->save();

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::find($id);
        $notification->read = 1;
        $notification->save();

        return redirect()->back();
    }

    public function deleteNotification($id) {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->back();
    }
}
