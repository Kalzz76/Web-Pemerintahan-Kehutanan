@extends('layouts.admin')

@section('title', 'Detail Laporan ' . $laporan->kode)

@section('breadcrumb')
    <span class="text-stone-300">/</span>
    <a href="{{ route('admin.laporan.index') }}" class="hover:text-[#064B38] transition">Kelola Laporan</a>
    <span class="text-stone-300">/</span>
    <span class="text-stone-800 font-semibold font-mono">{{ $laporan->kode }}</span>
@endsection

@section('content')
<div class="mb-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-lg md:text-xl font-bold text-stone-900 tracking-tight flex items-center space-x-3">
                <span class="font-mono">{{ $laporan->kode }}</span>
                <span class="text-xs font-semibold text-stone-900 border border-stone-300 px-2.5 py-0.5 rounded-full bg-transparent">
                    {{ $laporan->status }}
                </span>
            </h1>
            <p class="text-stone-500 text-xs mt-0.5">
                Dilaporkan pada {{ \Carbon\Carbon::parse($laporan->created_at)->locale('id')->isoFormat('dddd, D MMMM Y - HH:mm') }} WIB
            </p>
        </div>

        @if ($laporan->jenis === 'Kebakaran')
            <a href="{{ Route::has('admin.prediksi.index') ? route('admin.prediksi.index', ['id_laporan' => $laporan->id, 'lat' => $laporan->latitude, 'long' => $laporan->longitude]) : '#' }}" class="inline-flex items-center px-4 py-2.5 bg-stone-900 hover:bg-stone-800 text-white font-bold rounded-xl shadow-sm transition text-xs shrink-0 active:scale-95">
                <i class="fa-solid fa-fire-flame-curved mr-2 text-stone-300"></i>
                <span>Hitung Prediksi dari Titik Ini</span>
            </a>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-6 sm:p-8 space-y-6">
            <h2 class="text-base font-bold text-stone-900 pb-3 border-b border-stone-100 flex items-center">
                <i class="fa-solid fa-circle-info text-green-700 mr-2"></i>
                <span>Informasi Kejadian</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs sm:text-sm">
                <div>
                    <span class="text-xs text-stone-400 block mb-1">Jenis Kejadian</span>
                    <span class="font-bold text-stone-900 text-base">
                        {{ $laporan->jenis }}
                        @if ($laporan->jenis_hewan)
                            <span class="text-sm font-normal text-stone-500">({{ $laporan->jenis_hewan }})</span>
                        @endif
                    </span>
                </div>

                <div>
                    <span class="text-xs text-stone-400 block mb-1">Koordinat Lokasi</span>
                    <span class="font-mono text-stone-800 text-xs font-semibold">
                        {{ number_format($laporan->latitude, 7) }}, {{ number_format($laporan->longitude, 7) }}
                    </span>
                </div>

                <div>
                    <span class="text-xs text-stone-400 block mb-1">Kabupaten/Kota (Jawa Barat)</span>
                    <span class="font-bold text-stone-900 text-sm">
                        {{ $laporan->kabupatenKota ? $laporan->kabupatenKota->nama : 'Belum ditentukan' }}
                    </span>
                </div>

                <div class="sm:col-span-2">
                    <span class="text-xs text-stone-400 block mb-1">Deskripsi Warga</span>
                    <p class="p-4 rounded-xl bg-stone-50 border border-stone-100 text-stone-800 leading-relaxed text-xs sm:text-sm">
                        {{ $laporan->deskripsi }}
                    </p>
                </div>

                @if ($laporan->detail_kejadian && is_array($laporan->detail_kejadian) && count($laporan->detail_kejadian) > 0)
                    <div class="sm:col-span-2 pt-3 border-t border-stone-100">
                        <span class="text-xs font-bold uppercase tracking-wider text-stone-500 block mb-3 flex items-center">
                            <i class="fa-solid fa-list-check text-stone-700 mr-2"></i>
                            <span>Rincian Khusus Kejadian Lapangan</span>
                        </span>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @if ($laporan->jenis === 'Kebakaran')
                                @if (!empty($laporan->detail_kejadian['tipe_vegetasi']))
                                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/70">
                                        <span class="text-[11px] text-stone-400 block mb-0.5">Vegetasi / Bahan Terbakar</span>
                                        <span class="font-bold text-stone-800 text-xs sm:text-sm">{{ $laporan->detail_kejadian['tipe_vegetasi'] }}</span>
                                    </div>
                                @endif
                                @if (!empty($laporan->detail_kejadian['perkiraan_luas']))
                                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/70">
                                        <span class="text-[11px] text-stone-400 block mb-0.5">Perkiraan Luas Area</span>
                                        <span class="font-bold text-stone-800 text-xs sm:text-sm">{{ $laporan->detail_kejadian['perkiraan_luas'] }}</span>
                                    </div>
                                @endif
                                @if (!empty($laporan->detail_kejadian['kondisi_api']))
                                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/70">
                                        <span class="text-[11px] text-stone-400 block mb-0.5">Kondisi Api & Asap</span>
                                        <span class="font-bold text-stone-800 text-xs sm:text-sm">{{ $laporan->detail_kejadian['kondisi_api'] }}</span>
                                    </div>
                                @endif
                                @if (!empty($laporan->detail_kejadian['arah_angin']))
                                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/70">
                                        <span class="text-[11px] text-stone-400 block mb-0.5">Arah Tiupan Angin</span>
                                        <span class="font-bold text-stone-800 text-xs sm:text-sm">{{ $laporan->detail_kejadian['arah_angin'] }}</span>
                                    </div>
                                @endif
                                @if (!empty($laporan->detail_kejadian['potensi_bahaya']))
                                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/70 sm:col-span-2">
                                        <span class="text-[11px] text-stone-400 block mb-0.5">Posisi / Kerentanan Area</span>
                                        <span class="font-bold text-stone-800 text-xs sm:text-sm">{{ $laporan->detail_kejadian['potensi_bahaya'] }}</span>
                                    </div>
                                @endif

                            @elseif ($laporan->jenis === 'Hewan Masuk Kampung')
                                @if (!empty($laporan->detail_kejadian['jenis_hewan']))
                                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/70">
                                        <span class="text-[11px] text-stone-400 block mb-0.5">Jenis Satwa</span>
                                        <span class="font-bold text-stone-800 text-xs sm:text-sm">{{ $laporan->detail_kejadian['jenis_hewan'] }}</span>
                                    </div>
                                @endif
                                @if (!empty($laporan->detail_kejadian['jumlah_satwa']))
                                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/70">
                                        <span class="text-[11px] text-stone-400 block mb-0.5">Jumlah Satwa</span>
                                        <span class="font-bold text-stone-800 text-xs sm:text-sm">{{ $laporan->detail_kejadian['jumlah_satwa'] }}</span>
                                    </div>
                                @endif
                                @if (!empty($laporan->detail_kejadian['aktivitas_satwa']))
                                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/70">
                                        <span class="text-[11px] text-stone-400 block mb-0.5">Aktivitas / Dampak</span>
                                        <span class="font-bold text-stone-800 text-xs sm:text-sm">{{ $laporan->detail_kejadian['aktivitas_satwa'] }}</span>
                                    </div>
                                @endif
                                @if (!empty($laporan->detail_kejadian['posisi_satwa']))
                                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/70">
                                        <span class="text-[11px] text-stone-400 block mb-0.5">Posisi Satwa Saat Ini</span>
                                        <span class="font-bold text-stone-800 text-xs sm:text-sm">{{ $laporan->detail_kejadian['posisi_satwa'] }}</span>
                                    </div>
                                @endif

                            @elseif ($laporan->jenis === 'Orang Hilang')
                                @if (!empty($laporan->detail_kejadian['nama_korban']))
                                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/70">
                                        <span class="text-[11px] text-stone-400 block mb-0.5">Nama Korban / Survivor</span>
                                        <span class="font-bold text-stone-800 text-xs sm:text-sm">{{ $laporan->detail_kejadian['nama_korban'] }}</span>
                                    </div>
                                @endif
                                @if (!empty($laporan->detail_kejadian['jumlah_korban']))
                                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/70">
                                        <span class="text-[11px] text-stone-400 block mb-0.5">Jumlah Orang Dicari</span>
                                        <span class="font-bold text-stone-800 text-xs sm:text-sm">{{ $laporan->detail_kejadian['jumlah_korban'] }}</span>
                                    </div>
                                @endif
                                @if (!empty($laporan->detail_kejadian['usia_korban']) || !empty($laporan->detail_kejadian['gender_korban']))
                                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/70">
                                        <span class="text-[11px] text-stone-400 block mb-0.5">Usia & Jenis Kelamin</span>
                                        <span class="font-bold text-stone-800 text-xs sm:text-sm">
                                            {{ $laporan->detail_kejadian['usia_korban'] ?? '-' }} / {{ $laporan->detail_kejadian['gender_korban'] ?? '-' }}
                                        </span>
                                    </div>
                                @endif
                                @if (!empty($laporan->detail_kejadian['kontak_terakhir']))
                                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/70">
                                        <span class="text-[11px] text-stone-400 block mb-0.5">Kontak / Terlihat Terakhir</span>
                                        <span class="font-bold text-stone-800 text-xs sm:text-sm">{{ $laporan->detail_kejadian['kontak_terakhir'] }}</span>
                                    </div>
                                @endif
                                @if (!empty($laporan->detail_kejadian['jalur_pendakian']))
                                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/70">
                                        <span class="text-[11px] text-stone-400 block mb-0.5">Jalur Masuk / Pos</span>
                                        <span class="font-bold text-stone-800 text-xs sm:text-sm">{{ $laporan->detail_kejadian['jalur_pendakian'] }}</span>
                                    </div>
                                @endif
                                @if (!empty($laporan->detail_kejadian['kondisi_bekal']))
                                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/70">
                                        <span class="text-[11px] text-stone-400 block mb-0.5">Kondisi Bekal / Logistik</span>
                                        <span class="font-bold text-stone-800 text-xs sm:text-sm">{{ $laporan->detail_kejadian['kondisi_bekal'] }}</span>
                                    </div>
                                @endif
                                @if (!empty($laporan->detail_kejadian['ciri_pakaian']))
                                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/70 sm:col-span-2">
                                        <span class="text-[11px] text-stone-400 block mb-0.5">Ciri Fisik & Pakaian Terakhir</span>
                                        <span class="font-bold text-stone-800 text-xs sm:text-sm">{{ $laporan->detail_kejadian['ciri_pakaian'] }}</span>
                                    </div>
                                @endif

                            @elseif ($laporan->jenis === 'Lainnya')
                                @if (!empty($laporan->detail_kejadian['kategori_lainnya']))
                                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/70">
                                        <span class="text-[11px] text-stone-400 block mb-0.5">Kategori Kejadian</span>
                                        <span class="font-bold text-stone-800 text-xs sm:text-sm">{{ $laporan->detail_kejadian['kategori_lainnya'] }}</span>
                                    </div>
                                @endif
                                @if (!empty($laporan->detail_kejadian['tingkat_urgensi']))
                                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/70">
                                        <span class="text-[11px] text-stone-400 block mb-0.5">Tingkat Urgensi / Dampak</span>
                                        <span class="font-bold text-stone-800 text-xs sm:text-sm">{{ $laporan->detail_kejadian['tingkat_urgensi'] }}</span>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                @endif

                @if ($laporan->foto)
                    <div class="sm:col-span-2">
                        <span class="text-xs text-stone-400 block mb-2">Foto dari Pelapor</span>
                        <div class="w-full max-w-md rounded-2xl overflow-hidden border border-stone-200">
                            <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Foto Laporan" class="w-full h-auto object-cover">
                        </div>
                    </div>
                @endif
            </div>

            <div class="pt-4 border-t border-stone-100">
                <h3 class="text-xs font-bold uppercase tracking-wider text-stone-400 mb-3">Peta Lokasi Kejadian</h3>
                <div id="peta-laporan-detail" class="w-full h-72 rounded-2xl border border-stone-200 overflow-hidden z-10"></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-6 space-y-4">
            <h2 class="text-base font-bold text-stone-900 pb-3 border-b border-stone-100 flex items-center">
                <i class="fa-solid fa-user-shield text-green-700 mr-2"></i>
                <span>Data Pelapor (Hanya Terlihat Oleh Admin)</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                <div class="p-4 rounded-xl bg-stone-50 border border-stone-100">
                    <span class="text-stone-400 block mb-1">Nama Pelapor</span>
                    <span class="font-bold text-stone-900 text-sm">{{ $laporan->nama_pelapor ?: 'Tidak mengisi (Anonim)' }}</span>
                </div>

                <div class="p-4 rounded-xl bg-stone-50 border border-stone-100">
                    <span class="text-stone-400 block mb-1">Nomor HP / WhatsApp</span>
                    @if ($laporan->no_hp)
                        <a href="tel:{{ $laporan->no_hp }}" class="font-mono font-bold text-green-800 hover:text-green-600 text-sm flex items-center">
                            <i class="fa-solid fa-phone mr-1.5 text-xs"></i>
                            {{ $laporan->no_hp }}
                        </a>
                    @else
                        <span class="text-stone-500">Tidak mengisi</span>
                    @endif
                </div>

                <div class="p-4 rounded-xl bg-stone-50 border border-stone-100">
                    <span class="text-stone-400 block mb-1">Alamat IP Pengirim</span>
                    <span class="font-mono text-stone-600 text-xs">{{ $laporan->ip_pelapor }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-6 space-y-5">
            <h2 class="text-base font-bold text-stone-900 pb-3 border-b border-stone-100 flex items-center">
                <i class="fa-solid fa-sliders text-green-700 mr-2"></i>
                <span>Tindak Lanjut & Verifikasi</span>
            </h2>

            <form method="POST" action="{{ route('admin.laporan.update', $laporan->id) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="status" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Status Penanganan</label>
                    <select id="status" name="status" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition bg-white font-semibold">
                        <option value="Baru" {{ old('status', $laporan->status) === 'Baru' ? 'selected' : '' }}>Baru (Menunggu Verifikasi)</option>
                        <option value="Diverifikasi" {{ old('status', $laporan->status) === 'Diverifikasi' ? 'selected' : '' }}>Diverifikasi (Tampil di Peta Publik)</option>
                        <option value="Ditangani" {{ old('status', $laporan->status) === 'Ditangani' ? 'selected' : '' }}>Ditangani (Petugas di Lapangan)</option>
                        <option value="Selesai" {{ old('status', $laporan->status) === 'Selesai' ? 'selected' : '' }}>Selesai (Penanganan Tuntas)</option>
                    </select>
                    <p class="text-[11px] text-stone-400 mt-1">Laporan baru tidak muncul di peta warga sebelum diubah ke Diverifikasi atau Ditangani.</p>
                </div>

                <div>
                    <label for="id_kabupaten_kota" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Kabupaten/Kota (Jawa Barat)</label>
                    <select id="id_kabupaten_kota" name="id_kabupaten_kota" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition bg-white">
                        <option value="">-- Belum Ditentukan --</option>
                        @foreach ($daftarKabupaten as $kab)
                            <option value="{{ $kab->id }}" {{ old('id_kabupaten_kota', $laporan->id_kabupaten_kota) == $kab->id ? 'selected' : '' }}>
                                {{ $kab->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="id_kawasan" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Tentukan Kawasan Hutan</label>
                    <select id="id_kawasan" name="id_kawasan" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition bg-white">
                        <option value="">-- Belum Ditentukan / Luar Kawasan --</option>
                        @foreach ($daftarKawasan as $kawasan)
                            <option value="{{ $kawasan->id }}" {{ old('id_kawasan', $laporan->id_kawasan) == $kawasan->id ? 'selected' : '' }}>
                                {{ $kawasan->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="catatan_admin" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Catatan Admin untuk Warga</label>
                    <textarea id="catatan_admin" name="catatan_admin" rows="4" placeholder="Tulis instruksi atau update penanganan yang akan dibaca warga di menu Cek Status..." class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-xs focus:border-green-600 outline-none transition">{{ old('catatan_admin', $laporan->catatan_admin) }}</textarea>
                </div>

                @if ($laporan->admin)
                    <div class="text-[11px] text-stone-400 pt-2 border-t border-stone-100">
                        Terakhir diubah oleh: <strong>{{ $laporan->admin->name }}</strong>
                    </div>
                @endif

                <div class="pt-2">
                    <button type="submit" class="w-full py-2.5 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl transition text-xs flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-floppy-disk text-xs"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>

            <div class="pt-4 border-t border-stone-100">
                <form method="POST" action="{{ route('admin.laporan.destroy', $laporan->id) }}" data-confirm="Apakah Anda yakin ingin menghapus laporan ini secara permanen?" data-confirm-title="Hapus Laporan" data-confirm-ok="Ya, Hapus">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-2.5 bg-white hover:bg-stone-100 text-stone-700 hover:text-stone-900 border border-stone-300 font-semibold rounded-xl text-xs transition flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-trash text-xs text-stone-500"></i>
                        <span>Hapus Laporan Palsu / Salah</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var lat = {{ $laporan->latitude }};
    var lng = {{ $laporan->longitude }};
    var warna = '{{ $laporan->jenis === "Kebakaran" ? "#dc2626" : "#ea580c" }}';

    var batasJabar = L.latLngBounds(L.latLng(-7.9, 106.3), L.latLng(-5.9, 108.9));
    var map = L.map('peta-laporan-detail', {
        maxBounds: batasJabar,
        minZoom: 7
    }).setView([lat, lng], 14);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.circleMarker([lat, lng], {
        radius: 10,
        color: warna,
        fillColor: warna,
        fillOpacity: 0.9,
        weight: 3
    }).addTo(map).bindPopup('<strong>' + '{{ $laporan->jenis }}' + '</strong><br>' + '{{ $laporan->kode }}').openPopup();
});
</script>
@endsection
