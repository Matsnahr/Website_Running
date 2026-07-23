@extends('layouts.admin')

@section('title', 'Dasbor Admin | Mau Run - Ekosistem Acara Lari Premium')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-800 dark:text-slate-100 mb-2">Ringkasan Dasbor</h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Selamat datang kembali, {{ auth()->user()->name }}. Berikut adalah ikhtisar performa acara Anda.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.events.create') }}" class="bg-brand-600 hover:bg-brand-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-0.5 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Acara Baru
        </a>
    </div>
</div>

{{-- Stat Cards --}}
<div class="grid grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-800 flex items-center gap-4">
        <div class="w-14 h-14 rounded-2xl bg-brand-50 dark:bg-brand-950/60 text-brand-600 dark:text-brand-400 flex items-center justify-center">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1">Total Acara</p>
            <p class="text-3xl font-extrabold text-slate-800 dark:text-slate-100">{{ $totalAcara }}</p>
        </div>
    </div>
    <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-800 flex items-center gap-4">
        <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1">Total Peserta</p>
            <p class="text-3xl font-extrabold text-slate-800 dark:text-slate-100">{{ number_format($totalPeserta) }}</p>
        </div>
    </div>
    <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-800 flex items-center gap-4">
        <div class="w-14 h-14 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1">Acara Aktif</p>
            <p class="text-3xl font-extrabold text-slate-800 dark:text-slate-100">{{ $acaraAktif }}</p>
        </div>
    </div>
    <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-800 flex items-center gap-4">
        <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1">Pendapatan</p>
            <p class="text-2xl font-extrabold text-slate-800 dark:text-slate-100">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>
    </div>
</div>

{{-- Charts --}}
<div class="grid grid-cols-3 gap-6 mb-8">
    <div class="col-span-2 bg-white dark:bg-slate-900 rounded-3xl p-8 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-800">
        <h3 class="font-bold text-lg text-slate-800 dark:text-slate-100 mb-6 flex items-center gap-2">
            <span class="w-1.5 h-6 bg-brand-500 rounded-full"></span>
            Proyeksi Pendaftaran ({{ now()->year }})
        </h3>
        <div class="relative h-72">
            <canvas id="lineChart"></canvas>
        </div>
    </div>
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-800">
        <h3 class="font-bold text-lg text-slate-800 dark:text-slate-100 mb-6 flex items-center gap-2">
            <span class="w-1.5 h-6 bg-purple-500 rounded-full"></span>
            Distribusi Kategori
        </h3>
        <div class="relative h-64 flex justify-center">
            <canvas id="donutChart"></canvas>
        </div>
    </div>
</div>

{{-- Acara Mendatang --}}
<div class="bg-white dark:bg-slate-900 rounded-3xl p-8 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-800">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-bold text-lg text-slate-800 dark:text-slate-100 flex items-center gap-2">
            <span class="w-1.5 h-6 bg-amber-500 rounded-full"></span>
            Acara Mendatang
        </h3>
        <a href="{{ route('admin.events.index') }}" class="text-sm font-semibold text-brand-600 dark:text-brand-400 hover:text-brand-700 dark:hover:text-brand-300 transition-colors">Lihat Semua →</a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-slate-400 dark:text-slate-400 uppercase bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                <tr>
                    <th scope="col" class="px-4 py-3 font-semibold rounded-tl-xl">Acara</th>
                    <th scope="col" class="px-4 py-3 font-semibold">Tanggal & Lokasi</th>
                    <th scope="col" class="px-4 py-3 font-semibold">Harga</th>
                    <th scope="col" class="px-4 py-3 font-semibold">Status Kuota</th>
                    <th scope="col" class="px-4 py-3 font-semibold rounded-tr-xl text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($acaraMendatang as $acara)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors group">
                        <td class="px-4 py-4">
                            <div class="font-bold text-slate-800 dark:text-slate-100">{{ $acara->nama }}</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $acara->kategori }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="font-medium text-slate-700 dark:text-slate-300">{{ $acara->tanggal->translatedFormat('d M Y') }}</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">📍 {{ $acara->kota }}</div>
                        </td>
                        <td class="px-4 py-4 font-semibold text-emerald-600 dark:text-emerald-400">
                            Rp {{ number_format($acara->harga, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-24 bg-slate-100 dark:bg-slate-800 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-brand-500 h-1.5 rounded-full" style="width: {{ ($acara->terisi / max(1, $acara->kuota)) * 100 }}%"></div>
                                </div>
                                <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">{{ $acara->terisi }}/{{ $acara->kuota }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-right">
                            <a href="{{ route('admin.events.edit', $acara) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 dark:text-slate-500 hover:text-brand-600 dark:hover:text-brand-400 hover:bg-brand-50 dark:hover:bg-slate-800 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-slate-500 dark:text-slate-400">
                            Tidak ada acara mendatang.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    const isDarkTheme = document.documentElement.classList.contains('dark');
    const chartTextColor = isDarkTheme ? '#94a3b8' : '#64748b';
    const chartGridColor = isDarkTheme ? 'rgba(51, 65, 85, 0.4)' : '#f1f5f9';

    // Line chart - proyeksi pendaftaran
    const bulanLabel = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    const dataProyeksi = @json($proyeksiBulanan);
    const lineData = bulanLabel.map((_, i) => dataProyeksi[i+1] ?? 0);

    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: bulanLabel,
            datasets: [{
                label: 'Pendaftaran',
                data: lineData,
                borderColor: '#14b8a6', // brand-500
                backgroundColor: 'rgba(20, 184, 166, 0.1)',
                borderWidth: 3,
                pointBackgroundColor: isDarkTheme ? '#0f172a' : '#ffffff',
                pointBorderColor: '#14b8a6',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4
            }]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    padding: 12,
                    titleFont: { family: 'Outfit', size: 13 },
                    bodyFont: { family: 'Outfit', size: 14, weight: 'bold' },
                    cornerRadius: 8,
                    displayColors: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: chartGridColor, drawBorder: false },
                    border: { display: false },
                    ticks: { font: { family: 'Outfit' }, color: chartTextColor }
                },
                x: {
                    grid: { display: false, drawBorder: false },
                    border: { display: false },
                    ticks: { font: { family: 'Outfit' }, color: chartTextColor }
                }
            }
        }
    });

    // Donut chart - distribusi kategori
    const distribusi = @json($distribusiKategori);
    new Chart(document.getElementById('donutChart'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(distribusi),
            datasets: [{
                data: Object.values(distribusi),
                backgroundColor: ['#14b8a6', '#0d9488', '#134e4a', '#2dd4bf', '#5eead4'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: { family: 'Outfit', size: 12 },
                        color: chartTextColor
                    }
                },
                tooltip: {
                    backgroundColor: '#0f172a',
                    padding: 12,
                    titleFont: { family: 'Outfit', size: 13 },
                    bodyFont: { family: 'Outfit', size: 14, weight: 'bold' },
                    cornerRadius: 8
                }
            }
        }
    });
</script>
@endsection