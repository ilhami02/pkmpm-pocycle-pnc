<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Daftar notifikasi pengguna.
     */
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->paginate(15);

        $unreadCount = Auth::user()->unreadNotifications()->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Tandai satu notifikasi sebagai sudah dibaca.
     */
    public function markAsRead(string $id)
    {
        $notification = Auth::user()
            ->notifications()
            ->findOrFail($id);

        $notification->markAsRead();

        // Redirect ke action_url jika ada
        $actionUrl = $notification->data['action_url'] ?? null;

        if ($actionUrl) {
            return redirect($actionUrl);
        }

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    /**
     * Tandai semua notifikasi sebagai sudah dibaca.
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}
