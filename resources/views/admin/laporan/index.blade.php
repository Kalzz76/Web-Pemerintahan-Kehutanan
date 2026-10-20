@extends('layouts.admin')

@section('title', 'Kelola Laporan Darurat')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
    <div>
        <h1 class="text-lg md:text-xl font-bold text-stone-900 tracking-tight">Kelola Laporan Darurat</h1>
        <p class="text-stone-500 text-xs mt-0.5">Verifikasi laporan darurat warga desa, tentukan kawasan, dan berikan catatan tindak lanjut.</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 p-5 mb-6">
    <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex flex-col lg:flex-row gap-3 items-stretch lg:items-center">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-stone-400">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
            </span>
            <input type="text" name="cari" value="{{ $cari }}" placeholder="Cari kode, pelapor, no HP, atau isi laporan..." class="w-full pl-9 pr-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-green-600 focus:ring-1 focus:ring-green-600 outline-none transition bg-stone-50/50 focus:bg-white">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
            <div class="w-full sm:w-36">
                <select name="status" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-green-600 outline-none transition bg-stone-50/50 focus:bg-white text-stone-700">
                    <option value="">Semua Status</option>
                    <option value="Baru" {{ $filterStatus === 'Baru' ? 'selected' : '' }}>Baru</option>
                    <option value="Diverifikasi" {{ $filterStatus === 'Diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                    <option value="Ditangani" {{ $filterStatus === 'Ditangani' ? 'selected' : '' }}>Ditangani</option>
                    <option value="Selesai" {{ $filterStatus === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="w-full sm:w-36">
                <select name="jenis" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-green-600 outline-none transition bg-stone-50/50 focus:bg-white text-stone-700">
                    <option value="">Semua Jenis</option>
                    <option value="Kebakaran" {{ $filterJenis === 'Kebakaran' ? 'selected' : '' }}>Kebakaran</option>
                    <option value="Hewan Masuk Kampung" {{ $filterJenis === 'Hewan Masuk Kampung' ? 'selected' : '' }}>Hewan Masuk</option>
                </select>
            </div>

            <div class="w-full sm:w-44">
                <select name="id_kabupaten_kota" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-green-600 outline-none transition bg-stone-50/50 focus:bg-white text-stone-700">
                    <option value="">Semua Kab/Kota</option>
                    @foreach ($daftarKabupaten as $kab)
                        <option value="{{ $kab->id }}" {{ (string)$filterKabupaten === (string)$kab->id ? 'selected' : '' }}>{{ $kab->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="flex-1 sm:flex-initial px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl text-xs sm:text-sm transition shadow-sm flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-filter text-xs"></i>
                <span>Filter</span>
            </button>

            @if ($cari || $filterStatus || $filterJenis || $filterKabupaten)
                <a href="{{ route('admin.laporan.index') }}" class="px-3.5 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 font-semibold rounded-xl text-xs sm:text-sm transition text-center" title="Reset filter">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 overflow-hidden">
    @if ($daftarLaporan->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm divide-y divide-stone-200/80">
                <thead>
                    <tr class="bg-stone-50/90 text-stone-600 uppercase text-[11px] font-bold tracking-wider">
                        <th class="px-4 py-3.5 whitespace-nowrap">Kode</th>
                        <th class="px-4 py-3.5 whitespace-nowrap">Jenis Kejadian</th>
                        <th class="px-4 py-3.5">Lokasi / Wilayah</th>
                        <th class="px-4 py-3.5 whitespace-nowrap">Waktu Lapor</th>
                        <th class="px-4 py-3.5">Pelapor</th>
                        <th class="px-4 py-3.5 whitespace-nowrap">Status</th>
                        <th class="px-4 py-3.5 text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 text-stone-700 bg-white">
                    @foreach ($daftarLaporan as $laporan)
                        <tr class="hover:bg-stone-50 transition-colors">
                            <td class="px-4 py-3.5 whitespace-nowrap">
                                <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="font-mono font-bold text-xs text-stone-900 hover:text-stone-600 hover:underline">
                                    {{ $laporan->kode }}
                                </a>
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap">
                                <div class="font-semibold text-stone-900 text-xs">
                                    {{ $laporan->jenis === 'Kebakaran' ? 'Kebakaran' : 'Hewan Masuk' }}
                                </div>
                                @if ($laporan->jenis_hewan)
                                    <div class="text-[11px] text-stone-500 font-normal mt-0.5">{{ $laporan->jenis_hewan }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3.5">
                                @if ($laporan->kabupatenKota)
                                    <div class="font-semibold text-stone-900 text-xs">{{ $laporan->kabupatenKota->nama }}</div>
                                    @if ($laporan->kawasanHutan)
                                        <div class="text-[11px] text-stone-500 truncate max-w-[200px]" title="{{ $laporan->kawasanHutan->nama }}">
                                            {{ $laporan->kawasanHutan->nama }}
                                        </div>
                                    @endif
                                @elseif ($laporan->kawasanHutan)
                                    <div class="font-semibold text-stone-900 text-xs truncate max-w-[200px]" title="{{ $laporan->kawasanHutan->nama }}">
                                        {{ $laporan->kawasanHutan->nama }}
                                    </div>
                                    <div class="text-[11px] text-stone-500">Jawa Barat</div>
                                @else
                                    <div class="font-semibold text-stone-900 text-xs">Jawa Barat</div>
                                    <div class="text-[11px] text-stone-500">Belum ditentukan</div>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap text-xs">
                                <div class="font-medium text-stone-900">{{ \Carbon\Carbon::parse($laporan->created_at)->locale('id')->isoFormat('D MMM Y') }}</div>
                                <div class="text-[11px] text-stone-500 font-mono">{{ \Carbon\Carbon::parse($laporan->created_at)->format('H:i') }} WIB</div>
                            </td>
                            <td class="px-4 py-3.5 text-xs">
                                <div class="font-semibold text-stone-900 truncate max-w-[140px]" title="{{ $laporan->nama_pelapor ?: 'Warga Anonim' }}">
                                    {{ $laporan->nama_pelapor ?: 'Warga Anonim' }}
                                </div>
                                <div class="text-stone-500 font-mono text-[11px]">{{ $laporan->no_hp ?: '-' }}</div>
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap">
                                <span class="text-xs font-semibold text-stone-900">
                                    {{ $laporan->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5 justify-end">
                                    <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 border border-stone-300 font-semibold rounded-lg text-xs transition">
                                        <i class="fa-solid fa-eye text-[11px] text-stone-600"></i>
                                        <span>Detail</span>
                                    </a>
                                    <form method="POST" action="{{ route('admin.laporan.destroy', $laporan->id) }}" class="inline" data-confirm="Apakah Anda yakin ingin menghapus laporan {{ $laporan->kode }}?" data-confirm-title="Hapus Laporan" data-confirm-ok="Ya, Hapus">
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
            {{ $daftarLaporan->links() }}
        </div>
    @else
        <div class="p-12 text-center text-stone-400">
            <i class="fa-solid fa-clipboard-list text-4xl mb-3 text-stone-300"></i>
            <p class="text-sm font-medium">Belum ada laporan darurat yang sesuai filter.</p>
        </div>
    @endif
</div>
@endsection
