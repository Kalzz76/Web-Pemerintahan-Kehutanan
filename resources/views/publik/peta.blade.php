@extends('layouts.publik')

@section('title', 'Peta Kawasan Hutan Jawa Barat')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-black text-stone-900 tracking-tight">Peta Kawasan Hutan Jawa Barat</h1>
            <p class="text-stone-500 text-sm mt-1">Pantau batas wilayah zonasi hutan konservasi Jawa Barat, pos jaga, sumber air, permukiman warga, serta laporan darurat terverifikasi.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3 bg-white p-3 rounded-2xl border border-stone-200 shadow-sm text-xs font-semibold text-stone-700">
            <span class="text-stone-400 font-bold uppercase text-[10px] tracking-wider px-1">Lapisan Peta:</span>
            <label class="flex items-center space-x-2 cursor-pointer select-none">
                <input type="checkbox" id="centang-kawasan" checked onchange="alihLapisan('kawasan')" class="rounded border-stone-300 text-green-700 focus:ring-green-500">
                <span class="flex items-center"><span class="w-3 h-3 rounded-sm bg-green-700 opacity-60 mr-1.5 inline-block"></span> Kawasan</span>
            </label>
            <label class="flex items-center space-x-2 cursor-pointer select-none">
                <input type="checkbox" id="centang-titik" checked onchange="alihLapisan('titik')" class="rounded border-stone-300 text-blue-700 focus:ring-blue-500">
                <span class="flex items-center"><span class="w-3 h-3 rounded-full bg-blue-600 mr-1.5 inline-block"></span> Titik Penting</span>
            </label>
            <label class="flex items-center space-x-2 cursor-pointer select-none">
                <input type="checkbox" id="centang-laporan" checked onchange="alihLapisan('laporan')" class="rounded border-stone-300 text-red-600 focus:ring-red-500">
                <span class="flex items-center"><span class="w-3 h-3 rounded-full bg-red-600 mr-1.5 inline-block"></span> Laporan Terverifikasi</span>
            </label>
        </div>
    </div>

    <div class="mb-4">
        <livewire:pilih-wilayah />
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-stone-100 p-4 relative mb-8">
        <livewire:peta-layar-penuh id-peta="peta-publik" tinggi="70vh" />
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-6">
        <h2 class="text-xs font-bold uppercase text-stone-400 tracking-wider mb-4">Keterangan Simbol & Warna Peta</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3 sm:gap-4 text-xs font-medium text-stone-700">
            <div class="flex items-center space-x-2">
                <span class="w-3.5 h-3.5 rounded-full bg-[#dc2626] shrink-0 shadow-sm"></span>
                <span class="whitespace-nowrap">Kebakaran</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="w-3.5 h-3.5 rounded-full bg-[#ea580c] shrink-0 shadow-sm"></span>
                <span class="whitespace-nowrap">Hewan Masuk</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="w-3.5 h-3.5 rounded-full bg-[#2563eb] shrink-0 shadow-sm"></span>
                <span class="whitespace-nowrap">Pos Jaga</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="w-3.5 h-3.5 rounded-full bg-[#991b1b] shrink-0 shadow-sm"></span>
                <span class="whitespace-nowrap">Pos Pemadam</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="w-3.5 h-3.5 rounded-full bg-[#0891b2] shrink-0 shadow-sm"></span>
                <span class="whitespace-nowrap">Sumber Air</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="w-3.5 h-3.5 rounded-full bg-[#16a34a] shrink-0 shadow-sm"></span>
                <span class="whitespace-nowrap">Titik Evakuasi</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="w-3.5 h-3.5 rounded-full bg-[#ca8a04] shrink-0 shadow-sm"></span>
                <span class="whitespace-nowrap">Permukiman</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="w-3.5 h-3.5 border-2 border-[#15803d] bg-green-200/50 rounded-sm shrink-0"></span>
                <span class="whitespace-nowrap">Kawasan Hutan</span>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>

<script>
var map;
var layerKawasan = L.layerGroup();
var layerTitik = L.layerGroup();
var layerLaporan = L.layerGroup();

function alihLapisan(nama) {
    if (nama === 'kawasan') {
        var centang = document.getElementById('centang-kawasan').checked;
        if (centang) {
            map.addLayer(layerKawasan);
        } else {
            map.removeLayer(layerKawasan);
        }
    } else if (nama === 'titik') {
        var centang = document.getElementById('centang-titik').checked;
        if (centang) {
            map.addLayer(layerTitik);
        } else {
            map.removeLayer(layerTitik);
        }
    } else if (nama === 'laporan') {
        var centang = document.getElementById('centang-laporan').checked;
        if (centang) {
            map.addLayer(layerLaporan);
        } else {
            map.removeLayer(layerLaporan);
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {
    var latPusat = {{ $pengaturan->lat_pusat ?? -6.87 }};
    var longPusat = {{ $pengaturan->long_pusat ?? 107.60 }};
    var zoomAwal = {{ $pengaturan->zoom_awal ?? 8 }};

    var bboxBarat = {{ $pengaturan->bbox_barat ?? 106.36 }};
    var bboxSelatan = {{ $pengaturan->bbox_selatan ?? -7.83 }};
    var bboxTimur = {{ $pengaturan->bbox_timur ?? 108.85 }};
    var bboxUtara = {{ $pengaturan->bbox_utara ?? -5.90 }};
    var boundsJabar = L.latLngBounds([bboxSelatan, bboxBarat], [bboxUtara, bboxTimur]);

    map = L.map('peta-publik', {
        maxBounds: boundsJabar,
        minZoom: 7
    }).setView([latPusat, longPusat], zoomAwal);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    layerKawasan.addTo(map);
    layerTitik.addTo(map);
    layerLaporan.addTo(map);

    var dataKawasan = @json($daftarKawasan);
    dataKawasan.forEach(function (k) {
        if (k.geojson) {
            try {
                var parsed = JSON.parse(k.geojson);
                var polyLayer = L.geoJSON(parsed, {
                    style: {
                        color: '#15803d',
                        fillColor: '#15803d',
                        fillOpacity: 0.2,
                        weight: 2
                    }
                });

                var labelPerkiraan = (!k.batas_resmi)
                    ? '<div class="mb-2"><span class="inline-block text-[10px] font-semibold px-2 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-md">Batas perkiraan</span></div>'
                    : '';

                var kategoriInfo = k.kategori ? '<div class="text-[10px] font-bold uppercase tracking-wider text-green-700 mb-0.5">' + k.kategori + '</div>' : '<div class="text-[10px] font-bold uppercase tracking-wider text-green-700 mb-0.5">Kawasan Hutan</div>';
                var pengelolaInfo = k.pengelola ? '<div class="text-[11px] text-stone-500 mb-1">Pengelola: ' + k.pengelola + '</div>' : '';

                var popupContent = '<div class="p-2 font-sans max-w-xs">' +
                    kategoriInfo +
                    '<h4 class="font-bold text-stone-900 text-sm mb-1">' + k.nama + '</h4>' +
                    labelPerkiraan +
                    pengelolaInfo +
                    (k.jenis_lahan ? '<div class="text-xs text-stone-600 mb-1">Tipe Lahan: <strong>' + k.jenis_lahan.nama + '</strong></div>' : '') +
                    (k.luas_ha ? '<div class="text-xs text-stone-600 mb-2">Luas: <strong>' + k.luas_ha + ' ha</strong></div>' : '') +
                    '<p class="text-xs text-stone-600 leading-relaxed">' + k.deskripsi + '</p>' +
                    '</div>';

                polyLayer.bindPopup(popupContent);
                layerKawasan.addLayer(polyLayer);
            } catch (e) {}
        }
    });

    var dataTitik = @json($daftarTitik);
    dataTitik.forEach(function (t) {
        var warna = '#15803d';
        if (t.jenis === 'Pos Jaga') warna = '#2563eb';
        if (t.jenis === 'Pos Pemadam') warna = '#991b1b';
        if (t.jenis === 'Sumber Air') warna = '#0891b2';
        if (t.jenis === 'Titik Kumpul Evakuasi') warna = '#16a34a';
        if (t.jenis === 'Permukiman') warna = '#ca8a04';

        var marker = L.circleMarker([t.latitude, t.longitude], {
            radius: 8,
            color: warna,
            fillColor: warna,
            fillOpacity: 0.9,
            weight: 3
        });

        var popupContent = '<div class="p-2 font-sans max-w-xs">' +
            '<div class="text-[10px] font-bold uppercase tracking-wider text-stone-500 mb-1">' + t.jenis + '</div>' +
            '<h4 class="font-bold text-stone-900 text-sm mb-1.5">' + t.nama + '</h4>' +
            (t.foto ? '<div class="w-full h-28 rounded-lg overflow-hidden mb-2 bg-stone-100"><img src="/storage/' + t.foto + '" class="w-full h-full object-cover"></div>' : '') +
            '<p class="text-xs text-stone-600 leading-relaxed mb-2">' + t.deskripsi + '</p>' +
            (t.kontak ? '<div class="text-xs font-semibold text-green-800 pt-2 border-t border-stone-100"><i class="fa-solid fa-phone mr-1 text-[10px]"></i> ' + t.kontak + '</div>' : '') +
            '</div>';

        marker.bindPopup(popupContent);
        layerTitik.addLayer(marker);
    });

    var dataLaporan = @json($daftarLaporan);
    dataLaporan.forEach(function (l) {
        var warna = '#57534e';
        if (l.jenis === 'Kebakaran') {
            warna = '#dc2626';
        } else if (l.jenis === 'Hewan Masuk Kampung') {
            warna = '#ea580c';
        } else if (l.jenis === 'Orang Hilang') {
            warna = '#0284c7';
        }

        var marker = L.circleMarker([l.latitude, l.longitude], {
            radius: 9,
            color: warna,
            fillColor: warna,
            fillOpacity: 0.9,
            weight: 3
        });

        var badgeClass = l.status === 'Diverifikasi' ? 'bg-amber-100 text-amber-800' : 'bg-sky-100 text-sky-800';

        var popupContent = '<div class="p-2 font-sans max-w-xs">' +
            '<div class="flex items-center justify-between mb-1">' +
            '<span class="text-[10px] font-bold uppercase tracking-wider text-red-600">Laporan ' + l.jenis + '</span>' +
            '<span class="text-[10px] font-bold px-2 py-0.5 rounded-full ' + badgeClass + '">' + l.status + '</span>' +
            '</div>' +
            '<h4 class="font-bold text-stone-900 text-sm mb-1">' + (l.jenis_hewan ? l.jenis_hewan : l.jenis) + '</h4>' +
            (l.foto ? '<div class="w-full h-28 rounded-lg overflow-hidden mb-2 bg-stone-100"><img src="/storage/' + l.foto + '" class="w-full h-full object-cover"></div>' : '') +
            '<p class="text-xs text-stone-600 leading-relaxed mb-2">' + l.deskripsi + '</p>' +
            '<div class="text-[10px] text-stone-400 pt-1 border-t border-stone-100">Kode: ' + l.kode + '</div>' +
            '</div>';

        marker.bindPopup(popupContent);
        layerLaporan.addLayer(marker);
    });

    window.addEventListener('peta-toggle-layar-penuh', function (e) {
        var detail = e.detail;
        if (Array.isArray(detail)) {
            detail = detail[0] || {};
        }
        var el = document.getElementById('peta-publik');
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

    window.addEventListener('peta-terbang', function (e) {
        var detail = e.detail;
        if (Array.isArray(detail)) {
            detail = detail[0] || {};
        }
        var lat = detail.lat;
        var long = detail.long;
        var zoom = detail.zoom || 12;
        if (typeof map !== 'undefined' && map && lat && long) {
            map.flyTo([lat, long], zoom);
        }
    });
});
</script>
@endsection
