@extends('layouts.app')

@section('title', 'Pendaftaran — ' . $event->nama . ' | Mau Run')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10 text-slate-800 dark:text-slate-100">

    {{-- Header Banner --}}
    <div class="bg-gradient-to-br from-brand-600 to-teal-500 rounded-2xl p-6 text-white mb-6 shadow-lg shadow-brand-500/20">
        <a href="{{ route('events.show', $event) }}" class="inline-flex items-center gap-1.5 text-white/70 hover:text-white text-xs font-medium mb-3 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Detail Event
        </a>
        <h1 class="text-xl font-extrabold">{{ $event->nama }}</h1>
        <p class="text-sm text-white/80 mt-0.5">{{ $event->kota }} · {{ $event->tanggal->translatedFormat('d F Y') }}</p>
    </div>

    <form method="POST" action="{{ route('events.register.store', $event) }}" class="grid md:grid-cols-3 gap-6" id="registration-form">
        @csrf

        <div class="md:col-span-2 space-y-5">

            {{-- ======================================== --}}
            {{-- PILIH KATEGORI (jika multi-kategori)     --}}
            {{-- ======================================== --}}
            @if($event->runCategories->count() > 0)
                <div class="border border-brand-200 dark:border-brand-800/60 bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm">
                    <h2 class="font-extrabold text-slate-800 dark:text-slate-100 mb-1 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Pilih Kategori Lari
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">Pilih satu kategori untuk diikuti. Harga akan menyesuaikan otomatis.</p>

                    @error('event_run_category_id')
                        <div class="bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800 text-rose-600 dark:text-rose-300 text-sm px-4 py-3 rounded-xl mb-3 font-medium">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="space-y-3" id="category-options">
                        @foreach($event->runCategories as $rc)
                            @php
                                $isPenuh = $rc->terisi >= $rc->kuota;
                                $sisaKuota = $rc->kuota - $rc->terisi;
                            @endphp
                            <label class="relative flex items-start gap-4 border-2 rounded-2xl p-4 cursor-pointer transition-all select-none
                                          category-option
                                          {{ old('event_run_category_id') == $rc->id ? 'border-brand-500 bg-brand-50 dark:bg-brand-900/30' : 'border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 hover:border-brand-300' }}
                                          {{ $isPenuh ? 'opacity-50 cursor-not-allowed' : '' }}"
                                   data-harga="{{ $rc->harga }}"
                                   data-category-id="{{ $rc->id }}">

                                <input type="radio" name="event_run_category_id"
                                       value="{{ $rc->id }}"
                                       id="cat_{{ $rc->id }}"
                                       class="hidden category-radio"
                                       {{ old('event_run_category_id') == $rc->id ? 'checked' : '' }}
                                       {{ $isPenuh ? 'disabled' : '' }}
                                       data-harga="{{ $rc->harga }}">

                                {{-- Radio Indicator --}}
                                <div class="mt-0.5 w-5 h-5 rounded-full border-2 flex-shrink-0 flex items-center justify-center
                                             {{ old('event_run_category_id') == $rc->id ? 'border-brand-500' : 'border-slate-300 dark:border-slate-600' }}
                                             radio-indicator">
                                    <div class="w-2.5 h-2.5 rounded-full bg-brand-500 {{ old('event_run_category_id') == $rc->id ? 'block' : 'hidden' }} radio-dot"></div>
                                </div>

                                <div class="flex-1">
                                    <div class="flex items-center justify-between gap-2 flex-wrap">
                                        <div>
                                            <p class="font-extrabold text-slate-800 dark:text-slate-100 text-base">{{ $rc->nama }}</p>
                                            @if($rc->jarak_km)
                                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ (float)$rc->jarak_km }} KM</p>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <p class="font-extrabold text-brand-600 dark:text-brand-400 text-lg">Rp {{ number_format($rc->harga, 0, ',', '.') }}</p>
                                            @if($isPenuh)
                                                <span class="text-xs font-bold text-rose-500 bg-rose-50 dark:bg-rose-950/40 px-2 py-0.5 rounded-full">PENUH</span>
                                            @else
                                                <p class="text-[11px] text-slate-400 dark:text-slate-500">Sisa {{ $sisaKuota }} slot</p>
                                            @endif
                                        </div>
                                    </div>
                                    @if($rc->deskripsi)
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5">{{ $rc->deskripsi }}</p>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ======================================== --}}
            {{-- DETAIL PELARI                            --}}
            {{-- ======================================== --}}
            <div class="border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm">
                <h2 class="font-extrabold text-slate-800 dark:text-slate-100 mb-4">Detail Pelari</h2>

                @if($errors->any() && !$errors->has('event_run_category_id'))
                    <div class="bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800 text-rose-600 dark:text-rose-300 text-sm p-3 rounded-xl mb-4">
                        <ul class="list-disc list-inside space-y-1 font-medium">
                            @foreach($errors->except('event_run_category_id')->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-3">
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', auth()->user()->name) }}" placeholder="Nama Lengkap"
                           class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none" required>

                    <div>
                        <input type="text" name="nik" id="nik_input"
                               value="{{ old('nik', auth()->user()->nik) }}"
                               placeholder="NIK (16 Digit)" maxlength="16" inputmode="numeric" pattern="\d{16}"
                               class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none @error('nik') border-rose-400 @enderror"
                               required>
                        @error('nik')
                            <p class="text-rose-500 text-xs mt-1 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-slate-400 text-xs mt-1" id="nik_counter">0 / 16 digit</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" placeholder="Email"
                               class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none" required>
                        <input type="text" name="no_hp" value="{{ old('no_hp', auth()->user()->no_hp) }}" placeholder="Nomor HP"
                               class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none" required>
                    </div>

                    <div>
                        <p class="text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Jenis Kelamin</p>
                        <div class="flex gap-3">
                            <label class="flex-1 border border-slate-200 dark:border-slate-700 rounded-xl py-2 text-center text-sm cursor-pointer has-[:checked]:bg-brand-600 has-[:checked]:text-white has-[:checked]:border-brand-600 dark:text-slate-200 transition-all">
                                <input type="radio" name="jenis_kelamin" value="Laki-laki" class="hidden" required {{ old('jenis_kelamin', auth()->user()->jenis_kelamin) === 'Laki-laki' ? 'checked' : '' }}> 👨 Laki-Laki
                            </label>
                            <label class="flex-1 border border-slate-200 dark:border-slate-700 rounded-xl py-2 text-center text-sm cursor-pointer has-[:checked]:bg-brand-600 has-[:checked]:text-white has-[:checked]:border-brand-600 dark:text-slate-200 transition-all">
                                <input type="radio" name="jenis_kelamin" value="Perempuan" class="hidden" {{ old('jenis_kelamin', auth()->user()->jenis_kelamin) === 'Perempuan' ? 'checked' : '' }}> 👩 Perempuan
                            </label>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Ukuran Jersey</p>
                        <div class="flex gap-2">
                            @foreach(['S','M','L','XL','XXL'] as $size)
                                <label class="flex-1 border border-slate-200 dark:border-slate-700 rounded-xl py-2 text-center text-sm cursor-pointer has-[:checked]:bg-brand-600 has-[:checked]:text-white has-[:checked]:border-brand-600 dark:text-slate-200 transition-all">
                                    <input type="radio" name="ukuran_jersey" value="{{ $size }}" class="hidden" required {{ old('ukuran_jersey', auth()->user()->ukuran_jersey ?? '') === $size ? 'checked' : '' }}> {{ $size }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ======================================== --}}
        {{-- RINGKASAN PESANAN (Sidebar)              --}}
        {{-- ======================================== --}}
        <div class="border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-2xl p-6 h-fit shadow-sm sticky top-28">
            <h2 class="font-extrabold text-slate-800 dark:text-slate-100 mb-4">Ringkasan Pesanan</h2>

            {{-- Kategori terpilih --}}
            @if($event->runCategories->count() > 0)
                <div class="bg-slate-50 dark:bg-slate-900 rounded-xl p-3 mb-4 text-sm">
                    <p class="text-slate-400 dark:text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Kategori Dipilih</p>
                    <p id="summary-category-name" class="font-bold text-slate-700 dark:text-slate-200 text-base">
                        — pilih kategori —
                    </p>
                </div>
            @endif

            <div class="flex justify-between text-sm mb-2">
                <span class="text-slate-500 dark:text-slate-400">Biaya Pendaftaran</span>
                <span id="summary-harga" class="font-semibold">Rp {{ number_format($event->runCategories->count() > 0 ? ($event->runCategories->first()?->harga ?? $event->harga) : $event->harga, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm mb-4">
                <span class="text-slate-500 dark:text-slate-400">Biaya Layanan</span>
                <span>Rp 5.000</span>
            </div>

            {{-- Kupon --}}
            <div class="mb-3">
                <div class="flex gap-2">
                    <input type="text" id="kode_kupon_input" name="kode_kupon"
                           placeholder="KODE KUPON"
                           class="flex-1 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 rounded-xl px-3 py-2 text-sm uppercase tracking-widest focus:outline-none focus:border-brand-400"
                           autocomplete="off">
                    <button type="button" id="btn_cek_kupon"
                            class="bg-slate-800 dark:bg-slate-700 text-white text-sm px-3 py-2 rounded-xl hover:bg-slate-700 dark:hover:bg-slate-600 transition-colors">
                        Cek
                    </button>
                </div>
                <div id="kupon_info" class="hidden mt-2 text-sm px-3 py-2 rounded-xl font-medium"></div>
            </div>

            {{-- Baris Diskon --}}
            <div id="row_diskon" class="hidden justify-between text-sm text-emerald-600 dark:text-emerald-400 font-semibold mb-2">
                <span>Diskon Kupon</span>
                <span id="diskon_nominal">-Rp 0</span>
            </div>

            <div class="flex justify-between font-extrabold border-t border-slate-100 dark:border-slate-700 pt-4 mb-5">
                <span>Total</span>
                <span class="text-emerald-600 dark:text-emerald-400 text-lg" id="total_bayar">
                    Rp {{ number_format(($event->runCategories->count() > 0 ? ($event->runCategories->first()?->harga ?? $event->harga) : $event->harga) + 5000, 0, ',', '.') }}
                </span>
            </div>

            <button type="submit"
                    class="w-full bg-brand-600 hover:bg-brand-500 text-white rounded-2xl py-3.5 font-bold text-sm shadow-lg shadow-brand-500/20 transition-all hover:-translate-y-0.5">
                Selesaikan Pendaftaran →
            </button>
        </div>
    </form>
</div>

<script>
(function () {
    // ---- Harga awal berdasarkan event type ----
    const hasRunCategories = {{ $event->runCategories->count() > 0 ? 'true' : 'false' }};
    let harga = {{ $event->runCategories->count() > 0 ? ($event->runCategories->first()?->harga ?? $event->harga) : $event->harga }};
    const layanan = 5000;
    let diskon = 0;

    // ---- Category Selection ----
    const categoryOptions = document.querySelectorAll('.category-option');

    function selectCategory(label) {
        const radio = label.querySelector('.category-radio');
        if (radio && radio.disabled) return; // kuota penuh

        // Reset semua
        categoryOptions.forEach(opt => {
            opt.classList.remove('border-brand-500', 'bg-brand-50', 'dark:bg-brand-900/30');
            opt.classList.add('border-slate-200', 'dark:border-slate-700');
            const dot    = opt.querySelector('.radio-dot');
            const ring   = opt.querySelector('.radio-indicator');
            if (dot)  dot.classList.add('hidden');
            if (ring) { ring.classList.remove('border-brand-500'); ring.classList.add('border-slate-300', 'dark:border-slate-600'); }
        });

        // Aktifkan yang dipilih
        label.classList.add('border-brand-500', 'bg-brand-50', 'dark:bg-brand-900/30');
        label.classList.remove('border-slate-200', 'dark:border-slate-700');
        const dot  = label.querySelector('.radio-dot');
        const ring = label.querySelector('.radio-indicator');
        if (dot)  dot.classList.remove('hidden');
        if (ring) { ring.classList.add('border-brand-500'); ring.classList.remove('border-slate-300', 'dark:border-slate-600'); }

        // Update harga
        const newHarga = parseFloat(label.dataset.harga);
        if (!isNaN(newHarga)) {
            harga = newHarga;
            // Update ringkasan harga
            const summaryHarga = document.getElementById('summary-harga');
            if (summaryHarga) summaryHarga.textContent = 'Rp ' + harga.toLocaleString('id-ID');
            // Update nama kategori di ringkasan
            const categoryName = label.querySelector('p.font-extrabold');
            const summaryName = document.getElementById('summary-category-name');
            if (summaryName && categoryName) summaryName.textContent = categoryName.textContent.trim();
            // Reset diskon (perlu cek ulang kupon)
            diskon = 0;
            const kuponInfo = document.getElementById('kupon_info');
            const rowDiskon = document.getElementById('row_diskon');
            if (kuponInfo) kuponInfo.classList.add('hidden');
            if (rowDiskon) rowDiskon.classList.add('hidden');
        }
        updateTotal();
    }

    categoryOptions.forEach(label => {
        label.addEventListener('click', () => selectCategory(label));
    });

    // Auto-select checked category (e.g. from old input) or first available category on page load
    const initialChecked = document.querySelector('.category-radio:checked');
    if (initialChecked) {
        const initialLabel = initialChecked.closest('.category-option');
        if (initialLabel) selectCategory(initialLabel);
    } else if (categoryOptions.length > 0) {
        const firstAvailable = Array.from(categoryOptions).find(opt => {
            const r = opt.querySelector('.category-radio');
            return r && !r.disabled;
        });
        if (firstAvailable) {
            const r = firstAvailable.querySelector('.category-radio');
            if (r) r.checked = true;
            selectCategory(firstAvailable);
        }
    }

    // ---- Total Calculation ----
    function formatRp(num) {
        return 'Rp ' + num.toLocaleString('id-ID');
    }

    function updateTotal() {
        const total = Math.max(harga + layanan - diskon, 0);
        document.getElementById('total_bayar').textContent = formatRp(total);
    }

    // ---- Kupon ----
    const inputKupon = document.getElementById('kode_kupon_input');
    const btnCek     = document.getElementById('btn_cek_kupon');
    const kuponInfo  = document.getElementById('kupon_info');
    const rowDiskon  = document.getElementById('row_diskon');
    const diskonNom  = document.getElementById('diskon_nominal');

    function showInfo(message, isValid) {
        kuponInfo.classList.remove('hidden', 'bg-emerald-50', 'text-emerald-700', 'bg-rose-50', 'text-rose-600', 'dark:bg-emerald-950/50', 'dark:bg-rose-950/50', 'dark:text-emerald-300', 'dark:text-rose-300');
        if (isValid) {
            kuponInfo.classList.add('bg-emerald-50', 'text-emerald-700', 'dark:bg-emerald-950/50', 'dark:text-emerald-300');
        } else {
            kuponInfo.classList.add('bg-rose-50', 'text-rose-600', 'dark:bg-rose-950/50', 'dark:text-rose-300');
        }
        kuponInfo.textContent = message;
    }

    btnCek.addEventListener('click', function () {
        const kode = inputKupon.value.trim();
        if (!kode) { showInfo('Masukkan kode kupon terlebih dahulu.', false); return; }

        btnCek.disabled = true;
        btnCek.textContent = '...';

        fetch('{{ route('coupon.check') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ kode_kupon: kode })
        })
        .then(res => res.json())
        .then(data => {
            if (data.valid) {
                diskon = data.discount_type === 'percentage'
                    ? (harga * data.discount) / 100
                    : data.discount;
                showInfo('✅ ' + data.message, true);
                rowDiskon.classList.remove('hidden');
                rowDiskon.style.display = 'flex';
                diskonNom.textContent = '-' + formatRp(diskon);
            } else {
                diskon = 0;
                showInfo('❌ ' + data.message, false);
                rowDiskon.classList.add('hidden');
            }
            updateTotal();
        })
        .catch(() => showInfo('Terjadi kesalahan. Coba lagi.', false))
        .finally(() => { btnCek.disabled = false; btnCek.textContent = 'Cek'; });
    });

    inputKupon.addEventListener('keydown', e => { if (e.key === 'Enter') { e.preventDefault(); btnCek.click(); } });
    inputKupon.addEventListener('input', function () {
        if (!this.value.trim()) { diskon = 0; kuponInfo.classList.add('hidden'); rowDiskon.classList.add('hidden'); updateTotal(); }
    });

    updateTotal();
})();

// ---- NIK Counter ----
(function () {
    const nikInput   = document.getElementById('nik_input');
    const nikCounter = document.getElementById('nik_counter');
    if (!nikInput || !nikCounter) return;
    updateCounter();
    nikInput.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 16);
        updateCounter();
    });
    function updateCounter() {
        const len = nikInput.value.length;
        nikCounter.textContent = len + ' / 16 digit';
        nikCounter.className = 'text-xs mt-1 ' + (len === 16 ? 'text-emerald-600' : len > 0 ? 'text-rose-500' : 'text-slate-400');
        if (len === 16) nikCounter.textContent = '✓ 16 / 16 digit';
    }
})();
</script>
@endsection