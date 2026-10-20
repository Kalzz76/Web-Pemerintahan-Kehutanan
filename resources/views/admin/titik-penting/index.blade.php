@extends('layouts.admin')

@section('title', 'Titik Penting')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
    <div>
        <h1 class="text-lg md:text-xl font-bold text-stone-900 tracking-tight">Titik Penting</h1>
        <p class="text-stone-500 text-xs mt-0.5">Daftar pos jaga, pos pemadam, sumber air, jalur evakuasi, dan permukiman warga.</p>
    </div>
    <a href="{{ route('admin.titik-penting.create') }}" class="inline-flex items-center px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl text-xs sm:text-sm shadow-sm transition active:scale-95 shrink-0">
        <i class="fa-solid fa-plus mr-1.5 text-xs"></i>
        <span>Tambah Titik Penting</span>
    </a>
</div>

<livewire:admin.titik-penting-table />
@endsection
