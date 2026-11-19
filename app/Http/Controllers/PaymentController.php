<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function create(Booking $booking)
    {
        abort_unless($booking->user_id === auth()->id(), 403);

        abort_unless($booking->status === 'disetujui', 422);

        $payment = Payment::firstOrCreate(
            ['booking_id' => $booking->id],
            [
                'kode_pembayaran' => 'KSP-' . Str::upper(Str::random(10)),
                'jumlah' => $booking->total_harga,
            ]
        );

        return view('pencari.pembayaran', compact('booking', 'payment'));
    }

    public function store(Request $request, Payment $payment)
    {
        abort_unless(
            $payment->booking->user_id === auth()->id(),
            403
        );

        abort_unless($payment->status === 'menunggu', 422);

        $data = $request->validate([
            'metode_pembayaran' => 'required|in:transfer_bank,e_wallet,tunai',
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('bukti_pembayaran')
            ->store('pembayaran', 'public');

        $payment->update([
            'metode_pembayaran' => $data['metode_pembayaran'],
            'bukti_pembayaran' => $path,
            'tanggal_pembayaran' => now(),
        ]);

        return back()->with(
            'success',
            'Bukti pembayaran berhasil dikirim untuk diperiksa.'
        );
    }

    public function verify(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'status' => 'required|in:dibayar,ditolak',
        ]);

        $payment->update($data);

        return back()->with('success', 'Status pembayaran diperbarui.');
    }
}
