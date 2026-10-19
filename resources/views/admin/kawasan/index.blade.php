@extends('layouts.admin')

@section('title', 'Kawasan Hutan')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl md:text-3xl font-extrabold text-stone-900 tracking-tight">Kawasan Hutan</h1>
        <p class="text-stone-500 text-sm mt-1">Daftar blok kawasan hutan, batas wilayah poligon, dan jenis tutupan lahan.</p>
    </div>
    <a href="{{ route('admin.kawasan.create') }}" class="inline-flex items-center px-5 py-3 bg-green-700 hover:bg-green-600 text-white font-bold rounded-xl shadow transition active:scale-95 text-sm shrink-0">
        <i class="fa-solid fa-plus mr-2"></i>
        <span>Tambah Kawasan Hutan</span>
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-6 mb-8">
    <form method="GET" action="{{ route('admin.kawasan.index') }}" class="flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-stone-400">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" name="cari" value="{{ $cari }}" placeholder="Cari nama kawasan hutan atau deskripsi..." class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition">
        </div>
        <button type="submit" class="px-5 py-2.5 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl text-sm transition">
            Cari
        </button>
        @if ($cari)
            <a href="{{ route('admin.kawasan.index') }}" class="px-5 py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-700 font-semibold rounded-xl text-sm transition text-center">
                Reset
            </a>
        @endif
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-stone-100 overflow-hidden">
    @if ($daftarKawasan->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-stone-100 text-stone-700 uppercase text-xs">
                        <th class="px-6 py-4 font-bold">Nama Kawasan</th>
                        <th class="px-6 py-4 font-bold">Jenis Lahan</th>
                        <th class="px-6 py-4 font-bold">Luas (ha)</th>
                        <th class="px-6 py-4 font-bold">Deskripsi</th>
                        <th class="px-6 py-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 text-stone-700">
                    @foreach ($daftarKawasan as $item)
                        <tr class="hover:bg-stone-50 transition">
                            <td class="px-6 py-4 font-semibold text-stone-900">
                                {{ $item->nama }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-xl bg-stone-100 text-stone-800 font-medium text-xs">
                                    <i class="fa-solid fa-layer-group text-[10px] mr-1.5 text-green-700"></i>
                                    {{ $item->jenisLahan->nama ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-mono text-xs">
                                {{ $item->luas_ha ? number_format($item->luas_ha, 2, ',', '.') . ' ha' : '-' }}
                            </td>
                            <td class="px-6 py-4 text-xs text-stone-500 max-w-xs truncate">
                                {{ $item->deskripsi }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.kawasan.edit', $item->id) }}" class="px-3.5 py-1.5 bg-green-50 hover:bg-green-100 text-green-700 font-semibold rounded-lg text-xs transition inline-flex items-center">
                                    <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('admin.kawasan.destroy', $item->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kawasan {{ $item->nama }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-semibold rounded-lg text-xs transition">
                                        <i class="fa-solid fa-trash mr-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-stone-100">
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
