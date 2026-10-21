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
    var dataPrediksi = @json($daftarPeringatan);
    var dataPermukiman = @json($daftarPermukiman);
    var latPusat = {{ $pengaturan->lat_pusat ?? -0.7893 }};
    var longPusat = {{ $pengaturan->long_pusat ?? 113.9213 }};
    var zoomAwal = {{ $pengaturan->zoom_awal ?? 12 }};

    document.addEventListener('DOMContentLoaded', function () {
        var petaEl = document.getElementById('peta-peringatan');
        if (!petaEl) return;

        peta = L.map('peta-peringatan').setView([latPusat, longPusat], zoomAwal);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(peta);

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
                    fillOpacity: 0.9
                }).addTo(peta);

                var pop = '<div class="p-1 font-sans text-xs">' +
                    '<div class="font-bold text-stone-900">' + p.nama + '</div>' +
                    '<div class="text-[10px] text-blue-600 font-semibold uppercase">Permukiman Warga</div>' +
                    '</div>';
                marker.bindPopup(pop);
            }
        });

        dataPrediksi.forEach(function (pred) {
            var lat0 = parseFloat(pred.latitude);
            var lng0 = parseFloat(pred.longitude);

            bounds.push([lat0, lng0]);

            var fireMarker = L.circleMarker([lat0, lng0], {
                radius: 9,
                fillColor: '#991b1b',
                color: '#ffffff',
                weight: 2,
                opacity: 1,
                fillOpacity: 1
            }).addTo(peta);

            fireMarker.bindPopup('<div class="p-1 font-sans text-xs">' +
                '<div class="font-bold text-rose-700">Titik Awal Api</div>' +
                '<div class="text-[10px] text-stone-500">Laju: ' + pred.laju_efektif + ' m/jam</div>' +
                '</div>');

            if (pred.poligon_6jam) {
                try {
                    var poly6 = JSON.parse(pred.poligon_6jam);
                    if (poly6.length > 0) {
                        L.polygon(poly6, {
                            color: '#ca8a04',
                            fillColor: '#facc15',
                            fillOpacity: 0.25,
                            weight: 2
                        }).addTo(peta).bindPopup('<div class="text-xs font-bold text-yellow-700">Radius Bahaya 6 Jam (' + pred.luas_6jam + ' ha)</div>');
                        poly6.forEach(function(pt) { bounds.push(pt); });
                    }
                } catch (e) {}
            }

            if (pred.poligon_3jam) {
                try {
                    var poly3 = JSON.parse(pred.poligon_3jam);
                    if (poly3.length > 0) {
                        L.polygon(poly3, {
                            color: '#ea580c',
                            fillColor: '#fb923c',
                            fillOpacity: 0.35,
                            weight: 2
                        }).addTo(peta).bindPopup('<div class="text-xs font-bold text-orange-700">Radius Bahaya 3 Jam (' + pred.luas_3jam + ' ha)</div>');
                        poly3.forEach(function(pt) { bounds.push(pt); });
                    }
                } catch (e) {}
            }

            if (pred.poligon_1jam) {
                try {
                    var poly1 = JSON.parse(pred.poligon_1jam);
                    if (poly1.length > 0) {
                        L.polygon(poly1, {
                            color: '#dc2626',
                            fillColor: '#ef4444',
                            fillOpacity: 0.5,
                            weight: 2
                        }).addTo(peta).bindPopup('<div class="text-xs font-bold text-red-700">Radius Bahaya 1 Jam (' + pred.luas_1jam + ' ha)</div>');
                        poly1.forEach(function(pt) { bounds.push(pt); });
                    }
                } catch (e) {}
            }
        });

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
