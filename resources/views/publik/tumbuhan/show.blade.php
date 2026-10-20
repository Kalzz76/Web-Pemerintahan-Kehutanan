@extends('layouts.publik')

@section('title', $tumbuhan->nama_lokal . ' - Profil Tumbuhan Rimba')

@section('content')
<div class="bg-stone-50 py-10 px-4 sm:px-6 lg:px-8 min-h-[calc(100vh-80px)]">
    <div class="max-w-5xl mx-auto space-y-8">
        <div>
            <a href="{{ route('tumbuhan') }}" class="inline-flex items-center text-xs font-bold text-stone-500 hover:text-stone-800 transition">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Katalog Tumbuhan
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-stone-200 shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-0">
                <div class="md:col-span-5 bg-stone-100 min-h-[300px] relative">
                    @if ($tumbuhan->foto)
                        <img src="{{ asset('storage/' . $tumbuhan->foto) }}" alt="{{ $tumbuhan->nama_lokal }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-emerald-50 to-stone-100 text-emerald-600 text-6xl p-12">
                            <i class="fa-solid fa-seedling"></i>
                        </div>
                    @endif
                </div>

                <div class="md:col-span-7 p-6 sm:p-8 space-y-6">
                    <div class="space-y-2">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-3 py-1 rounded-full text-xs font-black bg-stone-900 text-white">
                                Habitus {{ $tumbuhan->jenis }}
                            </span>

                            @if ($tumbuhan->status_konservasi == 'CR')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">Kritis (CR)</span>
                            @elseif ($tumbuhan->status_konservasi == 'EN')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-800">Terancam (EN)</span>
                            @elseif ($tumbuhan->status_konservasi == 'VU')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">Rentan (VU)</span>
                            @elseif ($tumbuhan->status_konservasi == 'NT')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-lime-100 text-lime-800">Hampir Terancam (NT)</span>
                            @elseif ($tumbuhan->status_konservasi == 'LC')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">Risiko Rendah (LC)</span>
                            @elseif ($tumbuhan->status_konservasi == 'DD')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-stone-100 text-stone-700">Data Kurang (DD)</span>
                            @elseif ($tumbuhan->status_konservasi == 'NE')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-stone-50 text-stone-500 border border-stone-200">Belum Dinilai (NE)</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-stone-100 text-stone-700">{{ $tumbuhan->status_konservasi }}</span>
                            @endif

                            @if ($tumbuhan->dilindungi)
                                <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-700 text-white flex items-center">
                                    <i class="fa-solid fa-shield mr-1.5 text-xs"></i> Dilindungi Penuh
                                </span>
                            @endif
                        </div>

                        <h1 class="text-3xl font-black text-stone-900 tracking-tight">{{ $tumbuhan->nama_lokal }}</h1>
                        <p class="text-stone-500 font-serif italic text-base">{{ $tumbuhan->nama_ilmiah }}</p>
                    </div>

                    <div class="p-4 bg-emerald-50/70 rounded-2xl border border-emerald-200/70 text-xs">
                        <div class="text-emerald-800 font-black uppercase text-[10px] mb-1">Manfaat Tradisional & Ekologis</div>
                        <div class="font-medium text-emerald-950 text-sm leading-relaxed">{{ $tumbuhan->manfaat }}</div>
                    </div>

                    <div>
                        <h2 class="text-xs font-bold text-stone-400 uppercase tracking-wider mb-2">Morfologi & Deskripsi Lengkap</h2>
                        <div class="text-stone-700 text-sm leading-relaxed whitespace-pre-line">
                            {{ $tumbuhan->deskripsi }}
                        </div>
                    </div>

                    <div class="pt-4 border-t border-stone-100">
                        <h3 class="text-xs font-bold text-stone-400 uppercase tracking-wider mb-2">Sebaran Wilayah di Desa Ini</h3>
                        @if ($tumbuhan->kawasanHutan->count() > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach ($tumbuhan->kawasanHutan as $kws)
                                    <a href="{{ route('peta') }}" class="px-3 py-1.5 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-800 text-xs font-bold transition flex items-center">
                                        <i class="fa-solid fa-mountain-sun mr-1.5 text-stone-500"></i>
                                        <span>{{ $kws->nama }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-stone-400 text-xs italic">
                                Belum ada pemetaan kawasan spesifik untuk spesies ini di dalam sistem.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if ($tumbuhanLain->count() > 0)
            <div class="pt-6">
                <h2 class="text-xl font-black text-stone-900 mb-4">Tumbuhan Rimba Lainnya</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach ($tumbuhanLain as $lain)
                        <a href="{{ route('tumbuhan.detail', $lain->id) }}" class="bg-white p-4 rounded-2xl border border-stone-200 hover:border-stone-300 transition shadow-sm flex items-center space-x-3 group">
                            <div class="w-12 h-12 rounded-xl bg-stone-100 overflow-hidden shrink-0">
                                @if ($lain->foto)
                                    <img src="{{ asset('storage/' . $lain->foto) }}" alt="{{ $lain->nama_lokal }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-emerald-600 bg-emerald-50">
                                        <i class="fa-solid fa-seedling text-sm"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <div class="text-sm font-bold text-stone-900 group-hover:text-green-700 transition truncate">
                                    {{ $lain->nama_lokal }}
                                </div>
                                <div class="text-[11px] text-stone-400 italic truncate font-serif">
                                    {{ $lain->nama_ilmiah }}
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
