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
        // Get all laporan (tickets) - CS should see all tickets
        $laporans = Laporan::with(['customer', 'teknisi', 'kategori'])->latest()->get();

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
            'status'       => 'required|in:Diproses,Ditolak,Selesai',
            'notes'        => 'nullable|string',
            'assigned_to'  => 'nullable|exists:user,id_user',
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

    // Bulk delete laporan (soft delete)
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ticket_ids' => 'required|array',
            'ticket_ids.*' => 'exists:laporans,id'
        ]);

        try {
            $ticketIds = $request->ticket_ids;
            
            // Filter out invalid values
            $ticketIds = array_filter($ticketIds, function($id) {
                return is_numeric($id) && $id > 0;
            });
            
            if (empty($ticketIds)) {
                return redirect()->route('dashboard.customerservice')
                    ->with('error', 'Tidak ada tiket yang valid untuk dihapus!');
            }
            
            $count = Laporan::whereIn('id', $ticketIds)->delete();

            return redirect()->route('dashboard.customerservice')
                ->with('success', "{$count} tiket berhasil dipindahkan ke arsip!");
        } catch (\Exception $e) {
            return redirect()->route('dashboard.customerservice')
                ->with('error', 'Gagal menghapus tiket: ' . $e->getMessage());
        }
    }

    /**
     * Delete all tickets permanently
     */
    public function deleteAll(Request $request)
    {
        try {
            // Get count before deletion for logging
            $totalCount = Laporan::count();
            
            \Log::info('Starting delete all tickets (Customer Service)', [
                'user_id' => auth()->id(),
                'total_tickets' => $totalCount
            ]);
            
            if ($totalCount == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada laporan yang bisa dihapus!'
                ]);
            }
            
            // Delete all tickets permanently
            $deletedCount = Laporan::query()->delete();
            
            \Log::info('All tickets deleted successfully (Customer Service)', [
                'deleted_count' => $deletedCount,
                'user_id' => auth()->id()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => "Berhasil menghapus {$deletedCount} laporan secara permanen!",
                'deleted_count' => $deletedCount
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error deleting all tickets (Customer Service)', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export laporan to CSV
     */
    public function export()
    {
        $laporans = Laporan::with(['customer', 'teknisi', 'kategori'])->latest()->get();
        
        $filename = 'laporan_customer_service_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($laporans) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'ID',
                'Ticket ID', 
                'Customer',
                'Email Customer',
                'Kategori',
                'Kendala',
                'Status',
                'Assigned To',
                'Tanggal Dibuat',
                'Tanggal Update'
            ]);
            
            // Data CSV
            foreach ($laporans as $laporan) {
                fputcsv($file, [
                    $laporan->id,
                    $laporan->ticket_id,
                    $laporan->customer->nama_lengkap ?? 'N/A',
                    $laporan->customer->email ?? 'N/A',
                    $laporan->kategori->nama ?? 'N/A',
                    $laporan->kendala,
                    $laporan->status,
                    $laporan->teknisi->nama_lengkap ?? 'Belum di-assign',
                    $laporan->created_at->format('d/m/Y H:i'),
                    $laporan->updated_at->format('d/m/Y H:i')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
