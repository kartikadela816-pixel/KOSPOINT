<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Menampilkan daftar sewa yang bisa diberi ulasan
    public function index()
    {
        $rentals = Rental::with(['kamar.kos', 'reviews'])
            ->where('id_pencari', Auth::id())
            ->whereIn('status_sewa', ['aktif', 'selesai'])
            ->latest()
            ->get();

        return view('reviews.index', compact('rentals'));
    }

    // Menyimpan ulasan
    public function store(Request $request)
    {
        $request->validate([
            'id_sewa' => 'required|exists:rentals,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        $rental = Rental::where('id', $request->id_sewa)
            ->where('id_pencari', Auth::id())
            ->whereIn('status_sewa', ['aktif', 'selesai'])
            ->firstOrFail();

        if ($rental->reviews()->exists()) {
            return back()->withErrors([
                'id_sewa' => 'Sewa ini sudah memiliki ulasan.',
            ]);
        }

        $rental->reviews()->create([
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return redirect()->route('reviews.index')
            ->with('success', 'Ulasan berhasil dikirim.');
    }
}
