@extends('layouts.admin')

@section('title', 'Kawasan Hutan')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
    <div>
        <h1 class="text-lg md:text-xl font-bold text-stone-900 tracking-tight">Kawasan Hutan</h1>
        <p class="text-stone-500 text-xs mt-0.5">Daftar kawasan konservasi hutan Jawa Barat, batas wilayah poligon, dan pengelola.</p>
    </div>
    <a href="{{ route('admin.kawasan.create') }}" class="inline-flex items-center px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl text-xs sm:text-sm shadow-sm transition active:scale-95 shrink-0">
        <i class="fa-solid fa-plus mr-1.5 text-xs"></i>
        <span>Tambah Kawasan</span>
    </a>
</div>

<livewire:admin.kawasan-table />
@endsection
