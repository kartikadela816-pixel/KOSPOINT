<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Menampilkan notifikasi milik pengguna yang sedang login
    public function index()
    {
        $notifications = Auth::user()
            ->notifikasiKosPoint()
            ->latest()
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    // Menandai satu notifikasi sebagai sudah dibaca
    public function markAsRead(Notification $notification)
    {
        $notification = Auth::user()
            ->notifikasiKosPoint()
            ->findOrFail($notification->id);

        $notification->update([
            'dibaca' => true,
        ]);

        return redirect()->route('notifications.index')
            ->with('success', 'Notifikasi berhasil ditandai sudah dibaca.');
    }
}
