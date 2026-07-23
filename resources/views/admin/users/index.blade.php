@extends('layouts.admin')

@section('title', 'Manajemen Pengguna | Mau Run - Ekosistem Acara Lari Premium')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-800 dark:text-slate-100 mb-2 flex items-center gap-2">
            <span class="w-1.5 h-8 bg-brand-500 rounded-full"></span>
            Manajemen Pengguna
        </h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm ml-3">Daftar pengguna terdaftar di platform baik dengan peran panitia/admin maupun peserta lari.</p>
    </div>
</div>

@if(session('success'))
    <div class="bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-4 py-4 rounded-xl mb-6 flex items-start gap-3 shadow-sm">
        <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <p class="text-sm font-medium">{{ session('success') }}</p>
    </div>
@endif

@if(session('error'))
    <div class="bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-300 px-4 py-4 rounded-xl mb-6 flex items-start gap-3 shadow-sm">
        <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        <p class="text-sm font-medium">{{ session('error') }}</p>
    </div>
@endif

{{-- Filter Card --}}
<div class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-800 mb-8">
    <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
        {{-- Search input --}}
        <div>
            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Cari Nama / Email</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau alamat email..."
                   class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
        </div>

        {{-- Filter Role --}}
        <div>
            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Peran (Role)</label>
            <select name="role" class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand-500">
                <option value="">Semua Peran</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                <option value="peserta" {{ request('role') == 'peserta' ? 'selected' : '' }}>Peserta</option>
            </select>
        </div>

        {{-- Submit and Reset buttons --}}
        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-brand-600 hover:bg-brand-500 text-white font-semibold py-2.5 rounded-xl text-sm transition-all shadow-md shadow-brand-500/20">
                Cari Pengguna
            </button>
            @if(request()->hasAny(['search', 'role']))
                <a href="{{ route('admin.users.index') }}" class="bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-semibold py-2.5 px-4 rounded-xl text-sm transition-colors">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

{{-- User Table --}}
<div class="bg-white dark:bg-slate-900 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-slate-400 dark:text-slate-400 uppercase bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                <tr>
                    <th scope="col" class="px-6 py-4 font-semibold">Nama Lengkap</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Alamat Email</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-center">Peran</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Tanggal Daftar</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($users as $user)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-brand-50 dark:bg-brand-950/60 text-brand-600 dark:text-brand-400 flex items-center justify-center font-bold text-sm">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                {{ $user->name }}
                                @if($user->id === auth()->id())
                                    <span class="text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 px-1.5 py-0.5 rounded">SAYA</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300 font-medium">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($user->role === 'admin')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 border-purple-200 dark:border-purple-800">
                                    Admin
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border bg-brand-50 dark:bg-brand-950/60 text-brand-700 dark:text-brand-300 border-brand-200 dark:border-brand-800">
                                    Peserta
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-500 dark:text-slate-400 text-xs">
                            {{ $user->created_at ? $user->created_at->translatedFormat('d M Y H:i') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $user->name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 dark:text-slate-500 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-slate-800 transition-colors" title="Hapus Pengguna">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-slate-300 dark:text-slate-600 italic">Akun Utama</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                            Tidak ada pengguna ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $users->links() }}
</div>
@endsection
