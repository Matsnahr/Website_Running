<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mau Run - Premium Running Events')</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Outfit', 'sans-serif'] },
                    colors: {
                        brand: {
                            50:   '#f0fdfa',
                            100:  '#ccfbf1',
                            200:  '#99f6e4',
                            400:  '#2dd4bf',
                            500:  '#14b8a6',
                            600:  '#0d9488',
                            700:  '#0f766e',
                            900:  '#134e4a',
                            dark: '#0f172a',
                        }
                    }
                }
            }
        }

        // Apply dark mode BEFORE page renders to avoid flash
        ;(function () {
            const saved = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (saved === 'dark' || (!saved && prefersDark)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    <style>
        body { font-family: 'Outfit', sans-serif; transition: background-color 0.3s, color 0.3s; }

        /* ─── Light navbar ─── */
        .glass-nav {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(0,0,0,0.06);
        }

        /* ─── Dark navbar ─── */
        .dark .glass-nav {
            background: rgba(15,23,42,0.92);
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        /* ─── Dark mode theme toggle animation ─── */
        #theme-toggle svg { transition: transform 0.4s cubic-bezier(.68,-.55,.27,1.55), opacity 0.3s; }

        /* ─── Smooth page transitions ─── */
        * { transition-property: background-color, border-color, color; transition-duration: 200ms; }
        img, svg { transition: none !important; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 antialiased selection:bg-brand-500 selection:text-white">

    {{-- ════════════════════════════════════ --}}
    {{-- NAVBAR                               --}}
    {{-- ════════════════════════════════════ --}}
    <nav class="fixed w-full z-50 glass-nav shadow-sm" id="main-navbar">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            {{-- Left: Logo + Nav --}}
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group shrink-0">
                    <img src="{{ asset('logo.png') }}" alt="Mau Run Logo" class="h-10 transform group-hover:scale-105 transition-transform duration-300">
                </a>
                <div class="hidden md:flex gap-7 text-sm font-medium text-slate-600 dark:text-slate-300">
                    <a href="{{ route('home') }}"
                       class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors {{ request()->routeIs('home') ? 'text-brand-600 dark:text-brand-400 font-semibold' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('events.index') }}"
                       class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors {{ request()->routeIs('events.*') ? 'text-brand-600 dark:text-brand-400 font-semibold' : '' }}">
                        Acara
                    </a>
                    @auth
                        <a href="{{ route('registrations.index') }}"
                           class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors {{ request()->routeIs('registrations.*') ? 'text-brand-600 dark:text-brand-400 font-semibold' : '' }}">
                            Pendaftaran Saya
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Right: Auth + Dark Mode Toggle --}}
            <div class="hidden md:flex items-center gap-3">
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                           class="text-sm font-medium text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 transition-colors flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Admin
                        </a>
                        <div class="h-4 w-px bg-slate-200 dark:bg-slate-700"></div>
                    @endif
                    <a href="{{ route('profile.edit') }}"
                       class="text-sm font-medium text-slate-700 dark:text-slate-200 hover:text-brand-600 dark:hover:text-brand-400 transition-colors flex items-center gap-2">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full object-cover ring-2 ring-brand-200 dark:ring-brand-700">
                        @else
                            <span class="w-8 h-8 rounded-full bg-brand-100 dark:bg-brand-900 text-brand-700 dark:text-brand-300 flex items-center justify-center font-bold text-xs uppercase">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </span>
                        @endif
                        {{ Auth::user()->name }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-slate-400 dark:text-slate-500 hover:text-red-500 dark:hover:text-red-400 transition-colors">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-brand-600 dark:hover:text-brand-400 transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="bg-brand-600 hover:bg-brand-500 text-white px-5 py-2.5 rounded-full text-sm font-semibold shadow-md shadow-brand-500/30 transition-all hover:-translate-y-0.5">
                        Daftar Sekarang
                    </a>
                @endauth

                {{-- ── Dark Mode Toggle Button ── --}}
                <button id="theme-toggle" aria-label="Toggle dark mode"
                    class="relative w-10 h-10 rounded-xl flex items-center justify-center
                           bg-slate-100 dark:bg-slate-800
                           hover:bg-slate-200 dark:hover:bg-slate-700
                           text-slate-600 dark:text-slate-300
                           transition-colors border border-slate-200 dark:border-slate-700">
                    {{-- Sun icon (shown in dark mode) --}}
                    <svg id="icon-sun" class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M18.364 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                    {{-- Moon icon (shown in light mode) --}}
                    <svg id="icon-moon" class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>
            </div>

            {{-- Hamburger Mobile + toggle --}}
            <div class="md:hidden flex items-center gap-2">
                {{-- Mobile dark mode toggle --}}
                <button id="theme-toggle-mobile" aria-label="Toggle dark mode"
                    class="w-9 h-9 rounded-lg flex items-center justify-center
                           bg-slate-100 dark:bg-slate-800
                           text-slate-600 dark:text-slate-300 transition-colors">
                    <svg class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M18.364 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                    <svg class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>
                <button id="mobile-menu-btn" class="flex items-center justify-center w-9 h-9 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" aria-label="Buka menu">
                    <svg id="icon-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="icon-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden md:hidden border-t border-slate-100 dark:border-slate-800 bg-white/95 dark:bg-slate-900/95 backdrop-blur">
            <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col gap-1">
                <a href="{{ route('home') }}"
                   class="px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-brand-50 dark:hover:bg-brand-900/30 hover:text-brand-600 dark:hover:text-brand-400 transition-colors {{ request()->routeIs('home') ? 'bg-brand-50 dark:bg-brand-900/30 text-brand-600 dark:text-brand-400' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('events.index') }}"
                   class="px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-brand-50 dark:hover:bg-brand-900/30 hover:text-brand-600 dark:hover:text-brand-400 transition-colors {{ request()->routeIs('events.*') ? 'bg-brand-50 dark:bg-brand-900/30 text-brand-600 dark:text-brand-400' : '' }}">
                    Acara
                </a>
                @auth
                    <a href="{{ route('registrations.index') }}"
                       class="px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-brand-50 dark:hover:bg-brand-900/30 hover:text-brand-600 dark:hover:text-brand-400 transition-colors {{ request()->routeIs('registrations.*') ? 'bg-brand-50 dark:bg-brand-900/30 text-brand-600 dark:text-brand-400' : '' }}">
                        Pendaftaran Saya
                    </a>
                    <a href="{{ route('profile.edit') }}"
                       class="px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-brand-50 dark:hover:bg-brand-900/30 hover:text-brand-600 dark:hover:text-brand-400 transition-colors">
                        Profil Saya
                    </a>
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                           class="px-3 py-2.5 rounded-lg text-sm font-medium text-amber-600 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-colors">
                            Admin Dashboard
                        </a>
                    @endif
                    <div class="border-t border-slate-100 dark:border-slate-800 mt-2 pt-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-3 py-2.5 rounded-lg text-sm font-medium text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                Keluar
                            </button>
                        </form>
                    </div>
                @else
                    <div class="border-t border-slate-100 dark:border-slate-800 mt-2 pt-3 flex flex-col gap-2">
                        <a href="{{ route('login') }}"
                           class="px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors text-center">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                           class="bg-brand-600 hover:bg-brand-500 text-white px-5 py-2.5 rounded-full text-sm font-semibold text-center transition-colors">
                            Daftar Sekarang
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ════════════════════════════════════ --}}
    {{-- MAIN CONTENT                         --}}
    {{-- ════════════════════════════════════ --}}
    <main class="pt-20 min-h-screen">
        @yield('content')
        @isset($slot)
            {{ $slot }}
        @endisset
    </main>

    {{-- ════════════════════════════════════ --}}
    {{-- FOOTER                               --}}
    {{-- ════════════════════════════════════ --}}
    <footer class="bg-slate-900 dark:bg-slate-950 text-slate-400 py-16 mt-20 border-t border-slate-800 dark:border-slate-800/60 relative overflow-hidden">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-brand-500/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-teal-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 relative z-10">
            <!-- Col 1: Brand -->
            <div class="flex flex-col gap-5">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('logo.png') }}" alt="Mau Run Logo" class="h-10 brightness-0 invert opacity-90 transition-transform duration-300 hover:scale-105">
                </div>
                <p class="text-sm leading-relaxed text-slate-400">
                    Mau Run adalah platform manajemen acara lari premium di Indonesia yang berdedikasi menciptakan pengalaman berlari yang aman, kompetitif, dan tak terlupakan bagi semua pelari.
                </p>
                <div class="flex items-center gap-3 mt-2">
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800/80 hover:bg-brand-500 text-slate-300 hover:text-white flex items-center justify-center transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg hover:shadow-brand-500/20" aria-label="Facebook">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.56-.93 8-4.96 8-9.75z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800/80 hover:bg-brand-500 text-slate-300 hover:text-white flex items-center justify-center transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg hover:shadow-brand-500/20" aria-label="Instagram">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800/80 hover:bg-brand-500 text-slate-300 hover:text-white flex items-center justify-center transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg hover:shadow-brand-500/20" aria-label="Twitter/X">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800/80 hover:bg-brand-500 text-slate-300 hover:text-white flex items-center justify-center transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg hover:shadow-brand-500/20" aria-label="Youtube">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.163a3.003 3.003 0 00-2.11-2.11C19.53 3.545 12 3.545 12 3.545s-7.53 0-9.388.508a3.003 3.003 0 00-2.11 2.11C0 8.017 0 12 0 12s0 3.983.502 5.837a3.003 3.003 0 002.11 2.11c1.858.507 9.388.507 9.388.507s7.53 0 9.388-.507a3.003 3.003 0 002.11-2.11C24 15.983 24 12 24 12s0-3.983-.502-5.837zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                </div>
            </div>

            <!-- Col 2: Quick Links -->
            <div>
                <h3 class="text-white font-semibold text-base mb-6 relative pb-2">
                    Tautan Cepat
                    <span class="absolute bottom-0 left-0 w-8 h-0.5 bg-brand-500 rounded-full"></span>
                </h3>
                <ul class="text-sm space-y-3">
                    <li><a href="{{ route('home') }}" class="text-slate-400 hover:text-white hover:translate-x-1.5 transition-transform duration-300 inline-flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-brand-500"></span>Beranda</a></li>
                    <li><a href="{{ route('events.index') }}" class="text-slate-400 hover:text-white hover:translate-x-1.5 transition-transform duration-300 inline-flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-brand-500"></span>Semua Acara</a></li>
                    @auth
                        <li><a href="{{ route('registrations.index') }}" class="text-slate-400 hover:text-white hover:translate-x-1.5 transition-transform duration-300 inline-flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-brand-500"></span>Pendaftaran Saya</a></li>
                        <li><a href="{{ route('profile.edit') }}" class="text-slate-400 hover:text-white hover:translate-x-1.5 transition-transform duration-300 inline-flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-brand-500"></span>Profil Pengguna</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="text-slate-400 hover:text-white hover:translate-x-1.5 transition-transform duration-300 inline-flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-brand-500"></span>Masuk Akun</a></li>
                        <li><a href="{{ route('register') }}" class="text-slate-400 hover:text-white hover:translate-x-1.5 transition-transform duration-300 inline-flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-brand-500"></span>Daftar Baru</a></li>
                    @endauth
                </ul>
            </div>

            <!-- Col 3: Support -->
            <div>
                <h3 class="text-white font-semibold text-base mb-6 relative pb-2">
                    Dukungan & Info
                    <span class="absolute bottom-0 left-0 w-8 h-0.5 bg-brand-500 rounded-full"></span>
                </h3>
                <ul class="text-sm space-y-3">
                    <li><a href="#" class="text-slate-400 hover:text-white hover:translate-x-1.5 transition-transform duration-300 inline-flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-brand-500"></span>Pusat Bantuan & FAQ</a></li>
                    <li><a href="#" class="text-slate-400 hover:text-white hover:translate-x-1.5 transition-transform duration-300 inline-flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-brand-500"></span>Syarat & Ketentuan</a></li>
                    <li><a href="#" class="text-slate-400 hover:text-white hover:translate-x-1.5 transition-transform duration-300 inline-flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-brand-500"></span>Kebijakan Privasi</a></li>
                    <li><a href="#" class="text-slate-400 hover:text-white hover:translate-x-1.5 transition-transform duration-300 inline-flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-brand-500"></span>Hubungi Kemitraan</a></li>
                </ul>
            </div>

            <!-- Col 4: Newsletter -->
            <div class="flex flex-col gap-4">
                <h3 class="text-white font-semibold text-base mb-2 relative pb-2">
                    Newsletter
                    <span class="absolute bottom-0 left-0 w-8 h-0.5 bg-brand-500 rounded-full"></span>
                </h3>
                <p class="text-sm text-slate-400 leading-relaxed">
                    Dapatkan pembaruan langsung tentang pembukaan pendaftaran & info event terbaru.
                </p>
                <form action="#" class="flex flex-col gap-2 mt-1">
                    <input type="email" placeholder="Email Anda" class="w-full px-4 py-2.5 bg-slate-800 border border-slate-700 rounded-xl text-white text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder:text-slate-500" required>
                    <button type="submit" class="w-full px-5 py-2.5 bg-gradient-to-r from-brand-500 to-teal-600 hover:from-brand-400 hover:to-teal-500 text-white rounded-xl text-sm font-semibold transition-all duration-300 transform active:scale-95 shadow-md shadow-brand-500/10">
                        Langganan
                    </button>
                </form>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="max-w-7xl mx-auto px-6 mt-16 pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-6 relative z-10 text-xs text-slate-500">
            <div>
                <span>© {{ date('Y') }} <strong>Mau Run</strong>. Seluruh Hak Cipta Dilindungi.</span>
            </div>
            <div class="flex items-center gap-6">
                <a href="#" class="hover:text-slate-300 transition-colors">Syarat Penggunaan</a>
                <a href="#" class="hover:text-slate-300 transition-colors">Kebijakan Cookies</a>
                <a href="#" class="hover:text-slate-300 transition-colors">Hubungi Kami</a>
            </div>
        </div>
    </footer>

    <script>
        // ── Dark Mode Toggle ──────────────────────────────────────────
        function applyTheme(isDark) {
            if (isDark) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        }

        ['theme-toggle', 'theme-toggle-mobile'].forEach(function (id) {
            const btn = document.getElementById(id);
            if (!btn) return;
            btn.addEventListener('click', function () {
                const isDark = document.documentElement.classList.contains('dark');
                applyTheme(!isDark);
            });
        });

        // ── Mobile Menu ───────────────────────────────────────────────
        const mobileBtn   = document.getElementById('mobile-menu-btn');
        const mobileMenu  = document.getElementById('mobile-menu');
        const iconOpen    = document.getElementById('icon-open');
        const iconClose   = document.getElementById('icon-close');

        mobileBtn.addEventListener('click', function () {
            const isHidden = mobileMenu.classList.toggle('hidden');
            iconOpen.classList.toggle('hidden', !isHidden);
            iconClose.classList.toggle('hidden', isHidden);
        });
    </script>

</body>
</html>