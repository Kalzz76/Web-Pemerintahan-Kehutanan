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

<div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 p-4 sm:p-5 mb-5">
    <form method="GET" action="{{ route('admin.kawasan.index') }}" class="flex flex-col sm:flex-row gap-2.5">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-stone-400">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
            </span>
            <input type="text" name="cari" value="{{ $cari }}" placeholder="Cari nama kawasan, kategori, pengelola, atau deskripsi..." class="w-full pl-9 pr-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-800 focus:ring-1 focus:ring-stone-800 outline-none transition bg-stone-50/50 focus:bg-white">
        </div>
        <button type="submit" class="px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl text-xs sm:text-sm transition flex items-center justify-center gap-1.5">
            <i class="fa-solid fa-magnifying-glass text-xs"></i>
            <span>Cari</span>
        </button>
        @if ($cari)
            <a href="{{ route('admin.kawasan.index') }}" class="px-3.5 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 border border-stone-300 font-semibold rounded-xl text-xs sm:text-sm transition text-center" title="Reset pencarian">
                <i class="fa-solid fa-rotate-left"></i>
            </a>
        @endif
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 overflow-hidden">
    @if ($daftarKawasan->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm divide-y divide-stone-200/80">
                <thead>
                    <tr class="bg-stone-50/90 text-stone-600 uppercase text-[11px] font-bold tracking-wider">
                        <th class="px-4 py-3.5">Nama & Kategori</th>
                        <th class="px-4 py-3.5 whitespace-nowrap">Status Batas</th>
                        <th class="px-4 py-3.5 whitespace-nowrap">Jenis Lahan</th>
                        <th class="px-4 py-3.5 whitespace-nowrap">Luas (ha)</th>
                        <th class="px-4 py-3.5">Kabupaten/Kota</th>
                        <th class="px-4 py-3.5 text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 text-stone-700 bg-white">
                    @foreach ($daftarKawasan as $item)
                        <tr class="hover:bg-stone-50 transition-colors">
                            <td class="px-4 py-3.5">
                                <div class="font-bold text-stone-900 text-xs sm:text-sm">{{ $item->nama }}</div>
                                <div class="text-[11px] text-stone-600 font-semibold mt-0.5">{{ $item->kategori }}</div>
                                @if ($item->pengelola)
                                    <div class="text-[11px] text-stone-500 mt-0.5">Pengelola: {{ $item->pengelola }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap">
                                <span class="text-xs font-semibold text-stone-900">
                                    {{ $item->batas_resmi ? 'Resmi' : 'Perkiraan' }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap">
                                <span class="text-xs font-medium text-stone-800">
                                    {{ $item->jenisLahan->nama ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 font-mono text-xs whitespace-nowrap font-medium text-stone-800">
                                {{ $item->luas_ha ? number_format($item->luas_ha, 2, ',', '.') . ' ha' : '-' }}
                            </td>
                            <td class="px-4 py-3.5 text-xs text-stone-600 max-w-xs">
                                @if ($item->kabupatenKota->count() > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($item->kabupatenKota as $kab)
                                            <span class="inline-block text-stone-800 font-medium text-[11px]">{{ $kab->nama }}{{ !$loop->last ? ',' : '' }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-stone-400 italic text-[11px]">Belum diatur</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5 justify-end">
                                    <a href="{{ route('admin.kawasan.edit', $item->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 border border-stone-300 font-semibold rounded-lg text-xs transition">
                                        <i class="fa-solid fa-pen-to-square text-[11px] text-stone-600"></i>
                                        <span>Edit</span>
                                    </a>
                                    <form method="POST" action="{{ route('admin.kawasan.destroy', $item->id) }}" class="inline" data-confirm="Apakah Anda yakin ingin menghapus kawasan {{ $item->nama }}?" data-confirm-title="Hapus Kawasan" data-confirm-ok="Ya, Hapus">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-stone-100 text-stone-700 hover:text-stone-900 border border-stone-300 font-semibold rounded-lg text-xs transition">
                                            <i class="fa-solid fa-trash text-[11px] text-stone-500"></i>
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
            {{ $daftarKawasan->links() }}
        </div>
    @else
        <div class="p-12 text-center text-stone-400">
            <i class="fa-solid fa-mountain-sun text-4xl mb-3 text-stone-300"></i>
            <p class="text-sm font-medium">Belum ada data kawasan hutan.</p>
        </div>
    @endif
</div>
@endsection
