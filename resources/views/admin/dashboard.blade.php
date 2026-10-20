@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-lg md:text-xl font-bold text-stone-900 tracking-tight">Ringkasan Sistem</h1>
        <p class="text-stone-500 text-xs mt-0.5">Pemantauan data lapangan, mitigasi karhutla, dan perlindungan keanekaragaman hayati Jawa Barat.</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3.5">
        <div class="bg-white p-4 rounded-2xl border border-stone-200/80 shadow-sm flex flex-col justify-between">
            <div class="w-9 h-9 rounded-xl bg-stone-100 text-stone-700 flex items-center justify-center text-sm mb-3">
                <i class="fa-solid fa-bell"></i>
            </div>
            <div>
                <div class="text-xl font-bold text-stone-900">{{ $jumlahLaporanBaru }}</div>
                <div class="text-[11px] font-semibold text-stone-500 uppercase tracking-wider mt-0.5">Laporan Baru</div>
            </div>
            <a href="{{ route('admin.laporan.index', ['status' => 'Baru']) }}" class="text-[11px] font-semibold text-stone-700 hover:text-stone-900 hover:underline mt-2.5 inline-block">
                Tinjau &rarr;
            </a>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-stone-200/80 shadow-sm flex flex-col justify-between">
            <div class="w-9 h-9 rounded-xl bg-stone-100 text-stone-700 flex items-center justify-center text-sm mb-3">
                <i class="fa-solid fa-fire-flame-curved"></i>
            </div>
            <div>
                <div class="text-xl font-bold text-stone-900">{{ $kebakaranAktif }}</div>
                <div class="text-[11px] font-semibold text-stone-500 uppercase tracking-wider mt-0.5">Kebakaran Aktif</div>
            </div>
            <a href="{{ route('admin.prediksi.index') }}" class="text-[11px] font-semibold text-stone-700 hover:text-stone-900 hover:underline mt-2.5 inline-block">
                Buka Prediksi &rarr;
            </a>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-stone-200/80 shadow-sm flex flex-col justify-between">
            <div class="w-9 h-9 rounded-xl bg-stone-100 text-stone-700 flex items-center justify-center text-sm mb-3">
                <i class="fa-solid fa-paw"></i>
            </div>
            <div>
                <div class="text-xl font-bold text-stone-900">{{ $hewanBulanIni }}</div>
                <div class="text-[11px] font-semibold text-stone-500 uppercase tracking-wider mt-0.5">Hewan Masuk</div>
            </div>
            <span class="text-[11px] font-medium text-stone-400 mt-2.5 inline-block">Bulan Berjalan</span>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-stone-200/80 shadow-sm flex flex-col justify-between">
            <div class="w-9 h-9 rounded-xl bg-stone-100 text-stone-700 flex items-center justify-center text-sm mb-3">
                <i class="fa-solid fa-mountain-sun"></i>
            </div>
            <div>
                <div class="text-xl font-bold text-stone-900">{{ $totalKawasan }}</div>
                <div class="text-[11px] font-semibold text-stone-500 uppercase tracking-wider mt-0.5">Kawasan Hutan</div>
            </div>
            <a href="{{ route('admin.kawasan.index') }}" class="text-[11px] font-semibold text-stone-700 hover:text-stone-900 hover:underline mt-2.5 inline-block">
                Kelola &rarr;
            </a>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-stone-200/80 shadow-sm flex flex-col justify-between">
            <div class="w-9 h-9 rounded-xl bg-stone-100 text-stone-700 flex items-center justify-center text-sm mb-3">
                <i class="fa-solid fa-dna"></i>
            </div>
            <div>
                <div class="text-xl font-bold text-stone-900">{{ $totalPrimata }}</div>
                <div class="text-[11px] font-semibold text-stone-500 uppercase tracking-wider mt-0.5">Satwa Primata</div>
            </div>
            <a href="{{ route('admin.primata.index') }}" class="text-[11px] font-semibold text-stone-700 hover:text-stone-900 hover:underline mt-2.5 inline-block">
                Katalog &rarr;
            </a>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-stone-200/80 shadow-sm flex flex-col justify-between">
            <div class="w-9 h-9 rounded-xl bg-stone-100 text-stone-700 flex items-center justify-center text-sm mb-3">
                <i class="fa-solid fa-seedling"></i>
            </div>
            <div>
                <div class="text-xl font-bold text-stone-900">{{ $totalTumbuhan }}</div>
                <div class="text-[11px] font-semibold text-stone-500 uppercase tracking-wider mt-0.5">Tumbuhan Rimba</div>
            </div>
            <a href="{{ route('admin.tumbuhan.index') }}" class="text-[11px] font-semibold text-stone-700 hover:text-stone-900 hover:underline mt-2.5 inline-block">
                Katalog &rarr;
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-12 bg-white p-5 rounded-2xl border border-stone-200/80 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-stone-900">Grafik Laporan Masuk</h2>
                    <p class="text-[11px] text-stone-500 mt-0.5">Tren jumlah laporan warga selama 6 bulan terakhir</p>
                </div>
                <span class="text-[11px] font-semibold text-stone-600 bg-stone-100 px-2.5 py-0.5 rounded-full border border-stone-200">
                    6 Bulan
                </span>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 pt-1">
                @foreach ($grafikBulanan as $gb)
                    <div class="space-y-1.5 p-3 rounded-xl bg-stone-50/60 border border-stone-200/80">
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-semibold text-stone-700">{{ $gb['label'] }}</span>
                            <span class="font-bold text-stone-900">{{ $gb['jumlah'] }}</span>
                        </div>
                        <div class="w-full h-2.5 bg-stone-200 rounded-full overflow-hidden">
                            <div class="h-full bg-stone-800 rounded-full transition-all duration-500" style="width: {{ max(4, $gb['persen']) }}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="lg:col-span-6 bg-white p-5 rounded-2xl border border-stone-200/80 shadow-sm space-y-4">
            <div>
                <h2 class="text-sm sm:text-base font-bold text-stone-900">Kabupaten/Kota Paling Rawan</h2>
                <p class="text-[11px] text-stone-500 mt-0.5">5 kabupaten/kota di Jawa Barat dengan laporan kebakaran terbanyak</p>
            </div>

            <div class="space-y-2.5">
                @forelse ($kabupatenRawan as $idx => $kr)
                    <div class="p-3 rounded-xl bg-stone-50/60 border border-stone-200/80 flex items-center justify-between">
                        <div class="flex items-center space-x-3 min-w-0">
                            <span class="w-6 h-6 rounded-full bg-stone-100 border border-stone-300 text-stone-800 flex items-center justify-center text-xs font-bold shrink-0">
                                {{ $idx + 1 }}
                            </span>
                            <div class="min-w-0">
                                <div class="text-xs font-semibold text-stone-900 truncate">{{ $kr->nama }}</div>
                                <div class="text-[10px] text-stone-500">{{ $kr->tipe }} di Jawa Barat</div>
                            </div>
                        </div>
                        <span class="text-xs font-semibold text-stone-900 shrink-0">
                            {{ $kr->laporan_count }} Kasus
                        </span>
                    </div>
                @empty
                    <div class="text-xs text-stone-400 text-center py-6">
                        Belum ada data kabupaten/kota.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="lg:col-span-6 bg-white p-5 rounded-2xl border border-stone-200/80 shadow-sm space-y-4">
            <div>
                <h2 class="text-sm sm:text-base font-bold text-stone-900">Kawasan Hutan Paling Rawan</h2>
                <p class="text-[11px] text-stone-500 mt-0.5">5 kawasan dengan frekuensi laporan kebakaran terbanyak</p>
            </div>

            <div class="space-y-2.5">
                @forelse ($kawasanRawan as $idx => $kr)
                    <div class="p-3 rounded-xl bg-stone-50/60 border border-stone-200/80 flex items-center justify-between">
                        <div class="flex items-center space-x-3 min-w-0">
                            <span class="w-6 h-6 rounded-full bg-stone-100 border border-stone-300 text-stone-800 flex items-center justify-center text-xs font-bold shrink-0">
                                {{ $idx + 1 }}
                            </span>
                            <div class="min-w-0">
                                <div class="text-xs font-semibold text-stone-900 truncate">{{ $kr->nama }}</div>
                                <div class="text-[10px] text-stone-500">{{ $kr->luas_ha ? $kr->luas_ha . ' ha' : 'Luas belum tercatat' }}</div>
                            </div>
                        </div>
                        <span class="text-xs font-semibold text-stone-900 shrink-0">
                            {{ $kr->laporan_count }} Kasus
                        </span>
                    </div>
                @empty
                    <div class="text-xs text-stone-400 text-center py-6">
                        Belum ada data kawasan hutan.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-stone-200/80 shadow-sm overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-stone-100 flex items-center justify-between">
            <div>
                <h2 class="text-sm sm:text-base font-bold text-stone-900">5 Laporan Terakhir dari Warga</h2>
                <p class="text-[11px] text-stone-500 mt-0.5">Pantauan laporan darurat terbaru yang masuk ke sistem</p>
            </div>
            <a href="{{ route('admin.laporan.index') }}" class="text-xs font-semibold text-stone-700 hover:text-stone-900 flex items-center">
                <span>Kelola Semua Laporan</span>
                <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm divide-y divide-stone-200/80">
                <thead class="bg-stone-50/90 text-stone-600 uppercase text-[11px] font-bold tracking-wider">
                    <tr>
                        <th class="py-3 px-4 whitespace-nowrap">Kode</th>
                        <th class="py-3 px-4 whitespace-nowrap">Jenis Kejadian</th>
                        <th class="py-3 px-4 whitespace-nowrap">Waktu Lapor</th>
                        <th class="py-3 px-4 whitespace-nowrap">Status</th>
                        <th class="py-3 px-4 text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 text-stone-700 bg-white">
                    @forelse ($laporanTerbaru as $lap)
                        <tr class="hover:bg-stone-50 transition-colors">
                            <td class="py-3.5 px-4 font-mono font-bold text-xs text-stone-900 whitespace-nowrap">
                                <a href="{{ route('admin.laporan.show', $lap->id) }}" class="hover:underline">
                                    {{ $lap->kode }}
                                </a>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="font-semibold text-stone-900 text-xs">
                                    {{ $lap->jenis === 'Kebakaran' ? 'Kebakaran' : 'Hewan Masuk' }}
                                </span>
                                @if ($lap->jenis_hewan)
                                    <span class="text-[11px] text-stone-500 ml-1">({{ $lap->jenis_hewan }})</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-xs text-stone-600 whitespace-nowrap">
                                {{ $lap->created_at ? $lap->created_at->format('d M Y, H:i') : '-' }} WIB
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="text-xs font-semibold text-stone-900">
                                    {{ $lap->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <a href="{{ route('admin.laporan.show', $lap->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 border border-stone-300 rounded-lg text-xs font-semibold transition">
                                    <i class="fa-solid fa-eye text-[11px] text-stone-600"></i>
                                    <span>Detail</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-stone-400">
                                Belum ada laporan masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
