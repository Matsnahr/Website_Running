@extends('layouts.admin')

@section('title', 'Master Kota Pelaksanaan | Mau Run')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-slate-800 dark:text-slate-100 mb-2 flex items-center gap-2">
        <span class="w-1.5 h-8 bg-brand-500 rounded-full"></span>
        Master Kota Pelaksanaan
    </h1>
    <p class="text-slate-500 dark:text-slate-400 text-sm ml-3">Kelola daftar kota/kabupaten yang tersedia sebagai lokasi event lari.</p>
</div>

@if(session('success'))
    <div class="bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-4 py-4 rounded-xl mb-6 flex items-start gap-3 shadow-sm">
        <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="text-sm font-medium">{{ session('success') }}</p>
    </div>
@endif

@if($errors->any())
    <div class="bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-300 px-4 py-4 rounded-xl mb-6">
        <ul class="text-sm list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Form Tambah Kota --}}
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-6">
            <h2 class="text-base font-bold text-slate-700 dark:text-slate-100 mb-5 flex items-center gap-2">
                <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Tambah Kota Baru
            </h2>
            <form method="POST" action="{{ route('admin.event-cities.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider block mb-1.5">Nama Kota / Kabupaten <span class="text-red-400">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Jakarta, Bandung"
                           class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors" required>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider block mb-1.5">Provinsi</label>
                    <input type="text" name="provinsi" value="{{ old('provinsi') }}" placeholder="Contoh: Jawa Barat"
                           class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors">
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Opsional, membantu pengelompokan wilayah.</p>
                </div>
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="aktif" id="aktif_city_new" value="1" checked
                           class="w-4 h-4 rounded border-slate-300 dark:border-slate-700 text-brand-600 focus:ring-brand-500">
                    <label for="aktif_city_new" class="text-sm font-medium text-slate-600 dark:text-slate-300">Aktif (tampil di pilihan)</label>
                </div>
                <button type="submit"
                        class="w-full bg-brand-600 hover:bg-brand-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-md shadow-brand-500/20 hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Kota
                </button>
            </form>
        </div>

        {{-- Info stats --}}
        <div class="mt-4 grid grid-cols-2 gap-3">
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-100 dark:border-slate-800 p-4 text-center shadow-sm">
                <p class="text-2xl font-extrabold text-brand-600 dark:text-brand-400">{{ $cities->where('aktif', true)->count() }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Kota Aktif</p>
            </div>
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-100 dark:border-slate-800 p-4 text-center shadow-sm">
                <p class="text-2xl font-extrabold text-slate-500 dark:text-slate-400">{{ $cities->where('aktif', false)->count() }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Nonaktif</p>
            </div>
        </div>
    </div>

    {{-- Tabel Kota --}}
    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <h2 class="text-base font-bold text-slate-700 dark:text-slate-100">Daftar Kota ({{ $cities->count() }})</h2>
                <input type="text" id="city-search" placeholder="Cari kota..." onkeyup="filterCities(this.value)"
                       class="border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-xl px-3 py-1.5 text-sm w-48 focus:outline-none focus:border-brand-400 transition-colors">
            </div>

            @if($cities->isEmpty())
                <div class="flex flex-col items-center justify-center py-16 text-slate-400 dark:text-slate-500">
                    <svg class="w-12 h-12 mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <p class="text-sm">Belum ada kota. Tambahkan di form sebelah kiri.</p>
                </div>
            @else
                <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
                    <table class="w-full text-sm text-left" id="cities-table">
                        <thead class="text-xs text-slate-400 dark:text-slate-400 uppercase bg-slate-50/70 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800 sticky top-0">
                            <tr>
                                <th class="px-6 py-3 font-semibold">Nama Kota</th>
                                <th class="px-6 py-3 font-semibold">Provinsi</th>
                                <th class="px-6 py-3 font-semibold text-center">Status</th>
                                <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                            @foreach($cities as $c)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors city-row" id="row-city-{{ $c->id }}">
                                <td class="px-6 py-4">
                                    <span class="view-mode-c-{{ $c->id }} font-semibold text-slate-800 dark:text-slate-100 city-name">{{ $c->nama }}</span>
                                    <span class="edit-mode-c-{{ $c->id }} hidden">
                                        <input type="text" name="nama" form="edit-c-{{ $c->id }}" value="{{ $c->nama }}" required
                                               class="border border-brand-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-lg px-2 py-1 text-sm w-full focus:outline-none focus:ring-1 focus:ring-brand-500">
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-500 dark:text-slate-400">
                                    <span class="view-mode-c-{{ $c->id }} city-prov">{{ $c->provinsi ?? '-' }}</span>
                                    <span class="edit-mode-c-{{ $c->id }} hidden">
                                        <input type="text" name="provinsi" form="edit-c-{{ $c->id }}" value="{{ $c->provinsi }}" placeholder="Provinsi"
                                               class="border border-brand-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-lg px-2 py-1 text-sm w-full focus:outline-none focus:ring-1 focus:ring-brand-500">
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="view-mode-c-{{ $c->id }}">
                                        @if($c->aktif)
                                            <span class="bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 text-xs font-semibold px-2.5 py-1 rounded-full">Aktif</span>
                                        @else
                                            <span class="bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-xs font-semibold px-2.5 py-1 rounded-full">Nonaktif</span>
                                        @endif
                                    </span>
                                    <span class="edit-mode-c-{{ $c->id }} hidden">
                                        <input type="checkbox" name="aktif" form="edit-c-{{ $c->id }}" value="1" {{ $c->aktif ? 'checked' : '' }}
                                               class="w-4 h-4 rounded border-slate-300 dark:border-slate-700 text-brand-600 focus:ring-brand-500">
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form id="edit-c-{{ $c->id }}" method="POST" action="{{ route('admin.event-cities.update', $c) }}">
                                        @csrf @method('PUT')
                                    </form>

                                    <div class="flex items-center justify-end gap-2 view-mode-c-{{ $c->id }}">
                                        <button type="button" onclick="toggleEditCity({{ $c->id }})"
                                                class="text-xs font-medium text-brand-600 dark:text-brand-400 bg-brand-50 dark:bg-brand-950/60 hover:bg-brand-100 dark:hover:bg-brand-900/60 px-3 py-1.5 rounded-lg transition-colors">
                                            Edit
                                        </button>
                                        <form method="POST" action="{{ route('admin.event-cities.destroy', $c) }}" onsubmit="return confirm('Hapus kota ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="text-xs font-medium text-red-500 dark:text-red-400 bg-red-50 dark:bg-red-950/60 hover:bg-red-100 dark:hover:bg-red-900/60 px-3 py-1.5 rounded-lg transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                    <div class="flex items-center justify-end gap-2 edit-mode-c-{{ $c->id }} hidden">
                                        <button type="submit" form="edit-c-{{ $c->id }}"
                                                class="text-xs font-medium text-white bg-brand-600 hover:bg-brand-500 px-3 py-1.5 rounded-lg transition-colors">
                                            Simpan
                                        </button>
                                        <button type="button" onclick="toggleEditCity({{ $c->id }})"
                                                class="text-xs font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 px-3 py-1.5 rounded-lg transition-colors">
                                            Batal
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function toggleEditCity(id) {
    document.querySelectorAll('.view-mode-c-' + id).forEach(el => el.classList.toggle('hidden'));
    document.querySelectorAll('.edit-mode-c-' + id).forEach(el => el.classList.toggle('hidden'));
}

function filterCities(query) {
    const q = query.toLowerCase();
    document.querySelectorAll('.city-row').forEach(row => {
        const name = row.querySelector('.city-name')?.textContent.toLowerCase() || '';
        const prov = row.querySelector('.city-prov')?.textContent.toLowerCase() || '';
        if (name.includes(q) || prov.includes(q)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endsection
