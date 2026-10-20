@extends('layouts.admin')

@section('title', 'Pengaturan Sistem')

@section('content')
<div class="mb-5">
    <h1 class="text-lg md:text-xl font-bold text-stone-900 tracking-tight">Pengaturan Sistem</h1>
    <p class="text-stone-500 text-xs mt-0.5">Konfigurasi identitas desa, koordinat pusat peta, dan parameter pencarian titik api satelit.</p>
</div>

<form method="POST" action="{{ route('admin.pengaturan.update') }}" enctype="multipart/form-data" class="space-y-5">
    @csrf

    <div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 p-4 sm:p-5">
        <h2 class="text-sm font-bold text-stone-900 mb-4 flex items-center border-b border-stone-200/80 pb-3">
            <i class="fa-solid fa-circle-info text-stone-700 mr-2"></i>
            <span>Identitas dan Kontak Aplikasi</span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="nama_aplikasi" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Nama Aplikasi</label>
                <input type="text" id="nama_aplikasi" name="nama_aplikasi" value="{{ old('nama_aplikasi', $pengaturan->nama_aplikasi ?? 'Jaga Hutan Desa') }}" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition">
            </div>

            <div>
                <label for="nama_instansi" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Nama Instansi / Pemerintah Desa</label>
                <input type="text" id="nama_instansi" name="nama_instansi" value="{{ old('nama_instansi', $pengaturan->nama_instansi ?? '') }}" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition">
            </div>

            <div class="md:col-span-2">
                <label for="slogan" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Slogan</label>
                <input type="text" id="slogan" name="slogan" value="{{ old('slogan', $pengaturan->slogan ?? '') }}" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition">
            </div>

            <div class="md:col-span-2">
                <label for="deskripsi_singkat" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Deskripsi Singkat</label>
                <textarea id="deskripsi_singkat" name="deskripsi_singkat" rows="3" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition">{{ old('deskripsi_singkat', $pengaturan->deskripsi_singkat ?? '') }}</textarea>
            </div>

            <div>
                <label for="email" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Alamat Email Resmi</label>
                <input type="email" id="email" name="email" value="{{ old('email', $pengaturan->email ?? '') }}" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition">
            </div>

            <div>
                <label for="telepon" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Nomor Telepon Desa</label>
                <input type="text" id="telepon" name="telepon" value="{{ old('telepon', $pengaturan->telepon ?? '') }}" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition">
            </div>

            <div class="md:col-span-2">
                <label for="alamat" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Alamat Kantor Desa / Posko</label>
                <textarea id="alamat" name="alamat" rows="2" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition">{{ old('alamat', $pengaturan->alamat ?? '') }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Logo Aplikasi</label>
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 rounded-xl bg-stone-100 border border-stone-200 flex items-center justify-center shrink-0 overflow-hidden shadow-inner">
                        @if ($pengaturan && $pengaturan->logo)
                            <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo saat ini" class="w-full h-full object-contain">
                        @else
                            <i class="fa-solid fa-tree text-stone-700 text-xl"></i>
                        @endif
                    </div>
                    <div class="flex-1">
                        <input type="file" id="logo" name="logo" accept="image/png,image/jpeg,image/jpg" class="w-full text-xs text-stone-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-stone-100 file:text-stone-800 hover:file:bg-stone-200 transition cursor-pointer">
                        <p class="text-[10px] text-stone-400 mt-1">Format: JPG, JPEG, atau PNG (Maksimal 2MB). Biarkan kosong bila tidak ingin mengganti logo.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 p-4 sm:p-5">
        <h2 class="text-sm font-bold text-stone-900 mb-4 flex items-center border-b border-stone-200/80 pb-3">
            <i class="fa-solid fa-map-location-dot text-stone-700 mr-2"></i>
            <span>Pengaturan Peta & Batas Wilayah Satelit (Jawa Barat)</span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label for="lat_pusat" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Latitude Pusat</label>
                <input type="number" step="0.0000001" id="lat_pusat" name="lat_pusat" value="{{ old('lat_pusat', $pengaturan->lat_pusat ?? -6.8700000) }}" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition font-mono">
            </div>

            <div>
                <label for="long_pusat" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Longitude Pusat</label>
                <input type="number" step="0.0000001" id="long_pusat" name="long_pusat" value="{{ old('long_pusat', $pengaturan->long_pusat ?? 107.6000000) }}" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition font-mono">
            </div>

            <div>
                <label for="zoom_awal" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Zoom Awal Peta</label>
                <input type="number" id="zoom_awal" name="zoom_awal" value="{{ old('zoom_awal', $pengaturan->zoom_awal ?? 8) }}" min="1" max="20" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition">
            </div>
        </div>

        <div class="border-t border-stone-200/80 pt-4">
            <h3 class="text-xs font-bold text-stone-800 mb-3 uppercase tracking-wider">Area Koordinat Batas Pemantauan Satelit (BBOX FIRMS)</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="bbox_barat" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Batas Barat (Min Long)</label>
                    <input type="number" step="0.0000001" id="bbox_barat" name="bbox_barat" value="{{ old('bbox_barat', $pengaturan->bbox_barat ?? 106.37) }}" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition font-mono">
                </div>

                <div>
                    <label for="bbox_selatan" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Batas Selatan (Min Lat)</label>
                    <input type="number" step="0.0000001" id="bbox_selatan" name="bbox_selatan" value="{{ old('bbox_selatan', $pengaturan->bbox_selatan ?? -7.82) }}" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition font-mono">
                </div>

                <div>
                    <label for="bbox_timur" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Batas Timur (Max Long)</label>
                    <input type="number" step="0.0000001" id="bbox_timur" name="bbox_timur" value="{{ old('bbox_timur', $pengaturan->bbox_timur ?? 108.84) }}" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition font-mono">
                </div>

                <div>
                    <label for="bbox_utara" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Batas Utara (Max Lat)</label>
                    <input type="number" step="0.0000001" id="bbox_utara" name="bbox_utara" value="{{ old('bbox_utara', $pengaturan->bbox_utara ?? -5.92) }}" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition font-mono">
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-end pt-1">
        <button type="submit" class="px-5 py-2.5 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl shadow-sm transition active:scale-95 text-xs sm:text-sm flex items-center space-x-2">
            <i class="fa-solid fa-floppy-disk text-xs"></i>
            <span>Simpan Perubahan</span>
        </button>
    </div>
</form>
@endsection
