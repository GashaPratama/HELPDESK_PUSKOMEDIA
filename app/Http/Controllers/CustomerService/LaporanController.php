<?php

namespace App\Http\Controllers\CustomerService;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // Dashboard CS: menampilkan semua laporan customer
    public function index()
    {
        $laporans = Laporan::with(['customer', 'teknisi', 'kategori'])
                            ->whereHas('customer', fn($q) => $q->where('role', 'customer'))
                            ->latest()
                            ->get();

        $teknisis = User::where('role', 'teknisi')->get();

        return view('customerservice.dashboard', compact('laporans', 'teknisis'));
    }

    // Tombol Kirim ke teknisi → ubah status menjadi 'dikirim'
    public function kirim($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->status = 'dikirim';
        $laporan->save();

        return back()->with('success', 'Laporan berhasil dikirim ke teknisi.');
    }

    // Update laporan (status, notes, assigned_to)
    public function update(Request $request, $id)
    {
        $request->validate([
            'status'       => 'required|in:Diproses,Diterima,Ditolak,Selesai',
            'notes'        => 'nullable|string',
            'assigned_to'  => 'nullable|exists:users,id',
        ]);

        $laporan = Laporan::findOrFail($id);

        $laporan->update([
            'status'      => $request->status,
            'notes'       => $request->notes,
            'assigned_to' => $request->assigned_to,
        ]);

        return back()->with('success', 'Laporan berhasil diperbarui.');
    }

    // Hapus laporan
    public function destroy($id)
    {
        Laporan::findOrFail($id)->delete();

        return back()->with('success', 'Laporan berhasil dihapus.');
    }
}
