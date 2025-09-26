<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TicketNoteController extends Controller
{
    /**
     * Add note to ticket
     */
    public function addNote(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|string',
            'note' => 'required|string|max:1000',
            'target_role' => 'required|string|in:superadmin,customer_service,teknisi,customer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $laporan = Laporan::where('ticket_id', $request->ticket_id)->first();
            
            if (!$laporan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ticket not found'
                ], 404);
            }

            // Update note with target role and from role
            $laporan->update([
                'note' => $request->note,
                'note_target_role' => $request->target_role,
                'note_from_role' => auth()->user()->role,
                'note_created_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Note added successfully',
                'data' => [
                    'ticket_id' => $laporan->ticket_id,
                    'note' => $laporan->note,
                    'updated_at' => $laporan->updated_at->format('Y-m-d H:i:s')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add note: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Assign ticket to teknisi
     */
    public function assignTicket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|string',
            'teknisi_id' => 'required|integer|exists:users,id_user',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $laporan = Laporan::where('ticket_id', $request->ticket_id)->first();
            
            if (!$laporan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ticket not found'
                ], 404);
            }

            // Check if teknisi exists and has teknisi role
            $teknisi = User::where('id_user', $request->teknisi_id)
                          ->where('role', 'teknisi')
                          ->first();
            
            if (!$teknisi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Teknisi not found or invalid role'
                ], 404);
            }

            // Assign ticket
            $laporan->update([
                'assigned_to' => $request->teknisi_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ticket assigned successfully',
                'data' => [
                    'ticket_id' => $laporan->ticket_id,
                    'assigned_to' => $laporan->assigned_to,
                    'teknisi_name' => $teknisi->nama_lengkap,
                    'updated_at' => $laporan->updated_at->format('Y-m-d H:i:s')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to assign ticket: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get teknisi list for assignment
     */
    public function getTeknisiList()
    {
        try {
            $teknisi = User::where('role', 'teknisi')
                          ->select('id_user', 'nama_lengkap as nama', 'email')
                          ->get();

            return response()->json([
                'success' => true,
                'data' => $teknisi
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get teknisi list: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get ticket details with note and assignment
     */
    public function getTicketDetails($ticket_id)
    {
        try {
            $laporan = Laporan::with(['teknisi', 'kategori', 'customer'])
                             ->where('ticket_id', $ticket_id)
                             ->first();

            if (!$laporan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ticket not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'ticket_id' => $laporan->ticket_id,
                    'note' => $laporan->note,
                    'assigned_to' => $laporan->assigned_to,
                    'teknisi' => $laporan->teknisi ? [
                        'id' => $laporan->teknisi->id_user,
                        'nama' => $laporan->teknisi->nama,
                        'email' => $laporan->teknisi->email
                    ] : null,
                    'status' => $laporan->status,
                    'updated_at' => $laporan->updated_at->format('Y-m-d H:i:s')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get ticket details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update ticket status
     */
    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|string',
            'status' => 'required|string|in:Diproses,Selesai,Ditolak',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $laporan = Laporan::where('ticket_id', $request->ticket_id)->first();
            
            if (!$laporan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ticket not found'
                ], 404);
            }

            // Check if teknisi is assigned to this ticket
            if (auth()->user()->role === 'teknisi' && $laporan->assigned_to !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not assigned to this ticket'
                ], 403);
            }

            // Update status
            $laporan->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully',
                'data' => [
                    'ticket_id' => $laporan->ticket_id,
                    'status' => $laporan->status
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error updating ticket status', [
                'error' => $e->getMessage(),
                'ticket_id' => $request->ticket_id,
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }
}