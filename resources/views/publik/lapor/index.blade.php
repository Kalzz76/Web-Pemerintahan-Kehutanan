@extends('layouts.publik')

@section('title', 'Lapor Darurat')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 text-red-600 rounded-3xl mb-4 text-2xl shadow-sm">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-stone-900 tracking-tight">Formulir Lapor Darurat</h1>
        <p class="text-stone-500 text-xs sm:text-sm mt-1 max-w-lg mx-auto">
            Layanan cepat tanggap warga wilayah Jawa Barat tanpa perlu akun atau login. Laporkan kejadian kebakaran hutan atau satwa liar yang masuk perkebunan/permukiman.
        </p>
    </div>

    <div id="kotak-notif-offline" class="hidden mb-6 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs sm:text-sm">
        <div class="flex items-start space-x-3">
            <i class="fa-solid fa-tower-broadcast text-amber-600 mt-0.5 text-base shrink-0"></i>
            <div id="pesan-notif-offline"></div>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl p-5 mb-6 text-sm">
            <div class="flex items-center font-bold mb-2">
                <i class="fa-solid fa-circle-exclamation mr-2"></i>
                <span>Mohon periksa kembali isian formulir:</span>
            </div>
            <ul class="list-disc list-inside text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-stone-100 p-6 sm:p-10">
        <form id="form-lapor" method="POST" action="{{ route('lapor.simpan') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Jenis Kejadian Darurat <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="relative flex items-center p-4 rounded-2xl border-2 cursor-pointer transition select-none" id="label-jenis-kebakaran">
                        <input type="radio" name="jenis" value="Kebakaran" onchange="pilihJenis('Kebakaran')" {{ old('jenis', $jenisTerpilih ?? 'Kebakaran') === 'Kebakaran' ? 'checked' : '' }} class="sr-only">
                        <div class="flex items-center space-x-3 w-full">
                            <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center text-lg shrink-0">
                                <i class="fa-solid fa-fire-flame-curved"></i>
                            </div>
                            <div>
                                <div class="font-bold text-sm text-stone-900">Kebakaran Hutan</div>
                                <div class="text-[11px] text-stone-500">Asap tebal atau titik api membara</div>
                            </div>
                        </div>
                    </label>

                    <label class="relative flex items-center p-4 rounded-2xl border-2 cursor-pointer transition select-none" id="label-jenis-hewan">
                        <input type="radio" name="jenis" value="Hewan Masuk Kampung" onchange="pilihJenis('Hewan Masuk Kampung')" {{ old('jenis', $jenisTerpilih) === 'Hewan Masuk Kampung' ? 'checked' : '' }} class="sr-only">
                        <div class="flex items-center space-x-3 w-full">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-lg shrink-0">
                                <i class="fa-solid fa-paw"></i>
                            </div>
                            <div>
                                <div class="font-bold text-sm text-stone-900">Hewan Masuk Kampung</div>
                                <div class="text-[11px] text-stone-500">Primata atau satwa liar di kebun</div>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <div id="wadah-jenis-hewan" class="hidden">
                <label for="jenis_hewan" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Jenis Hewan Liar (Contoh: Monyet Ekor Panjang)</label>
                <input type="text" id="jenis_hewan" name="jenis_hewan" value="{{ old('jenis_hewan') }}" placeholder="Sebutkan jenis satwa jika diketahui..." class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Lokasi Kejadian di Jawa Barat <span class="text-red-500">*</span></label>
                <div class="flex flex-col sm:flex-row gap-3 mb-3">
                    <button type="button" onclick="ambilLokasiSaya()" class="px-5 py-3 rounded-xl bg-green-700 hover:bg-green-600 text-white font-bold text-xs flex items-center justify-center space-x-2 transition shadow active:scale-95">
                        <i class="fa-solid fa-location-crosshairs text-sm"></i>
                        <span>Gunakan Lokasi Saya (GPS)</span>
                    </button>
                    <span class="text-xs text-stone-400 self-center">atau klik langsung pada peta Jawa Barat di bawah:</span>
                </div>

                <div id="peta-lapor" class="w-full h-64 rounded-2xl border border-stone-200 overflow-hidden z-10 mb-2"></div>
                <div class="flex items-center justify-between text-[11px] text-stone-500 px-1">
                    <span id="label-status-lokasi">Lokasi belum ditentukan.</span>
                    <span class="font-mono text-stone-700 font-semibold" id="label-koordinat-terpilih"></span>
                </div>

                <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
            </div>

            <div>
                <label for="id_kabupaten_kota" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Kabupaten / Kota di Jawa Barat (Opsional)</label>
                <select id="id_kabupaten_kota" name="id_kabupaten_kota" class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition bg-white">
                    <option value="">-- Pilih Kabupaten / Kota (Opsional) --</option>
                    @foreach($kabupatenKota as $kab)
                        <option value="{{ $kab->id }}" {{ old('id_kabupaten_kota') == $kab->id ? 'selected' : '' }}>{{ $kab->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="deskripsi" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Deskripsi Kejadian <span class="text-red-500">*</span></label>
                <textarea id="deskripsi" name="deskripsi" rows="3" required placeholder="Jelaskan perkiraan luasan, arah api, atau jumlah satwa yang terlihat..." class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition">{{ old('deskripsi') }}</textarea>
                <p class="text-[11px] text-stone-400 mt-1">Maksimal 1000 karakter.</p>
            </div>

            <div>
                <label for="foto" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Foto Kejadian (Opsional)</label>
                <input type="file" id="foto" name="foto" accept="image/png,image/jpeg,image/jpg" class="w-full text-xs text-stone-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition cursor-pointer">
                <p class="text-[11px] text-stone-400 mt-1">Maksimal 5MB (JPG/PNG). Foto tidak dapat disimpan jika offline.</p>
            </div>

            <div class="pt-4 border-t border-stone-100">
                <h3 class="text-xs font-bold text-stone-400 uppercase tracking-wider mb-3">Identitas Pelapor (Opsional)</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="nama_pelapor" class="block text-xs font-medium text-stone-700 mb-1.5">Nama Anda</label>
                        <input type="text" id="nama_pelapor" name="nama_pelapor" value="{{ old('nama_pelapor') }}" placeholder="Boleh nama panggilan atau inisial" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition">
                    </div>

                    <div>
                        <label for="no_hp" class="block text-xs font-medium text-stone-700 mb-1.5">Nomor HP / WhatsApp</label>
                        <input type="tel" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 08123456789" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition font-mono">
                    </div>
                </div>
                <p class="text-[11px] text-stone-400 mt-2 flex items-center">
                    <i class="fa-solid fa-lock text-green-700 mr-1.5"></i>
                    Nomor HP Anda bersifat rahasia, hanya dapat dilihat oleh petugas untuk konfirmasi darurat, dan tidak akan ditampilkan ke publik.
                </p>
            </div>

            <div class="pt-4">
                <button type="submit" id="tombol-kirim" class="w-full py-4 px-6 bg-red-600 hover:bg-red-500 text-white font-extrabold rounded-2xl shadow-xl transition active:scale-95 text-base flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Kirim Laporan Darurat</span>
                </button>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>

<script>
var mapLapor;
var markerLapor = null;

function pilihJenis(jenis) {
    var radioKebakaran = document.querySelector('input[value="Kebakaran"]');
    var radioHewan = document.querySelector('input[value="Hewan Masuk Kampung"]');
    var labelKebakaran = document.getElementById('label-jenis-kebakaran');
    var labelHewan = document.getElementById('label-jenis-hewan');
    var wadahHewan = document.getElementById('wadah-jenis-hewan');

    if (jenis === 'Kebakaran') {
        radioKebakaran.checked = true;
        labelKebakaran.className = 'relative flex items-center p-4 rounded-2xl border-2 border-red-600 bg-red-50/50 cursor-pointer transition select-none';
        labelHewan.className = 'relative flex items-center p-4 rounded-2xl border-2 border-stone-200 hover:border-stone-300 cursor-pointer transition select-none';
        wadahHewan.classList.add('hidden');
    } else {
        radioHewan.checked = true;
        labelHewan.className = 'relative flex items-center p-4 rounded-2xl border-2 border-amber-600 bg-amber-50/50 cursor-pointer transition select-none';
        labelKebakaran.className = 'relative flex items-center p-4 rounded-2xl border-2 border-stone-200 hover:border-stone-300 cursor-pointer transition select-none';
        wadahHewan.classList.remove('hidden');
    }

    if (markerLapor) {
        var warna = jenis === 'Kebakaran' ? '#dc2626' : '#ea580c';
        markerLapor.setStyle({ color: warna, fillColor: warna });
    }
}

function perbaruiTitikLokasi(lat, lng) {
    var latInput = document.getElementById('latitude');
    var longInput = document.getElementById('longitude');
    var labelStatus = document.getElementById('label-status-lokasi');
    var labelKoordinat = document.getElementById('label-koordinat-terpilih');

    latInput.value = parseFloat(lat).toFixed(7);
    longInput.value = parseFloat(lng).toFixed(7);

    var jenisDipilih = document.querySelector('input[name="jenis"]:checked');
    var jenis = jenisDipilih ? jenisDipilih.value : 'Kebakaran';
    var warna = jenis === 'Kebakaran' ? '#dc2626' : '#ea580c';

    if (markerLapor) {
        markerLapor.setLatLng([lat, lng]);
        markerLapor.setStyle({ color: warna, fillColor: warna });
    } else {
        markerLapor = L.circleMarker([lat, lng], {
            radius: 9,
            color: warna,
            fillColor: warna,
            fillOpacity: 0.9,
            weight: 3
        }).addTo(mapLapor);
    }

    labelStatus.innerText = 'Titik lokasi terpilih:';
    labelKoordinat.innerText = parseFloat(lat).toFixed(5) + ', ' + parseFloat(lng).toFixed(5);
}

function ambilLokasiSaya() {
    var labelStatus = document.getElementById('label-status-lokasi');
    if (!navigator.geolocation) {
        alert('Browser Anda tidak mendukung deteksi lokasi otomatis.');
        return;
    }

    labelStatus.innerText = 'Mencari sinyal GPS...';

    navigator.geolocation.getCurrentPosition(function (posisi) {
        var lat = posisi.coords.latitude;
        var lng = posisi.coords.longitude;
        mapLapor.setView([lat, lng], 14);
        perbaruiTitikLokasi(lat, lng);
    }, function (err) {
        alert('Tidak dapat mendeteksi lokasi GPS secara otomatis. Silakan klik langsung titik kejadian pada peta.');
        labelStatus.innerText = 'Gagal mendeteksi GPS. Silakan klik peta.';
    }, {
        enableHighAccuracy: true,
        timeout: 10000
    });
}

function simpanOffline(data) {
    var daftar = [];
    try {
        var raw = localStorage.getItem('laporanTertunda');
        if (raw) daftar = JSON.parse(raw);
    } catch (e) {}

    daftar.push(data);
    localStorage.setItem('laporanTertunda', JSON.stringify(daftar));

    var notif = document.getElementById('kotak-notif-offline');
    var pesan = document.getElementById('pesan-notif-offline');
    pesan.innerHTML = '<strong>Tidak ada koneksi internet.</strong> Laporan berhasil disimpan di perangkat HP Anda dan akan dikirim secara otomatis saat sinyal kembali normal.';
    notif.classList.remove('hidden');
    window.scrollTo({ top: 0, behavior: 'smooth' });

    document.getElementById('form-lapor').reset();
    if (markerLapor) {
        mapLapor.removeLayer(markerLapor);
        markerLapor = null;
    }
    document.getElementById('latitude').value = '';
    document.getElementById('longitude').value = '';
    document.getElementById('label-status-lokasi').innerText = 'Lokasi belum ditentukan.';
    document.getElementById('label-koordinat-terpilih').innerText = '';
}

function sinkronkanLaporanTertunda() {
    var raw = localStorage.getItem('laporanTertunda');
    if (!raw) return;

    var daftar = [];
    try {
        daftar = JSON.parse(raw);
    } catch (e) {
        return;
    }

    if (!Array.isArray(daftar) || daftar.length === 0) return;

    var item = daftar[0];

    fetch('/lapor/sinkron', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(item)
    }).then(function (res) {
        return res.json();
    }).then(function (hasil) {
        if (hasil.sukses && hasil.kode) {
            daftar.shift();
            localStorage.setItem('laporanTertunda', JSON.stringify(daftar));

            var riwayat = [];
            try {
                var rawRiwayat = localStorage.getItem('kodeLaporanSaya');
                if (rawRiwayat) riwayat = JSON.parse(rawRiwayat);
            } catch (e) {}

            riwayat.unshift({
                kode: hasil.kode,
                jenis: hasil.jenis,
                waktu: new Date().toISOString()
            });
            localStorage.setItem('kodeLaporanSaya', JSON.stringify(riwayat));

            var notif = document.getElementById('kotak-notif-offline');
            var pesan = document.getElementById('pesan-notif-offline');
            pesan.innerHTML = '<strong>Laporan berhasil tersinkron!</strong> Laporan tertunda Anda telah diterima server dengan kode: <strong>' + hasil.kode + '</strong>. Catat kode ini untuk mengecek status.';
            notif.classList.remove('hidden');

            if (daftar.length > 0) {
                sinkronkanLaporanTertunda();
            }
        }
    }).catch(function () {});
}

document.addEventListener('DOMContentLoaded', function () {
    var jenisAwal = document.querySelector('input[name="jenis"]:checked');
    pilihJenis(jenisAwal ? jenisAwal.value : 'Kebakaran');

    var latPusat = {{ $pengaturan->lat_pusat ?? -6.87 }};
    var longPusat = {{ $pengaturan->long_pusat ?? 107.60 }};
    var zoomAwal = {{ $pengaturan->zoom_awal ?? 8 }};

    var bboxBarat = {{ $pengaturan->bbox_barat ?? 106.36 }};
    var bboxSelatan = {{ $pengaturan->bbox_selatan ?? -7.83 }};
    var bboxTimur = {{ $pengaturan->bbox_timur ?? 108.85 }};
    var bboxUtara = {{ $pengaturan->bbox_utara ?? -5.90 }};
    var boundsJabar = L.latLngBounds([bboxSelatan, bboxBarat], [bboxUtara, bboxTimur]);

    mapLapor = L.map('peta-lapor', {
        maxBounds: boundsJabar,
        minZoom: 7
    }).setView([latPusat, longPusat], zoomAwal);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(mapLapor);

    var latLama = document.getElementById('latitude').value;
    var longLama = document.getElementById('longitude').value;
    if (latLama && longLama) {
        perbaruiTitikLokasi(parseFloat(latLama), parseFloat(longLama));
        mapLapor.setView([parseFloat(latLama), parseFloat(longLama)], 14);
    }

    mapLapor.on('click', function (e) {
        perbaruiTitikLokasi(e.latlng.lat, e.latlng.lng);
    });

    var form = document.getElementById('form-lapor');
    form.addEventListener('submit', function (e) {
        var lat = document.getElementById('latitude').value;
        var lng = document.getElementById('longitude').value;

        if (!lat || !lng) {
            e.preventDefault();
            alert('Silakan tentukan lokasi kejadian darurat pada peta terlebih dahulu.');
            return;
        }

        if (!navigator.onLine) {
            e.preventDefault();

            var fotoInput = document.getElementById('foto');
            if (fotoInput.files && fotoInput.files.length > 0) {
                alert('Peringatan: Karena perangkat sedang offline, foto tidak dapat dikirim. Laporan teks dan koordinat akan tetap disimpan dan dikirim otomatis.');
            }

            var jenisRadio = document.querySelector('input[name="jenis"]:checked');
            var dataLapor = {
                jenis: jenisRadio ? jenisRadio.value : 'Kebakaran',
                jenis_hewan: document.getElementById('jenis_hewan').value,
                latitude: lat,
                longitude: lng,
                id_kabupaten_kota: document.getElementById('id_kabupaten_kota').value,
                deskripsi: document.getElementById('deskripsi').value,
                nama_pelapor: document.getElementById('nama_pelapor').value,
                no_hp: document.getElementById('no_hp').value,
                dibuat: new Date().toISOString()
            };

            simpanOffline(dataLapor);
        }
    });

    window.addEventListener('online', sinkronkanLaporanTertunda);
    if (navigator.onLine) {
        sinkronkanLaporanTertunda();
    }
});
</script>
@endsection
