<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Report;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'jumlahPengguna' => User::count(),
            'jumlahKos' => Kos::count(),
            'kosMenunggu' => Kos::where('status', 'menunggu')->count(),
            'jumlahBooking' => Booking::count(),
            'jumlahPembayaran' => Payment::count(),
            'laporanMenunggu' => Report::where('status', 'menunggu')->count(),
        ]);
    }

    public function kos()
    {
        $kos = Kos::with('pemilik')->latest()->paginate(10);

        return view('admin.kos.index', compact('kos'));
    }

    public function verifikasiKos(Kos $kos, Request $request)
    {
        $data = $request->validate([
            'status' => 'required|in:aktif,ditolak,nonaktif',
        ]);

        $kos->update($data);

        return back()->with('success', 'Status kos berhasil diperbarui.');
    }

    public function pengguna()
    {
        $pengguna = User::latest()->paginate(10);

        return view('admin.pengguna.index', compact('pengguna'));
    }

    public function laporan()
    {
        $laporan = Report::with(['user', 'kos'])
            ->latest()->paginate(10);

        return view('admin.laporan.index', compact('laporan'));
    }

    public function updateLaporan(Request $request, Report $report)
    {
        $data = $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai',
        ]);

        $report->update($data);

        return back()->with('success', 'Laporan diperbarui.');
    }

    public function pembayaran()
    {
        $payments = Payment::with('booking.user', 'booking.kos')
            ->latest()->paginate(10);

        return view('admin.pembayaran.index', compact('payments'));
    }
}