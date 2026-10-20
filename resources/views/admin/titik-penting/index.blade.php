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

<div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 p-4 sm:p-5 mb-5">
    <form method="GET" action="{{ route('admin.titik-penting.index') }}" class="flex flex-col sm:flex-row gap-2.5">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-stone-400">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
            </span>
            <input type="text" name="cari" value="{{ $cari }}" placeholder="Cari nama titik, deskripsi, atau kontak..." class="w-full pl-9 pr-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-800 focus:ring-1 focus:ring-stone-800 outline-none transition bg-stone-50/50 focus:bg-white">
        </div>

        <div class="w-full sm:w-56">
            <select name="jenis" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-800 outline-none transition bg-stone-50/50 focus:bg-white text-stone-700">
                <option value="">Semua Jenis</option>
                <option value="Pos Jaga" {{ $filterJenis == 'Pos Jaga' ? 'selected' : '' }}>Pos Jaga</option>
                <option value="Pos Pemadam" {{ $filterJenis == 'Pos Pemadam' ? 'selected' : '' }}>Pos Pemadam</option>
                <option value="Sumber Air" {{ $filterJenis == 'Sumber Air' ? 'selected' : '' }}>Sumber Air</option>
                <option value="Titik Kumpul Evakuasi" {{ $filterJenis == 'Titik Kumpul Evakuasi' ? 'selected' : '' }}>Titik Kumpul Evakuasi</option>
                <option value="Permukiman" {{ $filterJenis == 'Permukiman' ? 'selected' : '' }}>Permukiman</option>
            </select>
        </div>

        <button type="submit" class="px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl text-xs sm:text-sm transition flex items-center justify-center gap-1.5">
            <i class="fa-solid fa-filter text-xs"></i>
            <span>Filter</span>
        </button>

        @if ($cari || $filterJenis)
            <a href="{{ route('admin.titik-penting.index') }}" class="px-3.5 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 border border-stone-300 font-semibold rounded-xl text-xs sm:text-sm transition text-center" title="Reset filter">
                <i class="fa-solid fa-rotate-left"></i>
            </a>
        @endif
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 overflow-hidden">
    @if ($daftarTitik->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm divide-y divide-stone-200/80">
                <thead>
                    <tr class="bg-stone-50/90 text-stone-600 uppercase text-[11px] font-bold tracking-wider">
                        <th class="px-4 py-3.5">Titik & Foto</th>
                        <th class="px-4 py-3.5 whitespace-nowrap">Jenis</th>
                        <th class="px-4 py-3.5">Lokasi / Wilayah</th>
                        <th class="px-4 py-3.5 whitespace-nowrap">Koordinat</th>
                        <th class="px-4 py-3.5 whitespace-nowrap">Kontak</th>
                        <th class="px-4 py-3.5 text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 text-stone-700 bg-white">
                    @foreach ($daftarTitik as $item)
                        <tr class="hover:bg-stone-50 transition-colors">
                            <td class="px-4 py-3.5">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-xl bg-stone-100 border border-stone-200 flex items-center justify-center shrink-0 overflow-hidden">
                                        @if ($item->foto)
                                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fa-solid fa-location-dot text-stone-500 text-sm"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-stone-900 text-xs sm:text-sm">{{ $item->nama }}</div>
                                        <div class="text-[11px] text-stone-500 line-clamp-1 max-w-xs">{{ $item->deskripsi }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap">
                                <span class="text-xs font-semibold text-stone-900">
                                    {{ $item->jenis }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-xs text-stone-600">
                                @if ($item->kabupatenKota)
                                    <div class="font-semibold text-stone-900">{{ $item->kabupatenKota->nama }}</div>
                                    @if ($item->kawasanHutan)
                                        <div class="text-[11px] text-stone-500">{{ $item->kawasanHutan->nama }}</div>
                                    @endif
                                @elseif ($item->kawasanHutan)
                                    <div class="font-semibold text-stone-900">{{ $item->kawasanHutan->nama }}</div>
                                    <div class="text-[11px] text-stone-400">Jawa Barat</div>
                                @else
                                    <div class="font-medium text-stone-800">Luar Kawasan</div>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 font-mono text-xs text-stone-600 whitespace-nowrap">
                                {{ number_format($item->latitude, 5) }}, {{ number_format($item->longitude, 5) }}
                            </td>
                            <td class="px-4 py-3.5 text-xs text-stone-600 whitespace-nowrap font-mono">
                                {{ $item->kontak ?? '-' }}
                            </td>
                            <td class="px-4 py-3.5 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5 justify-end">
                                    <a href="{{ route('admin.titik-penting.edit', $item->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200/80 font-semibold rounded-lg text-xs transition shadow-2xs">
                                        <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                        <span>Edit</span>
                                    </a>
                                    <form method="POST" action="{{ route('admin.titik-penting.destroy', $item->id) }}" class="inline" data-confirm="Apakah Anda yakin ingin menghapus titik penting {{ $item->nama }}?" data-confirm-title="Hapus Titik Penting" data-confirm-ok="Ya, Hapus">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 font-semibold rounded-lg text-xs transition shadow-2xs">
                                            <i class="fa-solid fa-trash text-[11px]"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4 sm:p-5 border-t border-stone-100 bg-stone-50/50">
            {{ $daftarTitik->links() }}
        </div>
    @else
        <div class="p-12 text-center text-stone-400">
            <i class="fa-solid fa-location-dot text-4xl mb-3 text-stone-300"></i>
            <p class="text-sm font-medium">Belum ada data titik penting.</p>
        </div>
    @endif
</div>
@endsection
