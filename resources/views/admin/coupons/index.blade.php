@extends('layouts.admin')

@section('title', 'Manajemen Kupon Diskon | Mau Run - Ekosistem Acara Lari Premium')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-800 dark:text-slate-100 mb-2 flex items-center gap-2">
            <span class="w-1.5 h-8 bg-brand-500 rounded-full"></span>
            Kupon Diskon
        </h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm ml-3">Kelola kode kupon promo dan nominal potongan pendaftaran peserta.</p>
    </div>
    <button onclick="toggleModal('couponModal', true)" class="bg-brand-600 hover:bg-brand-500 text-white px-6 py-3 rounded-xl text-sm font-semibold shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-0.5 flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Buat Kupon Baru
    </button>
</div>

@if(session('success'))
    <div class="bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-4 py-4 rounded-xl mb-6 flex items-start gap-3 shadow-sm">
        <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <p class="text-sm font-medium">{{ session('success') }}</p>
    </div>
@endif

@if($errors->any())
    <div class="bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-300 px-4 py-4 rounded-xl mb-6 shadow-sm">
        <ul class="list-disc list-inside text-sm font-medium">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Table --}}
<div class="bg-white dark:bg-slate-900 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-slate-400 dark:text-slate-400 uppercase bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                <tr>
                    <th scope="col" class="px-6 py-4 font-semibold">Kode Kupon</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Besar Potongan</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Masa Berlaku</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-center">Status</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($coupons as $coupon)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors group">
                        <td class="px-6 py-5">
                            <span class="font-mono bg-brand-50 dark:bg-brand-950/60 text-brand-700 dark:text-brand-300 px-3 py-1.5 rounded-lg text-sm font-bold border border-brand-100 dark:border-brand-900/60 tracking-wider">
                                {{ $coupon->code }}
                            </span>
                        </td>
                        <td class="px-6 py-5 font-bold text-slate-800 dark:text-slate-100 text-base">
                            @if($coupon->discount_type === 'percentage')
                                {{ (float) $coupon->discount }}%
                            @else
                                Rp {{ number_format($coupon->discount, 0, ',', '.') }}
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            @if($coupon->expired_at)
                                <div class="font-semibold text-slate-700 dark:text-slate-300">
                                    {{ \Carbon\Carbon::parse($coupon->expired_at)->translatedFormat('d M Y') }}
                                </div>
                                <div class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">
                                    @if(\Carbon\Carbon::parse($coupon->expired_at)->isPast())
                                        <span class="text-rose-500 dark:text-rose-400 font-semibold">Kadaluarsa</span>
                                    @else
                                        {{ \Carbon\Carbon::parse($coupon->expired_at)->diffForHumans() }}
                                    @endif
                                </div>
                            @else
                                <span class="text-slate-400 dark:text-slate-500">Selamanya</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-center">
                            @if($coupon->is_active && (!$coupon->expired_at || !\Carbon\Carbon::parse($coupon->expired_at)->isPast()))
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800">
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-700">
                                    Tidak Aktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="editCoupon({{ json_encode($coupon) }})" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 dark:text-slate-500 hover:text-brand-600 dark:hover:text-brand-400 hover:bg-brand-50 dark:hover:bg-slate-800 transition-colors" title="Edit Kupon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kupon ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 dark:text-slate-500 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-slate-800 transition-colors" title="Hapus Kupon">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                            Belum ada kupon promo dibuat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $coupons->links() }}
</div>

{{-- Create/Edit Coupon Modal --}}
<div id="couponModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-slate-900/70 backdrop-blur-sm" onclick="toggleModal('couponModal', false)"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-100 dark:border-slate-800">
            <form id="couponForm" method="POST" action="{{ route('admin.coupons.store') }}" class="p-8">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                
                <h3 class="text-xl font-extrabold text-slate-800 dark:text-slate-100 mb-6" id="modalTitle">Buat Kupon Baru</h3>
                
                <div class="space-y-4">
                    {{-- Code --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Kode Kupon</label>
                        <input type="text" name="code" id="couponCode" required placeholder="CONTOH: MERDEKARUN"
                               class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 font-mono tracking-wider">
                    </div>
                    
                    {{-- Discount Type & Nominal --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tipe Diskon</label>
                            <select name="discount_type" id="couponDiscountType" class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 font-semibold" onchange="updateDiscountLabel()">
                                <option value="nominal">Nominal (Rp)</option>
                                <option value="percentage">Persentase (%)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2" id="discountLabel">Besar Potongan (Rp)</label>
                            <input type="number" step="any" name="discount" id="couponDiscount" required placeholder="50000"
                                   class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 font-semibold">
                        </div>
                    </div>
                    
                    {{-- Expired At --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tanggal Kadaluarsa (Opsional)</label>
                        <input type="date" name="expired_at" id="couponExpired"
                               class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                    </div>
                    
                    {{-- Is Active --}}
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="couponActive" value="1" checked
                               class="rounded border-slate-300 dark:border-slate-700 text-brand-600 focus:ring-brand-500 h-4 w-4">
                        <label for="couponActive" class="ms-2 text-sm font-semibold text-slate-600 dark:text-slate-300">Kupon Aktif & Bisa Digunakan</label>
                    </div>
                </div>
                
                <div class="mt-8 flex justify-end gap-3">
                    <button type="button" onclick="toggleModal('couponModal', false)"
                            class="bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-semibold py-3 px-6 rounded-xl text-sm transition-colors">
                        Batal
                    </button>
                    <button type="submit" id="submitBtn"
                            class="bg-brand-600 hover:bg-brand-500 text-white font-semibold py-3 px-6 rounded-xl text-sm transition-all shadow-lg shadow-brand-500/20">
                        Simpan Kupon
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleModal(id, show) {
        const modal = document.getElementById(id);
        if (show) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }
    
    function updateDiscountLabel() {
        const type = document.getElementById('couponDiscountType').value;
        const label = document.getElementById('discountLabel');
        const input = document.getElementById('couponDiscount');
        if (type === 'percentage') {
            label.innerText = 'Besar Potongan (%)';
            input.placeholder = '10';
            input.max = '100';
        } else {
            label.innerText = 'Besar Potongan (Rp)';
            input.placeholder = '50000';
            input.removeAttribute('max');
        }
    }
    
    function editCoupon(coupon) {
        document.getElementById('modalTitle').innerText = 'Edit Kupon Diskon';
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('couponForm').action = `{{ url('/admin/coupons') }}/${coupon.id}`;
        
        document.getElementById('couponCode').value = coupon.code;
        document.getElementById('couponDiscountType').value = coupon.discount_type || 'nominal';
        document.getElementById('couponDiscount').value = parseFloat(coupon.discount);
        document.getElementById('couponExpired').value = coupon.expired_at ? coupon.expired_at.split('T')[0] : '';
        document.getElementById('couponActive').checked = coupon.is_active;
        
        updateDiscountLabel();
        toggleModal('couponModal', true);
    }
    
    // Reset modal to store state if opened fresh
    window.addEventListener('click', (e) => {
        if (e.target.innerText === 'Buat Kupon Baru') {
            document.getElementById('modalTitle').innerText = 'Buat Kupon Baru';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('couponForm').action = "{{ route('admin.coupons.store') }}";
            document.getElementById('couponForm').reset();
            updateDiscountLabel();
            document.getElementById('couponActive').checked = true;
        }
    });
</script>
@endsection
