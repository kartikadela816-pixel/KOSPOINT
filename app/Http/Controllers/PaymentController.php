<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // Menampilkan daftar pembayaran
    public function index()
    {
        $payments = Payment::with('rental')
            ->where('id_pencari', Auth::id())
            ->latest()
            ->get();

        return view('payments.index', compact('payments'));
    }

        // Menampilkan semua pembayaran untuk admin
    public function adminIndex()
    {
        $payments = Payment::with(['rental', 'pencari'])
            ->latest()
            ->get();

        return view('admin.payments.index', compact('payments'));
    }

    // Menampilkan formulir pembayaran
    public function create()
    {
        $rentals = Rental::where('id_pencari', Auth::id())
            ->where('status_sewa', 'aktif')
            ->get();

        return view('payments.create', compact('rentals'));
    }

    // Menyimpan data pembayaran
    public function store(Request $request)
    {
        $request->validate([
            'id_sewa' => 'required|exists:rentals,id',
            'jumlah_bayar' => 'required|numeric|min:1',
            'metode_pembayaran' => 'required|in:Transfer Bank,QRIS',
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Memastikan sewa milik pengguna yang sedang login
        $rental = Rental::where('id', $request->id_sewa)
            ->where('id_pencari', Auth::id())
            ->where('status_sewa', 'aktif')
            ->firstOrFail();

        // Menyimpan bukti pembayaran
        $bukti = $request->file('bukti_pembayaran')
            ->store('bukti-pembayaran', 'public');

        // Menyimpan pembayaran ke database
        Payment::create([
            'id_sewa' => $rental->id,
            'id_pencari' => Auth::id(),
            'jumlah_bayar' => $request->jumlah_bayar,
            'metode_pembayaran' => $request->metode_pembayaran,
            'bukti_pembayaran' => $bukti,
            'tanggal_bayar' => now(),
            'status_pembayaran' => 'menunggu',
        ]);

        return redirect()->route('payments.index')
            ->with('success', 'Pembayaran berhasil dikirim dan menunggu verifikasi.');
    }

     // Menyetujui pembayaran
    public function approve($id)
    {
        $payment = Payment::findOrFail($id);

        $payment->update([
            'status_pembayaran' => 'berhasil',
        ]);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Pembayaran berhasil disetujui.');
    }

    // Menolak pembayaran
    public function reject($id)
    {
        $payment = Payment::findOrFail($id);

        $payment->update([
            'status_pembayaran' => 'ditolak',
        ]);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Pembayaran berhasil ditolak.');
    }

}
