<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Kategori;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * List tiket + filter (q, status, kategori_id) + pagination
     */
    public function index(Request $request)
    {
        $q        = $request->input('q');
        $status   = $request->input('status');
        $kategori = $request->input('kategori'); // <-- ini ID kategori dari dropdown

        // Dropdown kategori langsung dari tabel kategoris
        // hasil: ['1' => 'Hardware', '2' => 'Jaringan', ...]
        $categoryOptions = Kategori::orderBy('nama')->pluck('nama', 'id');

        $tickets = Laporan::with(['kategori']) // eager load biar di blade bisa $t->kategori->nama
            ->when($q, function ($qr) use ($q) {
                $qr->where(function ($w) use ($q) {
                    $w->where('kendala', 'like', "%{$q}%")
                      ->orWhere('url_situs', 'like', "%{$q}%")
                      ->orWhere('ticket_id', 'like', "%{$q}%")
                      ->orWhere('id', 'like', "%{$q}%");
                });
            })
            ->when($status, fn ($qr) => $qr->where('status', $status))
            ->when($kategori, fn ($qr) => $qr->where('kategori_id', $kategori))
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('superadmin.tickets.index', compact('tickets', 'q', 'status', 'kategori', 'categoryOptions'));
    }

    /**
     * Update status tiket (Di Cek / Diproses / Selesai / Ditolak)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Diterima,Diproses,Selesai,Ditolak',
        ]);

        // Cari berdasarkan ticket_id ATAU id (fallback)
        $ticket = Laporan::where('ticket_id', $id)
                    ->orWhere('id', $id)
                    ->firstOrFail();

        $ticket->status = $request->status;
        $ticket->save();

        return back()->with('success', 'Status tiket berhasil diperbarui.');
    }

    /**
     * Soft delete tiket (pindah ke arsip)
     */
    public function remove($id)
    {
        try {
            $ticket = Laporan::findOrFail($id);
            $ticket->delete(); // Soft delete

            return redirect()->route('superadmin.tickets.index')
                ->with('success', 'Tiket berhasil dipindahkan ke arsip!');
        } catch (\Exception $e) {
            return redirect()->route('superadmin.tickets.index')
                ->with('error', 'Gagal menghapus tiket: ' . $e->getMessage());
        }
    }

    /**
     * Bulk soft delete tiket
     */
    public function bulkDelete(Request $request)
    {
        \Log::info('Bulk delete request received', ['request' => $request->all()]);
        
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
            
            \Log::info('Deleting tickets', ['ticket_ids' => $ticketIds]);
            
            if (empty($ticketIds)) {
                return redirect()->route('superadmin.tickets.index')
                    ->with('error', 'Tidak ada tiket yang valid untuk dihapus!');
            }
            
            $count = Laporan::whereIn('id', $ticketIds)->delete();
            
            \Log::info('Tickets deleted successfully', ['count' => $count]);

            return redirect()->route('superadmin.tickets.index')
                ->with('success', "{$count} tiket berhasil dipindahkan ke arsip!");
        } catch (\Exception $e) {
            \Log::error('Error deleting tickets', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            
            return redirect()->route('superadmin.tickets.index')
                ->with('error', 'Gagal menghapus tiket: ' . $e->getMessage());
        }
    }

    /**
     * Opsional: endpoint kategori untuk kebutuhan lain (AJAX, dsb)
     */
    public function listCategories()
    {
        // Kembalikan array ['id' => 'nama'] agar mudah dipakai
        return response()->json(
            Kategori::orderBy('nama')->pluck('nama', 'id')
        );
    }

    /**
     * Delete all tickets permanently
     */
    public function deleteAll(Request $request)
    {
        try {
            // Get count before deletion for logging
            $totalCount = Laporan::count();
            
            \Log::info('Starting delete all tickets', [
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
            
            \Log::info('All tickets deleted successfully', [
                'deleted_count' => $deletedCount,
                'user_id' => auth()->id()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => "Berhasil menghapus {$deletedCount} laporan secara permanen!",
                'deleted_count' => $deletedCount
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error deleting all tickets', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}
