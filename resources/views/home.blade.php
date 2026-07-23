@extends('layouts.app')

@section('title', 'Mau Run - Ekosistem Acara Lari Premium')

@section('content')
<section class="relative h-[600px] flex items-center justify-center overflow-hidden">
    <!-- Hero Image & Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1552674605-db6ffd4facb5?w=1600&q=80" class="w-full h-full object-cover" alt="Runners">
        <div class="absolute inset-0 bg-gradient-to-r from-brand-dark/90 via-brand-dark/70 to-transparent"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 flex flex-col items-start">
        <div class="bg-brand-500/10 border border-brand-400/20 backdrop-blur-md text-brand-100 text-xs font-semibold px-4 py-1.5 rounded-full mb-6 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-brand-400 animate-pulse"></span>
            Musim Balapan 2026 Telah Dibuka
        </div>
        <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight max-w-3xl">
            Berlari Melampaui <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-300 to-brand-500">Batas Maksimalmu</span>
        </h1>
        <p class="text-slate-300 text-lg mb-10 max-w-2xl leading-relaxed">
            Bergabunglah dengan rangkaian acara lari paling eksklusif di Indonesia. Pantau progres Anda, bersaing secara sehat, dan rayakan pencapaian bersama ribuan pelari lainnya.
        </p>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('events.index') }}" class="bg-brand-500 hover:bg-brand-400 text-white px-8 py-3.5 rounded-full font-medium transition-all shadow-lg shadow-brand-500/30 hover:-translate-y-1 flex items-center gap-2">
                Jelajahi Acara
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
            <a href="{{ route('register') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 text-white px-8 py-3.5 rounded-full font-medium transition-all flex items-center gap-2">
                Daftar Gratis
            </a>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="relative z-20 -mt-16 max-w-7xl mx-auto px-6 mb-24">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700 flex flex-col items-center justify-center text-center transform transition-transform hover:-translate-y-1">
            <div class="w-12 h-12 rounded-xl bg-brand-50 flex items-center justify-center text-brand-500 mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <p class="text-3xl font-bold text-slate-800 dark:text-slate-100 mb-1">{{ $totalAcara }}</p>
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Acara</p>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700 flex flex-col items-center justify-center text-center transform transition-transform hover:-translate-y-1">
            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500 mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <p class="text-3xl font-bold text-slate-800 dark:text-slate-100 mb-1">{{ $totalMember }}</p>
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Member Terdaftar</p>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700 flex flex-col items-center justify-center text-center transform transition-transform hover:-translate-y-1">
            <div class="w-12 h-12 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500 mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <p class="text-3xl font-bold text-slate-800 dark:text-slate-100 mb-1">{{ $totalKota }}</p>
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Kota Tuan Rumah</p>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700 flex flex-col items-center justify-center text-center transform transition-transform hover:-translate-y-1">
            <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <p class="text-3xl font-bold text-slate-800 dark:text-slate-100 mb-1">{{ $acaraMendatang }}</p>
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Acara Mendatang</p>
        </div>
    </div>
</section>
@endsection