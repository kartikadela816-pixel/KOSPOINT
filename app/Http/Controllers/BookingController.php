<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\KamarKos;
use App\Models\Kos;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    // ===== Pencari =====

    public function index()
    {
        $bookings = Booking::with(['kamar', 'rental'])
            ->where('id_pencari', Auth::id())
            ->latest('tanggal_booking')
            ->get();

        return view('booking.index', compact('bookings'));
    }

    public function store(Request $request, $kamar)
    {
        abort_unless(Auth::user()->isPencari(), 403);

        $data = $request->validate([
            'tanggal_masuk_rencana' => 'required|date|after_or_equal:today',
            'lama_sewa_bulan' => 'required|integer|min:1|max:36',
            'catatan_pencari' => 'nullable|string|max:1000',
        ]);

        return DB::transaction(function () use ($data, $kamar) {
            $kamarKos = KamarKos::lockForUpdate()->findOrFail($kamar);

            if ($kamarKos->status_kamar !== 'tersedia') {
                return back()->with('error', 'Kamar ini sedang tidak tersedia.');
            }

            Booking::create($data + [
                'id_pencari' => Auth::id(),
                'id_kamar' => $kamarKos->id,
                'status_booking' => 'menunggu',
            ]);

            $kamarKos->update(['status_kamar' => 'dipesan']);

            return redirect()->route('booking.index')
                ->with('success', 'Booking berhasil diajukan. Tunggu konfirmasi pemilik.');
        });
    }

    public function batal(Booking $booking)
    {
        abort_unless($booking->id_pencari === Auth::id(), 403);

        if ($booking->status_booking !== 'menunggu') {
            return back()->with('error', 'Hanya booking berstatus menunggu yang bisa dibatalkan.');
        }

        DB::transaction(function () use ($booking) {
            $booking->update(['status_booking' => 'dibatalkan']);
            KamarKos::whereKey($booking->id_kamar)->update(['status_kamar' => 'tersedia']);
        });

        return back()->with('success', 'Booking dibatalkan.');
    }

    // ===== Pemilik =====

    public function masuk()
    {
        abort_unless(Auth::user()->isPemilik(), 403);

        $bookings = Booking::with(['pencari', 'kamar'])
            ->whereIn('id_kamar', $this->kamarMilikPemilik())
            ->latest('tanggal_booking')
            ->get();

        return view('booking.masuk', compact('bookings'));
    }

    public function terima(Request $request, Booking $booking)
    {
        $this->pastikanMilikPemilik($booking);

        if ($booking->status_booking !== 'menunggu') {
            return back()->with('error', 'Booking ini sudah diproses.');
        }

        DB::transaction(function () use ($request, $booking) {
            $kamar = KamarKos::findOrFail($booking->id_kamar);
            $mulai = $booking->tanggal_masuk_rencana;

            $booking->update([
                'status_booking' => 'diterima',
                'catatan_pemilik' => $request->input('catatan_pemilik'),
                'tanggal_ditanggapi' => now(),
            ]);

            Rental::create([
                'id_booking' => $booking->id,
                'id_pencari' => $booking->id_pencari,
                'id_kamar' => $booking->id_kamar,
                'tanggal_mulai' => $mulai,
                'tanggal_selesai' => $mulai->copy()->addMonths($booking->lama_sewa_bulan),
                'harga_per_bulan' => $kamar->harga_per_bulan,
                'uang_jaminan' => $kamar->uang_jaminan,
                'status_sewa' => 'aktif',
            ]);

            $kamar->update(['status_kamar' => 'terisi']);
        });

        return back()->with('success', 'Booking diterima dan data sewa dibuat.');
    }

    public function tolak(Request $request, Booking $booking)
    {
        $this->pastikanMilikPemilik($booking);

        if ($booking->status_booking !== 'menunggu') {
            return back()->with('error', 'Booking ini sudah diproses.');
        }

        DB::transaction(function () use ($request, $booking) {
            $booking->update([
                'status_booking' => 'ditolak',
                'catatan_pemilik' => $request->input('catatan_pemilik'),
                'tanggal_ditanggapi' => now(),
            ]);
            KamarKos::whereKey($booking->id_kamar)->update(['status_kamar' => 'tersedia']);
        });

        return back()->with('success', 'Booking ditolak.');
    }

    // ===== Helper =====

    private function kamarMilikPemilik()
    {
        $idKos = Kos::where('id_pemilik', Auth::id())->pluck('id');

        return KamarKos::whereIn('id_kos', $idKos)->pluck('id');
    }

    private function pastikanMilikPemilik(Booking $booking): void
    {
        abort_unless(Auth::user()->isPemilik(), 403);
        abort_unless($this->kamarMilikPemilik()->contains($booking->id_kamar), 403);
    }
}