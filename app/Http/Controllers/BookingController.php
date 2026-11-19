<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use App\Models\Booking;
use App\Models\KamarKos;
use App\Models\Rental;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function store(Request $request, Kos $kos)
    {
        abort_unless($kos->status === 'aktif', 404);

        $data = $request->validate([
            'kamar_id' => 'required|exists:kamar_kos,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'nullable|date|after:tanggal_mulai',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $booking = DB::transaction(function () use ($data, $kos) {
            $kamar = KamarKos::where('kos_id', $kos->id)
                ->whereKey($data['kamar_id'])
                ->lockForUpdate()
                ->firstOrFail();

            abort_unless($kamar->status === 'tersedia', 422);

            $total = $kamar->harga;

            $booking = Booking::create([
                'user_id' => auth()->id(),
                'kos_id' => $kos->id,
                'kamar_id' => $kamar->id,
                'tanggal_mulai' => $data['tanggal_mulai'],
                'tanggal_selesai' => $data['tanggal_selesai'] ?? null,
                'total_harga' => $total,
                'catatan' => $data['catatan'] ?? null,
            ]);

            Notification::create([
                'user_id' => $kos->pemilik_id,
                'judul' => 'Pengajuan sewa baru',
                'pesan' => 'Ada pengajuan sewa baru untuk ' . $kos->nama_kos,
                'tipe' => 'booking',
            ]);

            return $booking;
        });

        return redirect()->route('pencari.booking')
            ->with('success', 'Pengajuan berhasil dikirim.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        abort_unless(
            $booking->kos()->where('pemilik_id', auth()->id())->exists(),
            403
        );

        $data = $request->validate([
            'status' => 'required|in:disetujui,ditolak',
        ]);

        DB::transaction(function () use ($booking, $data) {
            $booking = Booking::whereKey($booking->id)
                ->lockForUpdate()
                ->firstOrFail();

            abort_unless($booking->status === 'menunggu', 422);

            if ($data['status'] === 'disetujui') {
                $kamar = KamarKos::whereKey($booking->kamar_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                abort_unless($kamar->status === 'tersedia', 422);

                $kamar->update(['status' => 'terisi']);

                Rental::create([
                    'booking_id' => $booking->id,
                    'user_id' => $booking->user_id,
                    'kos_id' => $booking->kos_id,
                    'kamar_id' => $booking->kamar_id,
                    'tanggal_masuk' => $booking->tanggal_mulai,
                    'tanggal_keluar' => $booking->tanggal_selesai,
                    'status' => 'aktif',
                ]);
            }

            $booking->update(['status' => $data['status']]);

            Notification::create([
                'user_id' => $booking->user_id,
                'judul' => 'Status pengajuan diperbarui',
                'pesan' => 'Pengajuan sewa kamu ' . $data['status'] . '.',
                'tipe' => 'booking',
            ]);
        });

        return back()->with('success', 'Status pengajuan diperbarui.');
    }

    public function cancel(Booking $booking)
    {
        abort_unless($booking->user_id === auth()->id(), 403);

        abort_unless($booking->status === 'menunggu', 422);

        $booking->update(['status' => 'dibatalkan']);

        return back()->with('success', 'Pengajuan berhasil dibatalkan.');
    }
}