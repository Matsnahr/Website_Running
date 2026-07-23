<x-app-layout>
@section('title', 'Profil Saya | Mau Run')
<div class="bg-slate-50 dark:bg-slate-950 min-h-screen pb-24">

    {{-- ===== HERO HEADER ===== --}}
    <div class="relative bg-brand-dark overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-brand-900 via-brand-700 to-teal-500 opacity-90"></div>
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-teal-400/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 -left-16 w-72 h-72 bg-brand-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative max-w-5xl mx-auto px-6 py-16 flex items-end gap-8">
            {{-- Avatar Section --}}
            <div class="relative group flex-shrink-0">
                <div id="avatar-ring" class="w-28 h-28 rounded-full ring-4 ring-white/40 shadow-2xl overflow-hidden bg-brand-100 flex items-center justify-center text-brand-700 font-extrabold text-4xl relative">
                    @if($user->avatar)
                        <img id="avatar-preview" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    @else
                        <span id="avatar-initials">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        <img id="avatar-preview" src="" alt="" class="w-full h-full object-cover hidden absolute inset-0">
                    @endif
                </div>
                {{-- Camera overlay --}}
                <label for="avatar-input" class="absolute inset-0 rounded-full bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </label>
                <span class="absolute -bottom-1 -right-1 bg-brand-500 text-white text-xs font-bold w-7 h-7 rounded-full flex items-center justify-center border-2 border-white shadow pointer-events-none">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </span>
            </div>

            {{-- User Info --}}
            <div class="pb-1 flex-1 min-w-0">
                <p class="text-white/60 text-xs font-semibold uppercase tracking-widest mb-1">Profil Saya</p>
                <h1 class="text-3xl md:text-4xl font-extrabold text-white leading-tight truncate">{{ $user->name }}</h1>
                <p class="text-white/70 text-sm mt-1 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    {{ $user->email }}
                </p>
                <div class="flex flex-wrap gap-2 mt-3">
                    @if($user->jenis_kelamin)
                        <span class="bg-white/15 backdrop-blur text-white text-xs font-semibold px-3 py-1 rounded-full">
                            {{ $user->jenis_kelamin === 'Laki-laki' ? '👨' : '👩' }} {{ $user->jenis_kelamin }}
                        </span>
                    @endif
                    @if($user->ukuran_jersey)
                        <span class="bg-white/15 backdrop-blur text-white text-xs font-semibold px-3 py-1 rounded-full">
                            👕 Jersey {{ $user->ukuran_jersey }}
                        </span>
                    @endif
                    @if($user->no_hp)
                        <span class="bg-white/15 backdrop-blur text-white text-xs font-semibold px-3 py-1 rounded-full">
                            📱 {{ $user->no_hp }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="max-w-5xl mx-auto px-6 -mt-5 relative z-10 space-y-6">

        {{-- Flash Messages --}}
        @if(session('status') === 'profile-updated')
            <div id="flash-success" class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl shadow flex items-center gap-3 text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Profil berhasil diperbarui!
            </div>
        @endif
        @if(session('status') === 'password-updated')
            <div id="flash-pw" class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl shadow flex items-center gap-3 text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Password berhasil diperbarui!
            </div>
        @endif

        {{-- Two-column layout --}}
        <div class="grid lg:grid-cols-3 gap-6">

            {{-- ===== LEFT: Edit Profile Info ===== --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Profile Information Card --}}
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700 overflow-hidden">
                    <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-700 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-brand-50 dark:bg-brand-900/40 text-brand-600 dark:text-brand-400 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <h2 class="font-bold text-slate-800 dark:text-slate-100">Informasi Profil</h2>
                            <p class="text-xs text-slate-400 dark:text-slate-400">Perbarui nama, email, dan data pribadi</p>
                        </div>
                    </div>

                    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-8 space-y-5" id="profile-form">
                        @csrf
                        @method('patch')

                        {{-- Hidden avatar input --}}
                        <input type="file" id="avatar-input" name="avatar" accept="image/*" class="hidden">

                        {{-- Avatar change hint --}}
                        <div class="bg-brand-50 dark:bg-brand-900/30 border border-brand-100 dark:border-brand-800/40 rounded-2xl px-4 py-3 flex items-center gap-3 text-sm text-brand-700 dark:text-brand-300">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Arahkan kursor ke foto profil di bagian atas untuk menggantinya.
                        </div>

                        @if($errors->any())
                            <div class="bg-rose-50 border border-rose-200 rounded-2xl px-4 py-3 text-sm text-rose-600">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Name + Email --}}
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus
                                    class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition-all">
                            </div>
                        </div>

                        {{-- NIK + No HP --}}
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">NIK <span class="text-slate-400 font-normal">(16 Digit)</span></label>
                                <input type="text" name="nik" value="{{ old('nik', $user->nik) }}" maxlength="16" inputmode="numeric" placeholder="Masukkan 16 digit NIK"
                                    class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Nomor HP</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" placeholder="Contoh: 08123456789"
                                    class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition-all">
                            </div>
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Jenis Kelamin</label>
                            <div class="flex gap-3">
                                <label class="flex-1 border-2 rounded-xl py-2.5 text-center text-sm cursor-pointer font-medium transition-all
                                    {{ old('jenis_kelamin', $user->jenis_kelamin) === 'Laki-laki' ? 'border-brand-500 bg-brand-50 text-brand-700' : 'border-slate-200 text-slate-500 hover:border-brand-300' }}">
                                    <input type="radio" name="jenis_kelamin" value="Laki-laki" class="hidden"
                                        {{ old('jenis_kelamin', $user->jenis_kelamin) === 'Laki-laki' ? 'checked' : '' }}>
                                    👨 Laki-laki
                                </label>
                                <label class="flex-1 border-2 rounded-xl py-2.5 text-center text-sm cursor-pointer font-medium transition-all
                                    {{ old('jenis_kelamin', $user->jenis_kelamin) === 'Perempuan' ? 'border-brand-500 bg-brand-50 text-brand-700' : 'border-slate-200 text-slate-500 hover:border-brand-300' }}">
                                    <input type="radio" name="jenis_kelamin" value="Perempuan" class="hidden"
                                        {{ old('jenis_kelamin', $user->jenis_kelamin) === 'Perempuan' ? 'checked' : '' }}>
                                    👩 Perempuan
                                </label>
                            </div>
                        </div>

                        {{-- Ukuran Jersey --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Ukuran Jersey</label>
                            <div class="flex gap-2">
                                @foreach(['S','M','L','XL','XXL'] as $size)
                                    <label class="flex-1 border-2 rounded-xl py-2.5 text-center text-sm cursor-pointer font-bold transition-all
                                        {{ old('ukuran_jersey', $user->ukuran_jersey) === $size ? 'border-brand-500 bg-brand-50 text-brand-700' : 'border-slate-200 text-slate-500 hover:border-brand-300' }}">
                                        <input type="radio" name="ukuran_jersey" value="{{ $size }}" class="hidden"
                                            {{ old('ukuran_jersey', $user->ukuran_jersey) === $size ? 'checked' : '' }}>
                                        {{ $size }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="pt-2">
                            <button type="submit"
                                class="w-full bg-brand-600 hover:bg-brand-500 text-white rounded-xl py-3 font-bold text-sm shadow-lg shadow-brand-500/20 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Password Card --}}
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700 overflow-hidden">
                    <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-700 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <div>
                            <h2 class="font-bold text-slate-800 dark:text-slate-100">Ubah Password</h2>
                            <p class="text-xs text-slate-400 dark:text-slate-400">Pastikan gunakan password yang kuat dan unik</p>
                        </div>
                    </div>
                    <form method="post" action="{{ route('password.update') }}" class="p-8 space-y-5">
                        @csrf
                        @method('put')

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Password Saat Ini</label>
                            <input type="password" name="current_password" autocomplete="current-password"
                                class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all">
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2"/>
                        </div>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Password Baru</label>
                                <input type="password" name="password" autocomplete="new-password"
                                    class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all">
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2"/>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" autocomplete="new-password"
                                    class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all">
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2"/>
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full bg-amber-500 hover:bg-amber-400 text-white rounded-xl py-3 font-bold text-sm shadow-lg shadow-amber-500/20 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Perbarui Password
                        </button>
                    </form>
                </div>
            </div>

            {{-- ===== RIGHT SIDEBAR ===== --}}
            <div class="space-y-6">

                {{-- Stats Card --}}
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700 p-6">
                    <h3 class="font-bold text-slate-800 dark:text-slate-100 mb-4 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        Statistik Lari
                    </h3>
                    @php $totalReg = $user->registrations()->count(); @endphp
                    <div class="space-y-3">
                        <div class="flex items-center justify-between bg-brand-50 dark:bg-brand-900/30 rounded-xl p-3">
                            <div class="flex items-center gap-2 text-sm text-brand-800 dark:text-brand-300 font-medium">
                                <span class="text-lg">🏅</span> Total Event Diikuti
                            </div>
                            <span class="font-extrabold text-brand-600 dark:text-brand-400 text-lg">{{ $totalReg }}</span>
                        </div>
                        <div class="flex items-center justify-between bg-slate-50 dark:bg-slate-700/50 rounded-xl p-3">
                            <div class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300 font-medium">
                                <span class="text-lg">📅</span> Member Sejak
                            </div>
                            <span class="font-semibold text-slate-600 dark:text-slate-400 text-sm">{{ $user->created_at->format('M Y') }}</span>
                        </div>
                        <a href="{{ route('registrations.index') }}" class="flex items-center justify-center gap-2 w-full bg-brand-600 hover:bg-brand-500 text-white rounded-xl py-2.5 font-semibold text-sm transition-all hover:-translate-y-0.5 mt-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Pendaftaran Saya
                        </a>
                    </div>
                </div>

                {{-- Kelengkapan Profil --}}
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700 p-6">
                    <h3 class="font-bold text-slate-800 dark:text-slate-100 mb-4 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Kelengkapan Profil
                    </h3>
                    @php
                        $fields = ['avatar' => $user->avatar, 'NIK' => $user->nik, 'No HP' => $user->no_hp, 'Kelamin' => $user->jenis_kelamin, 'Jersey' => $user->ukuran_jersey];
                        $filled = collect($fields)->filter()->count();
                        $total = count($fields) + 2; // +name +email always filled
                        $percent = round((($filled + 2) / $total) * 100);
                    @endphp
                    <div class="mb-3 flex items-center justify-between">
                        <span class="text-xs text-slate-500 font-medium">{{ $percent }}% lengkap</span>
                        <span class="text-xs font-bold {{ $percent >= 80 ? 'text-emerald-500' : 'text-amber-500' }}">{{ $percent >= 100 ? '✅ Sempurna!' : ($percent >= 80 ? '👍 Hampir selesai' : '⚠️ Segera lengkapi') }}</span>
                    </div>
                    <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-2.5 overflow-hidden mb-4">
                        <div class="h-full rounded-full transition-all duration-700 {{ $percent >= 80 ? 'bg-gradient-to-r from-emerald-400 to-teal-500' : 'bg-gradient-to-r from-amber-400 to-orange-500' }}" style="width: {{ $percent }}%"></div>
                    </div>
                    <div class="space-y-2">
                        @foreach(['Nama' => $user->name, 'Email' => $user->email, 'Foto Profil' => $user->avatar, 'NIK' => $user->nik, 'No HP' => $user->no_hp, 'Jenis Kelamin' => $user->jenis_kelamin, 'Ukuran Jersey' => $user->ukuran_jersey] as $label => $val)
                            <div class="flex items-center gap-2 text-xs {{ $val ? 'text-slate-500' : 'text-slate-400' }}">
                                @if($val)
                                    <svg class="w-3.5 h-3.5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                @else
                                    <svg class="w-3.5 h-3.5 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @endif
                                {{ $label }}
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Danger Zone --}}
                <div class="bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-900/50 rounded-3xl p-6">
                    <h3 class="font-bold text-rose-700 dark:text-rose-400 mb-2 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        Zona Berbahaya
                    </h3>
                    <p class="text-xs text-rose-600 mb-4 leading-relaxed">Menghapus akun tidak bisa dibatalkan. Semua data akan hilang selamanya.</p>
                    <button type="button"
                        x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                        class="w-full bg-rose-600 hover:bg-rose-500 text-white rounded-xl py-2.5 font-bold text-sm transition-all hover:-translate-y-0.5 shadow-lg shadow-rose-500/20 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus Akun Saya
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Delete Account Modal --}}
<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
        @csrf
        @method('delete')
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 rounded-2xl bg-rose-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <h2 class="text-lg font-extrabold text-slate-800">Hapus Akun?</h2>
                <p class="text-sm text-slate-500">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
        </div>
        <p class="text-sm text-slate-600 mb-6 leading-relaxed">Setelah akun dihapus, semua data dan riwayat pendaftaran Anda akan hilang selamanya. Masukkan password untuk konfirmasi.</p>
        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
            <input type="password" name="password" placeholder="Masukkan password Anda"
                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-rose-400 focus:border-transparent transition-all">
            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2"/>
        </div>
        <div class="flex gap-3">
            <x-secondary-button x-on:click="$dispatch('close')" class="flex-1 justify-center">
                Batal
            </x-secondary-button>
            <button type="submit" class="flex-1 bg-rose-600 hover:bg-rose-500 text-white rounded-xl py-2.5 font-bold text-sm transition-all flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Ya, Hapus Akun
            </button>
        </div>
    </form>
</x-modal>

<script>
(function () {
    const avatarInput    = document.getElementById('avatar-input');
    const avatarPreview  = document.getElementById('avatar-preview');
    const avatarInitials = document.getElementById('avatar-initials');

    if (!avatarInput || !avatarPreview) return;

    avatarInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            avatarPreview.src = e.target.result;
            avatarPreview.classList.remove('hidden');
            avatarPreview.style.position = 'absolute';
            avatarPreview.style.inset    = '0';
            if (avatarInitials) avatarInitials.style.display = 'none';
        };
        reader.readAsDataURL(file);

        // Attach file to the main profile form
        const profileForm = document.getElementById('profile-form');
        if (profileForm) {
            // Create a DataTransfer to set file input inside the form
            const dt = new DataTransfer();
            dt.items.add(file);
            const hiddenInput = profileForm.querySelector('input[name="avatar"]');
            if (hiddenInput) hiddenInput.files = dt.files;
        }
    });

    // Radio toggle highlight — Gender & Jersey
    document.querySelectorAll('input[type="radio"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            const siblings = document.querySelectorAll('input[name="' + this.name + '"]');
            siblings.forEach(function (sib) {
                const label = sib.closest('label');
                if (!label) return;
                label.classList.remove('border-brand-500', 'bg-brand-50', 'text-brand-700');
                label.classList.add('border-slate-200', 'text-slate-500');
            });
            const myLabel = this.closest('label');
            if (myLabel) {
                myLabel.classList.add('border-brand-500', 'bg-brand-50', 'text-brand-700');
                myLabel.classList.remove('border-slate-200', 'text-slate-500');
            }
        });
    });

    // Auto-dismiss flash messages
    ['flash-success', 'flash-pw'].forEach(function (id) {
        const el = document.getElementById(id);
        if (el) setTimeout(function () {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity = '0';
            setTimeout(function () { el.remove(); }, 500);
        }, 3000);
    });
})();
</script>
</x-app-layout>
