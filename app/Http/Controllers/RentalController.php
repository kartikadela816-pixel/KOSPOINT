<?php

namespace App\Http\Controllers;

use App\Models\KamarKos;
use App\Models\Kos;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;

class RentalController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = Rental::with(['kamar', 'pencari'])->latest('tanggal_mulai');

        if ($user->isPemilik()) {
            $query->whereIn('id_kamar', $this->kamarMilikPemilik());
        } else {
            $query->where('id_pencari', $user->id);
        }

        $rentals = $query->get();

        return view('rental.index', compact('rentals'));
    }

    public function show(Rental $rental)
    {
        $user = Auth::user();

        $boleh = $user->isPemilik()
            ? $this->kamarMilikPemilik()->contains($rental->id_kamar)
            : $rental->id_pencari === $user->id;

        abort_unless($boleh, 403);

        $rental->load(['kamar', 'pencari', 'booking']);

        return view('rental.show', compact('rental'));
    }

    private function kamarMilikPemilik()
    {
        $idKos = Kos::where('id_pemilik', Auth::id())->pluck('id');

        return KamarKos::whereIn('id_kos', $idKos)->pluck('id');
    }
}
