@extends('layouts.admin')

@section('title', 'Detail Laporan ' . $laporan->kode)

@section('content')
<div class="mb-8">
    <div class="flex items-center space-x-2 text-xs text-stone-500 mb-2">
        <a href="{{ route('admin.laporan.index') }}" class="hover:text-green-700">Kelola Laporan</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-stone-800 font-semibold">{{ $laporan->kode }}</span>
    </div>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-stone-900 tracking-tight flex items-center space-x-3">
                <span class="font-mono">{{ $laporan->kode }}</span>
                @if ($laporan->status === 'Baru')
                    <span class="text-xs font-black px-3.5 py-1 rounded-full bg-rose-100 text-rose-800">Baru</span>
                @elseif ($laporan->status === 'Diverifikasi')
                    <span class="text-xs font-black px-3.5 py-1 rounded-full bg-amber-100 text-amber-800">Diverifikasi</span>
                @elseif ($laporan->status === 'Ditangani')
                    <span class="text-xs font-black px-3.5 py-1 rounded-full bg-sky-100 text-sky-800">Ditangani</span>
                @else
                    <span class="text-xs font-black px-3.5 py-1 rounded-full bg-emerald-100 text-emerald-800">Selesai</span>
                @endif
            </h1>
            <p class="text-stone-500 text-sm mt-1">
                Dilaporkan pada {{ \Carbon\Carbon::parse($laporan->created_at)->locale('id')->isoFormat('dddd, D MMMM Y - HH:mm') }} WIB
            </p>
        </div>

        @if ($laporan->jenis === 'Kebakaran')
            <a href="{{ Route::has('admin.prediksi.index') ? route('admin.prediksi.index', ['id_laporan' => $laporan->id, 'lat' => $laporan->latitude, 'long' => $laporan->longitude]) : '#' }}" class="inline-flex items-center px-5 py-3 bg-red-600 hover:bg-red-500 text-white font-bold rounded-xl shadow transition text-xs shrink-0 active:scale-95">
                <i class="fa-solid fa-fire-flame-curved mr-2"></i>
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

                <div class="sm:col-span-2">
                    <span class="text-xs text-stone-400 block mb-1">Deskripsi Warga</span>
                    <p class="p-4 rounded-xl bg-stone-50 border border-stone-100 text-stone-800 leading-relaxed text-xs sm:text-sm">
                        {{ $laporan->deskripsi }}
                    </p>
                </div>

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
                    <button type="submit" class="w-full py-3 bg-green-700 hover:bg-green-600 text-white font-bold rounded-xl shadow transition text-xs flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>

            <div class="pt-4 border-t border-stone-100">
                <form method="POST" action="{{ route('admin.laporan.destroy', $laporan->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini secara permanen?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-semibold rounded-xl text-xs transition flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-trash"></i>
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

    var map = L.map('peta-laporan-detail').setView([lat, lng], 15);

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
