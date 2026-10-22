@extends('layouts.publik')

@section('title', 'Lapor Darurat')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <div class="text-center mb-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-stone-100 text-stone-700 mb-3 border border-stone-200">
            <i class="fa-solid fa-tower-broadcast text-amber-600"></i>
            <span>Layanan Cepat Tanggap Jawa Barat</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-stone-900 tracking-tight">Formulir Lapor Darurat</h1>
        <p class="text-stone-500 text-xs sm:text-sm mt-1.5 max-w-lg mx-auto leading-relaxed">
            Laporkan kejadian kebakaran hutan, konflik satwa liar, pendaki/orang hilang, atau kejadian darurat kehutanan lainnya di Jawa Barat tanpa perlu login akun.
        </p>
    </div>

    <div id="kotak-notif-offline" class="hidden mb-6 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs sm:text-sm">
        <div class="flex items-start space-x-3">
            <i class="fa-solid fa-circle-exclamation text-amber-600 mt-0.5 text-base shrink-0"></i>
            <div id="pesan-notif-offline" class="leading-relaxed"></div>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl p-4 sm:p-5 mb-6 text-xs sm:text-sm">
            <div class="flex items-center font-bold mb-2">
                <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                <span>Terdapat kesalahan pada input:</span>
            </div>
            <ul class="list-disc list-inside text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-xs border border-stone-200/90 p-5 sm:p-8 md:p-10">
        <form id="form-lapor" method="POST" action="{{ route('lapor.simpan') }}" enctype="multipart/form-data" class="space-y-7">
            @csrf

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2.5">
                    1. Jenis Kejadian Darurat <span class="text-rose-500">*</span>
                </label>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5">
                    <label class="relative flex flex-col justify-between p-4 rounded-2xl border-2 cursor-pointer transition select-none bg-white hover:border-stone-300 min-h-[115px]" id="label-jenis-kebakaran" onclick="pilihJenis('Kebakaran')">
                        <input type="radio" name="jenis" value="Kebakaran" {{ old('jenis', $jenisTerpilih ?? 'Kebakaran') === 'Kebakaran' ? 'checked' : '' }} class="sr-only">
                        <div class="flex items-start justify-between w-full mb-2">
                            <div class="w-10 h-10 rounded-xl bg-stone-100 flex items-center justify-center text-stone-800 text-base border border-stone-200 shrink-0" id="icon-box-kebakaran">
                                <i class="fa-solid fa-fire-flame-curved"></i>
                            </div>
                            <div class="w-5 h-5 rounded-full border-2 border-stone-300 flex items-center justify-center shrink-0 mt-0.5" id="dot-kebakaran">
                                <div class="w-2.5 h-2.5 rounded-full bg-stone-900 hidden" id="dot-fill-kebakaran"></div>
                            </div>
                        </div>
                        <div>
                            <div class="font-bold text-xs sm:text-sm text-stone-900">Kebakaran Hutan</div>
                            <div class="text-[11px] text-stone-500 mt-0.5 leading-snug">Titik api / asap karhutla</div>
                        </div>
                    </label>

                    <label class="relative flex flex-col justify-between p-4 rounded-2xl border-2 cursor-pointer transition select-none bg-white hover:border-stone-300 min-h-[115px]" id="label-jenis-hewan" onclick="pilihJenis('Hewan Masuk Kampung')">
                        <input type="radio" name="jenis" value="Hewan Masuk Kampung" {{ old('jenis', $jenisTerpilih) === 'Hewan Masuk Kampung' ? 'checked' : '' }} class="sr-only">
                        <div class="flex items-start justify-between w-full mb-2">
                            <div class="w-10 h-10 rounded-xl bg-stone-100 flex items-center justify-center text-stone-800 text-base border border-stone-200 shrink-0" id="icon-box-hewan">
                                <i class="fa-solid fa-paw"></i>
                            </div>
                            <div class="w-5 h-5 rounded-full border-2 border-stone-300 flex items-center justify-center shrink-0 mt-0.5" id="dot-hewan">
                                <div class="w-2.5 h-2.5 rounded-full bg-stone-900 hidden" id="dot-fill-hewan"></div>
                            </div>
                        </div>
                        <div>
                            <div class="font-bold text-xs sm:text-sm text-stone-900">Satwa Masuk</div>
                            <div class="text-[11px] text-stone-500 mt-0.5 leading-snug">Primata / satwa di kebun</div>
                        </div>
                    </label>

                    <label class="relative flex flex-col justify-between p-4 rounded-2xl border-2 cursor-pointer transition select-none bg-white hover:border-stone-300 min-h-[115px]" id="label-jenis-hilang" onclick="pilihJenis('Orang Hilang')">
                        <input type="radio" name="jenis" value="Orang Hilang" {{ old('jenis', $jenisTerpilih) === 'Orang Hilang' ? 'checked' : '' }} class="sr-only">
                        <div class="flex items-start justify-between w-full mb-2">
                            <div class="w-10 h-10 rounded-xl bg-stone-100 flex items-center justify-center text-stone-800 text-base border border-stone-200 shrink-0" id="icon-box-hilang">
                                <i class="fa-solid fa-person-hiking"></i>
                            </div>
                            <div class="w-5 h-5 rounded-full border-2 border-stone-300 flex items-center justify-center shrink-0 mt-0.5" id="dot-hilang">
                                <div class="w-2.5 h-2.5 rounded-full bg-stone-900 hidden" id="dot-fill-hilang"></div>
                            </div>
                        </div>
                        <div>
                            <div class="font-bold text-xs sm:text-sm text-stone-900">Orang Hilang</div>
                            <div class="text-[11px] text-stone-500 mt-0.5 leading-snug">Pendaki / warga tersesat</div>
                        </div>
                    </label>

                    <label class="relative flex flex-col justify-between p-4 rounded-2xl border-2 cursor-pointer transition select-none bg-white hover:border-stone-300 min-h-[115px]" id="label-jenis-lainnya" onclick="pilihJenis('Lainnya')">
                        <input type="radio" name="jenis" value="Lainnya" {{ old('jenis', $jenisTerpilih) === 'Lainnya' ? 'checked' : '' }} class="sr-only">
                        <div class="flex items-start justify-between w-full mb-2">
                            <div class="w-10 h-10 rounded-xl bg-stone-100 flex items-center justify-center text-stone-800 text-base border border-stone-200 shrink-0" id="icon-box-lainnya">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </div>
                            <div class="w-5 h-5 rounded-full border-2 border-stone-300 flex items-center justify-center shrink-0 mt-0.5" id="dot-lainnya">
                                <div class="w-2.5 h-2.5 rounded-full bg-stone-900 hidden" id="dot-fill-lainnya"></div>
                            </div>
                        </div>
                        <div>
                            <div class="font-bold text-xs sm:text-sm text-stone-900">Lainnya</div>
                            <div class="text-[11px] text-stone-500 mt-0.5 leading-snug">Illegal logging, longsor</div>
                        </div>
                    </label>
                </div>
            </div>

            <div id="wadah-detail-kebakaran" class="hidden space-y-3.5 pt-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label for="tipe_vegetasi" class="block text-xs font-medium text-stone-700 mb-1">
                            Vegetasi / Bahan Terbakar <span class="text-rose-500">*</span>
                        </label>
                        <select id="tipe_vegetasi" name="tipe_vegetasi" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-xs sm:text-sm bg-white focus:border-stone-900 outline-none transition">
                            <option value="">-- Pilih Jenis Vegetasi Terbakar --</option>
                            <option value="Semak Belukar / Alang-alang" {{ old('tipe_vegetasi') === 'Semak Belukar / Alang-alang' ? 'selected' : '' }}>Semak Belukar / Alang-alang Kering</option>
                            <option value="Tegakan Pohon Pinus / Rimba" {{ old('tipe_vegetasi') === 'Tegakan Pohon Pinus / Rimba' ? 'selected' : '' }}>Tegakan Pohon Pinus / Rimba Hutan</option>
                            <option value="Lahan Gambut / Serasah Kering" {{ old('tipe_vegetasi') === 'Lahan Gambut / Serasah Kering' ? 'selected' : '' }}>Lahan Gambut / Serasah Daun Kering</option>
                            <option value="Perkebunan Warga dekat Hutan" {{ old('tipe_vegetasi') === 'Perkebunan Warga dekat Hutan' ? 'selected' : '' }}>Perkebunan Warga dekat Hutan</option>
                            <option value="Lainnya / Tidak Tahu" {{ old('tipe_vegetasi') === 'Lainnya / Tidak Tahu' ? 'selected' : '' }}>Lainnya / Belum Diketahui</option>
                        </select>
                    </div>

                    <div>
                        <label for="perkiraan_luas" class="block text-xs font-medium text-stone-700 mb-1">
                            Perkiraan Luas Area Terbakar <span class="text-rose-500">*</span>
                        </label>
                        <select id="perkiraan_luas" name="perkiraan_luas" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-xs sm:text-sm bg-white focus:border-stone-900 outline-none transition">
                            <option value="">-- Pilih Perkiraan Luas --</option>
                            <option value="Spot Kecil (< 0.5 Ha)" {{ old('perkiraan_luas') === 'Spot Kecil (< 0.5 Ha)' ? 'selected' : '' }}>Spot Kecil (&lt; 0.5 Hektare)</option>
                            <option value="Sedang (0.5 - 2 Ha)" {{ old('perkiraan_luas') === 'Sedang (0.5 - 2 Ha)' ? 'selected' : '' }}>Sedang (0.5 - 2 Hektare)</option>
                            <option value="Luas (> 2 Ha)" {{ old('perkiraan_luas') === 'Luas (> 2 Ha)' ? 'selected' : '' }}>Luas / Menjalar (&gt; 2 Hektare)</option>
                            <option value="Sangat Luas (> 10 Ha)" {{ old('perkiraan_luas') === 'Sangat Luas (> 10 Ha)' ? 'selected' : '' }}>Sangat Luas / Masif (&gt; 10 Hektare)</option>
                            <option value="Belum Terukur" {{ old('perkiraan_luas') === 'Belum Terukur' ? 'selected' : '' }}>Belum Dapat Diperkirakan</option>
                        </select>
                    </div>

                    <div>
                        <label for="kondisi_api" class="block text-xs font-medium text-stone-700 mb-1">
                            Kondisi Kobaran Api & Asap <span class="text-rose-500">*</span>
                        </label>
                        <select id="kondisi_api" name="kondisi_api" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-xs sm:text-sm bg-white focus:border-stone-900 outline-none transition">
                            <option value="">-- Pilih Kondisi Api --</option>
                            <option value="Kepulan Asap Tebal (Api belum tampak)" {{ old('kondisi_api') === 'Kepulan Asap Tebal (Api belum tampak)' ? 'selected' : '' }}>Kepulan Asap Tebal (Api belum tampak)</option>
                            <option value="Api Berkobar Menjalar Cepat" {{ old('kondisi_api') === 'Api Berkobar Menjalar Cepat' ? 'selected' : '' }}>Api Berkobar &amp; Menjalar Cepat</option>
                            <option value="Api Merayap di Permukaan" {{ old('kondisi_api') === 'Api Merayap di Permukaan' ? 'selected' : '' }}>Api Merayap di Permukaan Tanah</option>
                            <option value="Bara Api & Sisa Asap" {{ old('kondisi_api') === 'Bara Api & Sisa Asap' ? 'selected' : '' }}>Bara Api &amp; Sisa-sisa Asap</option>
                        </select>
                    </div>

                    <div>
                        <label for="arah_angin" class="block text-xs font-medium text-stone-700 mb-1">
                            Arah Tiupan Angin <span class="text-rose-500">*</span>
                        </label>
                        <select id="arah_angin" name="arah_angin" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-xs sm:text-sm bg-white focus:border-stone-900 outline-none transition">
                            <option value="">-- Pilih Arah Angin --</option>
                            <option value="Mengarah ke Permukiman / Kebun" {{ old('arah_angin') === 'Mengarah ke Permukiman / Kebun' ? 'selected' : '' }}>Mengarah ke Permukiman / Kebun Warga</option>
                            <option value="Mengarah ke Puncak Hutan" {{ old('arah_angin') === 'Mengarah ke Puncak Hutan' ? 'selected' : '' }}>Mengarah ke Puncak / Lereng Hutan</option>
                            <option value="Angin Tenang" {{ old('arah_angin') === 'Angin Tenang' ? 'selected' : '' }}>Angin Tenang / Lambat</option>
                            <option value="Angin Kencang Berubah-ubah" {{ old('arah_angin') === 'Angin Kencang Berubah-ubah' ? 'selected' : '' }}>Angin Kencang &amp; Berubah-ubah</option>
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="potensi_bahaya" class="block text-xs font-medium text-stone-700 mb-1">
                            Posisi / Kerentanan Area <span class="text-rose-500">*</span>
                        </label>
                        <select id="potensi_bahaya" name="potensi_bahaya" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-xs sm:text-sm bg-white focus:border-stone-900 outline-none transition">
                            <option value="">-- Pilih Kerentanan Area --</option>
                            <option value="Dekat Permukiman Warga (< 500m)" {{ old('potensi_bahaya') === 'Dekat Permukiman Warga (< 500m)' ? 'selected' : '' }}>Dekat Permukiman Warga (&lt; 500 Meter)</option>
                            <option value="Dekat Sumber Air / Sungai" {{ old('potensi_bahaya') === 'Dekat Sumber Air / Sungai' ? 'selected' : '' }}>Dekat Sumber Air / Sungai</option>
                            <option value="Di Tebing Curam / Sulit Dijangkau" {{ old('potensi_bahaya') === 'Di Tebing Curam / Sulit Dijangkau' ? 'selected' : '' }}>Di Tebing Curam / Jurang (Sulit Dijangkau)</option>
                            <option value="Jauh di Tengah Kawasan Hutan" {{ old('potensi_bahaya') === 'Jauh di Tengah Kawasan Hutan' ? 'selected' : '' }}>Jauh di Tengah Kawasan Hutan</option>
                        </select>
                    </div>
                </div>
            </div>

            <div id="wadah-detail-hewan" class="hidden space-y-3.5 pt-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label for="jenis_hewan" class="block text-xs font-medium text-stone-700 mb-1">
                            Jenis Satwa yang Terlihat <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="jenis_hewan" name="jenis_hewan" list="daftar-hewan-rekomendasi" value="{{ old('jenis_hewan') }}" placeholder="Contoh: Monyet Ekor Panjang, Lutung, Babi Hutan..." class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-xs sm:text-sm bg-white focus:border-stone-900 outline-none transition">
                        <datalist id="daftar-hewan-rekomendasi">
                            <option value="Monyet Ekor Panjang">
                            <option value="Lutung Jawa">
                            <option value="Surili">
                            <option value="Babi Hutan">
                            <option value="Ular Berbisa / Sanca">
                            <option value="Macan Tutul / Kumbang">
                            <option value="Trenggiling">
                            <option value="Burung Pemangsa / Elang">
                        </datalist>
                    </div>

                    <div>
                        <label for="jumlah_satwa" class="block text-xs font-medium text-stone-700 mb-1">
                            Perkiraan Jumlah Ekor <span class="text-rose-500">*</span>
                        </label>
                        <select id="jumlah_satwa" name="jumlah_satwa" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-xs sm:text-sm bg-white focus:border-stone-900 outline-none transition">
                            <option value="">-- Pilih Perkiraan Jumlah --</option>
                            <option value="1 Ekor (Sendirian)" {{ old('jumlah_satwa') === '1 Ekor (Sendirian)' ? 'selected' : '' }}>1 Ekor (Sendirian)</option>
                            <option value="2 - 5 Ekor (Kelompok Kecil)" {{ old('jumlah_satwa') === '2 - 5 Ekor (Kelompok Kecil)' ? 'selected' : '' }}>2 - 5 Ekor (Kelompok Kecil)</option>
                            <option value="Lebih dari 5 Ekor (Kawanan)" {{ old('jumlah_satwa') === 'Lebih dari 5 Ekor (Kawanan)' ? 'selected' : '' }}>Lebih dari 5 Ekor (Kawanan Besar)</option>
                            <option value="Tidak Terhitung Jelas" {{ old('jumlah_satwa') === 'Tidak Terhitung Jelas' ? 'selected' : '' }}>Tidak Terhitung Jelas</option>
                        </select>
                    </div>

                    <div>
                        <label for="aktivitas_satwa" class="block text-xs font-medium text-stone-700 mb-1">
                            Aktivitas / Dampak Satwa <span class="text-rose-500">*</span>
                        </label>
                        <select id="aktivitas_satwa" name="aktivitas_satwa" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-xs sm:text-sm bg-white focus:border-stone-900 outline-none transition">
                            <option value="">-- Pilih Aktivitas Satwa --</option>
                            <option value="Merusak Kebun / Tanaman Warga" {{ old('aktivitas_satwa') === 'Merusak Kebun / Tanaman Warga' ? 'selected' : '' }}>Merusak Kebun / Tanaman Warga</option>
                            <option value="Masuk ke Halaman / Rumah Warga" {{ old('aktivitas_satwa') === 'Masuk ke Halaman / Rumah Warga' ? 'selected' : '' }}>Masuk ke Halaman / Rumah Warga</option>
                            <option value="Memangsa Hewan Ternak" {{ old('aktivitas_satwa') === 'Memangsa Hewan Ternak' ? 'selected' : '' }}>Memangsa Hewan Ternak (Ayam, Kambing, dll)</option>
                            <option value="Agresif / Menyerang Warga" {{ old('aktivitas_satwa') === 'Agresif / Menyerang Warga' ? 'selected' : '' }}>Agresif / Menyerang / Mengancam Warga</option>
                            <option value="Satwa Terluka / Terjebak" {{ old('aktivitas_satwa') === 'Satwa Terluka / Terjebak' ? 'selected' : '' }}>Satwa Terluka / Terjebak</option>
                        </select>
                    </div>

                    <div>
                        <label for="posisi_satwa" class="block text-xs font-medium text-stone-700 mb-1">
                            Posisi Satwa Saat Ini <span class="text-rose-500">*</span>
                        </label>
                        <select id="posisi_satwa" name="posisi_satwa" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-xs sm:text-sm bg-white focus:border-stone-900 outline-none transition">
                            <option value="">-- Pilih Posisi Satwa --</option>
                            <option value="Masih di Lokasi (Pohon / Atap)" {{ old('posisi_satwa') === 'Masih di Lokasi (Pohon / Atap)' ? 'selected' : '' }}>Masih di Lokasi (Pohon / Atap / Pekarangan)</option>
                            <option value="Bersembunyi di Rumpun Semak" {{ old('posisi_satwa') === 'Bersembunyi di Rumpun Semak' ? 'selected' : '' }}>Bersembunyi di Rumpun Semak / Bambu</option>
                            <option value="Bergerak Kembali Menuju Hutan" {{ old('posisi_satwa') === 'Bergerak Kembali Menuju Hutan' ? 'selected' : '' }}>Sudah Bergerak Menjauh Kembali ke Hutan</option>
                            <option value="Terjebak di Bangunan / Sumur" {{ old('posisi_satwa') === 'Terjebak di Bangunan / Sumur' ? 'selected' : '' }}>Terjebak di Bangunan / Sumur / Kandang</option>
                        </select>
                    </div>
                </div>
            </div>

            <div id="wadah-detail-hilang" class="hidden space-y-3.5 pt-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label for="nama_korban" class="block text-xs font-medium text-stone-700 mb-1">
                            Nama Korban / Survivor <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="nama_korban" name="nama_korban" value="{{ old('nama_korban') }}" placeholder="Contoh: Rian Pratama (atau rombongan X)" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-xs sm:text-sm bg-white focus:border-stone-900 outline-none transition">
                    </div>

                    <div>
                        <label for="jumlah_korban" class="block text-xs font-medium text-stone-700 mb-1">
                            Jumlah Orang yang Dicari <span class="text-rose-500">*</span>
                        </label>
                        <select id="jumlah_korban" name="jumlah_korban" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-xs sm:text-sm bg-white focus:border-stone-900 outline-none transition">
                            <option value="">-- Pilih Jumlah Korban --</option>
                            <option value="1 Orang (Sendirian)" {{ old('jumlah_korban') === '1 Orang (Sendirian)' ? 'selected' : '' }}>1 Orang (Sendirian / Terpisah)</option>
                            <option value="2 - 4 Orang (Kelompok Kecil)" {{ old('jumlah_korban') === '2 - 4 Orang (Kelompok Kecil)' ? 'selected' : '' }}>2 - 4 Orang (Kelompok Kecil)</option>
                            <option value="Lebih dari 4 Orang (Rombongan)" {{ old('jumlah_korban') === 'Lebih dari 4 Orang (Rombongan)' ? 'selected' : '' }}>Lebih dari 4 Orang (Rombongan)</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label for="usia_korban" class="block text-xs font-medium text-stone-700 mb-1">
                                Perkiraan Usia <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="usia_korban" name="usia_korban" value="{{ old('usia_korban') }}" placeholder="Contoh: 23 Tahun" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-xs sm:text-sm bg-white focus:border-stone-900 outline-none transition">
                        </div>
                        <div>
                            <label for="gender_korban" class="block text-xs font-medium text-stone-700 mb-1">
                                Jenis Kelamin <span class="text-rose-500">*</span>
                            </label>
                            <select id="gender_korban" name="gender_korban" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-xs sm:text-sm bg-white focus:border-stone-900 outline-none transition">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old('gender_korban') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('gender_korban') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                <option value="Campuran" {{ old('gender_korban') === 'Campuran' ? 'selected' : '' }}>Campuran</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="kontak_terakhir" class="block text-xs font-medium text-stone-700 mb-1">
                            Waktu Kontak / Terlihat Terakhir <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="kontak_terakhir" name="kontak_terakhir" value="{{ old('kontak_terakhir') }}" placeholder="Contoh: Kemarin jam 16:30 WIB" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-xs sm:text-sm bg-white focus:border-stone-900 outline-none transition">
                    </div>

                    <div>
                        <label for="jalur_pendakian" class="block text-xs font-medium text-stone-700 mb-1">
                            Jalur / Titik Masuk Terakhir <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="jalur_pendakian" name="jalur_pendakian" value="{{ old('jalur_pendakian') }}" placeholder="Contoh: Pos 3 Jalur Apuy / Palutungan" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-xs sm:text-sm bg-white focus:border-stone-900 outline-none transition">
                    </div>

                    <div>
                        <label for="kondisi_bekal" class="block text-xs font-medium text-stone-700 mb-1">
                            Perlengkapan / Bekal Logistik <span class="text-rose-500">*</span>
                        </label>
                        <select id="kondisi_bekal" name="kondisi_bekal" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-xs sm:text-sm bg-white focus:border-stone-900 outline-none transition">
                            <option value="">-- Pilih Kondisi Bekal --</option>
                            <option value="Logistik Diperkirakan Habis" {{ old('kondisi_bekal') === 'Logistik Diperkirakan Habis' ? 'selected' : '' }}>Logistik / Air Diperkirakan Habis</option>
                            <option value="Membawa Tenda & Logistik Lengkap" {{ old('kondisi_bekal') === 'Membawa Tenda & Logistik Lengkap' ? 'selected' : '' }}>Membawa Tenda &amp; Logistik Lengkap</option>
                            <option value="Membawa HP Aktif / HT / Peluit" {{ old('kondisi_bekal') === 'Membawa HP Aktif / HT / Peluit' ? 'selected' : '' }}>Membawa HP Aktif / HT / Peluit</option>
                            <option value="Perlengkapan Minim / Bukan Pendaki" {{ old('kondisi_bekal') === 'Perlengkapan Minim / Bukan Pendaki' ? 'selected' : '' }}>Perlengkapan Minim / Tanpa Alat Gunung</option>
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="ciri_pakaian" class="block text-xs font-medium text-stone-700 mb-1">
                            Ciri Fisik & Pakaian Terakhir yang Dikenakan <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="ciri_pakaian" name="ciri_pakaian" value="{{ old('ciri_pakaian') }}" placeholder="Contoh: Jaket parasut merah, tas carrier biru 60L, celana kargo loreng..." class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-xs sm:text-sm bg-white focus:border-stone-900 outline-none transition">
                    </div>
                </div>
            </div>

            <div id="wadah-detail-lainnya" class="hidden space-y-3.5 pt-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label for="kategori_lainnya" class="block text-xs font-medium text-stone-700 mb-1">
                            Kategori Kejadian Lapangan <span class="text-rose-500">*</span>
                        </label>
                        <select id="kategori_lainnya" name="kategori_lainnya" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-xs sm:text-sm bg-white focus:border-stone-900 outline-none transition">
                            <option value="">-- Pilih Kategori Kejadian --</option>
                            <option value="Pembalakan Liar / Penebangan Ilegal" {{ old('kategori_lainnya') === 'Pembalakan Liar / Penebangan Ilegal' ? 'selected' : '' }}>Pembalakan Liar (Illegal Logging)</option>
                            <option value="Perburuan Liar / Pemasangan Jerat" {{ old('kategori_lainnya') === 'Perburuan Liar / Pemasangan Jerat' ? 'selected' : '' }}>Perburuan Liar / Jerat Satwa</option>
                            <option value="Tanah Longsor di Kawasan Hutan" {{ old('kategori_lainnya') === 'Tanah Longsor di Kawasan Hutan' ? 'selected' : '' }}>Tanah Longsor di Kawasan Hutan</option>
                            <option value="Pohon Tumbang Menutup Akses" {{ old('kategori_lainnya') === 'Pohon Tumbang Menutup Akses' ? 'selected' : '' }}>Pohon Tumbang Menutup Akses Hutan</option>
                            <option value="Perambahan / Penyerobotan Lahan" {{ old('kategori_lainnya') === 'Perambahan / Penyerobotan Lahan' ? 'selected' : '' }}>Perambahan / Penyerobotan Lahan Hutan</option>
                            <option value="Pencemaran Sungai / Sumber Air Hutan" {{ old('kategori_lainnya') === 'Pencemaran Sungai / Sumber Air Hutan' ? 'selected' : '' }}>Pencemaran Sungai / Sumber Air Hutan</option>
                            <option value="Kejadian Khusus Lainnya" {{ old('kategori_lainnya') === 'Kejadian Khusus Lainnya' ? 'selected' : '' }}>Kejadian Khusus Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label for="tingkat_urgensi" class="block text-xs font-medium text-stone-700 mb-1">
                            Tingkat Urgensi / Dampak <span class="text-rose-500">*</span>
                        </label>
                        <select id="tingkat_urgensi" name="tingkat_urgensi" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-xs sm:text-sm bg-white focus:border-stone-900 outline-none transition">
                            <option value="">-- Pilih Tingkat Urgensi --</option>
                            <option value="Sangat Mendesak (Mengancam Keselamatan)" {{ old('tingkat_urgensi') === 'Sangat Mendesak (Mengancam Keselamatan)' ? 'selected' : '' }}>Sangat Mendesak (Mengancam Keselamatan Warga)</option>
                            <option value="Mendesak (Akses Tertutup / Kerusakan Hutan)" {{ old('tingkat_urgensi') === 'Mendesak (Akses Tertutup / Kerusakan Hutan)' ? 'selected' : '' }}>Mendesak (Akses Tertutup / Kerusakan Berlanjut)</option>
                            <option value="Perlu Penyelidikan / Investigasi" {{ old('tingkat_urgensi') === 'Perlu Penyelidikan / Investigasi' ? 'selected' : '' }}>Perlu Investigasi / Pengecekan Petugas</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2.5">
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider">
                        2. Titik Lokasi Kejadian (Jawa Barat) <span class="text-rose-500">*</span>
                    </label>
                    <button type="button" onclick="ambilLokasiSaya()" class="inline-flex items-center justify-center px-3.5 py-1.5 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-800 text-xs font-semibold border border-stone-200 transition active:scale-95 cursor-pointer">
                        <i class="fa-solid fa-location-crosshairs mr-1.5 text-stone-600"></i>
                        <span>Deteksi Lokasi GPS Saya</span>
                    </button>
                </div>

                <div class="relative mb-2.5">
                    <div class="relative flex items-center">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-emerald-700 pointer-events-none">
                            <i class="fa-solid fa-tree text-xs"></i>
                        </span>
                        <input type="text" id="input-cari-hutan" placeholder="Cari kawasan hutan di peta (Contoh: Gn. Ciremai, Papandayan, Halimun...)" autocomplete="off" class="w-full pl-9 pr-10 py-2.5 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition bg-stone-50/50 focus:bg-white">
                        <button type="button" id="btn-bersihkan-hutan" onclick="bersihkanCariHutan()" class="hidden absolute inset-y-0 right-2 px-2.5 text-stone-400 hover:text-stone-700 cursor-pointer">
                            <i class="fa-solid fa-xmark text-xs"></i>
                        </button>
                    </div>
                    <div id="hasil-cari-hutan" class="hidden absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-xl border border-stone-200 max-h-56 overflow-y-auto z-40 divide-y divide-stone-100 text-xs"></div>
                </div>

                <div class="rounded-2xl border border-stone-200/90 overflow-hidden relative shadow-xs mb-2">
                    <div id="peta-lapor" class="w-full h-80 relative z-0"></div>
                    <div class="absolute top-2.5 right-2.5 z-20 bg-white/90 backdrop-blur px-2.5 py-1 rounded-lg border border-stone-200 text-[10px] text-stone-600 font-medium shadow-2xs">
                        Klik peta untuk menandai titik
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 text-[11px] text-stone-500 px-1">
                    <span id="label-status-lokasi" class="flex items-center">
                        <i class="fa-solid fa-map-pin mr-1.5 text-stone-400"></i>
                        Lokasi belum ditentukan. Silakan klik pada peta atau cari kawasan hutan.
                    </span>
                    <span class="font-mono text-stone-800 font-semibold bg-stone-100 px-2 py-0.5 rounded-md" id="label-koordinat-terpilih">-</span>
                </div>

                <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="id_kabupaten_kota" class="block text-xs font-bold text-stone-700 uppercase tracking-wider">
                        Kabupaten / Kota di Jawa Barat <span class="text-rose-500">*</span>
                    </label>
                </div>
                <select id="id_kabupaten_kota" name="id_kabupaten_kota" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition bg-white">
                    <option value="">-- Pilih Wilayah Kabupaten/Kota --</option>
                    @foreach($kabupatenKota as $kab)
                        <option value="{{ $kab->id }}" {{ old('id_kabupaten_kota') == $kab->id ? 'selected' : '' }}>{{ $kab->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="deskripsi" class="block text-xs font-bold text-stone-700 uppercase tracking-wider">
                        3. Deskripsi Kejadian <span class="text-rose-500">*</span>
                    </label>
                    <span id="char-count" class="text-[11px] text-stone-400">0 / 1000</span>
                </div>
                <textarea id="deskripsi" name="deskripsi" rows="3" required maxlength="1000" placeholder="Jelaskan perkiraan luasan lahan terbakar, arah angin, atau jumlah satwa yang terlihat..." class="w-full px-4 py-3 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition leading-relaxed">{{ old('deskripsi') }}</textarea>
            </div>

            <div>
                <label for="foto" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">
                    Lampiran Foto Lapangan (Opsional)
                </label>
                <div class="border-2 border-dashed border-stone-200 hover:border-stone-400 rounded-2xl p-4 text-center transition cursor-pointer relative bg-stone-50/50" onclick="document.getElementById('foto').click()">
                    <input type="file" id="foto" name="foto" accept="image/png,image/jpeg,image/jpg" class="hidden" onchange="previewFoto(this)">
                    <div class="flex flex-col items-center justify-center space-y-1.5" id="foto-placeholder">
                        <div class="w-9 h-9 rounded-xl bg-white border border-stone-200 flex items-center justify-center text-stone-600 shadow-2xs">
                            <i class="fa-solid fa-camera text-sm"></i>
                        </div>
                        <div class="text-xs font-semibold text-stone-800">
                            Pilih atau Ambil Foto dari Kamera
                        </div>
                        <div class="text-[11px] text-stone-400">
                            Format JPG / PNG, ukuran maksimal 5 MB
                        </div>
                    </div>
                    <div id="foto-preview-box" class="hidden flex items-center justify-center space-x-2 text-xs font-semibold text-stone-800">
                        <i class="fa-solid fa-image text-stone-600"></i>
                        <span id="foto-file-name" class="truncate max-w-xs"></span>
                        <button type="button" onclick="hapusFoto(event)" class="text-stone-400 hover:text-stone-700 ml-2">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-stone-100 space-y-3.5">
                <div>
                    <h3 class="text-xs font-bold text-stone-800 uppercase tracking-wider">Identitas Pelapor (Opsional)</h3>
                    <p class="text-[11px] text-stone-500 mt-0.5">
                        Boleh dikosongkan. Nomor HP Anda bersifat rahasia dan hanya digunakan untuk konfirmasi penanganan darurat.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label for="nama_pelapor" class="block text-xs font-medium text-stone-700 mb-1">Nama Lengkap / Panggilan</label>
                        <input type="text" id="nama_pelapor" name="nama_pelapor" value="{{ old('nama_pelapor') }}" placeholder="Contoh: Budi Santoso" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-xs sm:text-sm bg-white focus:border-stone-900 outline-none transition">
                    </div>

                    <div>
                        <label for="no_hp" class="block text-xs font-medium text-stone-700 mb-1">Nomor WhatsApp / HP</label>
                        <input type="tel" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 08123456789" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-xs sm:text-sm bg-white focus:border-stone-900 outline-none transition font-mono">
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" id="tombol-kirim" class="w-full py-3.5 px-6 bg-stone-900 hover:bg-stone-800 text-white font-bold rounded-2xl shadow-sm transition active:scale-[0.99] text-xs sm:text-sm flex items-center justify-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                    <span>Kirim Laporan Darurat Sekarang</span>
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
var layerKawasanGroup = null;
var daftarKawasanData = @json($daftarKawasan ?? []);

var daftarTipe = ['Kebakaran', 'Hewan Masuk Kampung', 'Orang Hilang', 'Lainnya'];
var mapId = {
    'Kebakaran': 'kebakaran',
    'Hewan Masuk Kampung': 'hewan',
    'Orang Hilang': 'hilang',
    'Lainnya': 'lainnya'
};

var daftarCentroidKab = [
    { id: 1, lat: -7.02, lng: 107.53 },
    { id: 2, lat: -6.84, lng: 107.50 },
    { id: 3, lat: -6.24, lng: 107.15 },
    { id: 4, lat: -6.55, lng: 106.80 },
    { id: 5, lat: -7.33, lng: 108.35 },
    { id: 6, lat: -6.82, lng: 107.14 },
    { id: 7, lat: -6.75, lng: 108.48 },
    { id: 8, lat: -7.22, lng: 107.90 },
    { id: 9, lat: -6.33, lng: 108.32 },
    { id: 10, lat: -6.30, lng: 107.30 },
    { id: 11, lat: -6.98, lng: 108.48 },
    { id: 12, lat: -6.83, lng: 108.23 },
    { id: 13, lat: -7.68, lng: 108.65 },
    { id: 14, lat: -6.55, lng: 107.44 },
    { id: 15, lat: -6.57, lng: 107.76 },
    { id: 16, lat: -7.00, lng: 106.70 },
    { id: 17, lat: -6.85, lng: 107.92 },
    { id: 18, lat: -7.35, lng: 108.11 },
    { id: 19, lat: -6.9175, lng: 107.6191 },
    { id: 20, lat: -7.37, lng: 108.53 },
    { id: 21, lat: -6.2383, lng: 106.9756 },
    { id: 22, lat: -6.5971, lng: 106.8060 },
    { id: 23, lat: -6.8722, lng: 107.5422 },
    { id: 24, lat: -6.7320, lng: 108.5523 },
    { id: 25, lat: -6.4025, lng: 106.7942 },
    { id: 26, lat: -6.9277, lng: 106.9300 },
    { id: 27, lat: -7.3274, lng: 108.2207 }
];

function pilihJenis(jenis) {
    daftarTipe.forEach(function (t) {
        var id = mapId[t];
        var radio = document.querySelector('input[value="' + t + '"]');
        var label = document.getElementById('label-jenis-' + id);
        var dotFill = document.getElementById('dot-fill-' + id);
        var dot = document.getElementById('dot-' + id);
        var iconBox = document.getElementById('icon-box-' + id);
        var wadah = document.getElementById('wadah-detail-' + id);

        if (t === jenis) {
            if (radio) radio.checked = true;
            if (label) {
                label.className = 'relative flex flex-col justify-between p-4 rounded-2xl border-2 border-stone-900 bg-stone-50/70 shadow-2xs cursor-pointer transition select-none min-h-[115px]';
            }
            if (iconBox) {
                iconBox.className = 'w-10 h-10 rounded-xl bg-stone-900 text-white flex items-center justify-center text-base shrink-0 transition';
            }
            if (dotFill) dotFill.classList.remove('hidden');
            if (dot) {
                dot.className = 'w-5 h-5 rounded-full border-2 border-stone-900 flex items-center justify-center shrink-0 mt-0.5';
            }
            if (wadah) {
                wadah.classList.remove('hidden');
                var fields = wadah.querySelectorAll('input, select');
                fields.forEach(function (f) {
                    f.required = true;
                });
            }
        } else {
            if (label) {
                label.className = 'relative flex flex-col justify-between p-4 rounded-2xl border-2 border-stone-200 hover:border-stone-300 bg-white cursor-pointer transition select-none min-h-[115px]';
            }
            if (iconBox) {
                iconBox.className = 'w-10 h-10 rounded-xl bg-stone-100 flex items-center justify-center text-stone-700 text-base border border-stone-200 shrink-0 transition';
            }
            if (dotFill) dotFill.classList.add('hidden');
            if (dot) {
                dot.className = 'w-5 h-5 rounded-full border-2 border-stone-300 flex items-center justify-center shrink-0 mt-0.5';
            }
            if (wadah) {
                wadah.classList.add('hidden');
                var fields = wadah.querySelectorAll('input, select');
                fields.forEach(function (f) {
                    f.required = false;
                });
            }
        }
    });

    if (markerLapor) {
        var warna = '#1c1917';
        markerLapor.setStyle({ color: warna, fillColor: warna });
    }
}

function otomatisPilihKabupaten(lat, lng) {
    if (!lat || !lng) return;
    var jarakMin = Infinity;
    var kabTerpilih = null;

    daftarCentroidKab.forEach(function (k) {
        var dLat = lat - k.lat;
        var dLng = lng - k.lng;
        var jarak = (dLat * dLat) + (dLng * dLng);
        if (jarak < jarakMin) {
            jarakMin = jarak;
            kabTerpilih = k.id;
        }
    });

    if (kabTerpilih) {
        var select = document.getElementById('id_kabupaten_kota');
        var badge = document.getElementById('badge-auto-kabupaten');
        select.value = kabTerpilih;
        if (badge) badge.classList.remove('hidden');
    }

    fetch('https://nominatim.openstreetmap.org/reverse?format=json&lat=' + lat + '&lon=' + lng + '&zoom=10')
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (!data || !data.address) return;
            var addr = data.address;
            var wilayah = addr.city || addr.county || addr.town || addr.municipality || '';
            if (wilayah) {
                var select = document.getElementById('id_kabupaten_kota');
                var cleanWilayah = wilayah.toLowerCase().replace(/kabupaten|kota/gi, '').trim();
                for (var i = 0; i < select.options.length; i++) {
                    var optText = select.options[i].text.toLowerCase();
                    if (cleanWilayah && optText.includes(cleanWilayah)) {
                        select.selectedIndex = i;
                        var badge = document.getElementById('badge-auto-kabupaten');
                        if (badge) badge.classList.remove('hidden');
                        break;
                    }
                }
            }
        })
        .catch(function () {});
}

function perbaruiTitikLokasi(lat, lng, lewatiAutoKabupaten) {
    var latInput = document.getElementById('latitude');
    var longInput = document.getElementById('longitude');
    var labelStatus = document.getElementById('label-status-lokasi');
    var labelKoordinat = document.getElementById('label-koordinat-terpilih');

    latInput.value = parseFloat(lat).toFixed(7);
    longInput.value = parseFloat(lng).toFixed(7);

    var warna = '#1c1917';

    if (markerLapor) {
        markerLapor.setLatLng([lat, lng]);
        markerLapor.setStyle({ color: warna, fillColor: warna });
    } else {
        markerLapor = L.circleMarker([lat, lng], {
            radius: 8,
            color: warna,
            fillColor: warna,
            fillOpacity: 0.9,
            weight: 2
        }).addTo(mapLapor);
    }

    labelStatus.innerHTML = '<i class="fa-solid fa-circle-check text-stone-700 mr-1.5"></i> Titik lokasi berhasil ditandai';
    labelKoordinat.innerText = parseFloat(lat).toFixed(5) + ', ' + parseFloat(lng).toFixed(5);

    if (!lewatiAutoKabupaten) {
        otomatisPilihKabupaten(lat, lng);
    }
}

function ambilLokasiSaya() {
    var labelStatus = document.getElementById('label-status-lokasi');
    if (!navigator.geolocation) {
        alert('Browser Anda tidak mendukung deteksi lokasi otomatis.');
        return;
    }

    labelStatus.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-stone-600 mr-1.5"></i> Mencari sinyal GPS perangkat...';

    navigator.geolocation.getCurrentPosition(function (posisi) {
        var lat = posisi.coords.latitude;
        var lng = posisi.coords.longitude;
        mapLapor.setView([lat, lng], 14);
        perbaruiTitikLokasi(lat, lng);
    }, function (err) {
        alert('Tidak dapat mendeteksi lokasi GPS otomatis. Silakan klik langsung titik kejadian pada peta.');
        labelStatus.innerHTML = '<i class="fa-solid fa-circle-xmark text-stone-500 mr-1.5"></i> Gagal mendeteksi GPS. Silakan klik pada peta.';
    }, {
        enableHighAccuracy: true,
        timeout: 10000
    });
}

function cariKawasanHutan(kataKunci) {
    var hasilBox = document.getElementById('hasil-cari-hutan');
    var btnBersihkan = document.getElementById('btn-bersihkan-hutan');
    var kw = (kataKunci || '').trim().toLowerCase();

    if (!kw) {
        hasilBox.classList.add('hidden');
        hasilBox.innerHTML = '';
        btnBersihkan.classList.add('hidden');
        return;
    }

    btnBersihkan.classList.remove('hidden');

    var filterHasil = daftarKawasanData.filter(function (k) {
        var namaCocok = k.nama && k.nama.toLowerCase().includes(kw);
        var katCocok = k.kategori && k.kategori.toLowerCase().includes(kw);
        var kabCocok = false;
        if (k.kabupaten_kota && Array.isArray(k.kabupaten_kota)) {
            kabCocok = k.kabupaten_kota.some(function (kab) {
                return kab.nama && kab.nama.toLowerCase().includes(kw);
            });
        }
        return namaCocok || katCocok || kabCocok;
    });

    if (filterHasil.length === 0) {
        hasilBox.innerHTML = '<div class="px-4 py-3 text-xs text-stone-400 text-center">Kawasan hutan tidak ditemukan</div>';
        hasilBox.classList.remove('hidden');
        return;
    }

    var html = '';
    filterHasil.slice(0, 8).forEach(function (hutan) {
        var kabNama = (hutan.kabupaten_kota && hutan.kabupaten_kota.length > 0)
            ? hutan.kabupaten_kota.map(function(k){ return k.nama; }).join(', ')
            : 'Jawa Barat';

        html += '<button type="button" onclick="pilihKawasanHutan(' + hutan.id + ')" class="w-full text-left px-4 py-3 hover:bg-stone-50 flex items-center justify-between transition cursor-pointer">' +
            '<div>' +
                '<div class="text-xs sm:text-sm font-bold text-stone-900">' + hutan.nama + '</div>' +
                '<div class="text-[11px] text-stone-500 flex items-center space-x-2 mt-0.5">' +
                    '<span class="text-emerald-700 font-medium">' + (hutan.kategori || 'Kawasan Hutan') + '</span>' +
                    '<span>&bull;</span>' +
                    '<span>' + kabNama + '</span>' +
                '</div>' +
            '</div>' +
            '<i class="fa-solid fa-arrow-right text-stone-300 text-xs shrink-0 ml-3"></i>' +
        '</button>';
    });

    hasilBox.innerHTML = html;
    hasilBox.classList.remove('hidden');
}

function pilihKawasanHutan(idHutan) {
    var hutan = daftarKawasanData.find(function (k) { return k.id === idHutan; });
    if (!hutan) return;

    var input = document.getElementById('input-cari-hutan');
    var hasilBox = document.getElementById('hasil-cari-hutan');
    var btnBersihkan = document.getElementById('btn-bersihkan-hutan');

    input.value = hutan.nama;
    hasilBox.classList.add('hidden');
    btnBersihkan.classList.remove('hidden');

    var lat = parseFloat(hutan.lat_pusat);
    var lng = parseFloat(hutan.long_pusat);

    if (lat && lng) {
        mapLapor.flyTo([lat, lng], 13, { duration: 1 });
        perbaruiTitikLokasi(lat, lng, true);
    }

    if (hutan.kabupaten_kota && hutan.kabupaten_kota.length > 0) {
        var idKab = hutan.kabupaten_kota[0].id;
        var select = document.getElementById('id_kabupaten_kota');
        var badge = document.getElementById('badge-auto-kabupaten');
        select.value = idKab;
        if (badge) badge.classList.remove('hidden');
    } else if (lat && lng) {
        otomatisPilihKabupaten(lat, lng);
    }
}

function bersihkanCariHutan() {
    var input = document.getElementById('input-cari-hutan');
    var hasilBox = document.getElementById('hasil-cari-hutan');
    var btnBersihkan = document.getElementById('btn-bersihkan-hutan');

    input.value = '';
    hasilBox.innerHTML = '';
    hasilBox.classList.add('hidden');
    btnBersihkan.classList.add('hidden');
    input.focus();
}

function previewFoto(input) {
    var placeholder = document.getElementById('foto-placeholder');
    var previewBox = document.getElementById('foto-preview-box');
    var fileNameSpan = document.getElementById('foto-file-name');

    if (input.files && input.files[0]) {
        placeholder.classList.add('hidden');
        previewBox.classList.remove('hidden');
        fileNameSpan.innerText = input.files[0].name;
    }
}

function hapusFoto(e) {
    e.stopPropagation();
    var input = document.getElementById('foto');
    input.value = '';
    document.getElementById('foto-placeholder').classList.remove('hidden');
    document.getElementById('foto-preview-box').classList.add('hidden');
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
    pesan.innerHTML = '<strong>Tidak ada koneksi internet.</strong> Laporan berhasil disimpan di perangkat HP Anda dan akan dikirim otomatis saat sinyal kembali normal.';
    notif.classList.remove('hidden');
    window.scrollTo({ top: 0, behavior: 'smooth' });

    document.getElementById('form-lapor').reset();
    if (markerLapor) {
        mapLapor.removeLayer(markerLapor);
        markerLapor = null;
    }
    document.getElementById('latitude').value = '';
    document.getElementById('longitude').value = '';
    document.getElementById('label-status-lokasi').innerHTML = '<i class="fa-solid fa-map-pin mr-1.5 text-stone-400"></i> Lokasi belum ditentukan. Silakan klik pada peta atau cari kawasan hutan.';
    document.getElementById('label-koordinat-terpilih').innerText = '-';
    hapusFoto(new Event('click'));
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
            pesan.innerHTML = '<strong>Laporan berhasil tersinkron!</strong> Laporan tertunda Anda telah diterima server dengan kode: <strong>' + hasil.kode + '</strong>.';
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

    var inputCariHutan = document.getElementById('input-cari-hutan');
    if (inputCariHutan) {
        inputCariHutan.addEventListener('input', function () {
            cariKawasanHutan(this.value);
        });
        document.addEventListener('click', function (e) {
            var hasilBox = document.getElementById('hasil-cari-hutan');
            if (hasilBox && !inputCariHutan.contains(e.target) && !hasilBox.contains(e.target)) {
                hasilBox.classList.add('hidden');
            }
        });
    }

    var descInput = document.getElementById('deskripsi');
    var charCount = document.getElementById('char-count');
    if (descInput && charCount) {
        charCount.innerText = descInput.value.length + ' / 1000';
        descInput.addEventListener('input', function () {
            charCount.innerText = this.value.length + ' / 1000';
        });
    }

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
        attribution: '&copy; OpenStreetMap'
    }).addTo(mapLapor);

    layerKawasanGroup = L.featureGroup().addTo(mapLapor);

    daftarKawasanData.forEach(function (hutan) {
        if (hutan.geojson) {
            try {
                var geoData = typeof hutan.geojson === 'string' ? JSON.parse(hutan.geojson) : hutan.geojson;
                var layer = L.geoJSON(geoData, {
                    style: {
                        color: '#15803d',
                        weight: 1.5,
                        fillColor: '#22c55e',
                        fillOpacity: 0.18
                    }
                });

                layer.on('click', function (e) {
                    L.DomEvent.stopPropagation(e);
                    perbaruiTitikLokasi(e.latlng.lat, e.latlng.lng, true);
                    if (hutan.kabupaten_kota && hutan.kabupaten_kota.length > 0) {
                        var select = document.getElementById('id_kabupaten_kota');
                        var badge = document.getElementById('badge-auto-kabupaten');
                        select.value = hutan.kabupaten_kota[0].id;
                        if (badge) badge.classList.remove('hidden');
                    } else {
                        otomatisPilihKabupaten(e.latlng.lat, e.latlng.lng);
                    }
                    var inputHutan = document.getElementById('input-cari-hutan');
                    if (inputHutan) inputHutan.value = hutan.nama;
                });

                layer.bindTooltip(hutan.nama, { sticky: true, className: 'text-[11px] font-sans' });
                layerKawasanGroup.addLayer(layer);
            } catch (err) {}
        }
    });

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
        var kab = document.getElementById('id_kabupaten_kota').value;

        if (!lat || !lng) {
            e.preventDefault();
            alert('Silakan tentukan titik lokasi kejadian pada peta terlebih dahulu.');
            return;
        }

        if (!kab) {
            e.preventDefault();
            alert('Silakan pilih wilayah Kabupaten / Kota terlebih dahulu.');
            document.getElementById('id_kabupaten_kota').focus();
            return;
        }

        if (!navigator.onLine) {
            e.preventDefault();

            var fotoInput = document.getElementById('foto');
            if (fotoInput.files && fotoInput.files.length > 0) {
                alert('Peringatan: Foto tidak dapat dikirim dalam kondisi offline. Data laporan dan koordinat akan tetap tersimpan.');
            }

            var jenisRadio = document.querySelector('input[name="jenis"]:checked');
            var jenisNilai = jenisRadio ? jenisRadio.value : 'Kebakaran';
            var dataLapor = {
                jenis: jenisNilai,
                latitude: lat,
                longitude: lng,
                id_kabupaten_kota: document.getElementById('id_kabupaten_kota').value,
                deskripsi: document.getElementById('deskripsi').value,
                nama_pelapor: document.getElementById('nama_pelapor').value,
                no_hp: document.getElementById('no_hp').value,
                dibuat: new Date().toISOString()
            };

            if (jenisNilai === 'Kebakaran') {
                dataLapor.tipe_vegetasi = document.getElementById('tipe_vegetasi').value;
                dataLapor.perkiraan_luas = document.getElementById('perkiraan_luas').value;
                dataLapor.kondisi_api = document.getElementById('kondisi_api').value;
                dataLapor.arah_angin = document.getElementById('arah_angin').value;
                dataLapor.potensi_bahaya = document.getElementById('potensi_bahaya').value;
            } else if (jenisNilai === 'Hewan Masuk Kampung') {
                dataLapor.jenis_hewan = document.getElementById('jenis_hewan').value;
                dataLapor.jumlah_satwa = document.getElementById('jumlah_satwa').value;
                dataLapor.aktivitas_satwa = document.getElementById('aktivitas_satwa').value;
                dataLapor.posisi_satwa = document.getElementById('posisi_satwa').value;
            } else if (jenisNilai === 'Orang Hilang') {
                dataLapor.nama_korban = document.getElementById('nama_korban').value;
                dataLapor.usia_korban = document.getElementById('usia_korban').value;
                dataLapor.gender_korban = document.getElementById('gender_korban').value;
                dataLapor.jumlah_korban = document.getElementById('jumlah_korban').value;
                dataLapor.kontak_terakhir = document.getElementById('kontak_terakhir').value;
                dataLapor.jalur_pendakian = document.getElementById('jalur_pendakian').value;
                dataLapor.ciri_pakaian = document.getElementById('ciri_pakaian').value;
                dataLapor.kondisi_bekal = document.getElementById('kondisi_bekal').value;
            } else if (jenisNilai === 'Lainnya') {
                dataLapor.kategori_lainnya = document.getElementById('kategori_lainnya').value;
                dataLapor.tingkat_urgensi = document.getElementById('tingkat_urgensi').value;
            }

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
