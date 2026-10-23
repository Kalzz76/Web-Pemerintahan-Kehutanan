@extends('layouts.admin')

@section('title', 'Prediksi Kebakaran')

@section('content')
<style>
.custom-kebakaran-marker {
    background: transparent !important;
    border: none !important;
}
</style>
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
    <div>
        <h1 class="text-lg md:text-xl font-bold text-stone-900 tracking-tight">Prediksi Perambatan Kebakaran</h1>
        <p class="text-stone-500 text-xs mt-0.5">Simulasi perambatan elips api berbasis arah angin, kecepatan, kelembapan, dan tutupan lahan.</p>
    </div>

    <form method="POST" action="{{ route('admin.prediksi.ambil-satelit') }}">
        @csrf
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl text-xs sm:text-sm shadow-sm transition active:scale-95 shrink-0 space-x-1.5">
            <i class="fa-solid fa-satellite text-xs"></i>
            <span>Ambil Titik Api Satelit</span>
        </button>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 p-4 sm:p-5 mb-5 space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-stone-200/80 gap-2">
        <h2 class="text-sm font-bold text-stone-900 flex items-center">
            <i class="fa-solid fa-map-location-dot text-stone-700 mr-2"></i>
            <span>Peta Pantauan & Titik Api</span>
        </h2>
        <div class="flex flex-wrap items-center gap-3 text-xs text-stone-600">
            <span class="flex items-center"><span class="w-2.5 h-2.5 rounded-full bg-[#7e22ce] mr-1.5"></span> Satelit ({{ $daftarTitikApi->count() }})</span>
            <span class="flex items-center"><span class="w-2.5 h-2.5 rounded-full bg-[#dc2626] mr-1.5"></span> Laporan Api Aktif ({{ $daftarKebakaranAktif->count() }})</span>
            <span class="flex items-center"><span class="w-2.5 h-2.5 rounded-full bg-[#ca8a04] mr-1.5"></span> Permukiman</span>
            <span class="flex items-center"><span class="w-2.5 h-2.5 rounded-sm border-2 border-stone-800 bg-stone-200 mr-1.5"></span> Kawasan</span>
        </div>
    </div>

    @if ($daftarKebakaranAktif->count() > 0)
        <div class="p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-900 text-xs flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
            <div class="flex items-center space-x-2.5">
                <span class="relative flex h-3 w-3 shrink-0">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-600"></span>
                </span>
                <div>
                    <span class="font-bold">Ada {{ $daftarKebakaranAktif->count() }} Laporan Kebakaran Aktif dari Warga!</span>
                    <span class="text-stone-600 block sm:inline sm:ml-1">Ditandai dengan pin api merah di peta. Jika status laporan di Kelola Laporan diubah menjadi <strong>Selesai</strong>, titik api otomatis hilang dari peta.</span>
                </div>
            </div>
            <a href="{{ route('admin.laporan.index', ['jenis' => 'Kebakaran']) }}" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg text-[11px] transition text-center shrink-0">
                Kelola Laporan &rarr;
            </a>
        </div>
    @endif

    <div class="p-3 rounded-xl bg-stone-100 border border-stone-200 text-stone-700 text-xs flex items-center space-x-2">
        <i class="fa-solid fa-crosshairs text-stone-500 text-xs shrink-0"></i>
        <span>Klik pada titik api di peta atau klik koordinat mana saja untuk mengisi formulir simulasi di bawah.</span>
    </div>

    <livewire:peta-layar-penuh id-peta="peta-prediksi" tinggi="500px" />
</div>

@if ($prediksiAktif)
<div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 p-4 sm:p-5 mb-5 space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-stone-200/80 gap-3">
        <div>
            <span class="text-[11px] font-bold uppercase tracking-wider text-stone-500 block">Hasil Simulasi Terpilih</span>
            <h2 class="text-base font-bold text-stone-900 mt-0.5">Perkiraan Luasan & Poligon Perambatan</h2>
        </div>
        <div class="flex items-center space-x-2">
            <form method="POST" action="{{ route('admin.prediksi.toggle-publik', $prediksiAktif->id) }}">
                @csrf
                <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition flex items-center space-x-1.5 border {{ $prediksiAktif->tampil_publik ? 'bg-stone-100 hover:bg-stone-200 text-stone-800 border-stone-300' : 'bg-stone-900 hover:bg-stone-800 text-white border-transparent' }}">
                    <i class="fa-solid {{ $prediksiAktif->tampil_publik ? 'fa-eye-slash' : 'fa-bullhorn' }}"></i>
                    <span>{{ $prediksiAktif->tampil_publik ? 'Sembunyikan dari Publik' : 'Tampilkan ke Publik' }}</span>
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
        <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/80">
            <span class="text-xs text-stone-500 block mb-0.5">Laju Efektif Api</span>
            <span class="text-lg font-bold text-stone-900 font-mono">{{ $prediksiAktif->laju_efektif }} m/jam</span>
        </div>
        <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/80">
            <span class="text-xs text-stone-500 block mb-0.5">Poligon 1 Jam</span>
            <span class="text-lg font-bold text-stone-900 font-mono">{{ $prediksiAktif->luas_1jam }} ha</span>
        </div>
        <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/80">
            <span class="text-xs text-stone-500 block mb-0.5">Poligon 3 Jam</span>
            <span class="text-lg font-bold text-stone-900 font-mono">{{ $prediksiAktif->luas_3jam }} ha</span>
        </div>
        <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/80">
            <span class="text-xs text-stone-500 block mb-0.5">Poligon 6 Jam</span>
            <span class="text-lg font-bold text-stone-900 font-mono">{{ $prediksiAktif->luas_6jam }} ha</span>
        </div>
    </div>

    <div>
        <h3 class="text-xs font-bold uppercase tracking-wider text-stone-500 mb-2.5">Daftar Permukiman Warga Terancam</h3>
        @php
            $terancamList = json_decode($prediksiAktif->area_terancam, true) ?: [];
        @endphp
        @if (count($terancamList) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2.5">
                @foreach ($terancamList as $item)
                    <div class="p-3 rounded-xl border border-stone-200/80 bg-stone-50 flex items-center justify-between">
                        <div class="font-bold text-xs text-stone-900">{{ $item['nama'] }}</div>
                        <span class="text-xs font-semibold text-stone-700">
                            &le; {{ $item['jam'] }} Jam
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200 text-stone-600 text-xs flex items-center space-x-2">
                <i class="fa-solid fa-circle-check text-stone-500"></i>
                <span>Tidak ada titik permukiman warga yang berada dalam radius perkiraan perambatan api hingga 6 jam ke depan.</span>
            </div>
        @endif
    </div>
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 p-4 sm:p-5 mb-5 space-y-5">
    <div class="pb-3 border-b border-stone-200/80">
        <h2 class="text-sm font-bold text-stone-900 flex items-center">
            <i class="fa-solid fa-calculator text-stone-700 mr-2"></i>
            <span>Formulir Perhitungan Prediksi</span>
        </h2>
        <p class="text-stone-500 text-xs mt-0.5">Tentukan koordinat titik api dan ambil parameter cuaca secara otomatis.</p>
    </div>

    <form method="POST" action="{{ route('admin.prediksi.hitung') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="id_laporan" value="{{ old('id_laporan', $inputIdLaporan) }}">

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
            <div>
                <label for="latitude" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Latitude Titik Api</label>
                <input type="number" step="0.0000001" id="latitude" name="latitude" value="{{ old('latitude', $inputLat ?? $pengaturan->lat_pusat) }}" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition font-mono">
            </div>

            <div>
                <label for="longitude" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Longitude Titik Api</label>
                <input type="number" step="0.0000001" id="longitude" name="longitude" value="{{ old('longitude', $inputLong ?? $pengaturan->long_pusat) }}" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition font-mono">
            </div>

            <div>
                <label for="id_jenis_lahan" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Jenis Tutupan Lahan</label>
                <select id="id_jenis_lahan" name="id_jenis_lahan" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition bg-white">
                    @foreach ($daftarJenisLahan as $jl)
                        <option value="{{ $jl->id }}" {{ old('id_jenis_lahan') == $jl->id ? 'selected' : '' }}>
                            {{ $jl->nama }} (Laju: {{ $jl->laju_dasar }} m/jam)
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/80 space-y-3">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                <span class="text-xs font-bold uppercase tracking-wider text-stone-600">Parameter Cuaca & Angin</span>
                <button type="button" onclick="ambilDataCuaca()" id="tombol-cuaca" class="px-3.5 py-1.5 rounded-xl bg-stone-900 hover:bg-stone-800 text-white font-semibold text-xs transition shadow-sm flex items-center justify-center space-x-1.5 active:scale-95 shrink-0">
                    <i class="fa-solid fa-cloud-bolt text-xs"></i>
                    <span id="label-tombol-cuaca">Ambil Data Cuaca</span>
                </button>
            </div>

            <div id="pesan-cuaca" class="hidden text-xs p-2.5 rounded-xl"></div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <div>
                    <label for="arah_angin" class="block text-[11px] font-bold text-stone-600 mb-1">Arah Asal Angin (°)</label>
                    <input type="number" step="0.1" min="0" max="360" id="arah_angin" name="arah_angin" value="{{ old('arah_angin', 45) }}" required class="w-full px-3 py-1.5 rounded-xl border border-stone-200 text-xs focus:border-stone-900 outline-none font-mono">
                    <p class="text-[10px] text-stone-400 mt-0.5">Api merambat (+180°)</p>
                </div>

                <div>
                    <label for="kecepatan_angin" class="block text-[11px] font-bold text-stone-600 mb-1">Kecepatan Angin (km/jam)</label>
                    <input type="number" step="0.1" min="0" id="kecepatan_angin" name="kecepatan_angin" value="{{ old('kecepatan_angin', 10) }}" required class="w-full px-3 py-1.5 rounded-xl border border-stone-200 text-xs focus:border-stone-900 outline-none font-mono">
                </div>

                <div>
                    <label for="kelembapan" class="block text-[11px] font-bold text-stone-600 mb-1">Kelembapan Udara (%)</label>
                    <input type="number" step="0.1" min="0" max="100" id="kelembapan" name="kelembapan" value="{{ old('kelembapan', 65) }}" required class="w-full px-3 py-1.5 rounded-xl border border-stone-200 text-xs focus:border-stone-900 outline-none font-mono">
                </div>

                <div>
                    <label for="curah_hujan" class="block text-[11px] font-bold text-stone-600 mb-1">Curah Hujan (mm)</label>
                    <input type="number" step="0.1" min="0" id="curah_hujan" name="curah_hujan" value="{{ old('curah_hujan', 0) }}" required class="w-full px-3 py-1.5 rounded-xl border border-stone-200 text-xs focus:border-stone-900 outline-none font-mono">
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-1">
            <span class="text-[11px] text-stone-400">Hasil ini perkiraan sederhana dan bukan pengganti keputusan petugas lapangan.</span>
            <button type="submit" class="px-5 py-2.5 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl shadow-sm transition text-xs sm:text-sm flex items-center justify-center space-x-1.5 active:scale-95 shrink-0">
                <i class="fa-solid fa-play text-xs"></i>
                <span>Hitung Prediksi</span>
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 p-4 sm:p-5 space-y-4">
    <h2 class="text-sm font-bold text-stone-900 pb-3 border-b border-stone-200/80 flex items-center">
        <i class="fa-solid fa-clock-rotate-left text-stone-700 mr-2"></i>
        <span>Riwayat Prediksi Kebakaran</span>
    </h2>

    @if ($riwayatPrediksi->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-stone-50/90 text-stone-600 uppercase text-[11px] font-bold tracking-wider">
                        <th class="px-4 py-3.5">Waktu</th>
                        <th class="px-4 py-3.5">Koordinat & Lahan</th>
                        <th class="px-4 py-3.5">Laju Efektif</th>
                        <th class="px-4 py-3.5">Luas (1h / 3h / 6h)</th>
                        <th class="px-4 py-3.5">Permukiman Terancam</th>
                        <th class="px-4 py-3.5">Status Publik</th>
                        <th class="px-4 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-200/70 text-stone-700">
                    @foreach ($riwayatPrediksi as $rp)
                        @php
                            $listTerancam = json_decode($rp->area_terancam, true) ?: [];
                        @endphp
                        <tr class="hover:bg-stone-50/80 transition">
                            <td class="px-4 py-3.5 whitespace-nowrap">
                                <div class="font-bold text-stone-900 text-xs sm:text-sm">{{ \Carbon\Carbon::parse($rp->created_at)->locale('id')->isoFormat('D MMM Y') }}</div>
                                <div class="text-[11px] text-stone-400">{{ \Carbon\Carbon::parse($rp->created_at)->format('H:i') }} WIB</div>
                            </td>
                            <td class="px-4 py-3.5 text-xs">
                                <div class="font-mono text-[11px] text-stone-800">{{ number_format($rp->latitude, 4) }}, {{ number_format($rp->longitude, 4) }}</div>
                                <div class="text-[10px] text-stone-500 font-semibold">{{ $rp->jenisLahan->nama ?? '-' }}</div>
                            </td>
                            <td class="px-4 py-3.5 font-mono font-bold text-xs text-stone-800">
                                {{ $rp->laju_efektif }} m/jam
                            </td>
                            <td class="px-4 py-3.5 font-mono text-xs whitespace-nowrap text-stone-800">
                                <span>{{ $rp->luas_1jam }}</span> /
                                <span>{{ $rp->luas_3jam }}</span> /
                                <span>{{ $rp->luas_6jam }}</span> ha
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap">
                                @if (count($listTerancam) > 0)
                                    <span class="text-xs font-semibold text-stone-900">
                                        {{ count($listTerancam) }} Permukiman
                                    </span>
                                @else
                                    <span class="text-stone-400 text-xs">Aman</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap">
                                @if ($rp->tampil_publik)
                                    <span class="text-xs font-semibold text-stone-900">
                                        Publik
                                    </span>
                                @else
                                    <span class="text-xs text-stone-400 font-medium">
                                        Internal
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-right space-x-1.5 whitespace-nowrap">
                                <a href="{{ route('admin.prediksi.index', ['id_prediksi' => $rp->id]) }}" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 border border-stone-300 font-semibold rounded-lg text-xs transition">
                                    Lihat
                                </a>
                                <form method="POST" action="{{ route('admin.prediksi.toggle-publik', $rp->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 border border-stone-300 font-semibold rounded-lg text-xs transition">
                                        {{ $rp->tampil_publik ? 'Sembunyi' : 'Publik' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.prediksi.destroy', $rp->id) }}" class="inline" data-confirm="Apakah Anda yakin ingin menghapus riwayat prediksi ini?" data-confirm-title="Hapus Prediksi" data-confirm-ok="Ya, Hapus">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-white hover:bg-stone-100 text-stone-700 hover:text-stone-900 border border-stone-300 font-semibold rounded-lg text-xs transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pt-3 border-t border-stone-200/80">
            {{ $riwayatPrediksi->links() }}
        </div>
    @else
        <div class="p-8 text-center text-stone-400">
            <i class="fa-solid fa-fire text-3xl mb-2 text-stone-300 block"></i>
            <p class="text-xs font-medium">Belum ada riwayat simulasi prediksi kebakaran.</p>
        </div>
    @endif
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>

<script>
var map;
var markerTitikApi = null;

function ambilDataCuaca() {
    var lat = document.getElementById('latitude').value;
    var lng = document.getElementById('longitude').value;
    var btn = document.getElementById('tombol-cuaca');
    var label = document.getElementById('label-tombol-cuaca');
    var pesan = document.getElementById('pesan-cuaca');

    if (!lat || !lng) {
        alert('Tentukan koordinat Latitude dan Longitude terlebih dahulu.');
        return;
    }

    label.innerText = 'Mengambil Cuaca...';
    btn.disabled = true;
    pesan.classList.add('hidden');

    fetch('{{ route("admin.prediksi.ambil-cuaca") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ latitude: lat, longitude: lng })
    })
    .then(function (res) {
        return res.json();
    })
    .then(function (data) {
        btn.disabled = false;
        label.innerText = 'Ambil Data Cuaca (Open-Meteo)';

        if (data.sukses) {
            document.getElementById('arah_angin').value = data.arah_angin;
            document.getElementById('kecepatan_angin').value = data.kecepatan_angin;
            document.getElementById('kelembapan').value = data.kelembapan;
            document.getElementById('curah_hujan').value = data.curah_hujan;

            pesan.className = 'text-xs p-3 rounded-xl bg-stone-100 text-stone-800 border border-stone-300 block';
            pesan.innerHTML = '<i class="fa-solid fa-circle-check mr-1.5"></i> Data cuaca berhasil diperbarui: Suhu ' + data.suhu + '°C, Kecepatan Angin ' + data.kecepatan_angin + ' km/jam, Arah ' + data.arah_angin + '°.';
        } else {
            pesan.className = 'text-xs p-3 rounded-xl bg-stone-100 text-stone-800 border border-stone-300 block';
            pesan.innerHTML = '<i class="fa-solid fa-triangle-exclamation mr-1.5"></i> ' + (data.pesan || 'Gagal mengambil data cuaca.');
        }
    })
    .catch(function () {
        btn.disabled = false;
        label.innerText = 'Ambil Data Cuaca (Open-Meteo)';
        pesan.className = 'text-xs p-3 rounded-xl bg-stone-100 text-stone-800 border border-stone-300 block';
        pesan.innerHTML = '<i class="fa-solid fa-triangle-exclamation mr-1.5"></i> Gagal menghubungi layanan Open-Meteo. Silakan masukkan parameter cuaca secara manual.';
    });
}

function pasangTitikSimulasi(lat, lng, idLaporan = null) {
    document.getElementById('latitude').value = parseFloat(lat).toFixed(7);
    document.getElementById('longitude').value = parseFloat(lng).toFixed(7);

    var inputIdLaporan = document.querySelector('input[name="id_laporan"]');
    if (inputIdLaporan) {
        inputIdLaporan.value = idLaporan ? idLaporan : '';
    }

    if (markerTitikApi) {
        markerTitikApi.setLatLng([lat, lng]);
    } else {
        markerTitikApi = L.circleMarker([lat, lng], {
            radius: 11,
            color: '#1c1917',
            fillColor: '#ef4444',
            fillOpacity: 1,
            weight: 3
        }).addTo(map);
    }
}

function inisialisasiPetaPrediksi() {
    var petaEl = document.getElementById('peta-prediksi');
    if (!petaEl || petaEl._leaflet_id) return;

    var latPusat = {{ $pengaturan->lat_pusat ?? -6.87 }};
    var longPusat = {{ $pengaturan->long_pusat ?? 107.60 }};
    var zoomAwal = {{ $pengaturan->zoom_awal ?? 8 }};

    var batasJabar = L.latLngBounds(L.latLng(-7.9, 106.3), L.latLng(-5.9, 108.9));
    map = L.map('peta-prediksi', {
        maxBounds: batasJabar,
        minZoom: 7
    }).setView([latPusat, longPusat], zoomAwal);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var dataKawasan = @json($daftarKawasan);
    dataKawasan.forEach(function (k) {
        if (k.geojson) {
            try {
                var parsed = JSON.parse(k.geojson);
                var p = L.geoJSON(parsed, {
                    style: {
                        color: '#15803d',
                        fillColor: '#15803d',
                        fillOpacity: 0.15,
                        weight: 2
                    }
                }).addTo(map);
                p.bindTooltip(k.nama, { sticky: true });
            } catch (e) {}
        }
    });

    var dataPermukiman = @json($daftarPermukiman);
    dataPermukiman.forEach(function (pm) {
        var marker = L.circleMarker([pm.latitude, pm.longitude], {
            radius: 8,
            color: '#ca8a04',
            fillColor: '#ca8a04',
            fillOpacity: 0.9,
            weight: 2
        }).addTo(map);
        marker.bindPopup('<strong>' + pm.nama + '</strong><br><span class="text-xs text-stone-500">Permukiman Warga</span>');
    });

    var dataTitikApi = @json($daftarTitikApi);
    dataTitikApi.forEach(function (ta) {
        var marker = L.circleMarker([ta.latitude, ta.longitude], {
            radius: 8,
            color: '#7e22ce',
            fillColor: '#7e22ce',
            fillOpacity: 0.9,
            weight: 2
        }).addTo(map);
        var waktuText = ta.waktu_deteksi ? ta.waktu_deteksi : '';
        marker.bindPopup('<strong>Titik Api Satelit (FIRMS)</strong><br><span class="text-xs">Waktu: ' + ta.tanggal_deteksi + ' ' + waktuText + '</span><br><button onclick="pasangTitikSimulasi(' + ta.latitude + ',' + ta.longitude + ', null)" class="text-xs text-stone-900 font-bold underline mt-1">Gunakan Titik Ini</button>');
    });

    var dataKebakaran = @json($daftarKebakaranAktif);
    dataKebakaran.forEach(function (kb) {
        var fireIcon = L.divIcon({
            className: 'custom-kebakaran-marker',
            html: '<div class="relative flex items-center justify-center w-8 h-8 rounded-full bg-red-600 text-white shadow-lg ring-4 ring-red-200 cursor-pointer transition hover:scale-110"><i class="fa-solid fa-fire text-sm"></i></div>',
            iconSize: [32, 32],
            iconAnchor: [16, 16],
            popupAnchor: [0, -16]
        });

        var marker = L.marker([kb.latitude, kb.longitude], { icon: fireIcon }).addTo(map);

        var lokasiNama = (kb.kabupaten_kota ? kb.kabupaten_kota.nama : '') + (kb.kawasan_hutan ? ' (' + kb.kawasan_hutan.nama + ')' : '');
        var popupContent = '<div class="p-1 space-y-2 min-w-[220px]">' +
            '<div class="flex items-center justify-between gap-2 border-b border-stone-200 pb-1.5">' +
                '<span class="font-bold font-mono text-red-600 text-xs flex items-center gap-1"><i class="fa-solid fa-fire text-[11px]"></i> ' + kb.kode + '</span>' +
                '<span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-red-100 text-red-800">' + kb.status + '</span>' +
            '</div>' +
            (lokasiNama ? '<div class="text-[11px] text-stone-500 font-semibold">' + lokasiNama + '</div>' : '') +
            '<div class="text-xs text-stone-700 leading-relaxed font-normal line-clamp-2">' + (kb.deskripsi || 'Laporan kebakaran aktif dari warga') + '</div>' +
            '<div class="pt-1 flex flex-col gap-1.5">' +
                '<button type="button" onclick="pasangTitikSimulasi(' + kb.latitude + ',' + kb.longitude + ',' + kb.id + ')" class="w-full px-2.5 py-1.5 bg-stone-900 hover:bg-stone-800 text-white text-[11px] font-semibold rounded-lg transition text-center shadow-sm flex items-center justify-center gap-1.5">' +
                    '<i class="fa-solid fa-calculator text-[10px]"></i><span>Gunakan Titik Untuk Prediksi</span>' +
                '</button>' +
                '<a href="/admin/laporan/' + kb.id + '" class="w-full px-2.5 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 text-[11px] font-semibold rounded-lg transition text-center border border-stone-300 flex items-center justify-center gap-1.5">' +
                    '<i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i><span>Buka di Kelola Laporan</span>' +
                '</a>' +
            '</div>' +
        '</div>';

        marker.bindPopup(popupContent);
    });

    var latAwal = document.getElementById('latitude').value;
    var lngAwal = document.getElementById('longitude').value;
    var idLaporanAwal = '{{ $inputIdLaporan ?? "" }}';
    if (latAwal && lngAwal) {
        pasangTitikSimulasi(parseFloat(latAwal), parseFloat(lngAwal), idLaporanAwal || null);
        @if ($inputIdLaporan)
            map.setView([parseFloat(latAwal), parseFloat(lngAwal)], 13);
        @endif
    }

    map.on('click', function (e) {
        pasangTitikSimulasi(e.latlng.lat, e.latlng.lng, null);
    });

    @if ($prediksiAktif)
        var poly6 = @json(json_decode($prediksiAktif->poligon_6jam));
        if (poly6) {
            L.polygon(poly6, {
                color: '#ca8a04',
                fillColor: '#ca8a04',
                fillOpacity: 0.25,
                weight: 2
            }).addTo(map).bindTooltip('Prediksi 6 Jam ({{ $prediksiAktif->luas_6jam }} ha)');
        }

        var poly3 = @json(json_decode($prediksiAktif->poligon_3jam));
        if (poly3) {
            L.polygon(poly3, {
                color: '#ea580c',
                fillColor: '#ea580c',
                fillOpacity: 0.3,
                weight: 2
            }).addTo(map).bindTooltip('Prediksi 3 Jam ({{ $prediksiAktif->luas_3jam }} ha)');
        }

        var poly1 = @json(json_decode($prediksiAktif->poligon_1jam));
        if (poly1) {
            L.polygon(poly1, {
                color: '#dc2626',
                fillColor: '#dc2626',
                fillOpacity: 0.35,
                weight: 2
            }).addTo(map).bindTooltip('Prediksi 1 Jam ({{ $prediksiAktif->luas_1jam }} ha)');
        }

        pasangTitikSimulasi({{ $prediksiAktif->latitude }}, {{ $prediksiAktif->longitude }});
        map.setView([{{ $prediksiAktif->latitude }}, {{ $prediksiAktif->longitude }}], 14);
    @endif

    window.addEventListener('peta-toggle-layar-penuh', function (e) {
        var detail = e.detail;
        if (Array.isArray(detail)) {
            detail = detail[0] || {};
        }
        var el = document.getElementById('peta-prediksi');
        if (el) {
            if (detail && detail.layarPenuh) {
                el.style.setProperty('height', '100vh', 'important');
                el.style.setProperty('width', '100vw', 'important');
                document.body.classList.add('overflow-hidden');
            } else {
                el.style.setProperty('height', '100%', 'important');
                el.style.setProperty('width', '100%', 'important');
                document.body.classList.remove('overflow-hidden');
            }
        }
        setTimeout(function () {
            if (typeof map !== 'undefined' && map) {
                map.invalidateSize();
            }
        }, 100);
        setTimeout(function () {
            if (typeof map !== 'undefined' && map) {
                map.invalidateSize();
            }
        }, 300);
    });
}

document.addEventListener('DOMContentLoaded', inisialisasiPetaPrediksi);
document.addEventListener('livewire:navigated', inisialisasiPetaPrediksi);
</script>
@endsection
