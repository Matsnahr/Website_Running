@extends('layouts.app')

@section('title', 'Aktivitas Saya | Mau Run')

@section('content')

{{-- Hero Header --}}
<div class="bg-brand-dark pt-14 pb-28 relative overflow-hidden">
    <div class="absolute -top-20 -right-20 w-80 h-80 bg-brand-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-teal-400/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="max-w-6xl mx-auto px-6 relative">
        <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
            {{-- Avatar --}}
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white font-extrabold text-3xl shadow-xl shadow-brand-900/40 flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <p class="text-brand-400 text-sm font-semibold mb-1 uppercase tracking-widest">Profil Pelari</p>
                <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-1">{{ auth()->user()->name }}</h1>
                <p class="text-slate-400 text-sm">{{ auth()->user()->email }}</p>
            </div>

            {{-- Stats ribbon --}}
            <div class="md:ml-auto flex gap-6">
                <div class="text-center">
                    <p class="text-3xl font-extrabold text-white">{{ $totalEvents }}</p>
                    <p class="text-slate-400 text-xs font-medium mt-0.5">Total Event</p>
                </div>
                <div class="w-px bg-white/10"></div>
                <div class="text-center">
                    <p class="text-3xl font-extrabold text-emerald-400">{{ $selesaiCount }}</p>
                    <p class="text-slate-400 text-xs font-medium mt-0.5">Selesai</p>
                </div>
                <div class="w-px bg-white/10"></div>
                <div class="text-center">
                    <p class="text-3xl font-extrabold text-amber-400">{{ $aktifCount }}</p>
                    <p class="text-slate-400 text-xs font-medium mt-0.5">Akan Datang</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto px-6 -mt-16 relative z-10 pb-24">

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl px-5 py-4 mb-6 flex items-start gap-3 shadow-sm">
        <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div>
            <p class="font-bold text-sm">Pendaftaran Berhasil! 🎉</p>
            <p class="text-sm text-emerald-700 mt-0.5">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if($totalEvents === 0)
    {{-- Empty State --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl p-16 text-center shadow-2xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700">
        <div class="w-28 h-28 bg-brand-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-14 h-14 text-brand-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
        </div>
        <h2 class="text-2xl font-extrabold text-slate-800 dark:text-slate-100 mb-3">Belum Ada Aktivitas</h2>
        <p class="text-slate-500 dark:text-slate-400 max-w-sm mx-auto mb-8">Anda belum mendaftar ke acara lari manapun. Temukan event seru dan mulai perjalanan Anda!</p>
        <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white px-8 py-3.5 rounded-xl font-semibold shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            Jelajahi Acara Sekarang
        </a>
    </div>
    @else

    {{-- ── Acara yang Sedang Berlangsung / Akan Datang ── --}}
    @if($aktifRegistrations->count() > 0)
    <div class="mb-12">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-slate-800 dark:text-slate-100">Acara Aktif & Mendatang</h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm">Event yang akan segera Anda ikuti</p>
            </div>
            <span class="ml-auto bg-amber-100 text-amber-700 text-sm font-bold px-3 py-1 rounded-full">{{ $aktifRegistrations->count() }} acara</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach($aktifRegistrations as $reg)
            @php
                $daysLeft = now()->startOfDay()->diffInDays($reg->event->tanggal->startOfDay(), false);
                $isToday  = $daysLeft === 0;
                $isPast   = $daysLeft < 0;
            @endphp
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-xl shadow-slate-200/40 dark:shadow-slate-900/40 overflow-hidden group transition-all hover:shadow-2xl hover:border-brand-200">
                <div class="flex">
                    {{-- Color side strip --}}
                    <div class="w-2 bg-gradient-to-b from-amber-400 to-orange-500 flex-shrink-0"></div>

                    <div class="flex-1 p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                {{-- Status badge --}}
                                <div class="flex items-center gap-2 mb-2">
                                    @if($reg->status_bayar === 'lunas')
                                        <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700 bg-emerald-100 px-2.5 py-0.5 rounded-full">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> Terkonfirmasi
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-xs font-bold text-amber-700 bg-amber-100 px-2.5 py-0.5 rounded-full">
                                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span> Menunggu Pembayaran
                                        </span>
                                    @endif
                                    <span class="text-xs font-medium text-slate-400">{{ $reg->runCategory ? $reg->runCategory->nama : $reg->event->kategori }}</span>
                                </div>

                                <h3 class="font-bold text-slate-800 dark:text-slate-100 text-lg leading-snug line-clamp-2 group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">{{ $reg->event->nama }}</h3>

                                <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-2 text-sm text-slate-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        {{ $reg->event->tanggal->translatedFormat('d M Y') }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $reg->event->kota }}
                                    </span>
                                </div>
                            </div>

                            {{-- Countdown --}}
                            <div class="text-center flex-shrink-0">
                                @if($isToday)
                                    <div class="bg-rose-100 text-rose-700 rounded-xl px-3 py-2">
                                        <p class="text-xl font-extrabold leading-none">🔥</p>
                                        <p class="text-xs font-bold mt-1">HARI INI</p>
                                    </div>
                                @elseif($isPast)
                                    <div class="bg-slate-100 text-slate-500 rounded-xl px-3 py-2">
                                        <p class="text-xl font-extrabold leading-none">✓</p>
                                        <p class="text-xs font-bold mt-1">LEWAT</p>
                                    </div>
                                @else
                                    <div class="bg-brand-50 text-brand-700 rounded-xl px-3 py-2">
                                        <p class="text-2xl font-extrabold leading-none">{{ $daysLeft }}</p>
                                        <p class="text-xs font-bold mt-0.5">hari lagi</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="flex items-center justify-between mt-4 pt-3 border-t border-slate-100 dark:border-slate-700">
                            <div>
                                <p class="text-xs text-slate-400">Total Bayar</p>
                                <p class="font-bold text-slate-700 dark:text-slate-200 text-sm">Rp {{ number_format($reg->total_bayar, 0, ',', '.') }}</p>
                            </div>
                            <a href="{{ route('events.show', $reg->event) }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700 transition-colors flex items-center gap-1">
                                Lihat Detail
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── Acara yang Telah Selesai Diikuti ── --}}
    @if($selesaiRegistrations->count() > 0)
    <div>
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-slate-800 dark:text-slate-100">Riwayat Perlombaan</h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm">Acara yang telah berhasil Anda selesaikan</p>
            </div>
            <span class="ml-auto bg-emerald-100 text-emerald-700 text-sm font-bold px-3 py-1 rounded-full">{{ $selesaiRegistrations->count() }} acara</span>
        </div>

        <div class="grid grid-cols-1 gap-4">
            @foreach($selesaiRegistrations as $reg)
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-lg shadow-slate-200/40 dark:shadow-slate-900/40 overflow-hidden group transition-all hover:shadow-xl hover:border-emerald-200">
                <div class="flex items-center gap-0">
                    {{-- Color strip --}}
                    <div class="w-2 bg-gradient-to-b from-emerald-400 to-teal-500 self-stretch flex-shrink-0"></div>

                    <div class="flex-1 flex flex-col md:flex-row md:items-center gap-4 p-5">
                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700 bg-emerald-100 px-2.5 py-0.5 rounded-full">
                                    🏅 Finisher
                                </span>
                                <span class="text-xs text-slate-400 font-medium">{{ $reg->runCategory ? $reg->runCategory->nama : $reg->event->kategori }}</span>
                            </div>
                            <h3 class="font-bold text-slate-800 dark:text-slate-100 text-base group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">{{ $reg->event->nama }}</h3>
                            <p class="text-sm text-slate-500 mt-0.5">
                                {{ $reg->event->tanggal->translatedFormat('d M Y') }} &middot; {{ $reg->event->kota }}
                            </p>
                        </div>

                        {{-- BIB if exists --}}
                        @if($reg->no_bib)
                        <div class="text-center px-4 py-2 bg-slate-50 dark:bg-slate-700/50 rounded-xl border border-slate-100 dark:border-slate-600">
                            <p class="text-xs text-slate-400 font-medium">No. BIB</p>
                            <p class="text-xl font-extrabold text-slate-800 dark:text-slate-100">{{ $reg->no_bib }}</p>
                        </div>
                        @endif

                        {{-- Payment badge --}}
                        <div class="text-center">
                            @if($reg->status_bayar === 'lunas')
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700 bg-emerald-100 px-3 py-1.5 rounded-xl">
                                    ✓ Lunas
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-amber-700 bg-amber-100 px-3 py-1.5 rounded-xl">
                                    ⚠ {{ ucfirst($reg->status_bayar) }}
                                </span>
                            @endif
                        </div>

                        {{-- Certificate --}}
                        <div>
                            <a href="{{ route('certificate.download', $reg) }}" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-md shadow-brand-500/20 hover:-translate-y-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Sertifikat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @endif {{-- end totalEvents check --}}
</div>
@endsection