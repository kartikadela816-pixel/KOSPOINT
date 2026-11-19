<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Kos;

class FavoriteController extends Controller
{
    public function toggle(Kos $kos)
    {
        $favorite = Favorite::where('user_id', auth()->id())
            ->where('kos_id', $kos->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $message = 'Kos dihapus dari favorit.';
        } else {
            Favorite::create([
                'user_id' => auth()->id(),
                'kos_id' => $kos->id,
            ]);

            $message = 'Kos berhasil disimpan ke favorit.';
        }

        return back()->with('success', $message);
    }

    public function index()
    {
        $favorites = Favorite::with('kos.foto')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('pencari.favorit', [
            'favorit' => $favorites
        ]);
    }
}
