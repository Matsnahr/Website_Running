@extends('layouts.admin')

@section('title', 'Daftar Peserta | Mau Run - Ekosistem Acara Lari Premium')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-800 dark:text-slate-100 mb-2 flex items-center gap-2">
            <span class="w-1.5 h-8 bg-brand-500 rounded-full"></span>
            Daftar Peserta
        </h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm ml-3">Daftar keseluruhan peserta yang mengikuti acara lari Anda.</p>
    </div>
</div>

{{-- Filter Card --}}
<div class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-800 mb-8">
    <form method="GET" action="{{ route('admin.participants.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        {{-- Search input --}}
        <div>
            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Cari Peserta</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama, email, atau BIB..."
                   class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
        </div>

        {{-- Filter Event --}}
        <div>
            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Filter Acara</label>
            <select name="event_id" class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand-500">
                <option value="">Semua Acara</option>
                @foreach($events as $event)
                    <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>{{ $event->nama }}</option>
                @endforeach
            </select>
        </div>

        {{-- Filter Status Bayar --}}
        <div>
            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Status Pembayaran</label>
            <select name="status_bayar" class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand-500">
                <option value="">Semua Status</option>
                <option value="lunas" {{ request('status_bayar') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                <option value="pending" {{ request('status_bayar') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="gagal" {{ request('status_bayar') == 'gagal' ? 'selected' : '' }}>Gagal</option>
            </select>
        </div>

        {{-- Submit and Reset buttons --}}
        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-brand-600 hover:bg-brand-500 text-white font-semibold py-2.5 rounded-xl text-sm transition-all shadow-md shadow-brand-500/20">
                Terapkan
            </button>
            @if(request()->hasAny(['search', 'event_id', 'status_bayar']))
                <a href="{{ route('admin.participants.index') }}" class="bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-semibold py-2.5 px-4 rounded-xl text-sm transition-colors">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

{{-- Participant Table --}}
<div class="bg-white dark:bg-slate-900 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-slate-400 dark:text-slate-400 uppercase bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                <tr>
                    <th scope="col" class="px-6 py-4 font-semibold">Peserta</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Acara Lari</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-center">BIB</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-center">Jersey</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Biaya</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-center">Pembayaran</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Registrasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($participants as $participant)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800 dark:text-slate-100">{{ $participant->nama_lengkap }}</div>
                            <div class="text-xs text-slate-400 dark:text-slate-400 mt-0.5">{{ $participant->email }} &middot; {{ $participant->no_hp }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($participant->event)
                                <div class="font-semibold text-slate-700 dark:text-slate-300">{{ $participant->event->nama }}</div>
                                <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $participant->runCategory ? $participant->runCategory->nama : $participant->event->kategori }} &middot; 📍 {{ $participant->event->kota }}</div>
                            @else
                                <span class="text-xs text-rose-500 dark:text-rose-400 font-semibold">Acara dihapus</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($participant->no_bib)
                                <span class="font-mono bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 px-2.5 py-1 rounded-lg text-xs font-bold border border-slate-200 dark:border-slate-700">
                                    {{ $participant->no_bib }}
                                </span>
                            @else
                                <span class="text-slate-300 dark:text-slate-600">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center font-bold text-slate-600 dark:text-slate-400">
                            {{ $participant->ukuran_jersey ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800 dark:text-slate-100">
                                Rp {{ number_format($participant->nominal_bayar, 0, ',', '.') }}
                            </div>
                            @if($participant->diskon > 0)
                                <div class="text-xs text-emerald-600 dark:text-emerald-400">
                                    Diskon: Rp {{ number_format($participant->diskon, 0, ',', '.') }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($participant->status_bayar === 'lunas')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                    Lunas
                                </span>
                            @elseif($participant->status_bayar === 'pending')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                                    Pending
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 dark:bg-rose-950/60 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800">
                                    Gagal
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-500 dark:text-slate-400 text-xs">
                            {{ $participant->created_at ? $participant->created_at->translatedFormat('d M Y H:i') : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                            Tidak ada data peserta ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $participants->links() }}
</div>
@endsection
