<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;

class TeknisiLaporanController extends Controller
{
    public function index()
    {
        // Hanya tampilkan laporan yang sudah dikirim CS
        $laporans = Laporan::with(['customer','kategori'])
                            ->where('status', 'dikirim')
                            ->latest()
                            ->get();

        return view('teknisi.dashboard', compact('laporans'));
    }

    public function show($id)
    {
        $laporan = Laporan::with(['customer','kategori'])->findOrFail($id);

        return view('teknisi.laporan.show', compact('laporan'));
    }

    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        $request->validate([
            'status' => 'required|string',
            'notes' => 'nullable|string|max:255',
        ]);

        $laporan->update([
            'status' => $request->status,
            'notes'  => $request->notes,
        ]);

        return redirect()->route('dashboard.teknisi')
                         ->with('success', 'Laporan berhasil diperbarui.');
    }
}
