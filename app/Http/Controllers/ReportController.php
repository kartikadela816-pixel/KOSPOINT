<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // Menampilkan laporan milik pengguna
    public function index()
    {
        $reports = Report::where('id_pelapor', Auth::id())
            ->latest()
            ->get();

        return view('reports.index', compact('reports'));
    }

    // Menyimpan laporan baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_laporan' => 'required|string',
        ]);

        Report::create([
            'id_pelapor' => Auth::id(),
            'judul' => $request->judul,
            'isi_laporan' => $request->isi_laporan,
        ]);

        return redirect()
            ->route('reports.index')
            ->with('success', 'Laporan berhasil dikirim.');
    }

    // Menampilkan semua laporan untuk admin
    public function adminIndex()
    {
        $reports = Report::with('pelapor')
            ->latest()
            ->get();

        return view('admin.reports.index', compact('reports'));
    }

    // Admin memberikan tanggapan dan mengubah status
    public function update(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
            'tanggapan' => 'nullable|string',
        ]);

        $report->update([
            'status' => $request->status,
            'tanggapan' => $request->tanggapan,
        ]);

        return redirect()
            ->route('admin.reports.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }
}