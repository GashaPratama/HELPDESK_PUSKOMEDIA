<?php

namespace App\Http\Controllers\CustomerService;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArchiveController extends Controller
{
    /**
     * Display archived tickets
     */
    public function index()
    {
        $archivedTickets = Laporan::onlyTrashed()
            ->with(['customer', 'kategori', 'teknisi'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        return view('customerservice.archive.index', compact('archivedTickets'));
    }

    /**
     * Restore a ticket from archive
     */
    public function restore($id)
    {
        try {
            $ticket = Laporan::onlyTrashed()->findOrFail($id);
            $ticket->restore();

            return redirect()->route('customerservice.archive.index')
                ->with('success', 'Tiket berhasil dipulihkan dari arsip!');
        } catch (\Exception $e) {
            return redirect()->route('customerservice.archive.index')
                ->with('error', 'Gagal memulihkan tiket: ' . $e->getMessage());
        }
    }

    /**
     * Permanently delete a ticket
     */
    public function forceDelete($id)
    {
        try {
            $ticket = Laporan::onlyTrashed()->findOrFail($id);
            
            // Delete associated file if exists
            if ($ticket->lampiran && \Storage::disk('public')->exists($ticket->lampiran)) {
                \Storage::disk('public')->delete($ticket->lampiran);
            }
            
            $ticket->forceDelete();

            return redirect()->route('customerservice.archive.index')
                ->with('success', 'Tiket berhasil dihapus permanen!');
        } catch (\Exception $e) {
            return redirect()->route('customerservice.archive.index')
                ->with('error', 'Gagal menghapus tiket: ' . $e->getMessage());
        }
    }

    /**
     * Bulk restore tickets
     */
    public function bulkRestore(Request $request)
    {
        $request->validate([
            'ticket_ids' => 'required|array',
            'ticket_ids.*' => 'exists:laporans,id'
        ]);

        try {
            $count = Laporan::onlyTrashed()
                ->whereIn('id', $request->ticket_ids)
                ->restore();

            return redirect()->route('customerservice.archive.index')
                ->with('success', "{$count} tiket berhasil dipulihkan dari arsip!");
        } catch (\Exception $e) {
            return redirect()->route('customerservice.archive.index')
                ->with('error', 'Gagal memulihkan tiket: ' . $e->getMessage());
        }
    }

    /**
     * Bulk permanent delete tickets
     */
    public function bulkForceDelete(Request $request)
    {
        $request->validate([
            'ticket_ids' => 'required|array',
            'ticket_ids.*' => 'exists:laporans,id'
        ]);

        try {
            $tickets = Laporan::onlyTrashed()->whereIn('id', $request->ticket_ids)->get();
            
            foreach ($tickets as $ticket) {
                // Delete associated file if exists
                if ($ticket->lampiran && \Storage::disk('public')->exists($ticket->lampiran)) {
                    \Storage::disk('public')->delete($ticket->lampiran);
                }
            }
            
            $count = Laporan::onlyTrashed()->whereIn('id', $request->ticket_ids)->forceDelete();

            return redirect()->route('customerservice.archive.index')
                ->with('success', "{$count} tiket berhasil dihapus permanen!");
        } catch (\Exception $e) {
            return redirect()->route('customerservice.archive.index')
                ->with('error', 'Gagal menghapus tiket: ' . $e->getMessage());
        }
    }
}