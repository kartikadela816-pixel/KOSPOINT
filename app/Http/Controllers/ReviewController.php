<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Kos $kos)
    {
        $sudahMenyewa = auth()->user()->rentals()
            ->where('kos_id', $kos->id)
            ->where('status', 'aktif')
            ->exists();

        abort_unless($sudahMenyewa, 403, 'Kamu harus menjadi penyewa untuk memberikan ulasan.');

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:2000',
        ]);

        Review::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'kos_id' => $kos->id,
            ],
            $data
        );

        return back()->with('success', 'Ulasan berhasil disimpan.');
    }

    public function destroy(Review $review)
    {
        abort_unless($review->user_id === auth()->id(), 403);

        $review->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
