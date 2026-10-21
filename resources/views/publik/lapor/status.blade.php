@extends('layouts.publik')

@section('title', 'Cek Status Laporan')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 text-green-700 rounded-3xl mb-4 text-2xl shadow-sm">
            <i class="fa-solid fa-magnifying-glass-location"></i>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-stone-900 tracking-tight">Cek Status Laporan</h1>
        <p class="text-stone-500 text-xs sm:text-sm mt-1 max-w-md mx-auto">
            Pantau tindak lanjut laporan darurat Anda dengan memasukkan kode laporan yang telah diberikan.
        </p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-stone-100 p-6 sm:p-8 mb-8">
        <form method="GET" action="{{ route('lapor.status') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-stone-400">
                    <i class="fa-solid fa-ticket"></i>
                </span>
                <input type="text" name="kode" value="{{ $kodeCari }}" required placeholder="Masukkan kode laporan (Contoh: JHD-AB34XY)" class="w-full pl-11 pr-4 py-3 rounded-2xl border border-stone-200 text-sm focus:border-green-600 outline-none uppercase font-mono tracking-wider transition">
            </div>
            <button type="submit" class="px-8 py-3 bg-green-700 hover:bg-green-600 text-white font-bold rounded-2xl text-sm transition shadow active:scale-95 shrink-0 flex items-center justify-center space-x-2">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span>Cek Laporan</span>
            </button>
        </form>

        @if ($pesanError)
            <div class="mt-4 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs sm:text-sm flex items-center space-x-2">
                <i class="fa-solid fa-triangle-exclamation text-rose-500 text-base"></i>
                <span>{{ $pesanError }}</span>
            </div>
        @endif
    </div>

    @if ($laporan)
        <div class="bg-white rounded-3xl shadow-sm border border-stone-100 p-6 sm:p-8 mb-8 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-stone-100 gap-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-stone-400 block mb-1">Kode Laporan</span>
                    <span class="text-2xl font-black font-mono text-stone-900 tracking-wider">{{ $laporan->kode }}</span>
                </div>
                <div>
                    @if ($laporan->status === 'Baru')
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black bg-rose-100 text-rose-800">
                            <span class="w-2 h-2 rounded-full bg-rose-600 mr-2 animate-pulse"></span> Baru (Menunggu Verifikasi)
                        </span>
                    @elseif ($laporan->status === 'Diverifikasi')
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black bg-amber-100 text-amber-800">
                            <span class="w-2 h-2 rounded-full bg-amber-600 mr-2"></span> Diverifikasi (Valid)
                        </span>
                    @elseif ($laporan->status === 'Ditangani')
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black bg-sky-100 text-sky-800">
                            <span class="w-2 h-2 rounded-full bg-sky-600 mr-2"></span> Sedang Ditangani Petugas
                        </span>
                    @else
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black bg-emerald-100 text-emerald-800">
                            <i class="fa-solid fa-check mr-2"></i> Penanganan Selesai
                        </span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs sm:text-sm">
                <div>
                    <span class="text-stone-400 text-xs block mb-1">Jenis Kejadian</span>
                    <div class="font-bold text-stone-800 flex items-center">
                        @if ($laporan->jenis === 'Kebakaran')
                            <i class="fa-solid fa-fire text-red-600 mr-2"></i>
                        @elseif ($laporan->jenis === 'Hewan Masuk Kampung')
                            <i class="fa-solid fa-paw text-amber-600 mr-2"></i>
                        @elseif ($laporan->jenis === 'Orang Hilang')
                            <i class="fa-solid fa-person-hiking text-sky-600 mr-2"></i>
                        @else
                            <i class="fa-solid fa-triangle-exclamation text-stone-600 mr-2"></i>
                        @endif
                        <span>{{ $laporan->jenis }}</span>
                        @if ($laporan->jenis === 'Hewan Masuk Kampung' && $laporan->jenis_hewan)
                            <span class="text-stone-500 font-normal ml-1">({{ $laporan->jenis_hewan }})</span>
                        @elseif ($laporan->jenis === 'Orang Hilang' && !empty($laporan->detail_kejadian['nama_korban']))
                            <span class="text-stone-500 font-normal ml-1">({{ $laporan->detail_kejadian['nama_korban'] }})</span>
                        @elseif ($laporan->jenis === 'Lainnya' && !empty($laporan->detail_kejadian['kategori_lainnya']))
                            <span class="text-stone-500 font-normal ml-1">({{ $laporan->detail_kejadian['kategori_lainnya'] }})</span>
                        @endif
                    </div>
                </div>

                <div>
                    <span class="text-stone-400 text-xs block mb-1">Waktu Pelaporan</span>
                    <div class="font-medium text-stone-700">
                        {{ \Carbon\Carbon::parse($laporan->created_at)->locale('id')->isoFormat('dddd, D MMMM Y - HH:mm') }} WIB
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <span class="text-stone-400 text-xs block mb-1">Deskripsi Warga</span>

                    @if ($laporan->deskripsi_terstruktur['is_structured'])
                        <div class="overflow-hidden rounded-xl border border-stone-200/80 bg-white">
                            <table class="w-full text-left text-xs">
                                <tbody class="divide-y divide-stone-100">
                                    @foreach ($laporan->deskripsi_terstruktur['items'] as $item)
                                        <tr class="transition-colors hover:bg-stone-50/40">
                                            <td class="w-36 sm:w-44 px-3 py-1.5 bg-stone-50/70 text-stone-500 font-medium text-xs align-top border-r border-stone-100 whitespace-nowrap">{{ $item['label'] }}</td>
                                            <td class="px-3 py-1.5 text-stone-800 font-semibold text-xs align-top leading-normal"><span class="whitespace-pre-line">{{ trim($item['value']) }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="px-3.5 py-2 rounded-xl bg-stone-50 border border-stone-200/70 text-stone-800 font-medium text-xs sm:text-sm leading-normal whitespace-pre-line">{{ trim($laporan->deskripsi) }}</div>
                    @endif
                </div>

                @if ($laporan->detail_kejadian && is_array($laporan->detail_kejadian) && count($laporan->detail_kejadian) > 0)
                    <div class="sm:col-span-2">
                        <span class="text-stone-400 text-xs block mb-2 font-bold uppercase tracking-wider">Rincian Tambahan Kejadian</span>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                            @foreach ($laporan->detail_kejadian as $kunci => $nilai)
                                @if (!empty($nilai))
                                    <div class="p-3 rounded-xl bg-stone-50 border border-stone-100">
                                        <span class="text-stone-400 text-[11px] block capitalize">{{ str_replace('_', ' ', $kunci) }}</span>
                                        <span class="font-semibold text-stone-800">{{ $nilai }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($laporan->foto)
                    <div class="sm:col-span-2">
                        <span class="text-stone-400 text-xs block mb-2">Foto Kejadian Terlampir</span>
                        <div class="w-full max-w-sm rounded-2xl overflow-hidden border border-stone-200 shadow-sm">
                            <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Foto Laporan" class="w-full h-auto object-cover">
                        </div>
                    </div>
                @endif

                <div class="sm:col-span-2 pt-2">
                    <span class="text-stone-400 text-xs block mb-1 font-bold uppercase tracking-wider">Catatan Petugas / Tindak Lanjut</span>
                    <div class="p-4 rounded-2xl {{ $laporan->catatan_admin ? 'bg-green-50 border border-green-200 text-green-900' : 'bg-stone-50 text-stone-500' }} text-xs sm:text-sm">
                        @if ($laporan->catatan_admin)
                            <div class="flex items-start space-x-2.5">
                                <i class="fa-solid fa-clipboard-check text-green-700 mt-0.5 text-base shrink-0"></i>
                                <div>
                                    <span class="font-bold block mb-1">Tanggapan Administrator Satgas:</span>
                                    <p class="leading-relaxed">{{ $laporan->catatan_admin }}</p>
                                </div>
                            </div>
                        @else
                            <p class="italic">Belum ada catatan tindak lanjut dari petugas.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-stone-100 p-6 sm:p-8">
        <h2 class="text-base font-bold text-stone-900 mb-2 flex items-center">
            <i class="fa-solid fa-clock-rotate-left text-green-700 mr-2.5"></i>
            <span>Riwayat Laporan di Perangkat Ini</span>
        </h2>
        <p class="text-xs text-stone-400 mb-4">Daftar kode laporan yang pernah dikirim melalui peramban atau perangkat HP ini.</p>

        <div id="wadah-riwayat-perangkat" class="space-y-2">
            <p class="text-xs text-stone-400 italic" id="pesan-riwayat-kosong">Tidak ada riwayat laporan tersimpan di perangkat ini.</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var raw = localStorage.getItem('kodeLaporanSaya');
    if (!raw) return;

    var daftar = [];
    try {
        daftar = JSON.parse(raw);
    } catch (e) {
        return;
    }

    if (Array.isArray(daftar) && daftar.length > 0) {
        var wadah = document.getElementById('wadah-riwayat-perangkat');
        var pesanKosong = document.getElementById('pesan-riwayat-kosong');
        if (pesanKosong) pesanKosong.remove();

        daftar.forEach(function (item) {
            var el = document.createElement('a');
            el.href = '/lapor/status?kode=' + encodeURIComponent(item.kode);
            el.className = 'flex items-center justify-between p-3.5 rounded-2xl bg-stone-50 hover:bg-green-50 border border-stone-200 hover:border-green-300 transition text-xs group';

            var iconClass = item.jenis === 'Kebakaran' ? 'fa-fire text-red-600' : 'fa-paw text-amber-600';

            el.innerHTML = '<div class="flex items-center space-x-3">' +
                '<i class="fa-solid ' + iconClass + ' text-base"></i>' +
                '<div>' +
                '<span class="font-mono font-bold text-stone-900 group-hover:text-green-800 text-sm tracking-wider">' + item.kode + '</span>' +
                '<span class="text-stone-400 text-[11px] ml-2">(' + (item.jenis || 'Laporan') + ')</span>' +
                '</div>' +
                '</div>' +
                '<span class="text-stone-400 group-hover:text-green-700 text-xs font-semibold flex items-center">' +
                '<span>Lihat Status</span>' +
                '<i class="fa-solid fa-chevron-right ml-1 text-[10px]"></i>' +
                '</span>';

            wadah.appendChild(el);
        });
    }
});
</script>
@endsection
