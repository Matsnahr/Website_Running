@extends('layouts.admin')

@section('title', 'Manajemen Acara | Mau Run - Ekosistem Acara Lari Premium')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-800 dark:text-slate-100 mb-2 flex items-center gap-2">
            <span class="w-1.5 h-8 bg-brand-500 rounded-full"></span>
            Manajemen Acara
        </h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm ml-3">Kelola dan pantau semua acara yang sedang berjalan di berbagai wilayah.</p>
    </div>
    <a href="{{ route('admin.events.create') }}" class="bg-brand-600 hover:bg-brand-500 text-white px-6 py-3 rounded-xl text-sm font-semibold shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-0.5 flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Buat Acara Baru
    </a>
</div>

@if(session('success'))
    <div class="bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-4 py-4 rounded-xl mb-6 flex items-start gap-3 shadow-sm">
        <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <p class="text-sm font-medium">{{ session('success') }}</p>
    </div>
@endif

{{-- Filter Status --}}
<div class="flex gap-2 mb-6 p-1 bg-slate-100 dark:bg-slate-900 rounded-xl w-fit border border-slate-200/60 dark:border-slate-800">
    @foreach(['semua' => 'Semua Acara', 'aktif' => 'Status Aktif', 'draft' => 'Draft', 'selesai' => 'Telah Selesai'] as $val => $label)
        <a href="{{ route('admin.events.index', ['status' => $val]) }}"
           class="px-5 py-2 rounded-lg text-sm font-semibold transition-all {{ request('status', 'semua') == $val ? 'bg-white dark:bg-slate-800 text-brand-600 dark:text-brand-400 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-200/50 dark:hover:bg-slate-800/50' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

<div class="bg-white dark:bg-slate-900 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-slate-400 dark:text-slate-400 uppercase bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                <tr>
                    <th scope="col" class="px-6 py-4 font-semibold">Nama Acara</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Kategori & Lokasi</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Tanggal</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Biaya</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Status Kuota</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-center">Status</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($events as $event)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors group">
                        <td class="px-6 py-5">
                            <div class="font-bold text-slate-800 dark:text-slate-100 text-base mb-0.5">{{ $event->nama }}</div>
                            <div class="text-xs font-medium text-slate-400 dark:text-slate-500 uppercase tracking-wider">ID: EVT-{{ str_pad($event->id, 3, '0', STR_PAD_LEFT) }}</div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-brand-50 dark:bg-brand-950/60 text-brand-700 dark:text-brand-300 mb-1">
                                {{ $event->kategori }}
                            </div>
                            <div class="text-sm font-medium text-slate-600 dark:text-slate-300 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $event->kota }}
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="font-semibold text-slate-700 dark:text-slate-300">{{ $event->tanggal->translatedFormat('d M Y') }}</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ \Carbon\Carbon::parse($event->waktu_mulai)->format('H:i') }} WIB</div>
                        </td>
                        <td class="px-6 py-5 font-bold text-slate-800 dark:text-slate-100">
                            Rp {{ number_format($event->harga, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="flex-1 w-24 bg-slate-100 dark:bg-slate-800 rounded-full h-2 overflow-hidden">
                                    <div class="bg-gradient-to-r from-amber-400 to-orange-500 h-2 rounded-full" style="width: {{ $event->persen_terisi }}%"></div>
                                </div>
                                <span class="text-xs font-bold text-slate-600 dark:text-slate-400 w-10">{{ $event->terisi }}/{{ $event->kuota }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            @php
                                $badgeStyle = [
                                    'aktif' => 'bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800', 
                                    'draft' => 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-700', 
                                    'selesai' => 'bg-blue-100 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border-blue-200 dark:border-blue-800'
                                ];
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $badgeStyle[$event->status] ?? 'bg-slate-100 text-slate-600' }}">
                                {{ ucfirst($event->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.events.edit', $event) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 dark:text-slate-500 hover:text-brand-600 dark:hover:text-brand-400 hover:bg-brand-50 dark:hover:bg-slate-800 transition-colors" title="Edit Acara">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus acara ini secara permanen?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 dark:text-slate-500 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-slate-800 transition-colors" title="Hapus Acara">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                            Belum ada acara lari dibuat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $events->links() }}
</div>
@endsection