@extends('layouts.app')

@section('title', $event->nama . ' | Mau Run - Ekosistem Acara Lari Premium')

@section('content')
<div class="bg-slate-50 dark:bg-slate-950 min-h-screen pb-20">
    <!-- Hero Banner -->
    <div class="relative h-[400px] bg-brand-900 overflow-hidden">
        @if($event->thumbnail)
            <img src="{{ asset('storage/' . $event->thumbnail) }}" class="w-full h-full object-cover opacity-50 mix-blend-overlay">
        @else
            <div class="absolute inset-0 bg-gradient-to-tr from-brand-900 via-brand-700 to-teal-500 opacity-80"></div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-slate-50 dark:from-slate-950 via-transparent to-transparent"></div>

        <div class="absolute inset-0 flex flex-col justify-end pb-12">
            <div class="max-w-5xl mx-auto px-6 w-full">
                <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 text-white/80 hover:text-white text-sm font-medium mb-6 transition-colors bg-black/20 backdrop-blur-md px-3 py-1.5 rounded-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar Acara
                </a>
                <div class="flex items-center gap-3 mb-4 flex-wrap">
                    {{-- Badge kategori --}}
                    @if($event->runCategories->count() > 0)
                        @foreach($event->runCategories as $rc)
                            <span class="bg-brand-500/80 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">{{ $rc->nama }}</span>
                        @endforeach
                    @else
                        <span class="bg-brand-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">{{ $event->kategori }}</span>
                    @endif
                    <span class="bg-white/20 backdrop-blur-md text-white text-xs font-medium px-3 py-1 rounded-full flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                        Terisi {{ $event->persen_terisi }}%
                    </span>
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-2 leading-tight drop-shadow-md">{{ $event->nama }}</h1>
                <p class="text-white/90 text-lg flex items-center gap-2 drop-shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ $event->kota }}, Indonesia
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-6 -mt-8 relative z-10">
        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-600 p-4 rounded-xl mb-6 shadow-sm flex items-start gap-3">
                <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm font-medium">{{ session('error') }}</p>
            </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <!-- Info Grid -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                    <div>
                        <div class="w-10 h-10 mx-auto bg-brand-50 text-brand-600 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        @if($event->runCategories->count() > 0)
                            <p class="font-bold text-slate-800 dark:text-slate-100 text-lg">{{ $event->runCategories->count() }} Kat.</p>
                        @else
                            <p class="font-bold text-slate-800 dark:text-slate-100 text-lg">{{ $event->jarak_km }} KM</p>
                        @endif
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Jarak</p>
                    </div>
                    <div>
                        <div class="w-10 h-10 mx-auto bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="font-bold text-slate-800 dark:text-slate-100 text-lg">{{ \Carbon\Carbon::parse($event->waktu_mulai)->format('H:i') }}</p>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Mulai (WIB)</p>
                    </div>
                    <div>
                        <div class="w-10 h-10 mx-auto bg-purple-50 text-purple-600 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <p class="font-bold text-slate-800 dark:text-slate-100 text-lg">{{ number_format($event->kuota) }}</p>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Kapasitas</p>
                    </div>
                    <div>
                        <div class="w-10 h-10 mx-auto bg-amber-50 text-amber-600 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <p class="font-bold text-slate-800 dark:text-slate-100 text-lg mb-0.5">{{ $event->tanggal->translatedFormat('d M Y') }}</p>
                        <p class="text-[11px] font-bold text-brand-600 mb-1">
                            @if($event->tanggal->lt(today()))
                                Selesai
                            @else
                                @php $daysLeft = today()->diffInDays($event->tanggal, false); @endphp
                                {{ $daysLeft === 0 ? 'Hari Ini' : $daysLeft . ' hari lagi' }}
                            @endif
                        </p>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Tanggal</p>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700">
                    <h2 class="font-extrabold text-2xl text-slate-800 dark:text-slate-100 mb-6 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-brand-500 rounded-full"></span>
                        Tentang Balapan
                    </h2>
                    <div class="prose prose-slate max-w-none text-slate-600 dark:text-slate-300 text-base leading-relaxed whitespace-pre-line">
                        {{ $event->deskripsi ?: 'Tidak ada deskripsi yang tersedia untuk acara ini.' }}
                    </div>
                </div>

                <!-- Fasilitas -->
                @if($event->facilities->count())
                    <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700">
                        <h2 class="font-extrabold text-2xl text-slate-800 dark:text-slate-100 mb-6 flex items-center gap-2">
                            <span class="w-1.5 h-6 bg-amber-500 rounded-full"></span>
                            Race Pack & Fasilitas
                        </h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($event->facilities as $facility)
                                <div class="flex items-center gap-3 bg-slate-50 dark:bg-slate-700 border border-slate-100 dark:border-slate-600 rounded-xl p-4 transition-transform hover:-translate-y-1">
                                    <div class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center text-lg">🎽</div>
                                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $facility->nama_fasilitas }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sticky Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-28 bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700">

                    @if($event->runCategories->count() > 0)
                        {{-- ===== MULTI-KATEGORI SIDEBAR ===== --}}
                        <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-3">Pilih Kategori</p>

                        <div class="space-y-2 mb-6">
                            @foreach($event->runCategories as $rc)
                                @php
                                    $isPenuh = $rc->terisi >= $rc->kuota;
                                    $sisaKuota = $rc->kuota - $rc->terisi;
                                @endphp
                                <div class="border {{ $isPenuh ? 'border-slate-200 dark:border-slate-700 opacity-60' : 'border-slate-200 dark:border-slate-600 hover:border-brand-400 dark:hover:border-brand-500' }} rounded-2xl p-4 transition-all {{ $isPenuh ? '' : 'hover:shadow-md hover:shadow-brand-500/10' }}">
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <p class="font-extrabold text-slate-800 dark:text-slate-100 text-base">{{ $rc->nama }}</p>
                                            @if($rc->jarak_km)
                                                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">{{ (float)$rc->jarak_km }} KM</p>
                                            @endif
                                        </div>
                                        <div class="text-right flex-shrink-0">
                                            <p class="font-extrabold text-brand-600 dark:text-brand-400 text-sm">Rp {{ number_format($rc->harga, 0, ',', '.') }}</p>
                                            @if($isPenuh)
                                                <span class="text-[10px] font-bold text-rose-500 bg-rose-50 dark:bg-rose-950/40 px-2 py-0.5 rounded-full">PENUH</span>
                                            @else
                                                <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">Sisa {{ $sisaKuota }} slot</p>
                                            @endif
                                        </div>
                                    </div>
                                    @if($rc->deskripsi)
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">{{ $rc->deskripsi }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        {{-- Kuota Bar --}}
                        <div class="bg-brand-50 dark:bg-brand-900/30 rounded-xl p-3 mb-6">
                            <div class="flex justify-between text-xs font-medium text-brand-900 dark:text-brand-300 mb-1.5">
                                <span>Total Sisa Kuota</span>
                                <span>{{ 100 - $event->persen_terisi }}%</span>
                            </div>
                            <div class="w-full bg-brand-200/50 rounded-full h-2 overflow-hidden">
                                <div class="bg-brand-500 h-full rounded-full" style="width: {{ $event->persen_terisi }}%"></div>
                            </div>
                        </div>

                        @if($event->tanggal->lt(today()))
                            <button disabled class="w-full bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400 rounded-2xl py-4 font-bold cursor-not-allowed">
                                Event Sudah Lewat
                            </button>
                        @elseif($event->persen_terisi >= 100)
                            <button disabled class="w-full bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400 rounded-2xl py-4 font-bold cursor-not-allowed">
                                Semua Kuota Penuh
                            </button>
                        @else
                            <a href="{{ route('events.register', $event) }}"
                               class="w-full bg-brand-600 hover:bg-brand-500 text-white rounded-2xl py-4 font-bold text-lg shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 flex items-center justify-center gap-2 group">
                                Daftar Sekarang
                                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        @endif

                    @else
                        {{-- ===== SINGLE CATEGORY (LEGACY) ===== --}}
                        <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2">Biaya Pendaftaran</p>
                        <div class="flex items-baseline gap-1 mb-6">
                            <span class="text-3xl font-extrabold text-slate-800 dark:text-slate-100">Rp {{ number_format($event->harga, 0, ',', '.') }}</span>
                        </div>

                        <div class="bg-brand-50 dark:bg-brand-900/30 rounded-xl p-4 mb-8">
                            <div class="flex justify-between text-sm font-medium text-brand-900 dark:text-brand-300 mb-2">
                                <span>Sisa Kuota</span>
                                <span>{{ 100 - $event->persen_terisi }}%</span>
                            </div>
                            <div class="w-full bg-brand-200/50 rounded-full h-2 overflow-hidden">
                                <div class="bg-brand-500 h-full rounded-full" style="width: {{ $event->persen_terisi }}%"></div>
                            </div>
                            <p class="text-xs text-brand-600 mt-2 text-center">
                                @if($event->tanggal->lt(today()))
                                    Acara ini sudah selesai dilaksanakan.
                                @else
                                    @php $daysLeft = today()->diffInDays($event->tanggal, false); @endphp
                                    {{ $daysLeft === 0 ? '🏁 Acara berlangsung HARI INI!' : '📅 ' . $daysLeft . ' hari lagi menuju acara!' }}
                                @endif
                            </p>
                        </div>

                        @if($event->tanggal->lt(today()))
                            <button disabled class="w-full bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400 rounded-2xl py-4 font-bold cursor-not-allowed">
                                Event Sudah Lewat
                            </button>
                        @elseif($event->persen_terisi >= 100)
                            <button disabled class="w-full bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400 rounded-2xl py-4 font-bold cursor-not-allowed">
                                Kuota Penuh
                            </button>
                        @else
                            <a href="{{ route('events.register', $event) }}"
                               class="w-full bg-brand-600 hover:bg-brand-500 text-white rounded-2xl py-4 font-bold text-lg shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 flex items-center justify-center gap-2 group">
                                Daftar Sekarang
                                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection