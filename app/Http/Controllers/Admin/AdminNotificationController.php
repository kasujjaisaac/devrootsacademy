<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminNotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = Schema::hasTable('notifications')
            ? $request->user()->notifications()->latest()->paginate(20)
            : collect();

        return view('admin.notifications.index', [
            'notifications' => $notifications,
        ]);
    }

    public function markRead(Request $request, string $notification)
    {
        if (! Schema::hasTable('notifications')) {
            return back();
        }

        $record = $request->user()->notifications()->where('id', $notification)->firstOrFail();
        $record->markAsRead();

        return back();
    }

    public function markAllRead(Request $request)
    {
        if (! Schema::hasTable('notifications')) {
            return back();
        }

        $request->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }
}
