@extends('layouts.admin')

@section('title', 'Edit Kawasan Hutan')

@section('breadcrumb')
    <span class="text-stone-300">/</span>
    <a href="{{ route('admin.kawasan.index') }}" class="hover:text-[#0F8179] transition">Kawasan Hutan</a>
    <span class="text-stone-300">/</span>
    <span class="text-stone-800 font-semibold">Edit Kawasan</span>
@endsection

@section('content')
<div class="mb-5">
    <h1 class="text-lg md:text-xl font-bold text-stone-900 tracking-tight">Edit Kawasan: {{ $kawasan->nama }}</h1>
    <p class="text-stone-500 text-xs mt-0.5">Perbarui batas wilayah poligon atau informasi konservasi kawasan hutan.</p>
</div>

@if ($errors->any())
    <div class="bg-stone-100 border border-stone-300 text-stone-800 rounded-2xl p-4 mb-5 text-xs">
        <div class="font-bold mb-1 flex items-center">
            <i class="fa-solid fa-triangle-exclamation mr-1.5"></i>
            <span>Periksa kembali data yang diisi:</span>
        </div>
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.kawasan.update', $kawasan->id) }}" class="space-y-5">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-1 space-y-5">
            <div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 p-4 sm:p-5 space-y-4">
                <h2 class="text-sm font-bold text-stone-900 pb-3 border-b border-stone-200/80 flex items-center">
                    <i class="fa-solid fa-pen-nib text-stone-700 mr-2"></i>
                    <span>Informasi Kawasan</span>
                </h2>

                <div>
                    <label for="nama" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Nama Kawasan <span class="text-rose-500">*</span></label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $kawasan->nama) }}" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition">
                </div>

                <div>
                    <label for="kategori" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Kategori <span class="text-rose-500">*</span></label>
                    <select id="kategori" name="kategori" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition bg-white">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach(['Taman Nasional', 'Cagar Alam', 'Suaka Margasatwa', 'Taman Wisata Alam', 'Taman Buru', 'Taman Hutan Raya', 'Hutan Lindung', 'Hutan Produksi', 'Lainnya'] as $kat)
                            <option value="{{ $kat }}" {{ old('kategori', $kawasan->kategori) === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="pengelola" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Instansi Pengelola</label>
                    <input type="text" id="pengelola" name="pengelola" value="{{ old('pengelola', $kawasan->pengelola) }}" placeholder="Contoh: Balai Besar KSDA Jawa Barat" class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition">
                </div>

                <div>
                    <label for="id_jenis_lahan" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Jenis Lahan <span class="text-rose-500">*</span></label>
                    <select id="id_jenis_lahan" name="id_jenis_lahan" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition bg-white">
                        <option value="">-- Pilih Jenis Lahan --</option>
                        @foreach ($daftarJenisLahan as $jenis)
                            <option value="{{ $jenis->id }}" {{ old('id_jenis_lahan', $kawasan->id_jenis_lahan) == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->nama }} (Laju: {{ $jenis->laju_dasar }} m/jam)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="luas_ha" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Luas Wilayah (Hektar, Opsional)</label>
                    <input type="number" step="0.01" id="luas_ha" name="luas_ha" value="{{ old('luas_ha', $kawasan->luas_ha) }}" class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition font-mono">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="lat_pusat" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Latitude Pusat</label>
                        <input type="number" step="any" id="lat_pusat" name="lat_pusat" value="{{ old('lat_pusat', $kawasan->lat_pusat) }}" placeholder="-6.8900" class="w-full px-3 py-1.5 rounded-xl border border-stone-200 text-xs focus:border-stone-900 outline-none font-mono">
                    </div>
                    <div>
                        <label for="long_pusat" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Longitude Pusat</label>
                        <input type="number" step="any" id="long_pusat" name="long_pusat" value="{{ old('long_pusat', $kawasan->long_pusat) }}" placeholder="107.6000" class="w-full px-3 py-1.5 rounded-xl border border-stone-200 text-xs focus:border-stone-900 outline-none font-mono">
                    </div>
                </div>

                <div class="p-3 bg-stone-50 rounded-xl border border-stone-200/80">
                    <label class="flex items-start space-x-2.5 cursor-pointer">
                        <input type="checkbox" name="batas_resmi" value="1" {{ old('batas_resmi', $kawasan->batas_resmi) ? 'checked' : '' }} class="mt-0.5 rounded border-stone-300 text-stone-900 focus:ring-stone-800">
                        <div>
                            <span class="text-xs font-bold text-stone-900 block">Batas sudah sesuai data resmi</span>
                            <span class="text-[11px] text-stone-500 block">Jika belum dicentang, batas akan ditandai dengan label "Batas perkiraan".</span>
                        </div>
                    </label>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Kabupaten / Kota Terkait</label>
                    @php
                        $selectedKab = old('kabupaten_kota', $kawasan->kabupatenKota->pluck('id')->toArray());
                    @endphp
                    <div class="max-h-44 overflow-y-auto p-3 bg-stone-50 rounded-xl border border-stone-200/80 space-y-2">
                        @foreach ($daftarKabupaten as $kab)
                            <label class="flex items-center space-x-2 text-xs text-stone-700 cursor-pointer">
                                <input type="checkbox" name="kabupaten_kota[]" value="{{ $kab->id }}" {{ in_array($kab->id, $selectedKab) ? 'checked' : '' }} class="rounded border-stone-300 text-stone-900 focus:ring-stone-800">
                                <span>{{ $kab->nama }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label for="deskripsi" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Deskripsi Kawasan <span class="text-rose-500">*</span></label>
                    <textarea id="deskripsi" name="deskripsi" rows="3" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition">{{ old('deskripsi', $kawasan->deskripsi) }}</textarea>
                </div>

                <textarea name="geojson" id="geojson" class="hidden">{{ old('geojson', $kawasan->geojson) }}</textarea>

                <div class="pt-3 border-t border-stone-200/80 flex items-center justify-between">
                    <a href="{{ route('admin.kawasan.index') }}" class="px-4 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 border border-stone-300 text-xs font-semibold transition">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-stone-900 hover:bg-stone-800 text-white text-xs font-semibold transition active:scale-95 shadow-sm">
                        Perbarui Kawasan
                    </button>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 p-4 sm:p-5 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-stone-200/80">
                    <h2 class="text-sm font-bold text-stone-900 flex items-center">
                        <i class="fa-solid fa-draw-polygon text-stone-700 mr-2"></i>
                        <span>Gambar Batas Poligon Kawasan Jawa Barat</span>
                    </h2>
                    <span class="text-xs text-stone-400">Edit poligon yang sudah ada</span>
                </div>

                <div class="p-3 rounded-xl bg-stone-100 border border-stone-200 text-stone-700 text-xs flex items-center space-x-2">
                    <i class="fa-solid fa-circle-info text-stone-500 text-xs shrink-0"></i>
                    <span>Anda dapat mengedit titik poligon atau menghapusnya dan menggambar ulang poligon baru.</span>
                </div>

                <div id="peta-kawasan" class="w-full h-[580px] rounded-xl border border-stone-200 overflow-hidden z-10"></div>
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
    var latPusat = {{ $kawasan->lat_pusat ?? $pengaturan->lat_pusat ?? -6.87 }};
    var longPusat = {{ $kawasan->long_pusat ?? $pengaturan->long_pusat ?? 107.60 }};
    var zoomAwal = {{ $pengaturan->zoom_awal ?? 8 }};

    var bboxBarat = {{ $pengaturan->bbox_barat ?? 106.36 }};
    var bboxSelatan = {{ $pengaturan->bbox_selatan ?? -7.83 }};
    var bboxTimur = {{ $pengaturan->bbox_timur ?? 108.85 }};
    var bboxUtara = {{ $pengaturan->bbox_utara ?? -5.90 }};
    var boundsJabar = L.latLngBounds([bboxSelatan, bboxBarat], [bboxUtara, bboxTimur]);

    var map = L.map('peta-kawasan', {
        maxBounds: boundsJabar,
        minZoom: 7
    }).setView([latPusat, longPusat], zoomAwal);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    var drawControl = new L.Control.Draw({
        draw: {
            polygon: {
                allowIntersection: false,
                showArea: true,
                drawError: {
                    color: '#e11d48',
                    message: 'Poligon tidak boleh saling silang!'
                },
                shapeOptions: {
                    color: '#15803d'
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

    var geojsonLama = document.getElementById('geojson').value;
    if (geojsonLama) {
        try {
            var parsed = JSON.parse(geojsonLama);
            var layer = L.geoJSON(parsed, {
                style: {
                    color: '#15803d'
                }
            });
            layer.eachLayer(function (l) {
                drawnItems.addLayer(l);
            });
            map.fitBounds(drawnItems.getBounds(), { padding: [20, 20] });
        } catch (e) {}
    }

    map.on(L.Draw.Event.CREATED, function (e) {
        drawnItems.clearLayers();
        var layer = e.layer;
        drawnItems.addLayer(layer);
        var geojson = layer.toGeoJSON();
        document.getElementById('geojson').value = JSON.stringify(geojson.geometry);

        var bounds = layer.getBounds();
        var center = bounds.getCenter();
        if (!document.getElementById('lat_pusat').value) {
            document.getElementById('lat_pusat').value = center.lat.toFixed(6);
        }
        if (!document.getElementById('long_pusat').value) {
            document.getElementById('long_pusat').value = center.lng.toFixed(6);
        }
    });

    map.on(L.Draw.Event.EDITED, function () {
        var layers = drawnItems.getLayers();
        if (layers.length > 0) {
            var geojson = layers[0].toGeoJSON();
            document.getElementById('geojson').value = JSON.stringify(geojson.geometry);
        }
    });

    map.on(L.Draw.Event.DELETED, function () {
        document.getElementById('geojson').value = '';
    });
});
</script>
@endsection
