@extends('layouts.publik')

@section('title', 'Katalog Satwa Primata')

@section('content')
<div class="bg-stone-50 py-10 px-4 sm:px-6 lg:px-8 min-h-[calc(100vh-80px)]">
    <div class="max-w-7xl mx-auto space-y-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 mb-2">
                    <i class="fa-solid fa-paw mr-1.5"></i> Fauna Khas & Dilindungi
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-stone-900 tracking-tight">Katalog Satwa Primata</h1>
                <p class="text-stone-600 text-sm sm:text-base mt-2 max-w-2xl leading-relaxed">
                    Mengenal berbagai jenis satwa primata penghuni rimba desa, status keterancamannya, serta kawasan sebaran habitat yang wajib kita jaga bersama.
                </p>
            </div>
            <div class="text-xs text-stone-500 font-semibold bg-white px-4 py-2.5 rounded-2xl border border-stone-200 shadow-sm self-start md:self-auto">
                Total Koleksi: <span class="font-bold text-stone-900">{{ $daftarPrimata->total() }} Spesies</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-stone-200 shadow-sm">
            <form method="GET" action="{{ route('primata') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                <div class="sm:col-span-5 relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-stone-400 text-sm"></i>
                    <input type="text" name="cari" value="{{ $cari ?? '' }}" placeholder="Cari nama lokal, ilmiah, habitat..." class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-green-600">
                </div>

                <div class="sm:col-span-3">
                    <select name="id_kawasan" class="w-full px-3 py-2.5 text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 bg-white">
                        <option value="">Semua Kawasan</option>
                        @foreach ($daftarKawasan as $kws)
                            <option value="{{ $kws->id }}" {{ ($idKawasan ?? '') == $kws->id ? 'selected' : '' }}>
                                {{ $kws->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <select name="status" class="w-full px-3 py-2.5 text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 bg-white">
                        <option value="">Status Konservasi</option>
                        <option value="CR" {{ ($statusKonservasi ?? '') == 'CR' ? 'selected' : '' }}>CR (Kritis)</option>
                        <option value="EN" {{ ($statusKonservasi ?? '') == 'EN' ? 'selected' : '' }}>EN (Genting)</option>
                        <option value="VU" {{ ($statusKonservasi ?? '') == 'VU' ? 'selected' : '' }}>VU (Rentan)</option>
                        <option value="NT" {{ ($statusKonservasi ?? '') == 'NT' ? 'selected' : '' }}>NT (Hampir Terancam)</option>
                        <option value="LC" {{ ($statusKonservasi ?? '') == 'LC' ? 'selected' : '' }}>LC (Risiko Rendah)</option>
                    </select>
                </div>

                <div class="sm:col-span-2 flex gap-2">
                    <button type="submit" class="flex-1 py-2.5 bg-green-700 hover:bg-green-600 text-white font-bold rounded-xl text-sm transition shadow">
                        Cari
                    </button>
                    @if (!empty($cari) || !empty($idKawasan) || !empty($statusKonservasi))
                        <a href="{{ route('primata') }}" class="px-3 py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-700 font-bold rounded-xl text-sm transition flex items-center justify-center">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        @if ($daftarPrimata->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center border border-stone-200 shadow-sm max-w-xl mx-auto">
                <div class="w-16 h-16 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center text-2xl mx-auto mb-4">
                    <i class="fa-solid fa-paw"></i>
                </div>
                <h3 class="text-lg font-black text-stone-900 mb-1">Satwa Primata Tidak Ditemukan</h3>
                <p class="text-stone-500 text-xs sm:text-sm mb-5">
                    Tidak ada satwa yang cocok dengan kata kunci atau filter pencarian Anda.
                </p>
                <a href="{{ route('primata') }}" class="px-5 py-2.5 bg-stone-900 text-white font-bold rounded-xl text-xs sm:text-sm">
                    Lihat Semua Primata
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($daftarPrimata as $primata)
                    <div class="bg-white rounded-3xl border border-stone-200 shadow-sm overflow-hidden flex flex-col group hover:shadow-md hover:border-stone-300 transition duration-200">
                        <div class="h-52 bg-stone-100 relative overflow-hidden">
                            @if ($primata->foto)
                                <img src="{{ asset('storage/' . $primata->foto) }}" alt="{{ $primata->nama_lokal }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-amber-50 to-stone-100 text-amber-500 text-4xl">
                                    <i class="fa-solid fa-paw"></i>
                                </div>
                            @endif

                            <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                                @if ($primata->status_konservasi == 'CR')
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-rose-600 text-white shadow-sm">CR (Kritis)</span>
                                @elseif ($primata->status_konservasi == 'EN')
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-orange-600 text-white shadow-sm">EN (Genting)</span>
                                @elseif ($primata->status_konservasi == 'VU')
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-amber-500 text-white shadow-sm">VU (Rentan)</span>
                                @elseif ($primata->status_konservasi == 'NT')
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-yellow-500 text-stone-900 shadow-sm">NT (Hampir Terancam)</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-emerald-600 text-white shadow-sm">{{ $primata->status_konservasi }}</span>
                                @endif

                                @if ($primata->dilindungi)
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-emerald-700 text-white shadow-sm flex items-center">
                                        <i class="fa-solid fa-shield text-[10px] mr-1"></i> Dilindungi
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                            <div>
                                <h3 class="text-lg font-black text-stone-900 group-hover:text-green-700 transition">
                                    {{ $primata->nama_lokal }}
                                </h3>
                                <p class="text-xs text-stone-500 italic mt-0.5 font-serif">
                                    {{ $primata->nama_ilmiah }}
                                </p>

                                <p class="text-xs text-stone-600 line-clamp-3 mt-3 leading-relaxed">
                                    {{ $primata->deskripsi }}
                                </p>
                            </div>

                            <div class="pt-3 border-t border-stone-100 space-y-2">
                                <div class="text-xs text-stone-500">
                                    <span class="font-bold text-stone-700">Habitat:</span> {{ Str::limit($primata->habitat, 40) }}
                                </div>

                                @if ($primata->kawasanHutan->count() > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($primata->kawasanHutan->take(2) as $kws)
                                            <span class="px-2 py-0.5 rounded-md bg-stone-100 text-stone-600 text-[10px] font-medium">{{ $kws->nama }}</span>
                                        @endforeach
                                        @if ($primata->kawasanHutan->count() > 2)
                                            <span class="px-1.5 py-0.5 rounded-md bg-stone-100 text-stone-500 text-[10px]">+{{ $primata->kawasanHutan->count() - 2 }}</span>
                                        @endif
                                    </div>
                                @endif

                                <div class="pt-2">
                                    <a href="{{ route('primata.detail', $primata->id) }}" class="inline-flex items-center text-xs font-bold text-green-700 hover:text-green-800 transition group/link">
                                        <span>Selengkapnya</span>
                                        <i class="fa-solid fa-arrow-right ml-1.5 text-[10px] group-hover/link:translate-x-1 transition transform"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($daftarPrimata->hasPages())
                <div class="pt-4">
                    {{ $daftarPrimata->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
