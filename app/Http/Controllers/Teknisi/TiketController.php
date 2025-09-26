<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TiketController extends Controller
{
    public function index()
    {
        // Get all tickets with related data
        $tickets = Laporan::with(['kategori', 'customer'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get categories for filter
        $kategories = Kategori::all();

        // Get status options
        $statuses = ['Diproses', 'Selesai', 'Ditolak'];

        // Get statistics
        $stats = [
            'total' => $tickets->count(),
            'diproses' => $tickets->where('status', 'Diproses')->count(),
            'selesai' => $tickets->where('status', 'Selesai')->count(),
            'ditolak' => $tickets->where('status', 'Ditolak')->count(),
        ];

        return view('teknisi.dashboard', compact('tickets', 'kategories', 'statuses', 'stats'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Diproses,Selesai,Ditolak',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            $ticket = Laporan::findOrFail($id);
            $ticket->update([
                'status' => $request->status,
                'notes' => $request->notes,
                'assigned_to' => auth()->id(),
            ]);

            Log::info('Ticket status updated', [
                'ticket_id' => $ticket->id,
                'old_status' => $ticket->getOriginal('status'),
                'new_status' => $request->status,
                'updated_by' => auth()->user()->nama_lengkap,
            ]);

            return redirect()->back()->with('success', 'Status tiket berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Failed to update ticket status', [
                'ticket_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Gagal memperbarui status tiket!');
        }
    }

    public function remove(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        try {
            $ticket = Laporan::findOrFail($id);
            
            // Log before deletion
            Log::info('Ticket removed', [
                'ticket_id' => $ticket->id,
                'ticket_data' => $ticket->toArray(),
                'removed_by' => auth()->user()->nama_lengkap,
                'reason' => $request->reason,
            ]);

            $ticket->delete();

            return redirect()->back()->with('success', 'Tiket berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Failed to remove ticket', [
                'ticket_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Gagal menghapus tiket!');
        }
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'selected_tickets' => 'required|array|min:1',
            'selected_tickets.*' => 'exists:laporans,id',
            'action' => 'required|in:update_status,remove',
            'status' => 'required_if:action,update_status|in:Diproses,Selesai,Ditolak',
            'notes' => 'nullable|string|max:1000',
            'reason' => 'required_if:action,remove|string|max:500',
        ]);

        try {
            $ticketIds = $request->selected_tickets;
            $action = $request->action;

            if ($action === 'update_status') {
                Laporan::whereIn('id', $ticketIds)->update([
                    'status' => $request->status,
                    'notes' => $request->notes,
                    'assigned_to' => auth()->id(),
                ]);

                Log::info('Bulk status update', [
                    'ticket_ids' => $ticketIds,
                    'new_status' => $request->status,
                    'updated_by' => auth()->user()->nama_lengkap,
                ]);

                return redirect()->back()->with('success', count($ticketIds) . ' tiket berhasil diperbarui!');
            } else if ($action === 'remove') {
                $tickets = Laporan::whereIn('id', $ticketIds)->get();
                
                Log::info('Bulk ticket removal', [
                    'ticket_ids' => $ticketIds,
                    'ticket_data' => $tickets->toArray(),
                    'removed_by' => auth()->user()->nama_lengkap,
                    'reason' => $request->reason,
                ]);

                Laporan::whereIn('id', $ticketIds)->delete();

                return redirect()->back()->with('success', count($ticketIds) . ' tiket berhasil dihapus!');
            }
        } catch (\Exception $e) {
            Log::error('Bulk operation failed', [
                'action' => $action,
                'ticket_ids' => $request->selected_tickets,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Gagal melakukan operasi bulk!');
        }
    }

    public function getTicketDetails($id)
    {
        try {
            $ticket = Laporan::with(['kategori', 'customer'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $ticket->ticket_id ?? $ticket->id,
                    'kategori' => $ticket->kategori->nama ?? 'Tidak ada kategori',
                    'deskripsi' => $ticket->kendala ?? 'Tidak ada deskripsi',
                    'status' => $ticket->status ?? 'Tidak ada status',
                    'link' => $ticket->url_situs ?? '',
                    'customer' => $ticket->customer->nama_lengkap ?? 'N/A',
                    'created_at' => $ticket->created_at ? $ticket->created_at->format('d M Y H:i') : '-',
                    'notes' => $ticket->notes ?? '',
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak ditemukan!'
            ], 404);
        }
    }

    // Bulk delete tickets (soft delete)
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
                return redirect()->route('teknisi.dashboard')
                    ->with('error', 'Tidak ada tiket yang valid untuk dihapus!');
            }
            
            $count = Laporan::whereIn('id', $ticketIds)->delete();

            return redirect()->route('teknisi.dashboard')
                ->with('success', "{$count} tiket berhasil dipindahkan ke arsip!");
        } catch (\Exception $e) {
            return redirect()->route('teknisi.dashboard')
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
            
            \Log::info('Starting delete all tickets (Teknisi)', [
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
            
            \Log::info('All tickets deleted successfully (Teknisi)', [
                'deleted_count' => $deletedCount,
                'user_id' => auth()->id()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => "Berhasil menghapus {$deletedCount} laporan secara permanen!",
                'deleted_count' => $deletedCount
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error deleting all tickets (Teknisi)', [
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

