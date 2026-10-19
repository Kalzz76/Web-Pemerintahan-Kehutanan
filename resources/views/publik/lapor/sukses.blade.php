@extends('layouts.publik')

@section('title', 'Laporan Terkirim')

@section('content')
<div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20 text-center">
    <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-3xl flex items-center justify-center mx-auto mb-6 text-3xl shadow-sm">
        <i class="fa-solid fa-circle-check"></i>
    </div>

    <h1 class="text-2xl sm:text-3xl font-black text-stone-900 tracking-tight mb-2">Laporan Berhasil Dikirim!</h1>
    <p class="text-stone-500 text-xs sm:text-sm mb-8 max-w-md mx-auto leading-relaxed">
        Laporan darurat Anda telah masuk ke sistem. Tim satgas desa dan petugas terkait akan segera menindaklanjuti.
    </p>

    <div class="bg-white rounded-3xl shadow-sm border border-stone-100 p-8 mb-8 space-y-4">
        <span class="text-xs font-bold uppercase tracking-wider text-stone-400 block">Kode Laporan Anda</span>
        <div class="text-3xl sm:text-4xl font-black font-mono text-stone-900 tracking-wider bg-stone-50 py-4 px-6 rounded-2xl border border-stone-200 select-all" id="teks-kode">
            {{ $laporan->kode }}
        </div>

        <button type="button" onclick="salinKode()" id="tombol-salin" class="px-5 py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-700 font-semibold rounded-xl text-xs transition inline-flex items-center space-x-2">
            <i class="fa-regular fa-copy"></i>
            <span id="label-salin">Salin Kode Laporan</span>
        </button>

        <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs text-left flex items-start space-x-2.5 mt-4">
            <i class="fa-solid fa-triangle-exclamation text-amber-600 mt-0.5 text-sm shrink-0"></i>
            <p>
                <strong>Penting:</strong> Simpan kode ini untuk mengecek status tindak lanjut penanganan laporan Anda di menu Cek Status Laporan.
            </p>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
        <a href="{{ route('lapor.status', ['kode' => $laporan->kode]) }}" class="w-full sm:w-auto px-6 py-3.5 bg-green-700 hover:bg-green-600 text-white font-bold rounded-xl shadow transition text-xs sm:text-sm flex items-center justify-center space-x-2">
            <i class="fa-solid fa-magnifying-glass"></i>
            <span>Cek Status Laporan Ini</span>
        </a>
        <a href="{{ route('beranda') }}" class="w-full sm:w-auto px-6 py-3.5 bg-stone-100 hover:bg-stone-200 text-stone-700 font-bold rounded-xl transition text-xs sm:text-sm">
            Kembali ke Beranda
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var kode = '{{ $laporan->kode }}';
    var jenis = '{{ $laporan->jenis }}';

    var riwayat = [];
    try {
        var raw = localStorage.getItem('kodeLaporanSaya');
        if (raw) riwayat = JSON.parse(raw);
    } catch (e) {}

    var sudahAda = riwayat.some(function (r) {
        return r.kode === kode;
    });

    if (!sudahAda) {
        riwayat.unshift({
            kode: kode,
            jenis: jenis,
            waktu: new Date().toISOString()
        });
        localStorage.setItem('kodeLaporanSaya', JSON.stringify(riwayat));
    }
});

function salinKode() {
    var kode = document.getElementById('teks-kode').innerText.trim();
    if (navigator.clipboard) {
        navigator.clipboard.writeText(kode).then(function () {
            document.getElementById('label-salin').innerText = 'Kode Berhasil Disalin!';
            setTimeout(function () {
                document.getElementById('label-salin').innerText = 'Salin Kode Laporan';
            }, 3000);
        });
    } else {
        alert('Silakan salin manual: ' + kode);
    }
}
</script>
@endsection
