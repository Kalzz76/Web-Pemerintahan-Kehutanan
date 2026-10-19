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
                Total Koleksi: <span class="font-bold text-stone-900">{{ $daftarTumbuhan->total() }} Spesies</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-stone-200 shadow-sm">
            <form method="GET" action="{{ route('tumbuhan') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                <div class="sm:col-span-5 relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-stone-400 text-sm"></i>
                    <input type="text" name="cari" value="{{ $cari ?? '' }}" placeholder="Cari nama lokal, ilmiah, manfaat..." class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-green-600">
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
                    <select name="jenis" class="w-full px-3 py-2.5 text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 bg-white">
                        <option value="">Semua Habitus</option>
                        <option value="Pohon" {{ ($jenis ?? '') == 'Pohon' ? 'selected' : '' }}>Pohon</option>
                        <option value="Perdu" {{ ($jenis ?? '') == 'Perdu' ? 'selected' : '' }}>Perdu</option>
                        <option value="Herba" {{ ($jenis ?? '') == 'Herba' ? 'selected' : '' }}>Herba</option>
                        <option value="Liana" {{ ($jenis ?? '') == 'Liana' ? 'selected' : '' }}>Liana</option>
                        <option value="Lainnya" {{ ($jenis ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div class="sm:col-span-2 flex gap-2">
                    <button type="submit" class="flex-1 py-2.5 bg-green-700 hover:bg-green-600 text-white font-bold rounded-xl text-sm transition shadow">
                        Cari
                    </button>
                    @if (!empty($cari) || !empty($idKawasan) || !empty($jenis))
                        <a href="{{ route('tumbuhan') }}" class="px-3 py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-700 font-bold rounded-xl text-sm transition flex items-center justify-center">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        @if ($daftarTumbuhan->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center border border-stone-200 shadow-sm max-w-xl mx-auto">
                <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mx-auto mb-4">
                    <i class="fa-solid fa-seedling"></i>
                </div>
                <h3 class="text-lg font-black text-stone-900 mb-1">Tumbuhan Tidak Ditemukan</h3>
                <p class="text-stone-500 text-xs sm:text-sm mb-5">
                    Tidak ada tanaman yang cocok dengan kata kunci atau filter pencarian Anda.
                </p>
                <a href="{{ route('tumbuhan') }}" class="px-5 py-2.5 bg-stone-900 text-white font-bold rounded-xl text-xs sm:text-sm">
                    Lihat Semua Tumbuhan
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($daftarTumbuhan as $tumbuhan)
                    <div class="bg-white rounded-3xl border border-stone-200 shadow-sm overflow-hidden flex flex-col group hover:shadow-md hover:border-stone-300 transition duration-200">
                        <div class="h-52 bg-stone-100 relative overflow-hidden">
                            @if ($tumbuhan->foto)
                                <img src="{{ asset('storage/' . $tumbuhan->foto) }}" alt="{{ $tumbuhan->nama_lokal }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-emerald-50 to-stone-100 text-emerald-600 text-4xl">
                                    <i class="fa-solid fa-seedling"></i>
                                </div>
                            @endif

                            <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-stone-900/80 text-white backdrop-blur-sm shadow-sm">
                                    {{ $tumbuhan->jenis }}
                                </span>

                                @if ($tumbuhan->status_konservasi == 'CR')
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-rose-600 text-white shadow-sm">CR</span>
                                @elseif ($tumbuhan->status_konservasi == 'EN')
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-orange-600 text-white shadow-sm">EN</span>
                                @elseif ($tumbuhan->status_konservasi == 'VU')
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-amber-500 text-white shadow-sm">VU</span>
                                @elseif ($tumbuhan->status_konservasi == 'NT')
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-yellow-500 text-stone-900 shadow-sm">NT</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-emerald-600 text-white shadow-sm">{{ $tumbuhan->status_konservasi }}</span>
                                @endif

                                @if ($tumbuhan->dilindungi)
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-emerald-700 text-white shadow-sm flex items-center">
                                        <i class="fa-solid fa-shield text-[10px] mr-1"></i> Dilindungi
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                            <div>
                                <h3 class="text-lg font-black text-stone-900 group-hover:text-green-700 transition">
                                    {{ $tumbuhan->nama_lokal }}
                                </h3>
                                <p class="text-xs text-stone-500 italic mt-0.5 font-serif">
                                    {{ $tumbuhan->nama_ilmiah }}
                                </p>

                                <div class="mt-3 text-xs bg-emerald-50/60 p-2.5 rounded-xl border border-emerald-100 text-emerald-950">
                                    <span class="font-bold block text-emerald-800 text-[10px] uppercase">Manfaat</span>
                                    <span class="line-clamp-2">{{ $tumbuhan->manfaat }}</span>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-stone-100 space-y-2">
                                @if ($tumbuhan->kawasanHutan->count() > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($tumbuhan->kawasanHutan->take(2) as $kws)
                                            <span class="px-2 py-0.5 rounded-md bg-stone-100 text-stone-600 text-[10px] font-medium">{{ $kws->nama }}</span>
                                        @endforeach
                                        @if ($tumbuhan->kawasanHutan->count() > 2)
                                            <span class="px-1.5 py-0.5 rounded-md bg-stone-100 text-stone-500 text-[10px]">+{{ $tumbuhan->kawasanHutan->count() - 2 }}</span>
                                        @endif
                                    </div>
                                @endif

                                <div class="pt-2">
                                    <a href="{{ route('tumbuhan.detail', $tumbuhan->id) }}" class="inline-flex items-center text-xs font-bold text-green-700 hover:text-green-800 transition group/link">
                                        <span>Selengkapnya</span>
                                        <i class="fa-solid fa-arrow-right ml-1.5 text-[10px] group-hover/link:translate-x-1 transition transform"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($daftarTumbuhan->hasPages())
                <div class="pt-4">
                    {{ $daftarTumbuhan->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
