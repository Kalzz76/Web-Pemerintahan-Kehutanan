@extends('layouts.publik')

@section('title', 'Katalog Tumbuhan Rimba')

@section('content')
<div class="bg-stone-50 py-10 px-4 sm:px-6 lg:px-8 min-h-[calc(100vh-80px)]">
    <div class="max-w-7xl mx-auto space-y-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 mb-2">
                    <i class="fa-solid fa-seedling mr-1.5"></i> Flora & Keanekaragaman Nabati
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-stone-900 tracking-tight">Katalog Tumbuhan Rimba</h1>
                <p class="text-stone-600 text-sm sm:text-base mt-2 max-w-2xl leading-relaxed">
                    Eksplorasi ragam jenis flora pohon, herba obat, dan liana hutan desa beserta manfaat ekologis dan status perlindungannya.
                </p>
            </div>
            <div class="text-xs text-stone-500 font-semibold bg-white px-4 py-2.5 rounded-2xl border border-stone-200 shadow-sm self-start md:self-auto">
                Total Koleksi: <span class="font-bold text-stone-900">{{ \App\Models\Tumbuhan::count() }} Spesies</span>
            </div>
        </div>

        <livewire:publik.tumbuhan-index />
    </div>
</div>
@endsection
