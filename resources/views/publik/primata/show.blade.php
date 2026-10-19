@extends('layouts.publik')

@section('title', $primata->nama_lokal . ' - Profil Primata')

@section('content')
<div class="bg-stone-50 py-10 px-4 sm:px-6 lg:px-8 min-h-[calc(100vh-80px)]">
    <div class="max-w-5xl mx-auto space-y-8">
        <div>
            <a href="{{ route('primata') }}" class="inline-flex items-center text-xs font-bold text-stone-500 hover:text-stone-800 transition">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Katalog Primata
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-stone-200 shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-0">
                <div class="md:col-span-5 bg-stone-100 min-h-[300px] relative">
                    @if ($primata->foto)
                        <img src="{{ asset('storage/' . $primata->foto) }}" alt="{{ $primata->nama_lokal }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-amber-50 to-stone-100 text-amber-500 text-6xl p-12">
                            <i class="fa-solid fa-paw"></i>
                        </div>
                    @endif
                </div>

                <div class="md:col-span-7 p-6 sm:p-8 space-y-6">
                    <div class="space-y-2">
                        <div class="flex flex-wrap items-center gap-2">
                            @if ($primata->status_konservasi == 'CR')
                                <span class="px-3 py-1 rounded-full text-xs font-black bg-rose-600 text-white">CR (Critically Endangered / Kritis)</span>
                            @elseif ($primata->status_konservasi == 'EN')
                                <span class="px-3 py-1 rounded-full text-xs font-black bg-orange-600 text-white">EN (Endangered / Genting)</span>
                            @elseif ($primata->status_konservasi == 'VU')
                                <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-500 text-white">VU (Vulnerable / Rentan)</span>
                            @elseif ($primata->status_konservasi == 'NT')
                                <span class="px-3 py-1 rounded-full text-xs font-black bg-yellow-500 text-stone-900">NT (Near Threatened / Hampir Terancam)</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-600 text-white">{{ $primata->status_konservasi }}</span>
                            @endif

                            @if ($primata->dilindungi)
                                <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-700 text-white flex items-center">
                                    <i class="fa-solid fa-shield mr-1.5 text-xs"></i> Dilindungi Penuh
                                </span>
                            @endif
                        </div>

                        <h1 class="text-3xl font-black text-stone-900 tracking-tight">{{ $primata->nama_lokal }}</h1>
                        <p class="text-stone-500 font-serif italic text-base">{{ $primata->nama_ilmiah }}</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div class="p-3.5 bg-stone-50 rounded-2xl border border-stone-100">
                            <div class="text-stone-400 font-bold uppercase text-[10px] mb-1">Habitat Utama</div>
                            <div class="font-semibold text-stone-800">{{ $primata->habitat }}</div>
                        </div>
                        <div class="p-3.5 bg-stone-50 rounded-2xl border border-stone-100">
                            <div class="text-stone-400 font-bold uppercase text-[10px] mb-1">Makanan Pokok</div>
                            <div class="font-semibold text-stone-800">{{ $primata->makanan }}</div>
                        </div>
                    </div>

                    <div class="p-3.5 bg-amber-50/70 rounded-2xl border border-amber-200/60 text-xs">
                        <div class="text-amber-800 font-black uppercase text-[10px] mb-1">Ciri Khas & Perilaku</div>
                        <div class="font-medium text-amber-950">{{ $primata->ciri_khas }}</div>
                    </div>

                    <div>
                        <h2 class="text-xs font-bold text-stone-400 uppercase tracking-wider mb-2">Deskripsi & Peran Ekologis</h2>
                        <div class="text-stone-700 text-sm leading-relaxed whitespace-pre-line">
                            {{ $primata->deskripsi }}
                        </div>
                    </div>

                    <div class="pt-4 border-t border-stone-100">
                        <h3 class="text-xs font-bold text-stone-400 uppercase tracking-wider mb-2">Sebaran Wilayah di Desa Ini</h3>
                        @if ($primata->kawasanHutan->count() > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach ($primata->kawasanHutan as $kws)
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

        @if ($primataLain->count() > 0)
            <div class="pt-6">
                <h2 class="text-xl font-black text-stone-900 mb-4">Satwa Primata Lainnya</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach ($primataLain as $lain)
                        <a href="{{ route('primata.detail', $lain->id) }}" class="bg-white p-4 rounded-2xl border border-stone-200 hover:border-stone-300 transition shadow-sm flex items-center space-x-3 group">
                            <div class="w-12 h-12 rounded-xl bg-stone-100 overflow-hidden shrink-0">
                                @if ($lain->foto)
                                    <img src="{{ asset('storage/' . $lain->foto) }}" alt="{{ $lain->nama_lokal }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-amber-600 bg-amber-50">
                                        <i class="fa-solid fa-paw text-sm"></i>
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
