@extends('layouts.admin')

@section('title', 'Pengaturan Sistem')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl md:text-3xl font-extrabold text-stone-900 tracking-tight">Pengaturan Sistem</h1>
    <p class="text-stone-500 text-sm mt-1">Konfigurasi identitas desa, koordinat pusat peta, dan parameter pencarian titik api satelit.</p>
</div>

<form method="POST" action="{{ route('admin.pengaturan.update') }}" enctype="multipart/form-data" class="space-y-8">
    @csrf

    <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-6 sm:p-8">
        <h2 class="text-lg font-bold text-stone-900 mb-6 flex items-center border-b border-stone-100 pb-4">
            <i class="fa-solid fa-circle-info text-green-700 mr-2.5"></i>
            <span>Identitas dan Kontak Aplikasi</span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="nama_aplikasi" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Nama Aplikasi</label>
                <input type="text" id="nama_aplikasi" name="nama_aplikasi" value="{{ old('nama_aplikasi', $pengaturan->nama_aplikasi ?? 'Jaga Hutan Desa') }}" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition">
            </div>

            <div>
                <label for="nama_instansi" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Nama Instansi / Pemerintah Desa</label>
                <input type="text" id="nama_instansi" name="nama_instansi" value="{{ old('nama_instansi', $pengaturan->nama_instansi ?? '') }}" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition">
            </div>

            <div class="md:col-span-2">
                <label for="slogan" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Slogan</label>
                <input type="text" id="slogan" name="slogan" value="{{ old('slogan', $pengaturan->slogan ?? '') }}" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition">
            </div>

            <div class="md:col-span-2">
                <label for="deskripsi_singkat" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Deskripsi Singkat</label>
                <textarea id="deskripsi_singkat" name="deskripsi_singkat" rows="3" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition">{{ old('deskripsi_singkat', $pengaturan->deskripsi_singkat ?? '') }}</textarea>
            </div>

            <div>
                <label for="email" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Alamat Email Resmi</label>
                <input type="email" id="email" name="email" value="{{ old('email', $pengaturan->email ?? '') }}" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition">
            </div>

            <div>
                <label for="telepon" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Nomor Telepon Desa</label>
                <input type="text" id="telepon" name="telepon" value="{{ old('telepon', $pengaturan->telepon ?? '') }}" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition">
            </div>

            <div class="md:col-span-2">
                <label for="alamat" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Alamat Kantor Desa / Posko</label>
                <textarea id="alamat" name="alamat" rows="2" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition">{{ old('alamat', $pengaturan->alamat ?? '') }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Logo Aplikasi</label>
                <div class="flex items-center space-x-6">
                    <div class="w-16 h-16 rounded-2xl bg-stone-100 border border-stone-200 flex items-center justify-center shrink-0 overflow-hidden shadow-inner">
                        @if ($pengaturan && $pengaturan->logo)
                            <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo saat ini" class="w-full h-full object-contain">
                        @else
                            <i class="fa-solid fa-tree text-green-800 text-2xl"></i>
                        @endif
                    </div>
                    <div class="flex-1">
                        <input type="file" id="logo" name="logo" accept="image/png,image/jpeg,image/jpg" class="w-full text-xs text-stone-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition cursor-pointer">
                        <p class="text-[11px] text-stone-400 mt-1">Format: JPG, JPEG, atau PNG (Maksimal 2MB). Biarkan kosong bila tidak ingin mengganti logo.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-6 sm:p-8">
        <h2 class="text-lg font-bold text-stone-900 mb-6 flex items-center border-b border-stone-100 pb-4">
            <i class="fa-solid fa-map-location-dot text-green-700 mr-2.5"></i>
            <span>Pengaturan Peta & Titik Api</span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div>
                <label for="lat_pusat" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Latitude Pusat</label>
                <input type="number" step="0.0000001" id="lat_pusat" name="lat_pusat" value="{{ old('lat_pusat', $pengaturan->lat_pusat ?? -6.8921000) }}" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition font-mono">
            </div>

            <div>
                <label for="long_pusat" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Longitude Pusat</label>
                <input type="number" step="0.0000001" id="long_pusat" name="long_pusat" value="{{ old('long_pusat', $pengaturan->long_pusat ?? 108.4112000) }}" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition font-mono">
            </div>

            <div>
                <label for="zoom_awal" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Zoom Awal Peta</label>
                <input type="number" id="zoom_awal" name="zoom_awal" value="{{ old('zoom_awal', $pengaturan->zoom_awal ?? 13) }}" min="1" max="20" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition">
            </div>

            <div>
                <label for="radius_titik_api_km" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Radius Titik Api (KM)</label>
                <input type="number" id="radius_titik_api_km" name="radius_titik_api_km" value="{{ old('radius_titik_api_km', $pengaturan->radius_titik_api_km ?? 30) }}" min="1" max="200" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition">
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="px-8 py-3.5 bg-green-700 hover:bg-green-600 text-white font-bold rounded-xl shadow transition active:scale-95 text-sm flex items-center space-x-2">
            <i class="fa-solid fa-floppy-disk"></i>
            <span>Simpan Perubahan</span>
        </button>
    </div>
</form>
@endsection
