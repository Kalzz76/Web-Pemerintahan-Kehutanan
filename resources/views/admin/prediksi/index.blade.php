@extends('layouts.admin')

@section('title', 'D. Prediksi Kebakaran')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl md:text-3xl font-extrabold text-stone-900 tracking-tight">D. Prediksi Perambatan Kebakaran</h1>
        <p class="text-stone-500 text-sm mt-1">Simulasi perambatan elips api berbasis arah angin, kecepatan, kelembapan, dan tutupan lahan.</p>
    </div>

    <form method="POST" action="{{ route('admin.prediksi.ambil-satelit') }}">
        @csrf
        <button type="submit" class="px-5 py-3 rounded-xl bg-purple-700 hover:bg-purple-600 text-white font-bold text-xs transition shadow active:scale-95 flex items-center space-x-2 shrink-0">
            <i class="fa-solid fa-satellite text-sm"></i>
            <span>Ambil Titik Api Satelit (FIRMS)</span>
        </button>
    </form>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-stone-100 p-6 sm:p-8 mb-8 space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-stone-100 gap-2">
        <h2 class="text-base font-bold text-stone-900 flex items-center">
            <i class="fa-solid fa-map-location-dot text-green-700 mr-2"></i>
            <span>Peta Pantauan & Titik Api</span>
        </h2>
        <div class="flex flex-wrap items-center gap-3 text-xs text-stone-600">
            <span class="flex items-center"><span class="w-3 h-3 rounded-full bg-[#7e22ce] mr-1.5"></span> Satelit ({{ $daftarTitikApi->count() }})</span>
            <span class="flex items-center"><span class="w-3 h-3 rounded-full bg-[#dc2626] mr-1.5"></span> Laporan Api ({{ $daftarKebakaranAktif->count() }})</span>
            <span class="flex items-center"><span class="w-3 h-3 rounded-full bg-[#ca8a04] mr-1.5"></span> Permukiman</span>
            <span class="flex items-center"><span class="w-3 h-3 rounded-sm border-2 border-[#15803d] bg-green-100 mr-1.5"></span> Kawasan</span>
        </div>
    </div>

    <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs flex items-center space-x-2">
        <i class="fa-solid fa-crosshairs text-amber-700 text-sm shrink-0"></i>
        <span>Klik pada titik api di peta atau klik koordinat mana saja untuk mengisi formulir simulasi di bawah.</span>
    </div>

    <div id="peta-prediksi" class="w-full h-[520px] rounded-2xl border border-stone-200 overflow-hidden z-10"></div>
</div>

@if ($prediksiAktif)
<div class="bg-white rounded-3xl shadow-sm border border-stone-100 p-6 sm:p-8 mb-8 space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-stone-100 gap-4">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-green-700 block mb-1">Hasil Simulasi Terpilih</span>
            <h2 class="text-xl font-black text-stone-900">Perkiraan Luasan & Poligon Perambatan</h2>
        </div>
        <div class="flex items-center space-x-3">
            <form method="POST" action="{{ route('admin.prediksi.toggle-publik', $prediksiAktif->id) }}">
                @csrf
                <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center space-x-2 {{ $prediksiAktif->tampil_publik ? 'bg-amber-100 text-amber-800 hover:bg-amber-200' : 'bg-green-700 text-white hover:bg-green-600' }}">
                    <i class="fa-solid {{ $prediksiAktif->tampil_publik ? 'fa-eye-slash' : 'fa-bullhorn' }}"></i>
                    <span>{{ $prediksiAktif->tampil_publik ? 'Sembunyikan dari Publik' : 'Tampilkan ke Publik' }}</span>
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="p-4 rounded-2xl bg-stone-50 border border-stone-100">
            <span class="text-xs text-stone-400 block mb-1">Laju Efektif Api</span>
            <span class="text-xl font-black text-stone-900 font-mono">{{ $prediksiAktif->laju_efektif }} m/jam</span>
        </div>
        <div class="p-4 rounded-2xl bg-red-50 border border-red-100">
            <span class="text-xs text-red-600 font-semibold block mb-1">Poligon 1 Jam</span>
            <span class="text-xl font-black text-red-900 font-mono">{{ $prediksiAktif->luas_1jam }} ha</span>
        </div>
        <div class="p-4 rounded-2xl bg-orange-50 border border-orange-100">
            <span class="text-xs text-orange-600 font-semibold block mb-1">Poligon 3 Jam</span>
            <span class="text-xl font-black text-orange-900 font-mono">{{ $prediksiAktif->luas_3jam }} ha</span>
        </div>
        <div class="p-4 rounded-2xl bg-amber-50 border border-amber-100">
            <span class="text-xs text-amber-600 font-semibold block mb-1">Poligon 6 Jam</span>
            <span class="text-xl font-black text-amber-900 font-mono">{{ $prediksiAktif->luas_6jam }} ha</span>
        </div>
    </div>

    <div>
        <h3 class="text-xs font-bold uppercase tracking-wider text-stone-400 mb-3">Daftar Permukiman Warga Terancam</h3>
        @php
            $terancamList = json_decode($prediksiAktif->area_terancam, true) ?: [];
        @endphp
        @if (count($terancamList) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                @foreach ($terancamList as $item)
                    <div class="p-4 rounded-2xl border flex items-center justify-between {{ $item['jam'] == 1 ? 'bg-red-50 border-red-200 text-red-900' : ($item['jam'] == 3 ? 'bg-orange-50 border-orange-200 text-orange-900' : 'bg-yellow-50 border-yellow-200 text-yellow-900') }}">
                        <div class="font-bold text-sm">{{ $item['nama'] }}</div>
                        <span class="px-2.5 py-1 rounded-full text-xs font-black bg-white shadow-sm">
                            &le; {{ $item['jam'] }} Jam
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs flex items-center space-x-2">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>Tidak ada titik permukiman warga yang berada dalam radius perkiraan perambatan api hingga 6 jam ke depan.</span>
            </div>
        @endif
    </div>
</div>
@endif

<div class="bg-white rounded-3xl shadow-sm border border-stone-100 p-6 sm:p-8 mb-8 space-y-6">
    <div class="pb-4 border-b border-stone-100">
        <h2 class="text-base font-bold text-stone-900 flex items-center">
            <i class="fa-solid fa-calculator text-green-700 mr-2"></i>
            <span>Formulir Perhitungan Prediksi</span>
        </h2>
        <p class="text-stone-400 text-xs mt-1">Tentukan koordinat titik api dan ambil parameter cuaca Open-Meteo secara otomatis.</p>
    </div>

    <form method="POST" action="{{ route('admin.prediksi.hitung') }}" class="space-y-6">
        @csrf
        <input type="hidden" name="id_laporan" value="{{ old('id_laporan', $inputIdLaporan) }}">

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label for="latitude" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Latitude Titik Api</label>
                <input type="number" step="0.0000001" id="latitude" name="latitude" value="{{ old('latitude', $inputLat ?? $pengaturan->lat_pusat) }}" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition font-mono">
            </div>

            <div>
                <label for="longitude" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Longitude Titik Api</label>
                <input type="number" step="0.0000001" id="longitude" name="longitude" value="{{ old('longitude', $inputLong ?? $pengaturan->long_pusat) }}" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition font-mono">
            </div>

            <div>
                <label for="id_jenis_lahan" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Jenis Tutupan Lahan</label>
                <select id="id_jenis_lahan" name="id_jenis_lahan" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition bg-white">
                    @foreach ($daftarJenisLahan as $jl)
                        <option value="{{ $jl->id }}" {{ old('id_jenis_lahan') == $jl->id ? 'selected' : '' }}>
                            {{ $jl->nama }} (Laju: {{ $jl->laju_dasar }} m/jam)
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="p-4 rounded-2xl bg-stone-50 border border-stone-200 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <span class="text-xs font-bold uppercase tracking-wider text-stone-600">Parameter Cuaca & Angin</span>
                <button type="button" onclick="ambilDataCuaca()" id="tombol-cuaca" class="px-4 py-2 rounded-xl bg-sky-700 hover:bg-sky-600 text-white font-bold text-xs transition shadow flex items-center justify-center space-x-1.5 active:scale-95 shrink-0">
                    <i class="fa-solid fa-cloud-bolt"></i>
                    <span id="label-tombol-cuaca">Ambil Data Cuaca (Open-Meteo)</span>
                </button>
            </div>

            <div id="pesan-cuaca" class="hidden text-xs p-3 rounded-xl"></div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="arah_angin" class="block text-[11px] font-bold text-stone-600 mb-1">Arah Asal Angin (°)</label>
                    <input type="number" step="0.1" min="0" max="360" id="arah_angin" name="arah_angin" value="{{ old('arah_angin', 45) }}" required class="w-full px-3 py-2 rounded-xl border border-stone-200 text-xs focus:border-green-600 outline-none font-mono">
                    <p class="text-[10px] text-stone-400 mt-1">Api merambat ke arah sebaliknya (+180°)</p>
                </div>

                <div>
                    <label for="kecepatan_angin" class="block text-[11px] font-bold text-stone-600 mb-1">Kecepatan Angin (km/jam)</label>
                    <input type="number" step="0.1" min="0" id="kecepatan_angin" name="kecepatan_angin" value="{{ old('kecepatan_angin', 10) }}" required class="w-full px-3 py-2 rounded-xl border border-stone-200 text-xs focus:border-green-600 outline-none font-mono">
                </div>

                <div>
                    <label for="kelembapan" class="block text-[11px] font-bold text-stone-600 mb-1">Kelembapan Udara (%)</label>
                    <input type="number" step="0.1" min="0" max="100" id="kelembapan" name="kelembapan" value="{{ old('kelembapan', 65) }}" required class="w-full px-3 py-2 rounded-xl border border-stone-200 text-xs focus:border-green-600 outline-none font-mono">
                </div>

                <div>
                    <label for="curah_hujan" class="block text-[11px] font-bold text-stone-600 mb-1">Curah Hujan (mm)</label>
                    <input type="number" step="0.1" min="0" id="curah_hujan" name="curah_hujan" value="{{ old('curah_hujan', 0) }}" required class="w-full px-3 py-2 rounded-xl border border-stone-200 text-xs focus:border-green-600 outline-none font-mono">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-2">
            <span class="text-xs text-stone-400 italic">Hasil ini perkiraan sederhana dan bukan pengganti keputusan petugas lapangan.</span>
            <button type="submit" class="px-8 py-3.5 bg-green-700 hover:bg-green-600 text-white font-bold rounded-xl shadow transition text-sm flex items-center space-x-2 active:scale-95">
                <i class="fa-solid fa-play"></i>
                <span>Hitung Prediksi</span>
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-stone-100 p-6 sm:p-8 space-y-4">
    <h2 class="text-base font-bold text-stone-900 pb-3 border-b border-stone-100 flex items-center">
        <i class="fa-solid fa-clock-rotate-left text-green-700 mr-2"></i>
        <span>Riwayat Prediksi Kebakaran</span>
    </h2>

    @if ($riwayatPrediksi->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-stone-100 text-stone-700 uppercase text-[10px] tracking-wider">
                        <th class="px-4 py-3 font-bold">Waktu</th>
                        <th class="px-4 py-3 font-bold">Koordinat & Lahan</th>
                        <th class="px-4 py-3 font-bold">Laju Efektif</th>
                        <th class="px-4 py-3 font-bold">Luas (1h / 3h / 6h)</th>
                        <th class="px-4 py-3 font-bold">Permukiman Terancam</th>
                        <th class="px-4 py-3 font-bold">Status Publik</th>
                        <th class="px-4 py-3 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 text-stone-700">
                    @foreach ($riwayatPrediksi as $rp)
                        @php
                            $listTerancam = json_decode($rp->area_terancam, true) ?: [];
                        @endphp
                        <tr class="hover:bg-stone-50 transition">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="font-semibold text-stone-900">{{ \Carbon\Carbon::parse($rp->created_at)->locale('id')->isoFormat('D MMM Y') }}</div>
                                <div class="text-[10px] text-stone-400">{{ \Carbon\Carbon::parse($rp->created_at)->format('H:i') }} WIB</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-mono text-[11px]">{{ number_format($rp->latitude, 4) }}, {{ number_format($rp->longitude, 4) }}</div>
                                <div class="text-[10px] text-stone-500 font-semibold">{{ $rp->jenisLahan->nama ?? '-' }}</div>
                            </td>
                            <td class="px-4 py-3 font-mono font-bold text-stone-800">
                                {{ $rp->laju_efektif }} m/jam
                            </td>
                            <td class="px-4 py-3 font-mono text-[11px] whitespace-nowrap">
                                <span class="text-red-700 font-bold">{{ $rp->luas_1jam }}</span> /
                                <span class="text-orange-700 font-bold">{{ $rp->luas_3jam }}</span> /
                                <span class="text-amber-700 font-bold">{{ $rp->luas_6jam }}</span> ha
                            </td>
                            <td class="px-4 py-3">
                                @if (count($listTerancam) > 0)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">
                                        {{ count($listTerancam) }} Permukiman
                                    </span>
                                @else
                                    <span class="text-stone-400 text-[11px]">Aman</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if ($rp->tampil_publik)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-800">
                                        Tampil Publik
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-stone-100 text-stone-600">
                                        Internal
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right space-x-1.5 whitespace-nowrap">
                                <a href="{{ route('admin.prediksi.index', ['id_prediksi' => $rp->id]) }}" class="px-2.5 py-1 bg-stone-100 hover:bg-stone-200 text-stone-800 rounded-lg text-[11px] font-semibold transition">
                                    Lihat
                                </a>
                                <form method="POST" action="{{ route('admin.prediksi.toggle-publik', $rp->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-1 rounded-lg text-[11px] font-semibold transition {{ $rp->tampil_publik ? 'bg-amber-50 hover:bg-amber-100 text-amber-700' : 'bg-green-50 hover:bg-green-100 text-green-700' }}">
                                        {{ $rp->tampil_publik ? 'Sembunyi' : 'Publik' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.prediksi.destroy', $rp->id) }}" class="inline" onsubmit="return confirm('Hapus riwayat prediksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-[11px] font-semibold transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pt-4 border-t border-stone-100">
            {{ $riwayatPrediksi->links() }}
        </div>
    @else
        <div class="p-8 text-center text-stone-400">
            <i class="fa-solid fa-fire text-3xl mb-2 text-stone-300"></i>
            <p class="text-xs">Belum ada riwayat simulasi prediksi kebakaran.</p>
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

            pesan.className = 'text-xs p-3 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200 block';
            pesan.innerHTML = '<i class="fa-solid fa-circle-check mr-1.5"></i> Data cuaca berhasil diperbarui: Suhu ' + data.suhu + '°C, Kecepatan Angin ' + data.kecepatan_angin + ' km/jam, Arah ' + data.arah_angin + '°.';
        } else {
            pesan.className = 'text-xs p-3 rounded-xl bg-rose-50 text-rose-700 border border-rose-200 block';
            pesan.innerHTML = '<i class="fa-solid fa-triangle-exclamation mr-1.5"></i> ' + (data.pesan || 'Gagal mengambil data cuaca.');
        }
    })
    .catch(function () {
        btn.disabled = false;
        label.innerText = 'Ambil Data Cuaca (Open-Meteo)';
        pesan.className = 'text-xs p-3 rounded-xl bg-rose-50 text-rose-700 border border-rose-200 block';
        pesan.innerHTML = '<i class="fa-solid fa-triangle-exclamation mr-1.5"></i> Gagal menghubungi layanan Open-Meteo. Silakan masukkan parameter cuaca secara manual.';
    });
}

function pasangTitikSimulasi(lat, lng) {
    document.getElementById('latitude').value = parseFloat(lat).toFixed(7);
    document.getElementById('longitude').value = parseFloat(lng).toFixed(7);

    if (markerTitikApi) {
        markerTitikApi.setLatLng([lat, lng]);
    } else {
        markerTitikApi = L.circleMarker([lat, lng], {
            radius: 10,
            color: '#dc2626',
            fillColor: '#dc2626',
            fillOpacity: 1,
            weight: 3
        }).addTo(map);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    var latPusat = {{ $pengaturan->lat_pusat ?? -6.8921000 }};
    var longPusat = {{ $pengaturan->long_pusat ?? 108.4112000 }};
    var zoomAwal = {{ $pengaturan->zoom_awal ?? 13 }};

    map = L.map('peta-prediksi').setView([latPusat, longPusat], zoomAwal);

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
        marker.bindPopup('<strong>Titik Api Satelit (FIRMS)</strong><br><span class="text-xs">Waktu: ' + ta.tanggal_deteksi + ' ' + ta.waktu_deteksi + '</span><br><button onclick="pasangTitikSimulasi(' + ta.latitude + ',' + ta.longitude + ')" class="text-xs text-blue-600 font-bold underline mt-1">Gunakan Titik Ini</button>');
    });

    var dataKebakaran = @json($daftarKebakaranAktif);
    dataKebakaran.forEach(function (kb) {
        var marker = L.circleMarker([kb.latitude, kb.longitude], {
            radius: 9,
            color: '#dc2626',
            fillColor: '#dc2626',
            fillOpacity: 0.9,
            weight: 2
        }).addTo(map);
        marker.bindPopup('<strong>Laporan: ' + kb.kode + '</strong><br><span class="text-xs">' + kb.deskripsi + '</span><br><button onclick="pasangTitikSimulasi(' + kb.latitude + ',' + kb.longitude + ')" class="text-xs text-red-600 font-bold underline mt-1">Gunakan Titik Ini</button>');
    });

    var latAwal = document.getElementById('latitude').value;
    var lngAwal = document.getElementById('longitude').value;
    if (latAwal && lngAwal) {
        pasangTitikSimulasi(parseFloat(latAwal), parseFloat(lngAwal));
    }

    map.on('click', function (e) {
        pasangTitikSimulasi(e.latlng.lat, e.latlng.lng);
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
});
</script>
@endsection
