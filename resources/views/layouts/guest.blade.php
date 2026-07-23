<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Mau Run') }}</title>
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Outfit', 'sans-serif'],
                        },
                        colors: {
                            brand: {
                                50: '#f0fdfa',
                                100: '#ccfbf1',
                                500: '#14b8a6', // teal-500
                                600: '#0d9488', // teal-600
                                950: '#042f2e',
                                dark: '#0f172a', // slate-900
                            }
                        }
                    }
                }
            }
        </script>
        <style>
            body { font-family: 'Outfit', sans-serif; }
        </style>
    </head>
    <body class="h-full font-sans text-slate-900 antialiased bg-slate-50 selection:bg-brand-500 selection:text-white">
        <div class="min-h-screen flex">
            
            {{-- Left Panel - Visual Branding (Hidden on mobile) --}}
            <div class="hidden lg:flex lg:w-1/2 relative bg-brand-dark overflow-hidden">
                <div class="absolute inset-0 z-0 opacity-60">
                    <img src="{{ asset('login_bg.png') }}" class="w-full h-full object-cover filter brightness-90 grayscale-[20%]" alt="Runner Background">
                </div>
                {{-- Decorative gradient overlay --}}
                <div class="absolute inset-0 bg-gradient-to-tr from-brand-950/90 via-brand-dark/80 to-transparent z-10"></div>
                
                {{-- Content overlay --}}
                <div class="relative z-20 flex flex-col justify-between p-16 h-full text-white">
                    <div>
                        <a href="/">
                            <img src="{{ asset('logo.png') }}" alt="Mau Run Logo" class="h-12 brightness-0 invert opacity-90">
                        </a>
                    </div>
                    
                    <div class="max-w-md">
                        <span class="inline-block bg-brand-500/20 text-brand-300 text-xs font-bold uppercase tracking-widest px-3 py-1.5 rounded-full mb-6 border border-brand-500/30">
                            🏁 EKOSISTEM ACARA LARI PREMIUM
                        </span>
                        <h2 class="text-4xl font-extrabold leading-tight mb-4 tracking-tight">
                            Tembus Batas Kemampuan Anda!
                        </h2>
                        <p class="text-slate-300 text-lg leading-relaxed font-light">
                            Temukan, daftarkan diri, dan taklukkan lintasan balap terpopuler di Indonesia. Catat waktu terbaik Anda di Mau Run.
                        </p>
                    </div>
                    
                    <div>
                        <p class="text-xs text-slate-500">
                            © {{ date('Y') }} Platform Mau Run. Hak cipta dilindungi undang-undang.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Right Panel - Auth Forms --}}
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-6 md:p-12 bg-white relative">
                {{-- Small logo visible only on mobile --}}
                <div class="lg:hidden absolute top-8 left-8">
                    <a href="/">
                        <img src="{{ asset('logo.png') }}" alt="Mau Run Logo" class="h-10">
                    </a>
                </div>
                
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>
            
        </div>
    </body>
</html>
