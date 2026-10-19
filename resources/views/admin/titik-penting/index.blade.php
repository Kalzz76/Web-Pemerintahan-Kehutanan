@extends('layouts.admin')

@section('title', 'Titik Penting')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl md:text-3xl font-extrabold text-stone-900 tracking-tight">Titik Penting</h1>
        <p class="text-stone-500 text-sm mt-1">Daftar pos jaga, pos pemadam, sumber air, jalur evakuasi, dan pemukiman warga.</p>
    </div>
    <a href="{{ route('admin.titik-penting.create') }}" class="inline-flex items-center px-5 py-3 bg-green-700 hover:bg-green-600 text-white font-bold rounded-xl shadow transition active:scale-95 text-sm shrink-0">
        <i class="fa-solid fa-plus mr-2"></i>
        <span>Tambah Titik Penting</span>
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-6 mb-8">
    <form method="GET" action="{{ route('admin.titik-penting.index') }}" class="flex flex-col md:flex-row gap-3">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-stone-400">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" name="cari" value="{{ $cari }}" placeholder="Cari nama titik, deskripsi, atau kontak..." class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition">
        </div>

        <div class="w-full md:w-56">
            <select name="jenis" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition bg-white">
                <option value="">Semua Jenis</option>
                <option value="Pos Jaga" {{ $filterJenis == 'Pos Jaga' ? 'selected' : '' }}>Pos Jaga</option>
                <option value="Pos Pemadam" {{ $filterJenis == 'Pos Pemadam' ? 'selected' : '' }}>Pos Pemadam</option>
                <option value="Sumber Air" {{ $filterJenis == 'Sumber Air' ? 'selected' : '' }}>Sumber Air</option>
                <option value="Titik Kumpul Evakuasi" {{ $filterJenis == 'Titik Kumpul Evakuasi' ? 'selected' : '' }}>Titik Kumpul Evakuasi</option>
                <option value="Permukiman" {{ $filterJenis == 'Permukiman' ? 'selected' : '' }}>Permukiman</option>
            </select>
        </div>

        <button type="submit" class="px-5 py-2.5 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl text-sm transition">
            Filter
        </button>

        @if ($cari || $filterJenis)
            <a href="{{ route('admin.titik-penting.index') }}" class="px-5 py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-700 font-semibold rounded-xl text-sm transition text-center">
                Reset
            </a>
        @endif
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-stone-100 overflow-hidden">
    @if ($daftarTitik->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-stone-100 text-stone-700 uppercase text-xs">
                        <th class="px-6 py-4 font-bold">Titik & Foto</th>
                        <th class="px-6 py-4 font-bold">Jenis</th>
                        <th class="px-6 py-4 font-bold">Kawasan</th>
                        <th class="px-6 py-4 font-bold">Koordinat</th>
                        <th class="px-6 py-4 font-bold">Kontak</th>
                        <th class="px-6 py-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 text-stone-700">
                    @foreach ($daftarTitik as $item)
                        <tr class="hover:bg-stone-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-xl bg-stone-100 border border-stone-200 flex items-center justify-center shrink-0 overflow-hidden">
                                        @if ($item->foto)
                                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}" class="w-full h-full object-cover">
                                        @else
                                            @if ($item->jenis == 'Pos Jaga')
                                                <i class="fa-solid fa-person-shelter text-blue-600"></i>
                                            @elseif ($item->jenis == 'Pos Pemadam')
                                                <i class="fa-solid fa-fire-extinguisher text-red-800"></i>
                                            @elseif ($item->jenis == 'Sumber Air')
                                                <i class="fa-solid fa-faucet-drip text-cyan-600"></i>
                                            @elseif ($item->jenis == 'Titik Kumpul Evakuasi')
                                                <i class="fa-solid fa-people-roof text-green-600"></i>
                                            @else
                                                <i class="fa-solid fa-house-chimney text-amber-600"></i>
                                            @endif
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-stone-900">{{ $item->nama }}</div>
                                        <div class="text-xs text-stone-500 line-clamp-1 max-w-xs">{{ $item->deskripsi }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($item->jenis == 'Pos Jaga')
                                    <span class="inline-flex items-center px-3 py-1 rounded-xl bg-blue-50 text-blue-800 font-semibold text-xs">
                                        <span class="w-2 h-2 rounded-full bg-blue-600 mr-2"></span> Pos Jaga
                                    </span>
                                @elseif ($item->jenis == 'Pos Pemadam')
                                    <span class="inline-flex items-center px-3 py-1 rounded-xl bg-rose-50 text-rose-800 font-semibold text-xs">
                                        <span class="w-2 h-2 rounded-full bg-rose-700 mr-2"></span> Pos Pemadam
                                    </span>
                                @elseif ($item->jenis == 'Sumber Air')
                                    <span class="inline-flex items-center px-3 py-1 rounded-xl bg-cyan-50 text-cyan-800 font-semibold text-xs">
                                        <span class="w-2 h-2 rounded-full bg-cyan-600 mr-2"></span> Sumber Air
                                    </span>
                                @elseif ($item->jenis == 'Titik Kumpul Evakuasi')
                                    <span class="inline-flex items-center px-3 py-1 rounded-xl bg-green-50 text-green-800 font-semibold text-xs">
                                        <span class="w-2 h-2 rounded-full bg-green-600 mr-2"></span> Titik Kumpul Evakuasi
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-xl bg-amber-50 text-amber-800 font-semibold text-xs">
                                        <span class="w-2 h-2 rounded-full bg-amber-600 mr-2"></span> Permukiman
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-stone-600">
                                {{ $item->kawasanHutan->nama ?? 'Luar Kawasan' }}
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-stone-500 whitespace-nowrap">
                                {{ number_format($item->latitude, 5) }}, {{ number_format($item->longitude, 5) }}
                            </td>
                            <td class="px-6 py-4 text-xs text-stone-600">
                                {{ $item->kontak ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.titik-penting.edit', $item->id) }}" class="px-3.5 py-1.5 bg-green-50 hover:bg-green-100 text-green-700 font-semibold rounded-lg text-xs transition inline-flex items-center">
                                    <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('admin.titik-penting.destroy', $item->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus titik penting {{ $item->nama }}?')">
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
