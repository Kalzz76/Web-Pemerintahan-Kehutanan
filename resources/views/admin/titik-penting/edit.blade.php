@extends('layouts.admin')

@section('title', 'Edit Titik Penting')

@section('breadcrumb')
    <span class="text-stone-300">/</span>
    <a href="{{ route('admin.titik-penting.index') }}" class="hover:text-[#0F8179] transition">Titik Penting</a>
    <span class="text-stone-300">/</span>
    <span class="text-stone-800 font-semibold">Edit Titik</span>
@endsection

@section('content')
<div class="mb-5">
    <h1 class="text-lg md:text-xl font-bold text-stone-900 tracking-tight">Edit Titik: {{ $titik->nama }}</h1>
    <p class="text-stone-500 text-xs mt-0.5">Perbarui koordinat lokasi, kontak, atau informasi titik penting.</p>
</div>

<form method="POST" action="{{ route('admin.titik-penting.update', $titik->id) }}" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-1 space-y-5">
            <div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 p-4 sm:p-5 space-y-4">
                <h2 class="text-sm font-bold text-stone-900 pb-3 border-b border-stone-200/80 flex items-center">
                    <i class="fa-solid fa-pen-nib text-stone-700 mr-2"></i>
                    <span>Informasi Titik</span>
                </h2>

                <div>
                    <label for="nama" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Nama Titik</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $titik->nama) }}" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition">
                </div>

                <div>
                    <label for="jenis" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Jenis Titik</label>
                    <select id="jenis" name="jenis" required onchange="perbaruiWarnaMarker()" class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition bg-white">
                        <option value="Pos Jaga" {{ old('jenis', $titik->jenis) == 'Pos Jaga' ? 'selected' : '' }}>Pos Jaga</option>
                        <option value="Pos Pemadam" {{ old('jenis', $titik->jenis) == 'Pos Pemadam' ? 'selected' : '' }}>Pos Pemadam</option>
                        <option value="Sumber Air" {{ old('jenis', $titik->jenis) == 'Sumber Air' ? 'selected' : '' }}>Sumber Air</option>
                        <option value="Titik Kumpul Evakuasi" {{ old('jenis', $titik->jenis) == 'Titik Kumpul Evakuasi' ? 'selected' : '' }}>Titik Kumpul Evakuasi</option>
                        <option value="Permukiman" {{ old('jenis', $titik->jenis) == 'Permukiman' ? 'selected' : '' }}>Permukiman</option>
                    </select>
                </div>

                <div>
                    <label for="id_kawasan" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Kawasan Hutan (Opsional)</label>
                    <select id="id_kawasan" name="id_kawasan" class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition bg-white">
                        <option value="">-- Berada di Luar Kawasan Hutan --</option>
                        @foreach ($daftarKawasan as $kawasan)
                            <option value="{{ $kawasan->id }}" {{ old('id_kawasan', $titik->id_kawasan) == $kawasan->id ? 'selected' : '' }}>
                                {{ $kawasan->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="id_kabupaten_kota" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Kabupaten / Kota (Opsional)</label>
                    <select id="id_kabupaten_kota" name="id_kabupaten_kota" class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition bg-white">
                        <option value="">-- Pilih Kabupaten / Kota di Jawa Barat --</option>
                        @foreach ($daftarKabupaten as $kab)
                            <option value="{{ $kab->id }}" {{ old('id_kabupaten_kota', $titik->id_kabupaten_kota) == $kab->id ? 'selected' : '' }}>
                                {{ $kab->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="latitude" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Latitude</label>
                        <input type="number" step="0.0000001" id="latitude" name="latitude" value="{{ old('latitude', $titik->latitude) }}" required class="w-full px-3 py-2 rounded-xl border border-stone-200 text-xs focus:border-stone-900 outline-none transition font-mono bg-stone-50">
                    </div>
                    <div>
                        <label for="longitude" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Longitude</label>
                        <input type="number" step="0.0000001" id="longitude" name="longitude" value="{{ old('longitude', $titik->longitude) }}" required class="w-full px-3 py-2 rounded-xl border border-stone-200 text-xs focus:border-stone-900 outline-none transition font-mono bg-stone-50">
                    </div>
                </div>

                <div>
                    <label for="kontak" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Kontak Petugas / PJ (Opsional)</label>
                    <input type="text" id="kontak" name="kontak" value="{{ old('kontak', $titik->kontak) }}" placeholder="Contoh: Pak RT: 08123456789" class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Foto Lokasi</label>
                    @if ($titik->foto)
                        <div class="w-16 h-16 rounded-xl overflow-hidden mb-2 border border-stone-200">
                            <img src="{{ asset('storage/' . $titik->foto) }}" alt="{{ $titik->nama }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <input type="file" id="foto" name="foto" accept="image/png,image/jpeg,image/jpg" class="w-full text-xs text-stone-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-stone-100 file:text-stone-800 hover:file:bg-stone-200 transition cursor-pointer">
                    <p class="text-[10px] text-stone-400 mt-1">Biarkan kosong bila tidak ingin mengganti foto.</p>
                </div>

                <div>
                    <label for="deskripsi" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Deskripsi Titik</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition">{{ old('deskripsi', $titik->deskripsi) }}</textarea>
                </div>

                <div class="pt-3 border-t border-stone-200/80 flex items-center justify-between">
                    <a href="{{ route('admin.titik-penting.index') }}" class="px-4 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 border border-stone-300 text-xs font-semibold transition">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-stone-900 hover:bg-stone-800 text-white text-xs font-semibold transition active:scale-95 shadow-sm">
                        Perbarui Titik
                    </button>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 p-4 sm:p-5 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-stone-200/80">
                    <h2 class="text-sm font-bold text-stone-900 flex items-center">
                        <i class="fa-solid fa-map-pin text-stone-700 mr-2"></i>
                        <span>Pilih Lokasi Titik di Peta</span>
                    </h2>
                    <span class="text-xs text-stone-400">Klik peta untuk memindahkan posisi</span>
                </div>

                <div class="p-3 rounded-xl bg-stone-100 border border-stone-200 text-stone-700 text-xs flex items-center space-x-2">
                    <i class="fa-solid fa-crosshairs text-stone-500 text-xs shrink-0"></i>
                    <span>Klik pada peta untuk mengubah posisi koordinat Latitude dan Longitude.</span>
                </div>

                <div id="peta-titik" class="w-full h-[540px] rounded-xl border border-stone-200 overflow-hidden z-10"></div>
            </div>
        </div>
    </div>
</form>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>

<script>
var map;
var currentMarker = null;

function dapatkanWarnaJenis(jenis) {
    if (jenis === 'Pos Jaga') return '#2563eb';
    if (jenis === 'Pos Pemadam') return '#991b1b';
    if (jenis === 'Sumber Air') return '#0891b2';
    if (jenis === 'Titik Kumpul Evakuasi') return '#16a34a';
    if (jenis === 'Permukiman') return '#ca8a04';
    return '#15803d';
}

function perbaruiWarnaMarker() {
    if (currentMarker) {
        var jenis = document.getElementById('jenis').value;
        var warna = dapatkanWarnaJenis(jenis);
        currentMarker.setStyle({
            color: warna,
            fillColor: warna
        });
    }
}

document.addEventListener('DOMContentLoaded', function () {
    var latPusat = {{ $titik->latitude ?? $pengaturan->lat_pusat ?? -6.87 }};
    var longPusat = {{ $titik->longitude ?? $pengaturan->long_pusat ?? 107.60 }};
    var zoomAwal = 15;

    var bboxBarat = {{ $pengaturan->bbox_barat ?? 106.36 }};
    var bboxSelatan = {{ $pengaturan->bbox_selatan ?? -7.83 }};
    var bboxTimur = {{ $pengaturan->bbox_timur ?? 108.85 }};
    var bboxUtara = {{ $pengaturan->bbox_utara ?? -5.90 }};
    var boundsJabar = L.latLngBounds([bboxSelatan, bboxBarat], [bboxUtara, bboxTimur]);

    map = L.map('peta-titik', {
        maxBounds: boundsJabar,
        minZoom: 7
    }).setView([latPusat, longPusat], zoomAwal);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var kawasanList = @json($semuaKawasan);
    kawasanList.forEach(function (k) {
        if (k.geojson) {
            try {
                var parsed = JSON.parse(k.geojson);
                var layer = L.geoJSON(parsed, {
                    style: {
                        color: '#15803d',
                        fillColor: '#15803d',
                        fillOpacity: 0.15,
                        weight: 2
                    }
                }).addTo(map);
                layer.bindTooltip(k.nama, { sticky: true });
            } catch (e) {}
        }
    });

    var latInput = document.getElementById('latitude');
    var longInput = document.getElementById('longitude');

    function letakkanMarker(lat, lng) {
        var jenis = document.getElementById('jenis').value;
        var warna = dapatkanWarnaJenis(jenis);

        if (currentMarker) {
            currentMarker.setLatLng([lat, lng]);
            currentMarker.setStyle({
                color: warna,
                fillColor: warna
            });
        } else {
            currentMarker = L.circleMarker([lat, lng], {
                radius: 9,
                color: warna,
                fillColor: warna,
                fillOpacity: 0.9,
                weight: 3
            }).addTo(map);
        }

        latInput.value = parseFloat(lat).toFixed(7);
        longInput.value = parseFloat(lng).toFixed(7);
    }

    if (latInput.value && longInput.value) {
        letakkanMarker(parseFloat(latInput.value), parseFloat(longInput.value));
    }

    map.on('click', function (e) {
        letakkanMarker(e.latlng.lat, e.latlng.lng);
    });
});
</script>
@endsection
