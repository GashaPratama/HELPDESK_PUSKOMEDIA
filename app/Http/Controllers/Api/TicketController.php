<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TicketController extends Controller
{
    /**
     * Get latest tickets for real-time updates
     */
    public function getLatestTickets(Request $request): JsonResponse
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $query = Laporan::with(['customer', 'kategori']);

        // Filter based on user role
        switch ($user->role) {
            case 'superadmin':
                // Superadmin sees all tickets
                break;
            case 'customerservice':
                // Customer Service sees all tickets
                break;
            case 'teknisi':
                // Teknisi sees only assigned tickets
                \Log::info('Teknisi filter applied', [
                    'user_id' => $user->id_user,
                    'role' => $user->role
                ]);
                $query->where('assigned_to', $user->id_user);
                break;
            case 'customer':
                // Customer sees only their own tickets
                $query->where('user_id', $user->id_user);
                break;
        }

        // Get latest tickets (not limited by time)
        $tickets = $query->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get counts for dashboard (filtered by role)
        $countQuery = Laporan::whereNull('deleted_at');
        
        // Apply same role filter for counts
        switch ($user->role) {
            case 'teknisi':
                \Log::info('Teknisi counts filter applied', [
                    'user_id' => $user->id_user,
                    'role' => $user->role
                ]);
                $countQuery->where('assigned_to', $user->id_user);
                break;
            case 'customer':
                $countQuery->where('user_id', $user->id_user);
                break;
            // superadmin and customerservice see all
        }
        
        $counts = [
            'total' => $countQuery->count(),
            'diproses' => $countQuery->where('status', 'Diproses')->count(),
            'selesai' => $countQuery->where('status', 'Selesai')->count(),
            'ditolak' => $countQuery->where('status', 'Ditolak')->count(),
        ];

        // Get recent activities (filtered by role)
        $activityQuery = Laporan::with(['customer', 'kategori'])
            ->whereNull('deleted_at');
            
        // Apply same role filter for activities
        switch ($user->role) {
            case 'teknisi':
                $activityQuery->where('assigned_to', $user->id_user);
                break;
            case 'customer':
                $activityQuery->where('user_id', $user->id_user);
                break;
            // superadmin and customerservice see all
        }
        
        $activities = $activityQuery->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($ticket) {
                return [
                    'id' => $ticket->id,
                    'ticket_id' => $ticket->ticket_id,
                    'customer' => $ticket->customer->nama_lengkap ?? 'N/A',
                    'status' => $ticket->status,
                    'kategori' => $ticket->kategori->nama ?? 'N/A',
                    'created_at' => $ticket->created_at->diffForHumans(),
                    'kendala' => $ticket->kendala,
                    'foto' => $ticket->foto ? asset('storage/' . $ticket->foto) : null,
                ];
            });

        return response()->json([
            'success' => true,
            'tickets' => $tickets,
            'counts' => $counts,
            'activities' => $activities,
            'timestamp' => now()->toISOString(),
        ]);
    }

    /**
     * Get ticket counts for dashboard
     */
    public function getTicketCounts(): JsonResponse
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $query = Laporan::query();

        // Filter based on user role
        switch ($user->role) {
            case 'teknisi':
                $query->where('assigned_to', $user->id_user);
                break;
            case 'customer':
                $query->where('user_id', $user->id_user);
                break;
        }

        $counts = [
            'total' => $query->count(),
            'diproses' => $query->where('status', 'Diproses')->count(),
            'selesai' => $query->where('status', 'Selesai')->count(),
            'ditolak' => $query->where('status', 'Ditolak')->count(),
        ];

        return response()->json([
            'success' => true,
            'counts' => $counts,
            'timestamp' => now()->toISOString(),
        ]);
    }
}

