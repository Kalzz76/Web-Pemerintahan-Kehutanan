@extends('layouts.admin')

@section('title', 'C. Kelola Laporan Darurat')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl md:text-3xl font-extrabold text-stone-900 tracking-tight">C. Kelola Laporan Darurat</h1>
        <p class="text-stone-500 text-sm mt-1">Verifikasi laporan darurat warga desa, tentukan kawasan, dan berikan catatan tindak lanjut.</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-6 mb-8">
    <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex flex-col md:flex-row gap-3">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-stone-400">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" name="cari" value="{{ $cari }}" placeholder="Cari kode, deskripsi, nama pelapor, atau nomor HP..." class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition">
        </div>

        <div class="w-full md:w-44">
            <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition bg-white">
                <option value="">Semua Status</option>
                <option value="Baru" {{ $filterStatus === 'Baru' ? 'selected' : '' }}>Baru</option>
                <option value="Diverifikasi" {{ $filterStatus === 'Diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                <option value="Ditangani" {{ $filterStatus === 'Ditangani' ? 'selected' : '' }}>Ditangani</option>
                <option value="Selesai" {{ $filterStatus === 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>

        <div class="w-full md:w-48">
            <select name="jenis" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition bg-white">
                <option value="">Semua Jenis</option>
                <option value="Kebakaran" {{ $filterJenis === 'Kebakaran' ? 'selected' : '' }}>Kebakaran</option>
                <option value="Hewan Masuk Kampung" {{ $filterJenis === 'Hewan Masuk Kampung' ? 'selected' : '' }}>Hewan Masuk Kampung</option>
            </select>
        </div>

        <button type="submit" class="px-5 py-2.5 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl text-sm transition">
            Filter
        </button>

        @if ($cari || $filterStatus || $filterJenis)
            <a href="{{ route('admin.laporan.index') }}" class="px-5 py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-700 font-semibold rounded-xl text-sm transition text-center">
                Reset
            </a>
        @endif
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-stone-100 overflow-hidden">
    @if ($daftarLaporan->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-stone-100 text-stone-700 uppercase text-xs">
                        <th class="px-6 py-4 font-bold">Kode</th>
                        <th class="px-6 py-4 font-bold">Jenis Kejadian</th>
                        <th class="px-6 py-4 font-bold">Waktu Lapor</th>
                        <th class="px-6 py-4 font-bold">Pelapor</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 text-stone-700">
                    @foreach ($daftarLaporan as $laporan)
                        <tr class="hover:bg-stone-50 transition">
                            <td class="px-6 py-4 font-mono font-bold text-stone-900">
                                <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="text-green-800 hover:text-green-600 hover:underline">
                                    {{ $laporan->kode }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    @if ($laporan->jenis === 'Kebakaran')
                                        <span class="w-2.5 h-2.5 rounded-full bg-red-600 shrink-0"></span>
                                        <span class="font-semibold text-stone-900">Kebakaran</span>
                                    @else
                                        <span class="w-2.5 h-2.5 rounded-full bg-amber-600 shrink-0"></span>
                                        <span class="font-semibold text-stone-900">Hewan Masuk</span>
                                    @endif
                                </div>
                                @if ($laporan->jenis_hewan)
                                    <div class="text-[11px] text-stone-500 mt-0.5">{{ $laporan->jenis_hewan }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-stone-600 whitespace-nowrap">
                                <div>{{ \Carbon\Carbon::parse($laporan->created_at)->locale('id')->isoFormat('D MMM Y') }}</div>
                                <div class="text-[11px] text-stone-400">{{ \Carbon\Carbon::parse($laporan->created_at)->format('H:i') }} WIB</div>
                            </td>
                            <td class="px-6 py-4 text-xs">
                                <div class="font-semibold text-stone-800">{{ $laporan->nama_pelapor ?: 'Warga Anonim' }}</div>
                                <div class="text-stone-500 font-mono">{{ $laporan->no_hp ?: '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($laporan->status === 'Baru')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800">
                                        Baru
                                    </span>
                                @elseif ($laporan->status === 'Diverifikasi')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                        Diverifikasi
                                    </span>
                                @elseif ($laporan->status === 'Ditangani')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-sky-100 text-sky-800">
                                        Ditangani
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                        Selesai
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="px-3.5 py-1.5 bg-green-50 hover:bg-green-100 text-green-700 font-semibold rounded-lg text-xs transition inline-flex items-center">
                                    <i class="fa-solid fa-eye mr-1"></i> Detail
                                </a>
                                <form method="POST" action="{{ route('admin.laporan.destroy', $laporan->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan {{ $laporan->kode }}?')">
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
