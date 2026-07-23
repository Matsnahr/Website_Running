@extends('layouts.admin')

@section('title', 'Profil Administrator | Mau Run')

@section('content')
<div class="space-y-6">

    {{-- Page Title --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100">Profil Administrator</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Kelola informasi pribadi, kontak, dan keamanan akun administrator Anda</p>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('status') === 'profile-updated')
        <div class="bg-emerald-50 dark:bg-emerald-950/70 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 px-5 py-4 rounded-2xl shadow-sm flex items-center gap-3 text-sm font-medium">
            <svg class="w-5 h-5 flex-shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Profil administrator berhasil diperbarui!
        </div>
    @endif
    @if(session('status') === 'password-updated')
        <div class="bg-emerald-50 dark:bg-emerald-950/70 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 px-5 py-4 rounded-2xl shadow-sm flex items-center gap-3 text-sm font-medium">
            <svg class="w-5 h-5 flex-shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Password administrator berhasil diperbarui!
        </div>
    @endif

    {{-- Hero Profile Banner --}}
    <div class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-brand-900 rounded-3xl p-8 overflow-hidden shadow-xl text-white">
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-brand-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative flex flex-col md:flex-row items-center md:items-start gap-6">
            {{-- Avatar Wrapper --}}
            <div class="relative group flex-shrink-0">
                <div id="avatar-container" class="w-24 h-24 rounded-full ring-4 ring-white/20 shadow-xl overflow-hidden bg-brand-600 flex items-center justify-center text-white font-extrabold text-3xl relative">
                    @if($user->avatar)
                        <img id="avatar-preview" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    @else
                        <span id="avatar-initials">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        <img id="avatar-preview" src="" alt="" class="w-full h-full object-cover hidden absolute inset-0">
                    @endif
                </div>
                {{-- Overlay for file selection --}}
                <label for="avatar-input" class="absolute inset-0 rounded-full bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </label>
                <span class="absolute bottom-0 right-0 bg-brand-500 text-white text-xs font-bold w-7 h-7 rounded-full flex items-center justify-center border-2 border-slate-900 shadow pointer-events-none">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </span>
            </div>

            {{-- User Details --}}
            <div class="text-center md:text-left flex-1">
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 mb-2">
                    <span class="bg-brand-500/20 text-brand-300 border border-brand-500/30 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                        Administrator System
                    </span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-white">{{ $user->name }}</h2>
                <p class="text-slate-300 text-sm mt-1 flex items-center justify-center md:justify-start gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    {{ $user->email }}
                </p>
                <div class="flex flex-wrap justify-center md:justify-start gap-2 mt-4 text-xs font-medium text-slate-300">
                    @if($user->no_hp)
                        <span class="bg-white/10 px-3 py-1 rounded-xl">📱 {{ $user->no_hp }}</span>
                    @endif
                    @if($user->nik)
                        <span class="bg-white/10 px-3 py-1 rounded-xl">🪪 NIK: {{ $user->nik }}</span>
                    @endif
                    @if($user->jenis_kelamin)
                        <span class="bg-white/10 px-3 py-1 rounded-xl">{{ $user->jenis_kelamin === 'Laki-laki' ? '👨' : '👩' }} {{ $user->jenis_kelamin }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Main Form Grid --}}
    <div class="grid lg:grid-cols-3 gap-6">

        {{-- Left 2 Columns: Forms --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Profile Information Card --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-brand-50 dark:bg-slate-800 text-brand-600 dark:text-brand-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <h2 class="font-bold text-slate-800 dark:text-slate-100">Informasi Profil Administrator</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Perbarui identitas, email, dan nomor kontak administrator</p>
                    </div>
                </div>

                <form method="post" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="p-6 space-y-5" id="admin-profile-form">
                    @csrf
                    @method('patch')

                    {{-- Hidden Avatar Input --}}
                    <input type="file" id="avatar-input" name="avatar" accept="image/*" class="hidden">

                    {{-- Avatar change hint --}}
                    <div class="bg-teal-50 dark:bg-slate-800 border border-teal-200 dark:border-slate-700 rounded-2xl px-4 py-3 flex items-center gap-3 text-sm text-teal-800 dark:text-teal-300 font-medium">
                        <svg class="w-5 h-5 flex-shrink-0 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Arahkan atau klik foto profil di banner atas untuk memperbarui foto avatar Anda.
                    </div>

                    @if($errors->any())
                        <div class="bg-rose-50 dark:bg-rose-950/70 border border-rose-200 dark:border-rose-800 rounded-2xl px-4 py-3 text-sm text-rose-700 dark:text-rose-300">
                            <ul class="list-disc list-inside space-y-1 font-medium">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Name + Email --}}
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">Email Administrator</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition-all">
                        </div>
                    </div>

                    {{-- NIK + No HP --}}
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">NIK <span class="text-slate-400 dark:text-slate-500 font-normal lowercase">(16 digit)</span></label>
                            <input type="text" name="nik" value="{{ old('nik', $user->nik) }}" maxlength="16" inputmode="numeric" placeholder="Masukkan 16 digit NIK"
                                class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">Nomor WhatsApp / HP</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" placeholder="Contoh: 08123456789"
                                class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition-all">
                        </div>
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Jenis Kelamin</label>
                        <div class="flex gap-3">
                            <label class="flex-1 border-2 rounded-xl py-2.5 text-center text-sm cursor-pointer font-medium transition-all
                                {{ old('jenis_kelamin', $user->jenis_kelamin) === 'Laki-laki' 
                                    ? 'border-brand-500 bg-brand-50 dark:bg-brand-900/40 text-brand-700 dark:text-brand-300 font-semibold' 
                                    : 'border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-950 hover:border-brand-300' }}">
                                <input type="radio" name="jenis_kelamin" value="Laki-laki" class="hidden"
                                    {{ old('jenis_kelamin', $user->jenis_kelamin) === 'Laki-laki' ? 'checked' : '' }}>
                                👨 Laki-laki
                            </label>
                            <label class="flex-1 border-2 rounded-xl py-2.5 text-center text-sm cursor-pointer font-medium transition-all
                                {{ old('jenis_kelamin', $user->jenis_kelamin) === 'Perempuan' 
                                    ? 'border-brand-500 bg-brand-50 dark:bg-brand-900/40 text-brand-700 dark:text-brand-300 font-semibold' 
                                    : 'border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-950 hover:border-brand-300' }}">
                                <input type="radio" name="jenis_kelamin" value="Perempuan" class="hidden"
                                    {{ old('jenis_kelamin', $user->jenis_kelamin) === 'Perempuan' ? 'checked' : '' }}>
                                👩 Perempuan
                            </label>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-2">
                        <button type="submit"
                            class="w-full bg-brand-600 hover:bg-brand-500 text-white rounded-xl py-3 font-bold text-sm shadow-md shadow-brand-500/20 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Change Password Card --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-slate-800 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <div>
                        <h2 class="font-bold text-slate-800 dark:text-slate-100">Ubah Password Administrator</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Pastikan akun administrator menggunakan kombinasi password yang kuat</p>
                    </div>
                </div>

                <form method="post" action="{{ route('password.update') }}" class="p-6 space-y-5">
                    @csrf
                    @method('put')

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">Password Saat Ini</label>
                        <input type="password" name="current_password" autocomplete="current-password"
                            class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all">
                        @if($errors->updatePassword->has('current_password'))
                            <p class="text-rose-600 dark:text-rose-400 text-xs mt-1.5 font-medium">{{ $errors->updatePassword->first('current_password') }}</p>
                        @endif
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">Password Baru</label>
                            <input type="password" name="password" autocomplete="new-password"
                                class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all">
                            @if($errors->updatePassword->has('password'))
                                <p class="text-rose-600 dark:text-rose-400 text-xs mt-1.5 font-medium">{{ $errors->updatePassword->first('password') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" autocomplete="new-password"
                                class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all">
                            @if($errors->updatePassword->has('password_confirmation'))
                                <p class="text-rose-600 dark:text-rose-400 text-xs mt-1.5 font-medium">{{ $errors->updatePassword->first('password_confirmation') }}</p>
                            @endif
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-amber-500 hover:bg-amber-400 text-white rounded-xl py-3 font-bold text-sm shadow-md shadow-amber-500/20 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Perbarui Password
                    </button>
                </form>
            </div>
        </div>

        {{-- Right Column: Admin Stats & Completeness --}}
        <div class="space-y-6">

            {{-- Admin Overview Stats --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 space-y-4">
                <h3 class="font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Statistik Administrator
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between bg-slate-50 dark:bg-slate-800/60 rounded-xl p-3">
                        <span class="text-slate-600 dark:text-slate-400 font-medium flex items-center gap-2">
                            <span>🏆</span> Total Event Dikelola
                        </span>
                        <span class="font-extrabold text-brand-600 dark:text-brand-400 text-base">{{ $totalEvents ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between bg-slate-50 dark:bg-slate-800/60 rounded-xl p-3">
                        <span class="text-slate-600 dark:text-slate-400 font-medium flex items-center gap-2">
                            <span>👥</span> Total Peserta System
                        </span>
                        <span class="font-extrabold text-blue-600 dark:text-blue-400 text-base">{{ number_format($totalParticipants ?? 0) }}</span>
                    </div>
                    <div class="flex items-center justify-between bg-slate-50 dark:bg-slate-800/60 rounded-xl p-3">
                        <span class="text-slate-600 dark:text-slate-400 font-medium">Peran System</span>
                        <span class="font-bold text-brand-600 dark:text-brand-400 bg-brand-50 dark:bg-brand-950/60 px-2.5 py-0.5 rounded-lg text-xs">Administrator</span>
                    </div>
                    <div class="flex items-center justify-between bg-slate-50 dark:bg-slate-800/60 rounded-xl p-3">
                        <span class="text-slate-600 dark:text-slate-400 font-medium">Terdaftar Sejak</span>
                        <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</span>
                    </div>
                </div>
            </div>

            {{-- Completeness Card --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 space-y-4">
                <h3 class="font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Kelengkapan Profil Admin
                </h3>
                @php
                    $adminFields = [
                        'Foto Profil' => $user->avatar,
                        'NIK Staf' => $user->nik,
                        'No WhatsApp/HP' => $user->no_hp,
                        'Jenis Kelamin' => $user->jenis_kelamin
                    ];
                    $filledCount = collect($adminFields)->filter()->count();
                    $totalAdminFields = count($adminFields) + 2; // +Nama +Email
                    $percent = round((($filledCount + 2) / $totalAdminFields) * 100);
                @endphp
                <div class="flex items-center justify-between text-xs">
                    <span class="text-slate-500 dark:text-slate-400 font-medium">{{ $percent }}% lengkap</span>
                    <span class="font-bold {{ $percent >= 80 ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400' }}">
                        {{ $percent >= 100 ? '✅ Sempurna!' : ($percent >= 80 ? '👍 Hampir Selesai' : '⚠️ Lengkapi Identitas') }}
                    </span>
                </div>
                <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2.5 overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-700 {{ $percent >= 80 ? 'bg-gradient-to-r from-emerald-400 to-teal-500' : 'bg-gradient-to-r from-amber-400 to-orange-500' }}" style="width: {{ $percent }}%"></div>
                </div>
                <div class="space-y-2 pt-1">
                    @foreach(['Nama Lengkap' => $user->name, 'Email Admin' => $user->email, 'Foto Profil' => $user->avatar, 'NIK Staf' => $user->nik, 'No WhatsApp/HP' => $user->no_hp, 'Jenis Kelamin' => $user->jenis_kelamin] as $label => $val)
                        <div class="flex items-center gap-2 text-xs {{ $val ? 'text-slate-700 dark:text-slate-300 font-medium' : 'text-slate-400 dark:text-slate-500' }}">
                            @if($val)
                                <svg class="w-3.5 h-3.5 text-emerald-500 dark:text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            @else
                                <svg class="w-3.5 h-3.5 text-slate-300 dark:text-slate-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @endif
                            {{ $label }}
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

</div>

{{-- Avatar Change & Preview Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const avatarInput = document.getElementById('avatar-input');
        const avatarPreview = document.getElementById('avatar-preview');
        const avatarInitials = document.getElementById('avatar-initials');

        if (avatarInput) {
            avatarInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        if (avatarPreview) {
                            avatarPreview.src = e.target.result;
                            avatarPreview.classList.remove('hidden');
                        }
                        if (avatarInitials) {
                            avatarInitials.classList.add('hidden');
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
@endsection
