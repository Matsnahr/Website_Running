<?php

namespace App\Http\Controllers;

class MyRegistrationController extends Controller
{
    public function index()
    {
        $all = auth()->user()->registrations()->with('event')->latest()->get();

        // Aktif: event belum selesai
        $aktifRegistrations = $all->filter(fn($r) => $r->event && $r->event->status !== 'selesai')->values();

        // Selesai: event sudah selesai
        $selesaiRegistrations = $all->filter(fn($r) => $r->event && $r->event->status === 'selesai')->values();

        $totalEvents  = $all->count();
        $aktifCount   = $aktifRegistrations->count();
        $selesaiCount = $selesaiRegistrations->count();

        return view('registrations.index', compact(
            'aktifRegistrations',
            'selesaiRegistrations',
            'totalEvents',
            'aktifCount',
            'selesaiCount'
        ));
    }
}