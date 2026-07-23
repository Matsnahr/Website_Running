<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $totalAcara   = Event::count();
        $totalMember  = User::where('role', '!=', 'admin')->count();
        $totalKota    = Event::distinct('kota')->count('kota');
        $acaraMendatang = Event::where('tanggal', '>=', now()->toDateString())->count();

        return view('home', compact(
            'totalAcara',
            'totalMember',
            'totalKota',
            'acaraMendatang'
        ));
    }
}