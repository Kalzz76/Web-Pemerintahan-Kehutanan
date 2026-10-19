@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-2xl md:text-3xl font-black text-stone-900 tracking-tight">Ringkasan Sistem</h1>
        <p class="text-stone-500 text-sm mt-1">Pemantauan data lapangan, mitigasi karhutla, dan perlindungan keanekaragaman hayati desa.</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-stone-200 shadow-sm flex flex-col justify-between">
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg mb-3">
                <i class="fa-solid fa-bell"></i>
            </div>
            <div>
                <div class="text-2xl font-black text-stone-900">{{ $jumlahLaporanBaru }}</div>
                <div class="text-xs font-bold text-stone-500 uppercase tracking-wider mt-0.5">Laporan Baru</div>
            </div>
            <a href="{{ route('admin.laporan.index', ['status' => 'Baru']) }}" class="text-[11px] font-bold text-rose-600 hover:underline mt-3 inline-block">
                Tinjau Sekarang &rarr;
            </a>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-stone-200 shadow-sm flex flex-col justify-between">
            <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center text-lg mb-3">
                <i class="fa-solid fa-fire-flame-curved"></i>
            </div>
            <div>
                <div class="text-2xl font-black text-stone-900">{{ $kebakaranAktif }}</div>
                <div class="text-xs font-bold text-stone-500 uppercase tracking-wider mt-0.5">Kebakaran Aktif</div>
            </div>
            <a href="{{ route('admin.prediksi.index') }}" class="text-[11px] font-bold text-orange-600 hover:underline mt-3 inline-block">
                Buka Prediksi &rarr;
            </a>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-stone-200 shadow-sm flex flex-col justify-between">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg mb-3">
                <i class="fa-solid fa-paw"></i>
            </div>
            <div>
                <div class="text-2xl font-black text-stone-900">{{ $hewanBulanIni }}</div>
                <div class="text-xs font-bold text-stone-500 uppercase tracking-wider mt-0.5">Hewan Masuk Desa</div>
            </div>
            <span class="text-[11px] font-medium text-stone-400 mt-3 inline-block">Bulan Berjalan</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-stone-200 shadow-sm flex flex-col justify-between">
            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-700 flex items-center justify-center text-lg mb-3">
                <i class="fa-solid fa-mountain-sun"></i>
            </div>
            <div>
                <div class="text-2xl font-black text-stone-900">{{ $totalKawasan }}</div>
                <div class="text-xs font-bold text-stone-500 uppercase tracking-wider mt-0.5">Kawasan Hutan</div>
            </div>
            <a href="{{ route('admin.kawasan.index') }}" class="text-[11px] font-bold text-green-700 hover:underline mt-3 inline-block">
                Kelola Kawasan &rarr;
            </a>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-stone-200 shadow-sm flex flex-col justify-between">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-lg mb-3">
                <i class="fa-solid fa-dna"></i>
            </div>
            <div>
                <div class="text-2xl font-black text-stone-900">{{ $totalPrimata }}</div>
                <div class="text-xs font-bold text-stone-500 uppercase tracking-wider mt-0.5">Satwa Primata</div>
            </div>
            <a href="{{ route('admin.primata.index') }}" class="text-[11px] font-bold text-emerald-700 hover:underline mt-3 inline-block">
                Katalog Satwa &rarr;
            </a>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-stone-200 shadow-sm flex flex-col justify-between">
            <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center text-lg mb-3">
                <i class="fa-solid fa-seedling"></i>
            </div>
            <div>
                <div class="text-2xl font-black text-stone-900">{{ $totalTumbuhan }}</div>
                <div class="text-xs font-bold text-stone-500 uppercase tracking-wider mt-0.5">Tumbuhan Rimba</div>
            </div>
            <a href="{{ route('admin.tumbuhan.index') }}" class="text-[11px] font-bold text-teal-700 hover:underline mt-3 inline-block">
                Katalog Flora &rarr;
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-7 bg-white p-6 sm:p-7 rounded-3xl border border-stone-200 shadow-sm space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-black text-stone-900">Grafik Laporan Masuk</h2>
                    <p class="text-xs text-stone-500 mt-0.5">Tren jumlah laporan warga selama 6 bulan terakhir</p>
                </div>
                <span class="text-xs font-bold text-stone-400 bg-stone-100 px-3 py-1 rounded-full">
                    6 Bulan
                </span>
            </div>

            <div class="space-y-4 pt-2">
                @foreach ($grafikBulanan as $gb)
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-bold text-stone-700">{{ $gb['label'] }}</span>
                            <span class="font-black text-stone-900">{{ $gb['jumlah'] }} Laporan</span>
                        </div>
                        <div class="w-full h-4 bg-stone-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-green-600 to-green-500 rounded-full transition-all duration-500" style="width: {{ max(4, $gb['persen']) }}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="lg:col-span-5 bg-white p-6 sm:p-7 rounded-3xl border border-stone-200 shadow-sm space-y-6">
            <div>
                <h2 class="text-lg font-black text-stone-900">Kawasan Paling Rawan</h2>
                <p class="text-xs text-stone-500 mt-0.5">5 kawasan dengan frekuensi laporan kebakaran terbanyak</p>
            </div>

            <div class="space-y-3">
                @forelse ($kawasanRawan as $idx => $kr)
                    <div class="p-3.5 rounded-2xl bg-stone-50 border border-stone-100 flex items-center justify-between">
                        <div class="flex items-center space-x-3 min-w-0">
                            <span class="w-6 h-6 rounded-full {{ $idx === 0 ? 'bg-rose-600 text-white' : 'bg-stone-200 text-stone-700' }} flex items-center justify-center text-xs font-black shrink-0">
                                {{ $idx + 1 }}
                            </span>
                            <div class="min-w-0">
                                <div class="text-xs font-bold text-stone-900 truncate">{{ $kr->nama }}</div>
                                <div class="text-[10px] text-stone-500">{{ $kr->luas_ha ? $kr->luas_ha . ' ha' : 'Luas belum tercatat' }}</div>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-xl text-xs font-black {{ $kr->laporan_count > 0 ? 'bg-rose-100 text-rose-800' : 'bg-stone-100 text-stone-600' }} shrink-0">
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

    <div class="bg-white rounded-3xl border border-stone-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-stone-100 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-black text-stone-900">5 Laporan Terakhir dari Warga</h2>
                <p class="text-xs text-stone-500 mt-0.5">Pantauan laporan darurat terbaru yang masuk ke sistem</p>
            </div>
            <a href="{{ route('admin.laporan.index') }}" class="text-xs font-bold text-green-700 hover:text-green-800 flex items-center">
                <span>Kelola Semua Laporan</span>
                <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-stone-100 text-stone-700 uppercase text-xs">
                    <tr>
                        <th class="py-3 px-6">Kode</th>
                        <th class="py-3 px-6">Jenis Insiden</th>
                        <th class="py-3 px-6">Waktu Masuk</th>
                        <th class="py-3 px-6">Status</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($laporanTerbaru as $lap)
                        <tr class="hover:bg-stone-50 transition">
                            <td class="py-3.5 px-6 font-mono font-bold text-xs text-stone-800">
                                {{ $lap->kode }}
                            </td>
                            <td class="py-3.5 px-6">
                                @if ($lap->jenis === 'Kebakaran')
                                    <span class="inline-flex items-center text-xs font-bold text-rose-700">
                                        <i class="fa-solid fa-fire text-rose-600 mr-2"></i> Kebakaran Hutan
                                    </span>
                                @else
                                    <span class="inline-flex items-center text-xs font-bold text-amber-700">
                                        <i class="fa-solid fa-paw text-amber-600 mr-2"></i> {{ $lap->jenis_hewan ?? 'Hewan Masuk' }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-6 text-xs text-stone-500">
                                {{ $lap->created_at ? $lap->created_at->format('d M Y, H:i') : '-' }} WIB
                            </td>
                            <td class="py-3.5 px-6">
                                @if ($lap->status === 'Baru')
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800 animate-pulse">Baru</span>
                                @elseif ($lap->status === 'Diverifikasi')
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800">Diverifikasi</span>
                                @elseif ($lap->status === 'Ditangani')
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">Ditangani</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">Selesai</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-6 text-center">
                                <a href="{{ route('admin.laporan.show', $lap->id) }}" class="px-3 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-xl text-xs font-bold transition">
                                    Tinjau
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-stone-400">
                                Belum ada laporan warga yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
