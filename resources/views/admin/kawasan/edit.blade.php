@extends('layouts.admin')

@section('title', 'Edit Kawasan Hutan')

@section('content')
<div class="mb-8">
    <div class="flex items-center space-x-2 text-xs text-stone-500 mb-2">
        <a href="{{ route('admin.kawasan.index') }}" class="hover:text-green-700">A. Kawasan Hutan</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-stone-800 font-semibold">Edit Kawasan</span>
    </div>
    <h1 class="text-2xl md:text-3xl font-extrabold text-stone-900 tracking-tight">Edit Kawasan: {{ $kawasan->nama }}</h1>
    <p class="text-stone-500 text-sm mt-1">Perbarui batas wilayah poligon atau informasi tutupan lahan.</p>
</div>

<form method="POST" action="{{ route('admin.kawasan.update', $kawasan->id) }}" class="space-y-8">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-6 space-y-5">
                <h2 class="text-base font-bold text-stone-900 pb-3 border-b border-stone-100 flex items-center">
                    <i class="fa-solid fa-pen-nib text-green-700 mr-2"></i>
                    <span>Informasi Kawasan</span>
                </h2>

                <div>
                    <label for="nama" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Nama Kawasan</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $kawasan->nama) }}" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition">
                </div>

                <div>
                    <label for="id_jenis_lahan" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Jenis Lahan</label>
                    <select id="id_jenis_lahan" name="id_jenis_lahan" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition bg-white">
                        <option value="">-- Pilih Jenis Lahan --</option>
                        @foreach ($daftarJenisLahan as $jenis)
                            <option value="{{ $jenis->id }}" {{ old('id_jenis_lahan', $kawasan->id_jenis_lahan) == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->nama }} (Laju: {{ $jenis->laju_dasar }} m/jam)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="luas_ha" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Luas Wilayah (Hektar, Opsional)</label>
                    <input type="number" step="0.01" id="luas_ha" name="luas_ha" value="{{ old('luas_ha', $kawasan->luas_ha) }}" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition font-mono">
                </div>

                <div>
                    <label for="deskripsi" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Deskripsi Kawasan</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition">{{ old('deskripsi', $kawasan->deskripsi) }}</textarea>
                </div>

                <textarea name="geojson" id="geojson" class="hidden">{{ old('geojson', $kawasan->geojson) }}</textarea>

                <div class="pt-4 border-t border-stone-100 flex items-center justify-between">
                    <a href="{{ route('admin.kawasan.index') }}" class="px-5 py-2.5 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-semibold transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-green-700 hover:bg-green-600 text-white text-xs font-bold transition shadow">
                        Perbarui Kawasan
                    </button>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-6 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-stone-100">
                    <h2 class="text-base font-bold text-stone-900 flex items-center">
                        <i class="fa-solid fa-draw-polygon text-green-700 mr-2"></i>
                        <span>Gambar Batas Poligon Kawasan</span>
                    </h2>
                    <span class="text-xs text-stone-400">Edit poligon yang sudah ada</span>
                </div>

                <div class="p-3.5 rounded-xl bg-green-50 border border-green-200 text-green-900 text-xs flex items-center space-x-2">
                    <i class="fa-solid fa-circle-info text-green-700 text-sm shrink-0"></i>
                    <span>Anda dapat mengedit titik poligon atau menghapusnya dan menggambar ulang poligon baru.</span>
                </div>

                <div id="peta-kawasan" class="w-full h-[520px] rounded-xl border border-stone-200 overflow-hidden z-10"></div>
            </div>
        </div>
    </div>
</form>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var latPusat = {{ $pengaturan->lat_pusat ?? -6.8921000 }};
    var longPusat = {{ $pengaturan->long_pusat ?? 108.4112000 }};
    var zoomAwal = {{ $pengaturan->zoom_awal ?? 13 }};

    var map = L.map('peta-kawasan').setView([latPusat, longPusat], zoomAwal);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    var drawControl = new L.Control.Draw({
        draw: {
            polygon: {
                allowIntersection: false,
                showArea: true,
                shapeOptions: {
                    color: '#15803d',
                    fillColor: '#15803d',
                    fillOpacity: 0.25,
                    weight: 2
                }
            },
            polyline: false,
            rectangle: false,
            circle: false,
            circlemarker: false,
            marker: false
        },
        edit: {
            featureGroup: drawnItems,
            remove: true
        }
    });
    map.addControl(drawControl);

    var existingGeojson = document.getElementById('geojson').value;
    if (existingGeojson) {
        try {
            var parsed = JSON.parse(existingGeojson);
            var geoLayer = L.geoJSON(parsed, {
                style: {
                    color: '#15803d',
                    fillColor: '#15803d',
                    fillOpacity: 0.25,
                    weight: 2
                }
            });
            geoLayer.eachLayer(function (layer) {
                drawnItems.addLayer(layer);
            });
            map.fitBounds(drawnItems.getBounds());
        } catch (e) {}
    }

    map.on(L.Draw.Event.CREATED, function (e) {
        drawnItems.clearLayers();
        var layer = e.layer;
        drawnItems.addLayer(layer);
        var geojsonObj = layer.toGeoJSON();
        document.getElementById('geojson').value = JSON.stringify(geojsonObj);
    });

    map.on(L.Draw.Event.EDITED, function () {
        var layers = drawnItems.getLayers();
        if (layers.length > 0) {
            var geojsonObj = layers[0].toGeoJSON();
            document.getElementById('geojson').value = JSON.stringify(geojsonObj);
        } else {
            document.getElementById('geojson').value = '';
        }
    });

    map.on(L.Draw.Event.DELETED, function () {
        document.getElementById('geojson').value = '';
    });
});
</script>
@endsection
