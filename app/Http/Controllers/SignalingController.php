<?php

namespace App\Http\Controllers;

use App\Models\Signal;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SignalingController extends Controller
{
    /**
     * Send a signal to a specific user
     */
    public function send(Request $request, Classroom $classroom)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'type' => 'required|string',
            'payload' => 'nullable|string',
        ]);

        Signal::create([
            'classroom_id' => $classroom->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'type' => $request->type,
            'payload' => $request->payload,
        ]);

        return response()->json(['status' => 'sent']);
    }

    /**
     * Poll for new signals
     */
    public function poll(Classroom $classroom)
    {
        // Get unprocessed signals for the current user in this classroom
        $signals = Signal::where('classroom_id', $classroom->id)
            ->where('receiver_id', auth()->id())
            ->where('is_processed', false)
            ->with('sender:id,name') // Eager load sender name
            ->get();

        // Mark them as processed so we don't fetch them again
        if ($signals->isNotEmpty()) {
            Signal::whereIn('id', $signals->pluck('id'))->update(['is_processed' => true]);
        }

        // Also return the list of currently active participants (heartbeat)
        // For simplicity, we'll just return all participants for now
        // In a real app, we'd check for recent activity
        $participants = $classroom->participants()
            ->with('user:id,name')
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->user->id,
                    'name' => $p->user->name,
                    'is_me' => $p->user->id === auth()->id(),
                ];
            });

        return response()->json([
            'signals' => $signals,
            'participants' => $participants
        ]);
    }
}
