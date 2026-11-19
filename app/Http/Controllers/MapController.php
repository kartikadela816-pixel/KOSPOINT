<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        return view('peta.index');
    }

    public function locations(Request $request)
    {
        $kos = Kos::where('status', 'aktif')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->when($request->filled('tipe'), function ($query) use ($request) {
                $query->where('tipe_kos', $request->tipe);
            })
            ->get([
                'id',
                'nama_kos',
                'alamat',
                'kota',
                'latitude',
                'longitude',
                'harga_mulai',
                'slug',
            ]);

        return response()->json($kos);
    }
}
