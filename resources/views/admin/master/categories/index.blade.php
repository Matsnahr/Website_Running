@extends('layouts.admin')

@section('title', 'Master Kategori Event | Mau Run')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-slate-800 dark:text-slate-100 mb-2 flex items-center gap-2">
        <span class="w-1.5 h-8 bg-brand-500 rounded-full"></span>
        Master Kategori Event
    </h1>
    <p class="text-slate-500 dark:text-slate-400 text-sm ml-3">Kelola jenis/kategori event lari yang tersedia (3K, 5K, 10K, dll).</p>
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

    {{-- Form Tambah Kategori --}}
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-6">
            <h2 class="text-base font-bold text-slate-700 dark:text-slate-100 mb-5 flex items-center gap-2">
                <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Kategori
            </h2>
            <form method="POST" action="{{ route('admin.event-categories.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider block mb-1.5">Nama Kategori <span class="text-red-400">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Contoh: 5K, Half Marathon"
                           class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors" required>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider block mb-1.5">Jarak KM Default</label>
                    <input type="number" step="0.1" name="jarak_km_default" value="{{ old('jarak_km_default') }}" placeholder="Contoh: 5.0"
                           class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors">
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Diisi otomatis ke form event jika dipilih.</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider block mb-1.5">Urutan Tampil</label>
                    <input type="number" name="urutan" value="{{ old('urutan', 0) }}" min="0"
                           class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors">
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Angka lebih kecil tampil lebih awal.</p>
                </div>
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="aktif" id="aktif_new" value="1" checked
                           class="w-4 h-4 rounded border-slate-300 dark:border-slate-700 text-brand-600 focus:ring-brand-500">
                    <label for="aktif_new" class="text-sm font-medium text-slate-600 dark:text-slate-300">Aktif (tampil di pilihan)</label>
                </div>
                <button type="submit"
                        class="w-full bg-brand-600 hover:bg-brand-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-md shadow-brand-500/20 hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Kategori
                </button>
            </form>
        </div>
    </div>

    {{-- Tabel Kategori --}}
    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <h2 class="text-base font-bold text-slate-700 dark:text-slate-100">Daftar Kategori ({{ $categories->count() }})</h2>
            </div>
            @if($categories->isEmpty())
                <div class="flex flex-col items-center justify-center py-16 text-slate-400 dark:text-slate-500">
                    <svg class="w-12 h-12 mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <p class="text-sm">Belum ada kategori. Tambahkan di form sebelah kiri.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-slate-400 dark:text-slate-400 uppercase bg-slate-50/70 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                            <tr>
                                <th class="px-6 py-3 font-semibold">Nama Kategori</th>
                                <th class="px-6 py-3 font-semibold">Jarak</th>
                                <th class="px-6 py-3 font-semibold text-center">Urutan</th>
                                <th class="px-6 py-3 font-semibold text-center">Status</th>
                                <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                            @foreach($categories as $cat)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors group" id="row-cat-{{ $cat->id }}">
                                <td class="px-6 py-4">
                                    <span class="view-mode-{{ $cat->id }}">
                                        <span class="font-semibold text-slate-800 dark:text-brand-300 bg-brand-50 dark:bg-brand-950/60 text-brand-700 dark:text-brand-300 px-2.5 py-1 rounded-full text-xs">{{ $cat->nama }}</span>
                                    </span>
                                    <span class="edit-mode-{{ $cat->id }} hidden">
                                        <input type="text" name="nama" form="edit-cat-{{ $cat->id }}" value="{{ $cat->nama }}"
                                               class="border border-brand-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-lg px-2 py-1 text-sm w-full focus:outline-none focus:ring-1 focus:ring-brand-500">
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-500 dark:text-slate-400">
                                    <span class="view-mode-{{ $cat->id }}">{{ $cat->jarak_km_default ? $cat->jarak_km_default . ' km' : '-' }}</span>
                                    <span class="edit-mode-{{ $cat->id }} hidden">
                                        <input type="number" step="0.1" name="jarak_km_default" form="edit-cat-{{ $cat->id }}" value="{{ $cat->jarak_km_default }}"
                                               class="border border-brand-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-lg px-2 py-1 text-sm w-20 focus:outline-none focus:ring-1 focus:ring-brand-500">
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-slate-500 dark:text-slate-400">
                                    <span class="view-mode-{{ $cat->id }}">{{ $cat->urutan }}</span>
                                    <span class="edit-mode-{{ $cat->id }} hidden">
                                        <input type="number" name="urutan" form="edit-cat-{{ $cat->id }}" value="{{ $cat->urutan }}" min="0"
                                               class="border border-brand-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-lg px-2 py-1 text-sm w-16 text-center focus:outline-none focus:ring-1 focus:ring-brand-500">
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="view-mode-{{ $cat->id }}">
                                        @if($cat->aktif)
                                            <span class="bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 text-xs font-semibold px-2.5 py-1 rounded-full">Aktif</span>
                                        @else
                                            <span class="bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-xs font-semibold px-2.5 py-1 rounded-full">Nonaktif</span>
                                        @endif
                                    </span>
                                    <span class="edit-mode-{{ $cat->id }} hidden">
                                        <input type="checkbox" name="aktif" form="edit-cat-{{ $cat->id }}" value="1" {{ $cat->aktif ? 'checked' : '' }}
                                               class="w-4 h-4 rounded border-slate-300 dark:border-slate-700 text-brand-600 focus:ring-brand-500">
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    {{-- Hidden edit form --}}
                                    <form id="edit-cat-{{ $cat->id }}" method="POST" action="{{ route('admin.event-categories.update', $cat) }}">
                                        @csrf @method('PUT')
                                    </form>

                                    <div class="flex items-center justify-end gap-2 view-mode-{{ $cat->id }}">
                                        <button type="button" onclick="toggleEdit({{ $cat->id }})"
                                                class="text-xs font-medium text-brand-600 dark:text-brand-400 bg-brand-50 dark:bg-brand-950/60 hover:bg-brand-100 dark:hover:bg-brand-900/60 px-3 py-1.5 rounded-lg transition-colors">
                                            Edit
                                        </button>
                                        <form method="POST" action="{{ route('admin.event-categories.destroy', $cat) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="text-xs font-medium text-red-500 dark:text-red-400 bg-red-50 dark:bg-red-950/60 hover:bg-red-100 dark:hover:bg-red-900/60 px-3 py-1.5 rounded-lg transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                    <div class="flex items-center justify-end gap-2 edit-mode-{{ $cat->id }} hidden">
                                        <button type="submit" form="edit-cat-{{ $cat->id }}"
                                                class="text-xs font-medium text-white bg-brand-600 hover:bg-brand-500 px-3 py-1.5 rounded-lg transition-colors">
                                            Simpan
                                        </button>
                                        <button type="button" onclick="toggleEdit({{ $cat->id }})"
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
function toggleEdit(id) {
    document.querySelectorAll('.view-mode-' + id).forEach(el => el.classList.toggle('hidden'));
    document.querySelectorAll('.edit-mode-' + id).forEach(el => el.classList.toggle('hidden'));
}
</script>
@endsection
