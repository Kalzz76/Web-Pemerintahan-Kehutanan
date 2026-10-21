@extends('layouts.publik')

@section('title', 'Peringatan Perambatan Api')

@section('content')
<div class="bg-stone-100 py-8 px-4 sm:px-6 lg:px-8 min-h-[calc(100vh-80px)]">
    <div class="max-w-7xl mx-auto space-y-8">
        <div>
            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700 mb-2">
                <i class="fa-solid fa-triangle-exclamation mr-1.5"></i> Pantauan Siaga Kebakaran
            </div>
            <h1 class="text-3xl font-black text-stone-900 tracking-tight">Peringatan Perambatan Api</h1>
            <p class="text-stone-600 text-sm mt-1 max-w-3xl">
                Halaman ini menyajikan visualisasi perkiraan arah dan sebaran kebakaran hutan serta permukiman warga yang berpotensi terancam rambatan api.
            </p>
        </div>

        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 sm:p-5 flex items-start space-x-3 shadow-sm">
            <i class="fa-solid fa-circle-exclamation text-amber-600 text-xl mt-0.5 shrink-0"></i>
            <div class="text-xs sm:text-sm text-amber-900 leading-relaxed">
                <span class="font-bold">Peringatan Penting:</span> Hasil perhitungan pada halaman ini adalah perkiraan matematis sederhana berdasarkan data cuaca dan jenis lahan, bukan pengganti arahan langsung atau keputusan dari petugas satgas dan aparat di lapangan. Selalu utamakan keselamatan diri dan keluarga serta ikuti arahan evakuasi resmi.
            </div>
        </div>

        @if ($daftarPeringatan->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center shadow-sm border border-stone-200 max-w-2xl mx-auto">
                <div class="w-20 h-20 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-3xl mx-auto mb-5 shadow-inner">
                    <i class="fa-solid fa-shield-heart"></i>
                </div>
                <h2 class="text-2xl font-black text-stone-900 mb-2">Kondisi Aman Terkendali</h2>
                <p class="text-stone-500 text-sm leading-relaxed mb-6">
                    Saat ini tidak ada peringatan kebakaran hutan yang dipublikasikan oleh petugas. Seluruh kawasan dalam pantauan aman.
                </p>
                <div class="flex flex-wrap justify-center gap-3">
                    <a href="{{ route('peta') }}" class="px-5 py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-800 font-bold rounded-xl text-sm transition">
                        <i class="fa-solid fa-map mr-2"></i> Buka Peta Hutan
                    </a>
                    <a href="{{ route('lapor', ['jenis' => 'Kebakaran']) }}" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-500 text-white font-bold rounded-xl text-sm transition shadow">
                        <i class="fa-solid fa-triangle-exclamation mr-2"></i> Lapor Kebakaran Baru
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <div class="lg:col-span-8 space-y-4">
                    <div class="bg-white rounded-3xl shadow-sm border border-stone-200 overflow-hidden">
                        <div class="p-4 sm:p-5 border-b border-stone-100 flex flex-wrap items-center justify-between gap-3 bg-stone-50">
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-map-location-dot text-rose-600"></i>
                                <span class="font-bold text-stone-800 text-sm">Visualisasi Wilayah Terdampak</span>
                            </div>
                            <div class="flex flex-wrap items-center gap-3 text-xs font-semibold">
                                <span class="inline-flex items-center text-red-600">
                                    <span class="w-3 h-3 rounded-full bg-red-600 mr-1.5 inline-block border border-white shadow-sm"></span> 1 Jam
                                </span>
                                <span class="inline-flex items-center text-amber-600">
                                    <span class="w-3 h-3 rounded-full bg-amber-500 mr-1.5 inline-block border border-white shadow-sm"></span> 3 Jam
                                </span>
                                <span class="inline-flex items-center text-yellow-600">
                                    <span class="w-3 h-3 rounded-full bg-yellow-400 mr-1.5 inline-block border border-white shadow-sm"></span> 6 Jam
                                </span>
                                <span class="inline-flex items-center text-blue-600">
                                    <span class="w-3 h-3 rounded-full bg-blue-600 mr-1.5 inline-block border border-white shadow-sm"></span> Permukiman
                                </span>
                            </div>
                        </div>

                        <livewire:peta-layar-penuh id-peta="peta-peringatan" tinggi="520px" />

                        <div class="p-4 sm:p-5 border-t border-stone-200 bg-stone-50 space-y-4">
                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <div class="flex items-center space-x-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-rose-600 animate-ping"></span>
                                    <span class="text-xs font-black uppercase tracking-wider text-rose-700">Simulasi Laju Perambatan Api</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button type="button" id="btn-play-simulasi" onclick="toggleSimulasi()" class="px-3.5 py-1.5 bg-rose-600 hover:bg-rose-500 text-white rounded-xl text-xs font-bold shadow flex items-center gap-1.5 transition">
                                        <i id="icon-play-simulasi" class="fa-solid fa-play"></i>
                                        <span id="label-play-simulasi">Mulai Simulasi</span>
                                    </button>
                                    <button type="button" onclick="resetSimulasi()" class="px-3 py-1.5 bg-white hover:bg-stone-200 text-stone-700 border border-stone-200 rounded-xl text-xs font-bold transition flex items-center gap-1">
                                        <i class="fa-solid fa-rotate-right"></i>
                                        <span>Reset</span>
                                    </button>
                                    <button type="button" id="btn-toggle-satelit" onclick="toggleLayerSatelit()" class="px-3 py-1.5 bg-white hover:bg-stone-200 text-stone-700 border border-stone-200 rounded-xl text-xs font-bold transition flex items-center gap-1">
                                        <i class="fa-solid fa-layer-group"></i>
                                        <span id="label-satelit">Peta Satelit</span>
                                    </button>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <div class="flex justify-between items-center text-xs font-bold text-stone-700">
                                    <span id="teks-waktu-simulasi">Waktu Simulasi: +0.0 Jam (0 Menit)</span>
                                    <div class="flex items-center gap-2">
                                        <span id="teks-titik-aktif" class="px-2 py-0.5 rounded-full bg-rose-100 text-rose-700 font-extrabold text-[10px] border border-rose-200">1 Titik Api Aktif</span>
                                        <span id="teks-jarak-simulasi" class="text-rose-600 font-extrabold">Perkiraan Menjalar: 0 m</span>
                                    </div>
                                </div>
                                <input type="range" id="slider-waktu" min="0" max="6" step="0.05" value="0" oninput="ubahWaktuSimulasi(parseFloat(this.value))" class="w-full accent-rose-600 cursor-pointer h-2 bg-stone-200 rounded-lg">
                                <div class="flex justify-between text-[10px] font-bold text-stone-600 px-0.5">
                                    <span>0 Jam (Titik Awal)</span>
                                    <span class="text-red-600">1 Jam (Radius Merah)</span>
                                    <span class="text-amber-600">3 Jam (Radius Oranye)</span>
                                    <span class="text-yellow-600">6 Jam (Radius Kuning)</span>
                                </div>
                            </div>

                            <div id="kotak-status-simulasi" class="p-3.5 rounded-2xl bg-white border border-stone-200 flex items-start gap-3 shadow-sm transition-all duration-300">
                                <div id="ikon-status-simulasi" class="w-9 h-9 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0 text-base mt-0.5">
                                    <i class="fa-solid fa-fire-flame-curved animate-pulse"></i>
                                </div>
                                <div class="text-xs">
                                    <div id="judul-status-simulasi" class="font-black text-stone-900 mb-0.5 text-sm">Kondisi Awal Titik Api Terdeteksi</div>
                                    <div id="pesan-status-simulasi" class="text-stone-600 leading-relaxed">Titik api pertama kali teridentifikasi pada vegetasi hutan. Tekan tombol "Mulai Simulasi" atau geser slider waktu untuk memantau perkiraan penjalaran lidah api ke arah pemukiman warga.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200">
                        <h2 class="text-base font-extrabold text-stone-900 mb-4 flex items-center">
                            <i class="fa-solid fa-list-check text-rose-600 mr-2"></i>
                            Daftar Peringatan Aktif ({{ $daftarPeringatan->count() }})
                        </h2>

                        <div class="space-y-5">
                            @foreach ($daftarPeringatan as $index => $item)
                                @php
                                    $terancam = json_decode($item->area_terancam, true) ?? [];
                                @endphp
                                <div class="p-5 rounded-2xl border-2 {{ $index === 0 ? 'border-rose-500 bg-rose-50/30' : 'border-stone-200 bg-stone-50' }} space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black uppercase tracking-wider bg-rose-600 text-white">
                                            Bahaya Kebakaran
                                        </span>
                                        <span class="text-xs text-stone-500 font-medium">
                                            {{ $item->created_at->format('d M Y, H:i') }} WIB
                                        </span>
                                    </div>

                                    <div>
                                        <div class="text-xs text-stone-500 font-semibold">Jenis Vegetasi Lahan</div>
                                        <div class="text-sm font-black text-stone-800">
                                            {{ $item->jenisLahan->nama ?? 'Tidak Diketahui' }}
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-2 text-xs bg-white p-3 rounded-xl border border-stone-200">
                                        <div>
                                            <span class="text-stone-400 block text-[10px]">Arah Angin</span>
                                            <span class="font-bold text-stone-700">{{ $item->arah_angin }}°</span>
                                        </div>
                                        <div>
                                            <span class="text-stone-400 block text-[10px]">Kecepatan Angin</span>
                                            <span class="font-bold text-stone-700">{{ $item->kecepatan_angin }} km/j</span>
                                        </div>
                                        <div>
                                            <span class="text-stone-400 block text-[10px]">Kelembapan</span>
                                            <span class="font-bold text-stone-700">{{ $item->kelembapan }}%</span>
                                        </div>
                                        <div>
                                            <span class="text-stone-400 block text-[10px]">Laju Rambat</span>
                                            <span class="font-bold text-rose-600">{{ $item->laju_efektif }} m/j</span>
                                        </div>
                                    </div>

                                    <div class="space-y-1.5 text-xs">
                                        <div class="font-bold text-stone-700 mb-1">Perkiraan Luas Terdampak:</div>
                                        <div class="flex justify-between items-center py-1 border-b border-stone-200">
                                            <span class="flex items-center text-red-600 font-semibold"><span class="w-2 h-2 rounded-full bg-red-600 mr-2"></span> Radius 1 Jam</span>
                                            <span class="font-black text-stone-800">{{ number_format($item->luas_1jam, 2, ',', '.') }} ha</span>
                                        </div>
                                        <div class="flex justify-between items-center py-1 border-b border-stone-200">
                                            <span class="flex items-center text-amber-600 font-semibold"><span class="w-2 h-2 rounded-full bg-amber-500 mr-2"></span> Radius 3 Jam</span>
                                            <span class="font-black text-stone-800">{{ number_format($item->luas_3jam, 2, ',', '.') }} ha</span>
                                        </div>
                                        <div class="flex justify-between items-center py-1">
                                            <span class="flex items-center text-yellow-600 font-semibold"><span class="w-2 h-2 rounded-full bg-yellow-400 mr-2"></span> Radius 6 Jam</span>
                                            <span class="font-black text-stone-800">{{ number_format($item->luas_6jam, 2, ',', '.') }} ha</span>
                                        </div>
                                    </div>

                                    <div class="pt-2 border-t border-stone-200">
                                        <div class="text-xs font-bold text-stone-800 mb-2 flex items-center">
                                            <i class="fa-solid fa-house-chimney-crack text-rose-600 mr-1.5"></i>
                                            Area Permukiman Terancam:
                                        </div>
                                        @if (count($terancam) > 0)
                                            <div class="space-y-1.5">
                                                @foreach ($terancam as $area)
                                                    <div class="flex items-center justify-between text-xs px-2.5 py-1.5 rounded-lg bg-rose-100/70 text-rose-900 font-semibold">
                                                        <span>{{ $area['nama'] }}</span>
                                                        <span class="px-2 py-0.5 rounded bg-rose-600 text-white text-[10px] font-black">
                                                            ± {{ $area['jam'] }} Jam
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-xs text-stone-500 italic bg-white p-2.5 rounded-lg border border-stone-200">
                                                Tidak ada permukiman yang berada dalam jalur rambatan 6 jam.
                                            </div>
                                        @endif
                                    </div>

                                    <button type="button" onclick="fokusPrediksi({{ $item->latitude }}, {{ $item->longitude }})" class="w-full py-2 bg-stone-900 hover:bg-stone-800 text-white rounded-xl text-xs font-bold transition flex items-center justify-center">
                                        <i class="fa-solid fa-crosshairs mr-2"></i> Fokus ke Lokasi Ini
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200 space-y-4">
                        <h3 class="text-sm font-extrabold text-stone-900 flex items-center">
                            <i class="fa-solid fa-phone-volume text-green-700 mr-2"></i> Butuh Bantuan Darurat?
                        </h3>
                        <p class="text-xs text-stone-600 leading-relaxed">
                            Jika melihat api mendekati area rumah atau kebun, segera hubungi posko siaga atau kirim laporan darurat desa.
                        </p>
                        <div class="space-y-2">
                            <a href="{{ route('lapor', ['jenis' => 'Kebakaran']) }}" class="block text-center w-full py-2.5 bg-rose-600 hover:bg-rose-500 text-white font-bold rounded-xl text-xs shadow transition">
                                <i class="fa-solid fa-fire mr-1.5"></i> Lapor Darurat Sekarang
                            </a>
                            <a href="{{ route('beranda') }}#kontak-darurat" class="block text-center w-full py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-800 font-bold rounded-xl text-xs transition">
                                <i class="fa-solid fa-address-book mr-1.5"></i> Daftar Kontak Darurat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>

<script>
    var peta;
    var layerOSM;
    var layerSatelit;
    var layerAktifSatelit = false;

    var dataPrediksi = @json($daftarPeringatan);
    var dataPermukiman = @json($daftarPermukiman);
    var latPusat = {{ $pengaturan->lat_pusat ?? -0.7893 }};
    var longPusat = {{ $pengaturan->long_pusat ?? 113.9213 }};
    var zoomAwal = {{ $pengaturan->zoom_awal ?? 12 }};

    var poly1Coords = [];
    var poly3Coords = [];
    var poly6Coords = [];
    var pusatApiLat = 0;
    var pusatApiLng = 0;
    var lajuRambatM = 0;
    var arahAnginDerajat = 0;
    var namaVegetasi = '';
    var permukimanTerancamList = [];

    var layerApiAnimasi = null;
    var markerPermukimanMap = {};
    var daftarTitikApiSekunder = [];
    var markerApiSekunder = [];
    var simulasiInterval = null;
    var waktuSimulasi = 0;

    function buatIconApiSekunder() {
        return L.divIcon({
            className: 'bg-transparent',
            html: '<div class="relative flex items-center justify-center -ml-2.5 -mt-2.5 w-6 h-6 pointer-events-none">' +
                '<span class="absolute w-5 h-5 rounded-full bg-amber-500/70 animate-ping"></span>' +
                '<span class="absolute w-4 h-4 rounded-full bg-red-600/80 animate-pulse"></span>' +
                '<div class="w-5 h-5 rounded-full bg-gradient-to-t from-red-600 via-orange-500 to-amber-400 border border-white shadow-lg flex items-center justify-center text-white text-[10px] z-10">' +
                '<i class="fa-solid fa-fire text-yellow-200"></i></div></div>',
            iconSize: [22, 22],
            iconAnchor: [11, 11]
        });
    }

    function inisialisasiTitikApiSekunder() {
        daftarTitikApiSekunder = [];
        if (!pusatApiLat || !pusatApiLng || poly1Coords.length === 0) return;

        var p1 = poly1Coords;
        var p3 = poly3Coords.length > 0 ? poly3Coords : poly1Coords;
        var p6 = poly6Coords.length > 0 ? poly6Coords : p3;

        var n1 = p1.length;
        var n3 = p3.length;
        var n6 = p6.length;

        var konfigurasi = [
            { jam: 0.35, lat: pusatApiLat + (p1[2 % n1][0] - pusatApiLat) * 0.45, lng: pusatApiLng + (p1[2 % n1][1] - pusatApiLng) * 0.45, label: 'Lidah Api Awal' },
            { jam: 0.65, lat: pusatApiLat + (p1[34 % n1][0] - pusatApiLat) * 0.65, lng: pusatApiLng + (p1[34 % n1][1] - pusatApiLng) * 0.65, label: 'Lidah Api Samping' },
            { jam: 0.95, lat: p1[0][0] * 0.95 + pusatApiLat * 0.05, lng: p1[0][1] * 0.95 + pusatApiLng * 0.05, label: 'Kepala Api 1 Jam' },
            { jam: 1.25, lat: p1[5 % n1][0], lng: p1[5 % n1][1], label: 'Loncatan Bara Kanan' },
            { jam: 1.55, lat: p1[31 % n1][0], lng: p1[31 % n1][1], label: 'Loncatan Bara Kiri' },
            { jam: 1.85, lat: p1[1 % n1][0] + (p3[1 % n3][0] - p1[1 % n1][0]) * 0.35, lng: p1[1 % n1][1] + (p3[1 % n3][1] - p1[1 % n1][1]) * 0.35, label: 'Perambatan Aktif' },
            { jam: 2.20, lat: p1[4 % n1][0] + (p3[4 % n3][0] - p1[4 % n1][0]) * 0.55, lng: p1[4 % n1][1] + (p3[4 % n3][1] - p1[4 % n1][1]) * 0.55, label: 'Lidah Api Hutan' },
            { jam: 2.55, lat: p1[33 % n1][0] + (p3[33 % n3][0] - p1[33 % n1][0]) * 0.65, lng: p1[33 % n1][1] + (p3[33 % n3][1] - p1[33 % n1][1]) * 0.65, label: 'Fokus Api Menyebar' },
            { jam: 2.90, lat: p3[0][0], lng: p3[0][1], label: 'Kepala Api 3 Jam' },
            { jam: 3.25, lat: p3[6 % n3][0], lng: p3[6 % n3][1], label: 'Titik Api Dekat Jalur Lereng' },
            { jam: 3.65, lat: p3[30 % n3][0], lng: p3[30 % n3][1], label: 'Lidah Api Sisi Barat' },
            { jam: 4.05, lat: p3[2 % n3][0] + (p6[2 % n6][0] - p3[2 % n3][0]) * 0.35, lng: p3[2 % n3][1] + (p6[2 % n6][1] - p3[2 % n3][1]) * 0.35, label: 'Loncatan Bara 4 Jam' },
            { jam: 4.45, lat: p3[32 % n3][0] + (p6[32 % n6][0] - p3[32 % n3][0]) * 0.50, lng: p3[32 % n3][1] + (p6[32 % n6][1] - p3[32 % n3][1]) * 0.50, label: 'Lidah Api Menjalar Luas' },
            { jam: 4.85, lat: p3[5 % n3][0] + (p6[5 % n6][0] - p3[5 % n3][0]) * 0.65, lng: p3[5 % n3][1] + (p6[5 % n6][1] - p3[5 % n3][1]) * 0.65, label: 'Bara Api Zona Kering' },
            { jam: 5.30, lat: p6[0][0], lng: p6[0][1], label: 'Garis Depan Api 6 Jam' },
            { jam: 5.75, lat: p6[3 % n6][0], lng: p6[3 % n6][1], label: 'Batas Maksimum Rambatan' }
        ];

        konfigurasi.forEach(function (cfg) {
            daftarTitikApiSekunder.push({
                jam: cfg.jam,
                lat: cfg.lat,
                lng: cfg.lng,
                label: cfg.label
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        var petaEl = document.getElementById('peta-peringatan');
        if (!petaEl) return;

        peta = L.map('peta-peringatan').setView([latPusat, longPusat], zoomAwal);

        layerOSM = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(peta);

        layerSatelit = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            attribution: '&copy; Google Maps Satelit'
        });

        var bounds = [];

        dataPermukiman.forEach(function (p) {
            if (p.latitude && p.longitude) {
                var lat = parseFloat(p.latitude);
                var lng = parseFloat(p.longitude);
                var marker = L.circleMarker([lat, lng], {
                    radius: 7,
                    fillColor: '#2563eb',
                    color: '#ffffff',
                    weight: 2,
                    opacity: 1,
                    fillOpacity: 0.95
                }).addTo(peta);

                var pop = '<div class="p-1 font-sans text-xs">' +
                    '<div class="font-bold text-stone-900">' + p.nama + '</div>' +
                    '<div class="text-[10px] text-blue-600 font-semibold uppercase">Permukiman Warga</div>' +
                    '<div class="mt-1 text-[11px] text-stone-500">Koordinat: ' + lat.toFixed(4) + ', ' + lng.toFixed(4) + '</div>' +
                    '<a href="https://www.google.com/maps/dir/?api=1&destination=' + lat + ',' + lng + '" target="_blank" class="inline-flex items-center gap-1 mt-1.5 px-2 py-0.5 rounded bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold text-[10px]">' +
                    '<i class="fa-solid fa-diamond-turn-right"></i> Rute ke Lokasi</a>' +
                    '</div>';
                marker.bindPopup(pop);
                markerPermukimanMap[p.nama] = marker;
            }
        });

        dataPrediksi.forEach(function (pred, idx) {
            var lat0 = parseFloat(pred.latitude);
            var lng0 = parseFloat(pred.longitude);

            if (idx === 0) {
                pusatApiLat = lat0;
                pusatApiLng = lng0;
                lajuRambatM = parseFloat(pred.laju_efektif) || 0;
                arahAnginDerajat = pred.arah_angin;
                namaVegetasi = pred.jenis_lahan ? pred.jenis_lahan.nama : 'Vegetasi Hutan';
                try {
                    permukimanTerancamList = JSON.parse(pred.area_terancam) || [];
                } catch (e) {
                    permukimanTerancamList = [];
                }
            }

            bounds.push([lat0, lng0]);

            var apiIcon = L.divIcon({
                className: 'bg-transparent',
                html: '<div class="relative flex items-center justify-center -ml-3 -mt-3 w-8 h-8">' +
                    '<span class="absolute w-8 h-8 rounded-full bg-red-600/50 animate-ping"></span>' +
                    '<span class="absolute w-6 h-6 rounded-full bg-amber-500/70 animate-pulse"></span>' +
                    '<div class="w-7 h-7 rounded-full bg-red-600 border-2 border-white shadow-xl flex items-center justify-center text-white text-xs z-10">' +
                    '<i class="fa-solid fa-fire text-amber-300"></i></div></div>',
                iconSize: [28, 28],
                iconAnchor: [14, 14]
            });

            var fireMarker = L.marker([lat0, lng0], { icon: apiIcon }).addTo(peta);

            fireMarker.bindPopup('<div class="p-1 font-sans text-xs">' +
                '<div class="font-extrabold text-rose-700 flex items-center gap-1"><i class="fa-solid fa-fire"></i> Pusat Titik Api Aktif</div>' +
                '<div class="text-[11px] text-stone-700 mt-0.5">Vegetasi: ' + (pred.jenis_lahan ? pred.jenis_lahan.nama : '-') + '</div>' +
                '<div class="text-[11px] text-stone-500">Laju Rambat: ' + pred.laju_efektif + ' m/jam</div>' +
                '<div class="text-[11px] text-stone-500">Arah Angin: ' + pred.arah_angin + '°</div>' +
                '<a href="https://www.google.com/maps/dir/?api=1&destination=' + lat0 + ',' + lng0 + '" target="_blank" class="inline-flex items-center gap-1 mt-1.5 px-2 py-0.5 rounded bg-rose-50 text-rose-700 hover:bg-rose-100 font-bold text-[10px]">' +
                '<i class="fa-solid fa-diamond-turn-right"></i> Rute ke Titik Api</a>' +
                '</div>');

            if (pred.poligon_6jam) {
                try {
                    var poly6 = JSON.parse(pred.poligon_6jam);
                    if (poly6.length > 0) {
                        if (idx === 0) poly6Coords = poly6;
                        L.polygon(poly6, {
                            color: '#ca8a04',
                            fillColor: '#facc15',
                            fillOpacity: 0.18,
                            weight: 1.5,
                            dashArray: '3, 3'
                        }).addTo(peta).bindPopup('<div class="text-xs font-bold text-yellow-700">Radius Bahaya 6 Jam (' + pred.luas_6jam + ' ha)</div>');
                        poly6.forEach(function(pt) { bounds.push(pt); });
                    }
                } catch (e) {}
            }

            if (pred.poligon_3jam) {
                try {
                    var poly3 = JSON.parse(pred.poligon_3jam);
                    if (poly3.length > 0) {
                        if (idx === 0) poly3Coords = poly3;
                        L.polygon(poly3, {
                            color: '#ea580c',
                            fillColor: '#fb923c',
                            fillOpacity: 0.22,
                            weight: 1.5,
                            dashArray: '3, 3'
                        }).addTo(peta).bindPopup('<div class="text-xs font-bold text-orange-700">Radius Bahaya 3 Jam (' + pred.luas_3jam + ' ha)</div>');
                        poly3.forEach(function(pt) { bounds.push(pt); });
                    }
                } catch (e) {}
            }

            if (pred.poligon_1jam) {
                try {
                    var poly1 = JSON.parse(pred.poligon_1jam);
                    if (poly1.length > 0) {
                        if (idx === 0) poly1Coords = poly1;
                        L.polygon(poly1, {
                            color: '#dc2626',
                            fillColor: '#ef4444',
                            fillOpacity: 0.25,
                            weight: 1.5,
                            dashArray: '3, 3'
                        }).addTo(peta).bindPopup('<div class="text-xs font-bold text-red-700">Radius Bahaya 1 Jam (' + pred.luas_1jam + ' ha)</div>');
                        poly1.forEach(function(pt) { bounds.push(pt); });
                    }
                } catch (e) {}
            }
        });

        inisialisasiTitikApiSekunder();

        if (pusatApiLat && pusatApiLng) {
            layerApiAnimasi = L.polygon([[pusatApiLat, pusatApiLng]], {
                color: '#ff2200',
                fillColor: '#ef4444',
                fillOpacity: 0.65,
                weight: 3,
                dashArray: '4, 4'
            }).addTo(peta);
        }

        if (bounds.length > 0) {
            peta.fitBounds(bounds, { padding: [40, 40] });
        }

        window.addEventListener('peta-toggle-layar-penuh', function (e) {
            var detail = e.detail;
            if (Array.isArray(detail)) {
                detail = detail[0] || {};
            }
            var el = document.getElementById('peta-peringatan');
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
                if (typeof peta !== 'undefined' && peta) {
                    peta.invalidateSize();
                }
            }, 100);
            setTimeout(function () {
                if (typeof peta !== 'undefined' && peta) {
                    peta.invalidateSize();
                }
            }, 300);
        });
    });

    function toggleLayerSatelit() {
        if (!peta) return;
        var label = document.getElementById('label-satelit');
        var btn = document.getElementById('btn-toggle-satelit');

        if (layerAktifSatelit) {
            peta.removeLayer(layerSatelit);
            peta.addLayer(layerOSM);
            layerAktifSatelit = false;
            label.innerText = 'Peta Satelit';
            btn.classList.remove('bg-stone-900', 'text-white');
            btn.classList.add('bg-white', 'text-stone-700');
        } else {
            peta.removeLayer(layerOSM);
            peta.addLayer(layerSatelit);
            layerAktifSatelit = true;
            label.innerText = 'Peta Jalan';
            btn.classList.remove('bg-white', 'text-stone-700');
            btn.classList.add('bg-stone-900', 'text-white');
        }
    }

    function hitungPoligonInterp(t) {
        if (!pusatApiLat || !pusatApiLng || poly1Coords.length === 0) return [];
        if (t <= 0.05) return [[pusatApiLat, pusatApiLng]];

        var n = poly1Coords.length;
        var hasil = [];

        if (t <= 1.0) {
            var f = t;
            for (var i = 0; i < n; i++) {
                var lat = pusatApiLat + (poly1Coords[i][0] - pusatApiLat) * f;
                var lng = pusatApiLng + (poly1Coords[i][1] - pusatApiLng) * f;
                hasil.push([lat, lng]);
            }
        } else if (t <= 3.0) {
            var f = (t - 1.0) / 2.0;
            var targetCoords = poly3Coords.length === n ? poly3Coords : poly1Coords;
            for (var i = 0; i < n; i++) {
                var lat = poly1Coords[i][0] + (targetCoords[i][0] - poly1Coords[i][0]) * f;
                var lng = poly1Coords[i][1] + (targetCoords[i][1] - poly1Coords[i][1]) * f;
                hasil.push([lat, lng]);
            }
        } else {
            var f = (t - 3.0) / 3.0;
            var sourceCoords = poly3Coords.length === n ? poly3Coords : poly1Coords;
            var targetCoords = poly6Coords.length === n ? poly6Coords : sourceCoords;
            for (var i = 0; i < n; i++) {
                var lat = sourceCoords[i][0] + (targetCoords[i][0] - sourceCoords[i][0]) * f;
                var lng = sourceCoords[i][1] + (targetCoords[i][1] - sourceCoords[i][1]) * f;
                hasil.push([lat, lng]);
            }
        }
        return hasil;
    }

    function ubahWaktuSimulasi(jam) {
        waktuSimulasi = parseFloat(jam);
        document.getElementById('slider-waktu').value = waktuSimulasi;

        var menitTotal = Math.round(waktuSimulasi * 60);
        var jamTeks = Math.floor(menitTotal / 60);
        var sisaMenit = menitTotal % 60;
        document.getElementById('teks-waktu-simulasi').innerText = 'Waktu Simulasi: +' + jamTeks + ' Jam ' + sisaMenit + ' Menit';

        var jarakMeter = Math.round(waktuSimulasi * lajuRambatM);
        document.getElementById('teks-jarak-simulasi').innerText = 'Perkiraan Menjalar: ~' + jarakMeter.toLocaleString('id-ID') + ' m';

        if (layerApiAnimasi) {
            var polyCoords = hitungPoligonInterp(waktuSimulasi);
            layerApiAnimasi.setLatLngs(polyCoords);
        }

        var jumlahSekunderAktif = 0;
        daftarTitikApiSekunder.forEach(function (titik, i) {
            if (waktuSimulasi >= titik.jam) {
                jumlahSekunderAktif++;
                if (!markerApiSekunder[i]) {
                    var m = L.marker([titik.lat, titik.lng], { icon: buatIconApiSekunder() }).addTo(peta);
                    m.bindPopup('<div class="p-1 font-sans text-xs">' +
                        '<div class="font-extrabold text-orange-600 flex items-center gap-1"><i class="fa-solid fa-fire"></i> ' + titik.label + '</div>' +
                        '<div class="text-[11px] text-stone-600 mt-0.5">Loncatan api aktif pada jam ke +' + titik.jam.toFixed(1) + '</div>' +
                        '</div>');
                    markerApiSekunder[i] = m;
                }
            } else {
                if (markerApiSekunder[i]) {
                    peta.removeLayer(markerApiSekunder[i]);
                    markerApiSekunder[i] = null;
                }
            }
        });

        var totalTitikAktif = 1 + jumlahSekunderAktif;
        var badgeTitik = document.getElementById('teks-titik-aktif');
        if (badgeTitik) {
            badgeTitik.innerText = totalTitikAktif + ' Titik Api Aktif';
        }

        var kotakStatus = document.getElementById('kotak-status-simulasi');
        var ikonStatus = document.getElementById('ikon-status-simulasi');
        var judulStatus = document.getElementById('judul-status-simulasi');
        var pesanStatus = document.getElementById('pesan-status-simulasi');

        var desaTerdampakSekarang = [];
        permukimanTerancamList.forEach(function (area) {
            var jamBahaya = parseFloat(area.jam);
            var marker = markerPermukimanMap[area.nama];
            if (waktuSimulasi >= jamBahaya) {
                desaTerdampakSekarang.push(area.nama);
                if (marker) {
                    marker.setStyle({
                        fillColor: '#dc2626',
                        radius: 10,
                        fillOpacity: 1
                    });
                }
            } else {
                if (marker) {
                    marker.setStyle({
                        fillColor: '#2563eb',
                        radius: 7,
                        fillOpacity: 0.95
                    });
                }
            }
        });

        if (desaTerdampakSekarang.length > 0) {
            kotakStatus.className = 'p-3.5 rounded-2xl bg-rose-50 border-2 border-rose-500 flex items-start gap-3 shadow-sm transition-all duration-300';
            ikonStatus.className = 'w-9 h-9 rounded-xl bg-rose-600 text-white flex items-center justify-center shrink-0 text-base mt-0.5 animate-bounce';
            judulStatus.className = 'font-black text-rose-900 mb-0.5 text-sm';
            judulStatus.innerText = 'PERINGATAN KRITIS: Lidah Api Memasuki Area Permukiman!';
            pesanStatus.className = 'text-rose-800 leading-relaxed font-medium';
            pesanStatus.innerText = 'Pada waktu simulasi +' + jamTeks + 'j ' + sisaMenit + 'm, api diperkirakan telah menjalar sejauh ~' + jarakMeter.toLocaleString('id-ID') + ' m dengan ' + totalTitikAktif + ' titik api aktif yang mulai mengancam: ' + desaTerdampakSekarang.join(', ') + '. Warga diimbau evakuasi terarah!';
        } else if (waktuSimulasi > 0) {
            kotakStatus.className = 'p-3.5 rounded-2xl bg-amber-50 border border-amber-300 flex items-start gap-3 shadow-sm transition-all duration-300';
            ikonStatus.className = 'w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 text-base mt-0.5';
            judulStatus.className = 'font-black text-amber-900 mb-0.5 text-sm';
            judulStatus.innerText = 'Api Sedang Merambat di Vegetasi ' + namaVegetasi;
            pesanStatus.className = 'text-amber-800 leading-relaxed';
            pesanStatus.innerText = 'Terdeteksi ' + totalTitikAktif + ' titik api aktif yang menyebar mengikuti dorongan angin ' + arahAnginDerajat + '° dengan kecepatan rambat ~' + lajuRambatM + ' m/jam. Jarak penjalaran api saat ini mencapai ~' + jarakMeter.toLocaleString('id-ID') + ' meter.';
        } else {
            kotakStatus.className = 'p-3.5 rounded-2xl bg-white border border-stone-200 flex items-start gap-3 shadow-sm transition-all duration-300';
            ikonStatus.className = 'w-9 h-9 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0 text-base mt-0.5';
            judulStatus.className = 'font-black text-stone-900 mb-0.5 text-sm';
            judulStatus.innerText = 'Kondisi Awal Titik Api Terdeteksi';
            pesanStatus.className = 'text-stone-600 leading-relaxed';
            pesanStatus.innerText = 'Titik api pertama kali teridentifikasi pada vegetasi hutan. Tekan tombol "Mulai Simulasi" atau geser slider waktu untuk memantau perkiraan penjalaran lidah api ke arah pemukiman warga.';
        }
    }

    function toggleSimulasi() {
        var btnIcon = document.getElementById('icon-play-simulasi');
        var btnLabel = document.getElementById('label-play-simulasi');

        if (simulasiInterval) {
            clearInterval(simulasiInterval);
            simulasiInterval = null;
            btnIcon.className = 'fa-solid fa-play';
            btnLabel.innerText = 'Lanjutkan';
        } else {
            if (waktuSimulasi >= 6) {
                waktuSimulasi = 0;
            }
            btnIcon.className = 'fa-solid fa-pause';
            btnLabel.innerText = 'Jeda';

            simulasiInterval = setInterval(function () {
                waktuSimulasi += 0.05;
                if (waktuSimulasi >= 6) {
                    waktuSimulasi = 6;
                    clearInterval(simulasiInterval);
                    simulasiInterval = null;
                    btnIcon.className = 'fa-solid fa-rotate-right';
                    btnLabel.innerText = 'Ulangi';
                }
                ubahWaktuSimulasi(waktuSimulasi);
            }, 80);
        }
    }

    function resetSimulasi() {
        if (simulasiInterval) {
            clearInterval(simulasiInterval);
            simulasiInterval = null;
        }
        if (markerApiSekunder && markerApiSekunder.length > 0) {
            markerApiSekunder.forEach(function (m) {
                if (m) {
                    peta.removeLayer(m);
                }
            });
            markerApiSekunder = [];
        }
        var btnIcon = document.getElementById('icon-play-simulasi');
        var btnLabel = document.getElementById('label-play-simulasi');
        btnIcon.className = 'fa-solid fa-play';
        btnLabel.innerText = 'Mulai Simulasi';
        ubahWaktuSimulasi(0);
    }

    function fokusPrediksi(lat, lng) {
        if (!peta) return;
        peta.setView([lat, lng], 14, { animate: true });
        window.scrollTo({
            top: document.getElementById('peta-peringatan').offsetTop - 100,
            behavior: 'smooth'
        });
    }
</script>
@endsection
