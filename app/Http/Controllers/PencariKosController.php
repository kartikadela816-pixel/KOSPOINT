<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Favorite;
use App\Models\SearchHistory;

class PencariKosController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        $jumlahBooking = Booking::where('user_id', $user->id)->count();

        $jumlahFavorit = Favorite::where('user_id', $user->id)->count();

        $bookingTerbaru = Booking::with(['kos', 'kamar'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $riwayatPencarian = SearchHistory::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('pencari.dashboard', compact(
            'jumlahBooking',
            'jumlahFavorit',
            'bookingTerbaru',
            'riwayatPencarian'
        ));
    }

    public function bookingSaya()
    {
        $bookings = Booking::with(['kos', 'kamar', 'payment'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('pencari.booking', compact('bookings'));
    }

    public function favoritSaya()
    {
        $favorit = Favorite::with(['kos.foto', 'kos.fasilitas'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('pencari.favorit', compact('favorit'));
    }
}