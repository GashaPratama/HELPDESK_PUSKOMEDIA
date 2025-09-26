<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    
    /**
     * Export tickets to CSV
     */
    public function exportTicketsCSV(Request $request)
    {
        try {
            $query = Laporan::with(['customer', 'kategori', 'teknisi']);
            
            // Apply filters
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            if ($request->filled('kategori_id')) {
                $query->where('kategori_id', $request->kategori_id);
            }
            
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            
            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }
            
            $tickets = $query->orderBy('created_at', 'desc')->get();
            
            $filename = 'laporan-tiket-' . now()->format('Y-m-d') . '.csv';
            
            // Create CSV content
            $csvContent = "\xEF\xBB\xBF"; // BOM for UTF-8
            
            // Add headers
            $csvContent .= "Ticket ID,Customer,Email,Telepon,Kategori,Kendala,Status,Teknisi,Tanggal Dibuat,Tanggal Diupdate\n";
            
            // Add data rows
            foreach ($tickets as $ticket) {
                $row = [
                    $ticket->ticket_id ?? $ticket->id,
                    '"' . str_replace('"', '""', $ticket->customer->nama_lengkap ?? 'N/A') . '"',
                    '"' . str_replace('"', '""', $ticket->customer->email ?? 'N/A') . '"',
                    '"' . str_replace('"', '""', $ticket->customer->no_telpon ?? 'N/A') . '"',
                    '"' . str_replace('"', '""', $ticket->kategori->nama ?? 'N/A') . '"',
                    '"' . str_replace('"', '""', $ticket->kendala ?? '') . '"',
                    '"' . str_replace('"', '""', $ticket->status ?? '') . '"',
                    '"' . str_replace('"', '""', $ticket->teknisi->nama_lengkap ?? 'Belum ditugaskan') . '"',
                    '"' . ($ticket->created_at ? $ticket->created_at->format('d/m/Y H:i') : 'N/A') . '"',
                    '"' . ($ticket->updated_at ? $ticket->updated_at->format('d/m/Y H:i') : 'N/A') . '"'
                ];
                
                $csvContent .= implode(',', $row) . "\n";
            }
            
            return response($csvContent, 200, [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('CSV Export Error: ' . $e->getMessage());
            return response()->json(['error' => 'Export failed: ' . $e->getMessage()], 500);
        }
    }
    
    
    /**
     * Export users to CSV
     */
    public function exportUsersCSV(Request $request)
    {
        try {
            $query = User::query();
            
            // Apply filters
            if ($request->filled('role')) {
                $query->where('role', $request->role);
            }
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('no_telpon', 'like', "%{$search}%");
                });
            }
            
            $users = $query->orderBy('created_at', 'desc')->get();
            
            $filename = 'laporan-user-' . now()->format('Y-m-d') . '.csv';
            
            // Create CSV content
            $csvContent = "\xEF\xBB\xBF"; // BOM for UTF-8
            
            // Add headers
            $csvContent .= "ID User,Nama Lengkap,Email,Telepon,Jenis Kelamin,Tanggal Lahir,Role,Tanggal Registrasi,Terakhir Update\n";
            
            // Add data rows
            foreach ($users as $user) {
                // Handle tanggal_lahir - check if it's Carbon instance or string
                $tanggal_lahir = 'N/A';
                if ($user->tanggal_lahir) {
                    if (is_string($user->tanggal_lahir)) {
                        try {
                            $tanggal_lahir = \Carbon\Carbon::parse($user->tanggal_lahir)->format('d/m/Y');
                        } catch (\Exception $e) {
                            $tanggal_lahir = $user->tanggal_lahir;
                        }
                    } else {
                        $tanggal_lahir = $user->tanggal_lahir->format('d/m/Y');
                    }
                }
                
                $row = [
                    $user->id_user,
                    '"' . str_replace('"', '""', $user->nama_lengkap ?? '') . '"',
                    '"' . str_replace('"', '""', $user->email ?? '') . '"',
                    '"' . str_replace('"', '""', $user->no_telpon ?? '') . '"',
                    '"' . str_replace('"', '""', $user->jenis_kelamin ?? '') . '"',
                    '"' . $tanggal_lahir . '"',
                    '"' . ucfirst(str_replace('_', ' ', $user->role ?? '')) . '"',
                    '"' . ($user->created_at ? $user->created_at->format('d/m/Y H:i') : 'N/A') . '"',
                    '"' . ($user->updated_at ? $user->updated_at->format('d/m/Y H:i') : 'N/A') . '"'
                ];
                
                $csvContent .= implode(',', $row) . "\n";
            }
            
            return response($csvContent, 200, [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('CSV Export Error: ' . $e->getMessage());
            return response()->json(['error' => 'Export failed: ' . $e->getMessage()], 500);
        }
    }
    
}