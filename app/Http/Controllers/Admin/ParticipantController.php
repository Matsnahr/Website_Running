<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Event;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index(Request $request)
    {
        $query = Registration::with(['event', 'runCategory']);

        // Search name, email, or BIB
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_bib', 'like', "%{$search}%");
            });
        }

        // Filter by Event
        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        // Filter by Status Pembayaran
        if ($request->filled('status_bayar')) {
            $query->where('status_bayar', $request->status_bayar);
        }

        $participants = $query->orderBy('created_at', 'desc')->paginate(15);
        $events = Event::orderBy('nama')->get();

        return view('admin.participants.index', compact('participants', 'events'));
    }
}
