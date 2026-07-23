@if($errors->any())
    <div class="bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800 text-rose-600 dark:text-rose-300 text-sm p-4 rounded-xl mb-4">
        <ul class="list-disc list-inside space-y-1 font-medium">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-5">
    {{-- Thumbnail --}}
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 block mb-1">Foto Acara</label>
        @if(isset($event) && $event->thumbnail)
            <img src="{{ asset('storage/' . $event->thumbnail) }}" class="w-40 h-24 object-cover rounded-lg mb-2 border border-slate-200 dark:border-slate-700">
        @endif
        <input type="file" name="thumbnail" accept="image/*" class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-brand-500">
        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Format JPG/PNG/WEBP, maks 2MB.</p>
    </div>

    {{-- Nama Acara --}}
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 block mb-1">Nama Acara</label>
        <input type="text" name="nama" value="{{ old('nama', $event->nama ?? '') }}"
               class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-brand-500" required>
    </div>

    {{-- Kota --}}
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 block mb-1">Kota Pelaksanaan</label>
        <select name="kota" id="kota-select" class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-brand-500" required>
            <option value="">Pilih Kota...</option>
            @foreach($cities as $city)
                <option value="{{ $city->nama }}" {{ old('kota', $event->kota ?? '') == $city->nama ? 'selected' : '' }}>
                    {{ $city->nama }}@if($city->provinsi) — {{ $city->provinsi }}@endif
                </option>
            @endforeach
            @if(isset($event) && $event->kota && !$cities->pluck('nama')->contains($event->kota))
                <option value="{{ $event->kota }}" selected>{{ $event->kota }} (data lama)</option>
            @endif
        </select>
    </div>

    {{-- Tanggal & Waktu --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 block mb-1">Tanggal</label>
            <input type="date" name="tanggal" value="{{ old('tanggal', isset($event) ? $event->tanggal->format('Y-m-d') : '') }}"
                   class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-brand-500" required>
        </div>
        <div>
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 block mb-1">Waktu Mulai</label>
            <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai', $event->waktu_mulai ?? '') }}"
                   class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-brand-500" required>
        </div>
    </div>

    {{-- Status --}}
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 block mb-1">Status</label>
        <select name="status" class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-brand-500" required>
            @foreach(['draft' => 'Draft', 'aktif' => 'Aktif', 'selesai' => 'Selesai'] as $val => $label)
                <option value="{{ $val }}" {{ old('status', $event->status ?? 'draft') == $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    {{-- Lokasi Detail --}}
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 block mb-1">Lokasi Detail</label>
        <input type="text" name="lokasi_detail" value="{{ old('lokasi_detail', $event->lokasi_detail ?? '') }}"
               placeholder="Contoh: Senayan Sports Complex, Gerbang A"
               class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-brand-500">
    </div>

    {{-- ========================================================== --}}
    {{-- MULTI-KATEGORI LARI                                       --}}
    {{-- ========================================================== --}}
    <div class="border border-brand-200 dark:border-brand-800/60 bg-brand-50/40 dark:bg-brand-950/20 rounded-2xl p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Kategori Lari
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Tambahkan lebih dari satu kategori. Peserta memilih satu kategori saat daftar.</p>
            </div>
            <button type="button" id="btn-add-category"
                    class="bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold px-4 py-2 rounded-xl flex items-center gap-1.5 transition-all shadow-md shadow-brand-500/20">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Kategori
            </button>
        </div>

        {{-- Header Row --}}
        <div class="hidden md:grid grid-cols-12 gap-2 px-2 mb-2 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider" id="category-header">
            <div class="col-span-3">Nama Kategori</div>
            <div class="col-span-2">Jarak (KM)</div>
            <div class="col-span-3">Harga (Rp)</div>
            <div class="col-span-2">Kuota</div>
            <div class="col-span-2 text-right">Aksi</div>
        </div>

        <div id="run-categories-container" class="space-y-3">
            {{-- Existing categories loaded from DB (edit mode) --}}
            @if(isset($event) && $event->runCategories->count() > 0)
                @foreach($event->runCategories as $i => $rc)
                    <div class="run-category-row bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl p-3">
                        <div class="grid grid-cols-12 gap-2 items-center">
                            <div class="col-span-12 md:col-span-3">
                                <label class="md:hidden text-[10px] font-bold text-slate-400 uppercase">Nama</label>
                                <input type="text" name="run_categories[{{ $i }}][nama]" value="{{ $rc->nama }}"
                                       placeholder="5K / 10K / Fun Run..."
                                       class="w-full border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500">
                            </div>
                            <div class="col-span-6 md:col-span-2">
                                <label class="md:hidden text-[10px] font-bold text-slate-400 uppercase">Jarak KM</label>
                                <input type="number" step="0.1" min="0" name="run_categories[{{ $i }}][jarak_km]" value="{{ $rc->jarak_km }}"
                                       placeholder="5.0"
                                       class="w-full border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500">
                            </div>
                            <div class="col-span-6 md:col-span-3">
                                <label class="md:hidden text-[10px] font-bold text-slate-400 uppercase">Harga</label>
                                <input type="number" min="0" name="run_categories[{{ $i }}][harga]" value="{{ $rc->harga }}"
                                       placeholder="100000"
                                       class="w-full border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500">
                            </div>
                            <div class="col-span-6 md:col-span-2">
                                <label class="md:hidden text-[10px] font-bold text-slate-400 uppercase">Kuota</label>
                                <input type="number" min="1" name="run_categories[{{ $i }}][kuota]" value="{{ $rc->kuota }}"
                                       placeholder="500"
                                       class="w-full border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500">
                            </div>
                            <div class="col-span-6 md:col-span-2 flex justify-end items-center">
                                <button type="button" onclick="this.closest('.run-category-row').remove(); reindexCategories()"
                                        class="text-rose-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40 w-8 h-8 rounded-lg flex items-center justify-center transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        {{-- Empty state --}}
        <div id="category-empty" class="{{ (isset($event) && $event->runCategories->count() > 0) ? 'hidden' : '' }} text-center py-6 text-slate-400 dark:text-slate-500 text-sm">
            <svg class="w-10 h-10 mx-auto mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            Belum ada kategori. Klik "Tambah Kategori" untuk menambahkan.
        </div>
    </div>

    {{-- Deskripsi --}}
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 block mb-1">Deskripsi</label>
        <textarea name="deskripsi" rows="4"
                  class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-brand-500">{{ old('deskripsi', $event->deskripsi ?? '') }}</textarea>
    </div>

    {{-- Fasilitas --}}
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 block mb-1">Fasilitas Peserta <span class="text-slate-400 font-normal">(opsional, pisah per baris)</span></label>
        @php
            $existingFacilities = isset($event) ? $event->facilities->pluck('nama_fasilitas')->implode("\n") : '';
        @endphp
        <textarea name="fasilitas_text" rows="3"
                  class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-brand-500"
                  placeholder="Jersey Balapan&#10;Medali Finisher&#10;Konsumsi"
                  onkeyup="syncFasilitas(this.value)">{{ $existingFacilities }}</textarea>
        <div id="fasilitas-hidden"></div>
    </div>
</div>

{{-- Template baris kategori (tersembunyi, di-clone oleh JS) --}}
<template id="category-row-template">
    <div class="run-category-row bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl p-3">
        <div class="grid grid-cols-12 gap-2 items-center">
            <div class="col-span-12 md:col-span-3">
                <label class="md:hidden text-[10px] font-bold text-slate-400 uppercase">Nama</label>
                <input type="text" name="" placeholder="5K / 10K / Fun Run..."
                       class="w-full border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500">
            </div>
            <div class="col-span-6 md:col-span-2">
                <label class="md:hidden text-[10px] font-bold text-slate-400 uppercase">Jarak KM</label>
                <input type="number" step="0.1" min="0" name="" placeholder="5.0"
                       class="w-full border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500">
            </div>
            <div class="col-span-6 md:col-span-3">
                <label class="md:hidden text-[10px] font-bold text-slate-400 uppercase">Harga</label>
                <input type="number" min="0" name="" placeholder="100000"
                       class="w-full border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500">
            </div>
            <div class="col-span-6 md:col-span-2">
                <label class="md:hidden text-[10px] font-bold text-slate-400 uppercase">Kuota</label>
                <input type="number" min="1" name="" placeholder="500"
                       class="w-full border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500">
            </div>
            <div class="col-span-6 md:col-span-2 flex justify-end items-center">
                <button type="button" onclick="this.closest('.run-category-row').remove(); reindexCategories()"
                        class="text-rose-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40 w-8 h-8 rounded-lg flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
        </div>
    </div>
</template>

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
// ---- Fasilitas ----
function syncFasilitas(text) {
    const container = document.getElementById('fasilitas-hidden');
    container.innerHTML = '';
    text.split('\n').forEach(item => {
        if (item.trim() !== '') {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'fasilitas[]';
            input.value = item.trim();
            container.appendChild(input);
        }
    });
}

// ---- Multi-Kategori ----
let catCount = {{ isset($event) ? $event->runCategories->count() : 0 }};

function reindexCategories() {
    const rows = document.querySelectorAll('#run-categories-container .run-category-row');
    rows.forEach((row, idx) => {
        const inputs = row.querySelectorAll('input');
        const fieldNames = ['nama', 'jarak_km', 'harga', 'kuota'];
        inputs.forEach((inp, fi) => {
            if (fi < fieldNames.length) {
                inp.name = `run_categories[${idx}][${fieldNames[fi]}]`;
            }
        });
    });
    catCount = rows.length;

    const emptyEl = document.getElementById('category-empty');
    if (emptyEl) emptyEl.classList.toggle('hidden', rows.length > 0);
}

document.getElementById('btn-add-category').addEventListener('click', function () {
    const template = document.getElementById('category-row-template');
    const clone    = template.content.cloneNode(true);
    const idx      = catCount;
    const fieldNames = ['nama', 'jarak_km', 'harga', 'kuota'];
    clone.querySelectorAll('input').forEach((inp, fi) => {
        if (fi < fieldNames.length) {
            inp.name = `run_categories[${idx}][${fieldNames[fi]}]`;
        }
    });
    document.getElementById('run-categories-container').appendChild(clone);
    catCount++;
    const emptyEl = document.getElementById('category-empty');
    if (emptyEl) emptyEl.classList.add('hidden');
});

window.addEventListener('DOMContentLoaded', () => {
    // Fasilitas awal (mode edit)
    const textarea = document.querySelector('textarea[name="fasilitas_text"]');
    if (textarea) syncFasilitas(textarea.value);

    // Reindex existing rows (edit mode)
    reindexCategories();

    // TomSelect untuk kota
    if (document.getElementById('kota-select')) {
        new TomSelect('#kota-select', {
            create: false,
            sortField: { field: 'text', direction: 'asc' },
            placeholder: 'Pilih Kota / Kabupaten...',
            maxOptions: null
        });
    }
});
</script>