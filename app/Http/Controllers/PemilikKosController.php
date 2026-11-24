<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use App\Models\Booking;
use App\Models\KamarKos;
use App\Models\Payment;

class PemilikKosController extends Controller
{
    public function dashboard()
    {
        $userId = auth()->id();

        $kosIds = Kos::where('pemilik_id', $userId)->pluck('id');

        $jumlahKos = $kosIds->count();

        $jumlahKamar = KamarKos::whereIn('kos_id', $kosIds)->count();

        $jumlahBooking = Booking::whereIn('kos_id', $kosIds)->count();

        $bookingMenunggu = Booking::with(['user', 'kos', 'kamar'])
            ->whereIn('kos_id', $kosIds)
            ->where('status', 'menunggu')
            ->latest()
            ->get();

        $pendapatan = Payment::whereHas('booking', function ($query) use ($kosIds) {
            $query->whereIn('kos_id', $kosIds);
        })->where('status', 'dibayar')->sum('jumlah');

        return view('pemilik.dashboard', compact(
            'jumlahKos',
            'jumlahKamar',
            'jumlahBooking',
            'bookingMenunggu',
            'pendapatan'
        ));
    }

    public function kosSaya()
    {
        $kos = Kos::with('foto', 'kamar')
            ->where('pemilik_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('pemilik.kos.index', compact('kos'));
    }

    public function createKos()
    {
        return view('pemilik.kos.create');
    }

    public function editKos(Kos $kos)
    {
        abort_unless($kos->pemilik_id === auth()->id(), 403);

        return view('pemilik.kos.edit', compact('kos'));
    }

    public function bookingMasuk()
    {
        $kosIds = Kos::where('pemilik_id', auth()->id())->pluck('id');

        $bookings = Booking::with(['user', 'kos', 'kamar'])
            ->whereIn('kos_id', $kosIds)
            ->latest()
            ->paginate(10);

        return view('pemilik.booking.index', compact('bookings'));
    }
}