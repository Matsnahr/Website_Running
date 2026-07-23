@extends('layouts.app')

@section('title', 'Jelajahi Acara | Mau Run - Ekosistem Acara Lari Premium')

@section('content')

{{-- Hero + Filter Section --}}
<div class="bg-brand-dark dark:bg-slate-950 pb-36 pt-14 relative overflow-hidden">
    {{-- decorative blobs --}}
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-brand-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 -left-16 w-72 h-72 bg-teal-400/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 relative">
        <h1 class="text-3xl md:text-5xl font-extrabold mb-4 text-white leading-tight">
            Temukan Tantangan <br class="hidden md:block"> Anda Berikutnya
        </h1>
        <p class="text-slate-400 text-lg mb-10 max-w-2xl">Cari balapan, maraton, dan lari komunitas mendatang. Amankan slot Anda sekarang dan jadilah bagian dari revolusi lari.</p>

        {{-- Filter Form --}}
        <form method="GET" action="{{ route('events.index') }}" id="filter-form" class="bg-white/10 backdrop-blur-md border border-white/10 p-5 rounded-2xl shadow-2xl">
            <div class="flex flex-wrap gap-3 items-end">

                {{-- Search nama --}}
                <div class="flex-1 min-w-[220px]">
                    <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5 block">Nama Acara</label>
                    <div class="relative">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama acara..."
                               class="w-full bg-white/5 border border-white/20 text-white placeholder-slate-500 rounded-xl pl-10 pr-4 py-3 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors">
                    </div>
                </div>

                {{-- Filter Kota/Daerah (dari master data DB) --}}
                <div class="min-w-[210px]">
                    <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5 block">Daerah / Kota</label>
                    @php
                        // Gabungkan kota dari master DB + kota dari event yang sudah ada (backward-compat)
                        $dbCityNames = $cities->pluck('nama')->toArray();
                        $mergedCities = array_unique(array_merge($dbCityNames, $kotaList->toArray()));
                        sort($mergedCities);
                    @endphp
                    <select name="kota" id="filter-kota">
                        <option value="">Semua Daerah</option>
                        @foreach($mergedCities as $k)
                            <option value="{{ $k }}" {{ request('kota') == $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Kategori (dari master data DB) --}}
                <div class="min-w-[160px]">
                    <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5 block">Kategori Jarak</label>
                    <select name="kategori" id="filter-kategori">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->nama }}" {{ request('kategori') == $cat->nama ? 'selected' : '' }}>{{ $cat->nama }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Submit --}}
                <div class="self-end">
                    <button type="submit" class="bg-brand-500 hover:bg-brand-400 text-white px-7 py-3 rounded-xl font-semibold transition-all shadow-lg shadow-brand-500/30 hover:-translate-y-0.5 flex items-center gap-2 h-[46px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Cari Acara
                    </button>
                </div>

                {{-- Clear filter if any active --}}
                @if(request()->hasAny(['search','kota','kategori']))
                <div class="self-end">
                    <a href="{{ route('events.index') }}" class="text-slate-400 hover:text-white text-sm font-medium px-4 py-3 rounded-xl border border-white/10 hover:border-white/30 transition-colors flex items-center gap-1.5 h-[46px]">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Reset
                    </a>
                </div>
                @endif
            </div>

            {{-- Active filters badge row --}}
            @if(request()->hasAny(['search','kota','kategori']))
            <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-white/10">
                <span class="text-xs text-slate-500 self-center">Filter aktif:</span>
                @if(request('search'))
                    <span class="inline-flex items-center gap-1 bg-brand-500/20 text-brand-300 text-xs font-medium px-3 py-1 rounded-full">
                        🔍 "{{ request('search') }}"
                    </span>
                @endif
                @if(request('kota'))
                    <span class="inline-flex items-center gap-1 bg-blue-500/20 text-blue-300 text-xs font-medium px-3 py-1 rounded-full">
                        📍 {{ request('kota') }}
                    </span>
                @endif
                @if(request('kategori'))
                    <span class="inline-flex items-center gap-1 bg-amber-500/20 text-amber-300 text-xs font-medium px-3 py-1 rounded-full">
                        🏃 {{ request('kategori') }}
                    </span>
                @endif
            </div>
            @endif
        </form>
    </div>
</div>

{{-- TomSelect assets & init --}}
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<style>
    /* ── TomSelect dark skin to match filter glassmorphism ── */
    #filter-form .ts-wrapper { width: 100%; }
    #filter-form .ts-control {
        background-color: rgba(255,255,255,0.05) !important;
        border: 1px solid rgba(255,255,255,0.2) !important;
        border-radius: 0.75rem !important;
        color: #fff !important;
        padding: 0.6rem 1rem !important;
        min-height: 46px;
        font-size: 0.875rem;
    }
    #filter-form .ts-control input { color: white !important; }
    #filter-form .ts-control input::placeholder { color: #94a3b8; }
    #filter-form .ts-dropdown {
        background-color: #1e293b !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
        border-radius: 0.75rem !important;
        color: #e2e8f0 !important;
        margin-top: 4px;
        font-size: 0.875rem;
    }
    #filter-form .ts-dropdown .option { padding: 9px 14px; }
    #filter-form .ts-dropdown .option:hover,
    #filter-form .ts-dropdown .active { background-color: rgba(20,184,166,0.2) !important; color: #2dd4bf !important; }
    #filter-form .ts-dropdown .selected { background-color: rgba(20,184,166,0.3) !important; color: #fff !important; }
</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        new TomSelect("#filter-kota", {
            placeholder: "Semua Daerah / Kota",
            maxOptions: null,
            sortField: { field: "text", direction: "asc" }
        });
        new TomSelect("#filter-kategori", {
            placeholder: "Semua Kategori"
        });
    });
</script>

{{-- Event Cards --}}
<div class="max-w-7xl mx-auto px-6 -mt-20 relative z-10 mb-24 bg-slate-50 dark:bg-slate-950 pb-10 rounded-t-3xl">

    {{-- Results info --}}
    @if(request()->hasAny(['search','kota','kategori']))
    <div class="mb-6 flex items-center justify-between">
        <p class="text-slate-600 text-sm">
            Menampilkan <span class="font-bold text-slate-800">{{ $events->total() }}</span> acara
            @if(request('kota')) di <span class="font-bold text-brand-600">{{ request('kota') }}</span>@endif
        </p>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($events as $event)
            <div class="bg-white dark:bg-slate-800 rounded-3xl overflow-hidden shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700 group flex flex-col transform transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-brand-100/60 dark:hover:shadow-brand-900/40">
                {{-- Thumbnail --}}
                <div class="h-52 bg-slate-200 relative overflow-hidden">
                    @if($event->thumbnail)
                        <img src="{{ asset('storage/' . $event->thumbnail) }}" alt="{{ $event->nama }}" class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center">
                            <span class="text-white font-extrabold text-4xl opacity-40">{{ $event->kategori }}</span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                    <div class="absolute top-4 left-4 flex gap-2">
                        <span class="bg-white/90 backdrop-blur-sm text-brand-700 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">{{ $event->kategori }}</span>
                        @if($event->tanggal->lt(today()))
                            <span class="bg-rose-600 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">Selesai</span>
                        @elseif($event->persen_terisi >= 100)
                            <span class="bg-red-600 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">Penuh</span>
                        @endif
                    </div>
                    <div class="absolute bottom-4 left-4">
                        <p class="text-xs font-semibold text-white bg-black/30 backdrop-blur-sm px-2.5 py-1 rounded-lg">📍 {{ $event->kota }}</p>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex justify-between items-center mb-2">
                        <p class="text-xs font-bold text-brand-500 tracking-wider uppercase">📅 {{ $event->tanggal->translatedFormat('d M Y') }}</p>
                        @if(!$event->tanggal->lt(today()))
                            @php
                                $daysLeft = today()->diffInDays($event->tanggal, false);
                            @endphp
                            <span class="text-xs bg-brand-50 text-brand-700 px-2.5 py-0.5 rounded-full font-semibold">
                                {{ $daysLeft === 0 ? 'Hari ini' : $daysLeft . ' hari lagi' }}
                            </span>
                        @endif
                    </div>
                    <h3 class="font-bold text-xl text-slate-800 dark:text-slate-100 mb-4 line-clamp-2 leading-tight group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">{{ $event->nama }}</h3>

                    <div class="mt-auto mb-5">
                        <div class="flex justify-between text-xs font-semibold text-slate-500 mb-1.5">
                            <span>Kuota Terisi</span>
                            <span class="{{ $event->persen_terisi >= 80 ? 'text-orange-500' : 'text-slate-700' }}">{{ $event->persen_terisi }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-2 overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-1000 {{ $event->persen_terisi >= 80 ? 'bg-gradient-to-r from-orange-400 to-red-500' : 'bg-gradient-to-r from-amber-400 to-orange-500' }}" style="width: {{ $event->persen_terisi }}%"></div>
                        </div>
                        @if($event->tanggal->lt(today()))
                            <p class="text-xs text-rose-500 font-semibold mt-1">⌛ Event sudah selesai.</p>
                        @elseif($event->persen_terisi >= 100)
                            <p class="text-xs text-red-500 font-semibold mt-1">🚫 Kuota penuh.</p>
                        @elseif($event->persen_terisi >= 80)
                            <p class="text-xs text-orange-500 font-semibold mt-1">⚡ Hampir penuh! Segera daftar.</p>
                        @endif
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-700">
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mb-0.5">Biaya Mulai</p>
                            <p class="text-slate-800 dark:text-slate-100 font-extrabold text-lg">Rp {{ number_format($event->harga, 0, ',', '.') }}</p>
                        </div>
                        <a href="{{ route('events.show', $event) }}" class="bg-brand-600 hover:bg-brand-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-md shadow-brand-500/20 hover:-translate-y-0.5 dark:shadow-brand-700/30">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white dark:bg-slate-800 rounded-3xl p-16 text-center border border-slate-100 dark:border-slate-700 shadow-sm">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-5 text-slate-300">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Tidak Ada Acara Ditemukan</h3>
                <p class="text-slate-500 mb-6">Coba ubah filter pencarian atau reset semua filter.</p>
                <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 bg-brand-50 hover:bg-brand-100 text-brand-600 px-6 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Reset Semua Filter
                </a>
            </div>
        @endforelse
    </div>

    <div class="mt-12">
        {{ $events->appends(request()->query())->links() }}
    </div>
</div>
@endsection
