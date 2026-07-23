@extends('layouts.admin')

@section('title', 'Edit Acara | Mau Run')

@section('content')
<h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100 mb-6">Edit Acara</h1>

<form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data" class="bg-white dark:bg-slate-900 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-800 p-8 max-w-2xl">
    @csrf
    @method('PUT')
    @include('admin.events._form', ['event' => $event])
    <button type="submit" class="bg-brand-600 hover:bg-brand-500 text-white px-6 py-3 rounded-xl text-sm font-semibold shadow-md shadow-brand-500/20 transition-all hover:-translate-y-0.5 mt-6 w-full flex items-center justify-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        Perbarui Data Acara
    </button>
</form>
@endsection