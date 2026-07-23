<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAcara = Event::count();
        $totalPeserta = Registration::count();
        $acaraAktif = Event::where('status', 'aktif')->count();
        $totalPendapatan = Registration::where('status_bayar', 'lunas')->sum('total_bayar');

        // Distribusi kategori (buat donut chart)
        $distribusiKategori = Event::select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        // Proyeksi pendaftaran per bulan (buat line chart)
        $proyeksiBulanan = Registration::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('count(*) as total')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        // Acara mendatang
        $acaraMendatang = Event::where('tanggal', '>=', now())
            ->orderBy('tanggal')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalAcara', 'totalPeserta', 'acaraAktif', 'totalPendapatan',
            'distribusiKategori', 'proyeksiBulanan', 'acaraMendatang'
        ));
    }
}