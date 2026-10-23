@extends('layouts.publik')

@section('title', 'Beranda')

@section('content')
<main id="public-main" class="w-full">

    <!-- 1. BERANDA -->
    <section id="view-beranda" class="view fade">
        <div class="hero-section">
            <div class="hero-overlay"></div>
            <div class="relative z-10 w-full max-w-7xl mx-auto px-6 pt-24 pb-16 md:pb-20">
                <div class="max-w-2xl text-white">
                    <span class="bg-emerald-600 text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest mb-6 inline-block shadow-lg">
                        Provinsi Jawa Barat
                    </span>
                    <h1 class="font-serif-elegant text-4xl sm:text-5xl md:text-6xl font-bold leading-tight mb-6" style="text-shadow:0 2px 12px rgba(0,0,0,.45)">
                        {{ $pengaturan->slogan ?? 'Menjaga Ruang Hidup Bersama' }}
                    </h1>
                    <p class="text-lg md:text-xl text-gray-100 mb-10 leading-relaxed" style="text-shadow:0 1px 8px rgba(0,0,0,.5)">
                        {{ $pengaturan->deskripsi_singkat ?? 'Sistem informasi terpadu untuk memantau kawasan hutan, mengenali keanekaragaman hayati, dan melaporkan insiden secara langsung.' }}
                    </p>
                    <div class="flex flex-wrap gap-4 mb-4">
                        <button onclick="bukaView('peta')" class="bg-white text-emerald-800 px-8 py-4 rounded-full font-bold hover:bg-gray-100 transition-all shadow-xl">
                            Jelajahi Peta <i class="fa-solid fa-map-location-dot ml-2"></i>
                        </button>
                        <button onclick="bukaView('lapor')" class="bg-emerald-600/80 backdrop-blur text-white border border-emerald-400 px-8 py-4 rounded-full font-bold hover:bg-emerald-600 transition-all">
                            Pusat Bantuan
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white pt-20 md:pt-24 pb-12">
            <!-- ABOUT US SECTION -->
            <div class="max-w-7xl mx-auto px-6 mb-24">
                <div class="flex flex-col md:flex-row gap-0 items-stretch bg-emerald-900 rounded-3xl overflow-hidden shadow-2xl">
                    <div class="md:w-1/2 p-10 md:p-14 text-white flex flex-col justify-center">
                        <span class="text-emerald-400 font-bold text-xs uppercase tracking-widest mb-2 block">Tentang Kami</span>
                        <h2 class="font-serif-elegant text-3xl md:text-4xl font-bold mb-6">Bersama Melindungi Paru-Paru Jawa Barat</h2>
                        <p class="text-emerald-100 mb-4 leading-relaxed">
                            {{ $pengaturan->nama_aplikasi ?? 'Jaga Hutan Desa' }} adalah inisiatif pelestarian lingkungan yang berfokus pada pengawasan kawasan hutan, perlindungan satwa endemik, dan penanganan insiden darurat melalui partisipasi aktif masyarakat dan keterbukaan data.
                        </p>
                        <p class="text-emerald-100 leading-relaxed mb-8">
                            Kami percaya bahwa hutan yang lestari adalah warisan paling berharga untuk kelangsungan ekosistem, cadangan air, dan masa depan generasi mendatang di Tanah Pasundan.
                        </p>
                        <div>
                            <button onclick="bukaView('info')" class="bg-[#f3c677] text-gray-900 px-6 py-3 rounded-full font-bold hover:bg-[#ffd98f] transition shadow-lg">
                                Pelajari Info &amp; Panduan
                            </button>
                        </div>
                    </div>
                    <div class="md:w-1/2 min-h-[350px] bg-cover bg-center" style="background-image: url('{{ asset('assets/pemandangan2.jpg') }}');"></div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="font-serif-elegant text-4xl text-gray-900 font-bold mb-4">Kekayaan Hayati &amp; Kawasan</h2>
                    <p class="text-gray-500 max-w-2xl mx-auto">Kompilasi data pemantauan ekosistem flora, fauna, dan kawasan konservasi di wilayah Jawa Barat.</p>
                </div>
                
                <!-- STATS COUNTERS -->
                <div class="grid md:grid-cols-3 gap-8 mb-24">
                    <div class="card group p-8 text-center border-t-4 border-emerald-500 cursor-pointer hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 bg-gradient-to-br from-white to-gray-50" onclick="bukaView('peta')">
                        <div class="w-20 h-20 bg-emerald-50 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300 rounded-full flex items-center justify-center mx-auto mb-6 text-emerald-600 shadow-sm">
                            <i class="fa-solid fa-tree text-3xl"></i>
                        </div>
                        <h3 class="text-5xl font-black text-gray-900 mb-3">{{ $totalKawasan }}</h3>
                        <p class="font-bold text-gray-500 group-hover:text-emerald-700 transition-colors uppercase tracking-widest text-sm">Kawasan Hutan</p>
                    </div>
                    <div class="card group p-8 text-center border-t-4 border-emerald-500 cursor-pointer hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 bg-gradient-to-br from-white to-gray-50" onclick="bukaView('fauna')">
                        <div class="w-20 h-20 bg-emerald-50 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300 rounded-full flex items-center justify-center mx-auto mb-6 text-emerald-600 shadow-sm">
                            <i class="fa-solid fa-paw text-3xl"></i>
                        </div>
                        <h3 id="hitung-fauna" class="text-5xl font-black text-gray-900 mb-3">{{ $totalPrimata }}</h3>
                        <p class="font-bold text-gray-500 group-hover:text-emerald-700 transition-colors uppercase tracking-widest text-sm">Fauna Utama</p>
                    </div>
                    <div class="card group p-8 text-center border-t-4 border-emerald-500 cursor-pointer hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 bg-gradient-to-br from-white to-gray-50" onclick="bukaView('flora')">
                        <div class="w-20 h-20 bg-emerald-50 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300 rounded-full flex items-center justify-center mx-auto mb-6 text-emerald-600 shadow-sm">
                            <i class="fa-solid fa-seedling text-3xl"></i>
                        </div>
                        <h3 id="hitung-flora" class="text-5xl font-black text-gray-900 mb-3">{{ $totalTumbuhan }}</h3>
                        <p class="font-bold text-gray-500 group-hover:text-emerald-700 transition-colors uppercase tracking-widest text-sm">Flora Terdata</p>
                    </div>
                </div>
                
                <div class="flex items-end justify-between mb-8 border-b border-gray-200 pb-4">
                    <div>
                        <h2 class="font-serif-elegant text-3xl text-gray-900 font-bold">Kabar Area Terbaru</h2>
                        <p class="text-gray-500 text-sm mt-1">Edukasi, panduan, dan pengumuman seputar kawasan hutan.</p>
                    </div>
                    <button onclick="bukaView('info')" class="text-emerald-600 font-bold hover:underline shrink-0 ml-4">Lihat Semua &rarr;</button>
                </div>
                <div id="berita-beranda" class="grid md:grid-cols-3 gap-8"></div>
            </div>
        </div>
    </section>

    <!-- 2. PETA KAWASAN -->
    <section id="view-peta" class="view fade w-full py-24 bg-white" hidden>
        <div class="max-w-7xl mx-auto px-6 pt-8">
            <div class="mb-6">
                <h1 class="font-serif-elegant text-4xl text-gray-900 font-bold">Peta Kawasan Hutan</h1>
                <p class="text-gray-500 mt-2">Mode Satelit Interaktif: pantau batas kawasan konservasi, pos pengamanan, dan titik sebaran laporan insiden.</p>
            </div>
            <div id="banner-simulasi" hidden class="mb-6 bg-amber-50 border border-amber-300 text-amber-900 rounded-xl p-4 text-sm flex gap-3 items-start">
                <i class="fa-solid fa-triangle-exclamation mt-0.5"></i>
                <p><b>Informasi Insiden:</b> Titik insiden di bawah bersumber dari laporan masyarakat yang terverifikasi dan simulasi pengawasan lapangan. Untuk kondisi darurat mendesak, hubungi 112 / 113.</p>
            </div>
            <div class="grid lg:grid-cols-[300px_1fr] gap-8">
                <aside class="card card-static p-6 shadow-lg border-gray-100 space-y-6">
                    <div>
                        <h2 class="font-bold mb-3 text-gray-900">Pilih Kawasan</h2>
                        <select id="pilih-kawasan-hutan" class="field text-sm" onchange="fokusPeta(this.value)">
                            <option value="">-- Semua Provinsi Jabar --</option>
                            @foreach ($daftarKawasan as $idx => $kws)
                                <option value="{{ $idx }}">{{ $kws->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <h2 class="font-bold mb-3 text-gray-900">Filter Insiden</h2>
                        <select id="filter-insiden" class="field text-sm" onchange="renderInsiden()">
                            <option value="">Semua Insiden</option>
                            <option value="Kebakaran">Hanya Laporan Kebakaran</option>
                            <option value="Hewan Masuk Kampung">Hanya Konflik Satwa</option>
                            <option value="Orang Hilang">Hanya Orang Hilang</option>
                            <option value="Lainnya">Laporan Lainnya</option>
                        </select>
                    </div>
                    @if (isset($daftarPrediksiPublik) && $daftarPrediksiPublik->isNotEmpty())
                    <div class="bg-red-50 border-2 border-red-300 text-red-900 rounded-xl p-3.5 text-xs space-y-2 shadow-sm">
                        <div class="flex items-center justify-between font-bold text-red-700">
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-fire text-sm animate-pulse"></i> Pantauan Titik Api Aktif</span>
                            <span class="bg-red-200 text-red-800 text-[10px] px-2 py-0.5 rounded-full font-black">{{ $daftarPrediksiPublik->count() }} Titik</span>
                        </div>
                        <p class="text-[11px] text-red-800 leading-tight">Simulasi perambatan kebakaran hutan aktif dipantau oleh Satgas Kehutanan Jawa Barat.</p>
                        @foreach ($daftarPrediksiPublik as $pred)
                        <button type="button" onclick="fokusPrediksi({{ $pred->latitude }}, {{ $pred->longitude }}, {{ $pred->id }})" class="w-full text-left bg-white p-2 rounded-lg border border-red-200 hover:bg-red-100 transition flex items-center justify-between shadow-2xs">
                            <div>
                                <div class="font-bold text-gray-900 text-xs">Titik Pantau #{{ $pred->id }}</div>
                                <div class="text-[10px] text-gray-500">Angin: {{ $pred->kecepatan_angin ?? 0 }} km/j &bull; Est. 6j: {{ $pred->luas_6jam ?? '-' }} ha</div>
                            </div>
                            <span class="text-xs text-red-600 font-bold flex items-center gap-1">Fokus <i class="fa-solid fa-crosshairs"></i></span>
                        </button>
                        @endforeach
                    </div>
                    @endif

                    <div>
                        <h2 class="font-bold mb-3 text-gray-900">Ringkasan Laporan</h2>
                        <div id="ringkasan-status" class="space-y-2 text-sm text-gray-600"></div>
                    </div>
                    <div>
                        <h2 class="font-bold mb-3 text-gray-900">Lapisan Peta</h2>
                        <div class="space-y-3 text-sm text-gray-600">
                            <label class="flex gap-3 items-center cursor-pointer">
                                <input type="checkbox" checked onchange="toggleLapisan('kawasan', this.checked)" class="accent-emerald-600 w-4 h-4"> Kawasan Hutan
                            </label>
                            <label class="flex gap-3 items-center cursor-pointer">
                                <input type="checkbox" checked onchange="toggleLapisan('titik', this.checked)" class="accent-emerald-600 w-4 h-4"> Pos Jaga &amp; Bantuan
                            </label>
                            <label class="flex gap-3 items-center cursor-pointer">
                                <input type="checkbox" checked onchange="toggleLapisan('laporan', this.checked)" class="accent-emerald-600 w-4 h-4"> Laporan Insiden
                            </label>
                            <label class="flex gap-3 items-center cursor-pointer">
                                <input type="checkbox" checked onchange="toggleLapisan('prediksi', this.checked)" class="accent-red-600 w-4 h-4"> Prediksi Perambatan Api
                            </label>
                        </div>
                    </div>
                    <div>
                        <h2 class="font-bold mb-3 text-gray-900">Legenda</h2>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-center gap-3">
                                <span class="marker-insiden shrink-0" style="background:#dc2626;box-shadow:0 0 8px #ef4444;width:24px;height:24px;font-size:11px"><i class="fa-solid fa-fire text-amber-300"></i></span> Titik pantau api &amp; rambatan
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="marker-insiden shrink-0" style="background:#dc2626;width:24px;height:24px;font-size:11px"><i class="fa-solid fa-fire"></i></span> Laporan kebakaran
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="marker-insiden shrink-0" style="background:#f97316;width:24px;height:24px;font-size:11px"><i class="fa-solid fa-paw"></i></span> Konflik satwa
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="marker-insiden shrink-0" style="background:#3b82f6;width:24px;height:24px;font-size:11px"><i class="fa-solid fa-person-circle-question"></i></span> Orang hilang
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="shrink-0 rounded-full border-2 border-white shadow" style="background:#10b981;width:20px;height:20px;margin:0 2px"></span> Pos jaga / bantuan
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="shrink-0 rounded-full border-2 border-white shadow" style="background:#eab308;width:20px;height:20px;margin:0 2px"></span> Titik permukiman warga
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="shrink-0 rounded" style="background:rgba(34,197,94,.3);border:3px solid #22c55e;width:24px;height:16px"></span> Batas kawasan hutan
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="marker-insiden selesai shrink-0" style="background:#6b7280;width:24px;height:24px;font-size:11px"><i class="fa-solid fa-check"></i></span> Pudar = status Selesai
                            </li>
                        </ul>
                    </div>

                    @if (isset($daftarJadwalPatroli) && $daftarJadwalPatroli->isNotEmpty())
                    <div class="border-t border-gray-100 pt-5">
                        <div class="flex items-center justify-between mb-3">
                            <h2 class="font-bold text-gray-900 flex items-center gap-2 text-sm">
                                <i class="fa-solid fa-person-hiking text-emerald-600"></i>
                                <span>Jadwal Patroli Satgas</span>
                            </h2>
                            <span class="text-[10px] bg-emerald-100 text-emerald-800 font-bold px-2 py-0.5 rounded-full">Aktif</span>
                        </div>
                        <div class="space-y-2.5 max-h-56 overflow-y-auto pr-1">
                            @foreach ($daftarJadwalPatroli as $jdw)
                            <div class="bg-gray-50 hover:bg-emerald-50/50 p-2.5 rounded-xl border border-gray-100 text-xs transition">
                                <div class="font-bold text-gray-800 line-clamp-1">{{ $jdw->judul }}</div>
                                <div class="text-[11px] text-emerald-700 font-semibold mt-0.5 flex items-center gap-1.5">
                                    <i class="fa-regular fa-calendar-check text-[10px]"></i>
                                    <span>{{ \Carbon\Carbon::parse($jdw->tanggal)->isoFormat('dddd, D MMMM Y') }}</span>
                                </div>
                                <div class="text-[10px] text-gray-500 mt-0.5 flex items-center gap-1.5">
                                    <i class="fa-regular fa-clock text-[9px]"></i>
                                    <span>{{ $jdw->jam }} &bull; {{ $jdw->lokasi }}</span>
                                </div>
                                @if ($jdw->keterangan)
                                <p class="text-[10px] text-gray-600 mt-1.5 bg-white p-1.5 rounded border border-gray-100 line-clamp-2">{{ $jdw->keterangan }}</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </aside>
                <div class="space-y-6">
                    <div class="card card-static p-2 shadow-lg border-gray-100">
                        <div id="map-hutan" class="map" role="application"></div>
                    </div>

                    @if (isset($daftarPrediksiPublik) && $daftarPrediksiPublik->isNotEmpty())
                    @php
                        $prediksiUtama = $daftarPrediksiPublik->first();
                    @endphp
                    <div id="panel-simulasi-api" class="bg-gradient-to-br from-white to-red-50/50 rounded-2xl p-6 shadow-lg border-2 border-red-200 space-y-5">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-red-100 pb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-red-600 text-white flex items-center justify-center text-lg shadow-md shrink-0">
                                    <i class="fa-solid fa-fire-flame-curved animate-pulse"></i>
                                </div>
                                <div>
                                    <h3 class="text-base font-extrabold text-gray-900 leading-tight">Simulasi Perambatan Api (Wildfire Spread Simulator)</h3>
                                    <p id="subteks-model-angin" class="text-xs text-gray-500 mt-0.5">Model elips Huygens berbasis dorongan angin {{ $prediksiUtama->arah_angin ?? 240 }}° &bull; Kecepatan {{ $prediksiUtama->kecepatan_angin ?? 14 }} km/j</p>
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center gap-2 shrink-0">
                                @if ($daftarPrediksiPublik->count() > 1)
                                <div class="flex items-center gap-1.5 bg-red-50/80 px-2 py-1 rounded-xl border border-red-200">
                                    <label for="select-titik-simulasi" class="text-xs font-bold text-red-800">Titik:</label>
                                    <select id="select-titik-simulasi" onchange="gantiTitikSimulasi(this.value)" class="bg-white border border-red-300 rounded-lg text-xs font-bold text-red-700 px-2 py-1 focus:outline-none">
                                        @foreach ($daftarPrediksiPublik as $pItem)
                                        <option value="{{ $pItem->id }}">Titik #{{ $pItem->id }} ({{ $pItem->luas_6jam ?? '-' }} Ha)</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <button type="button" id="btn-play-simulasi" onclick="toggleSimulasi()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs font-bold transition-all shadow-md flex items-center gap-2 cursor-pointer">
                                    <i id="icon-play-simulasi" class="fa-solid fa-play"></i>
                                    <span id="label-play-simulasi">Mulai Simulasi</span>
                                </button>
                                <button type="button" onclick="resetSimulasi()" class="px-3 py-2 bg-white hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-xl text-xs font-bold transition shadow-xs flex items-center gap-1.5 cursor-pointer">
                                    <i class="fa-solid fa-rotate-left"></i>
                                    <span>Reset</span>
                                </button>
                                <button type="button" onclick="fokusPrediksi(pusatApiLat, pusatApiLng)" class="px-3 py-2 bg-white hover:bg-red-50 text-red-600 border border-red-200 rounded-xl text-xs font-bold transition shadow-xs flex items-center gap-1.5 cursor-pointer">
                                    <i class="fa-solid fa-crosshairs"></i>
                                    <span>Fokus</span>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex flex-wrap justify-between items-center text-xs font-bold text-gray-700 gap-2">
                                <span id="teks-waktu-simulasi" class="text-gray-900 font-extrabold">Waktu Simulasi: +0.0 Jam (0 Menit)</span>
                                <div class="flex items-center gap-2">
                                    <span id="teks-titik-aktif" class="px-2.5 py-0.5 rounded-full bg-red-100 text-red-700 font-extrabold text-[11px] border border-red-200">1 Titik Api Aktif</span>
                                    <span id="teks-jarak-simulasi" class="text-red-600 font-extrabold">Perkiraan Menjalar: 0 m</span>
                                </div>
                            </div>
                            <input type="range" id="slider-waktu" min="0" max="6" step="0.05" value="0" oninput="ubahWaktuSimulasi(parseFloat(this.value))" class="w-full accent-red-600 cursor-pointer h-2.5 bg-gray-200 rounded-lg">
                            <div class="flex justify-between text-[11px] font-bold text-gray-500 px-1">
                                <span>0 Jam (Titik Mula)</span>
                                <span class="text-red-600">1 Jam (Inti Merah)</span>
                                <span class="text-orange-600">3 Jam (Radius Oranye)</span>
                                <span class="text-amber-600">6 Jam (Perimeter Kuning)</span>
                            </div>
                        </div>

                        <div id="kotak-status-simulasi" class="p-4 rounded-xl bg-white border border-gray-200 flex items-start gap-3 shadow-sm transition-all duration-300">
                            <div id="ikon-status-simulasi" class="w-9 h-9 rounded-lg bg-red-50 text-red-600 flex items-center justify-center shrink-0 text-base mt-0.5">
                                <i class="fa-solid fa-fire animate-pulse"></i>
                            </div>
                            <div class="text-xs">
                                <div id="judul-status-simulasi" class="font-bold text-gray-900 mb-0.5 text-sm">Kondisi Awal Titik Api Terdeteksi</div>
                                <div id="pesan-status-simulasi" class="text-gray-600 leading-relaxed">Titik api teridentifikasi pada kawasan vegetasi hutan. Tekan tombol "Mulai Simulasi" atau geser slider waktu untuk memantau perambatan lidah api dan titik api baru ke arah pemukiman warga.</div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- 3. FLORA (DINAMIS DENGAN MODEL Tumbuhan & SEMUA FIELD ADMIN) -->
    <section id="view-flora" class="view fade showcase w-full min-h-screen text-white" hidden></section>

    <!-- 4. FAUNA (DINAMIS DENGAN MODEL Primata) -->
    <section id="view-fauna" class="view fade showcase w-full min-h-screen text-white" hidden></section>

    <!-- 5. PUSAT INFORMASI & KESELAMATAN -->
    <section id="view-info" class="view fade w-full py-24 bg-white" hidden>
        <div class="max-w-4xl mx-auto px-6 pt-8">
            <h1 class="font-serif-elegant text-4xl text-gray-900 font-bold mb-8 text-center">Pusat Informasi &amp; Keselamatan</h1>
            <div class="flex gap-2 bg-gray-100 p-1 rounded-lg mb-8">
                <button role="tab" id="tab-kabar" onclick="bukaTab('kabar')" class="flex-1 py-3 text-sm font-bold rounded-md bg-white shadow text-gray-900">
                    Kabar Area
                </button>
                <button role="tab" id="tab-tips" onclick="bukaTab('tips')" class="flex-1 py-3 text-sm font-bold rounded-md text-gray-500 hover:text-gray-900">
                    Tips Keselamatan
                </button>
            </div>
            <div id="panel-kabar">
                <div class="card card-static p-6 mb-8 shadow-md border-emerald-100 bg-emerald-50/40">
                    <h2 class="font-bold text-lg mb-2 text-gray-900">
                        <i class="fa-solid fa-bullhorn text-emerald-600 mr-2"></i>Pengumuman Terkini
                    </h2>
                    <p class="text-gray-600 leading-relaxed text-sm">
                        Jaga kawasan hutan Jawa Barat bersama. Perhatikan cuaca ekstrim selama musim kemarau untuk mencegah kebakaran lahan kering dan lindungi satwa endemik dari perburuan ilegal.
                    </p>
                </div>
                <div id="berita-daftar-wrap">
                    <input id="cari-berita" class="field mb-4" placeholder="Cari informasi..." oninput="renderDaftarBerita()">
                    <div id="chip-berita" class="flex gap-2 flex-wrap mb-6"></div>
                    <div id="berita-daftar" class="grid sm:grid-cols-2 gap-6"></div>
                </div>
                <div id="berita-detail" hidden></div>
            </div>
            <div id="panel-tips" class="card card-static p-8 shadow-lg border-gray-100 space-y-6" hidden>
                <h2 class="font-bold text-xl mb-4 text-gray-900">Panduan &amp; Prosedur Keamanan Hutan</h2>
                <div class="space-y-4 text-gray-600 text-sm leading-relaxed">
                    <div class="flex gap-3">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 font-bold flex items-center justify-center shrink-0">1</div>
                        <div>
                            <h3 class="font-bold text-gray-800">Dilarang Menyalakan Api Sembarangan</h3>
                            <p>Jangan pernah membuat api unggun di area rawan angin atau meninggalkannya tanpa dipadamkan hingga dingin tuntas. Puntung rokok wajib dipadamkan dan dibuang ke tempat sampah tertutup.</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 font-bold flex items-center justify-center shrink-0">2</div>
                        <div>
                            <h3 class="font-bold text-gray-800">Protokol Papasan Satwa Liar</h3>
                            <p>Bila bertemu satwa liar (macan, babi hutan, owa), jangan pernah membelakangi atau berlari secara tiba-tiba. Mundur perlahan dengan tenang dan jaga kontak mata tanpa menunjukkan agresi.</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 font-bold flex items-center justify-center shrink-0">3</div>
                        <div>
                            <h3 class="font-bold text-gray-800">Evakuasi Saat Terjadi Kebakaran</h3>
                            <p>Perhatikan arah angin dan hindari lembah yang dapat menjadi perangkap asap tebal. Segera hubungi saluran darurat terpadu 112 atau kirimkan koordinat GPS Anda melalui form Lapor Darurat situs ini.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- 6. CEK STATUS LAPORAN -->
    <section id="view-cek-status" class="view fade w-full py-24 bg-white" hidden>
        <div class="max-w-5xl mx-auto px-6 pt-8">
            <div class="mb-10 text-center">
                <h1 class="font-serif-elegant text-4xl text-gray-900 font-bold">Lacak Status Laporan</h1>
                <p class="text-gray-500 mt-2">Pantau perkembangan penanganan laporan darurat Anda menggunakan kode laporan resmi.</p>
            </div>
            <div class="card p-8 mb-10 shadow-md border-emerald-100 bg-emerald-50/30 max-w-3xl mx-auto">
                <h2 class="font-bold text-xl mb-4 text-gray-900">
                    <i class="fa-solid fa-magnifying-glass mr-2 text-emerald-600"></i> Masukkan Kode Laporan Anda
                </h2>
                <form id="cek-form" class="flex flex-col sm:flex-row gap-4" onsubmit="handleCekStatus(event)">
                    <input id="kode-input" class="field flex-1 font-bold tracking-widest uppercase bg-white" placeholder="KODE (CONTOH: JHD-AREZCX)">
                    <button type="submit" class="bg-gray-900 text-white px-8 py-3 rounded-lg font-bold hover:bg-gray-800 transition">
                        Cek Status
                    </button>
                </form>
                <div id="hasil-status" class="mt-4" role="status"></div>
                <div class="mt-6">
                    <h3 class="text-xs uppercase text-gray-400 font-bold mb-2">Riwayat Pencarian Anda:</h3>
                    <div id="riwayat-kode" class="flex gap-2 flex-wrap"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. LAPOR DARURAT -->
    <section id="view-lapor" class="view fade w-full py-24 bg-white" hidden>
        <div class="max-w-5xl mx-auto px-6 pt-8">
            <div class="mb-10 text-center">
                <h1 class="font-serif-elegant text-4xl text-gray-900 font-bold">Pusat Pengaduan Darurat</h1>
                <p class="text-gray-500 mt-2">Laporkan insiden dengan cepat untuk penanganan segera oleh Satgas Kehutanan.</p>
            </div>
            
            <div id="sukses" hidden class="card p-10 text-center mb-10 bg-emerald-50 border-emerald-200">
                <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fa-solid fa-check"></i>
                </div>
                <p class="font-bold text-emerald-800 text-xl">Laporan Berhasil Diterima oleh Satgas!</p>
                <p class="text-sm text-emerald-600 mt-1">Gunakan kode di bawah ini untuk memantau status penanganan laporan Anda:</p>
                <strong id="kode-besar" class="block text-4xl my-4 text-emerald-950 tracking-widest font-mono font-black"></strong>
                <button type="button" onclick="salinKode()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-full text-sm font-bold shadow-md transition inline-flex items-center gap-2">
                    <i class="fa-regular fa-copy"></i> Salin Kode Laporan
                </button>
            </div>
            
            <div id="kotak-notif-offline" class="hidden mb-6 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs sm:text-sm">
                <div class="flex items-start space-x-3">
                    <i class="fa-solid fa-circle-exclamation text-amber-600 mt-0.5 text-base shrink-0"></i>
                    <div id="pesan-notif-offline" class="leading-relaxed"></div>
                </div>
            </div>

            <form id="lapor-form" class="card card-static p-6 sm:p-10 shadow-lg border-gray-100 space-y-8" onsubmit="handleKirimLaporan(event)" enctype="multipart/form-data">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">
                        1. Jenis Kejadian Darurat <span class="text-rose-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5">
                        <label class="relative flex flex-col justify-between p-4 rounded-2xl border-2 cursor-pointer transition select-none bg-white hover:border-emerald-300 min-h-[115px] border-emerald-600 bg-emerald-50/60" id="label-jenis-kebakaran" onclick="pilihJenis('Kebakaran')">
                            <input type="radio" name="jenis" value="Kebakaran" checked class="sr-only">
                            <div class="flex items-start justify-between w-full mb-2">
                                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-base shrink-0 transition" id="icon-box-kebakaran">
                                    <i class="fa-solid fa-fire-flame-curved"></i>
                                </div>
                                <div class="w-5 h-5 rounded-full border-2 border-emerald-600 flex items-center justify-center shrink-0 mt-0.5" id="dot-kebakaran">
                                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-700" id="dot-fill-kebakaran"></div>
                                </div>
                            </div>
                            <div>
                                <div class="font-bold text-xs sm:text-sm text-gray-900">Kebakaran Hutan</div>
                                <div class="text-[11px] text-gray-500 mt-0.5 leading-snug">Titik api / asap karhutla</div>
                            </div>
                        </label>

                        <label class="relative flex flex-col justify-between p-4 rounded-2xl border-2 cursor-pointer transition select-none bg-white hover:border-gray-300 min-h-[115px] border-gray-200" id="label-jenis-hewan" onclick="pilihJenis('Hewan Masuk Kampung')">
                            <input type="radio" name="jenis" value="Hewan Masuk Kampung" class="sr-only">
                            <div class="flex items-start justify-between w-full mb-2">
                                <div class="w-10 h-10 rounded-xl bg-gray-100 text-gray-700 flex items-center justify-center text-base border border-gray-200 shrink-0 transition" id="icon-box-hewan">
                                    <i class="fa-solid fa-paw"></i>
                                </div>
                                <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center shrink-0 mt-0.5" id="dot-hewan">
                                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-700 hidden" id="dot-fill-hewan"></div>
                                </div>
                            </div>
                            <div>
                                <div class="font-bold text-xs sm:text-sm text-gray-900">Satwa Masuk</div>
                                <div class="text-[11px] text-gray-500 mt-0.5 leading-snug">Primata / satwa di kebun</div>
                            </div>
                        </label>

                        <label class="relative flex flex-col justify-between p-4 rounded-2xl border-2 cursor-pointer transition select-none bg-white hover:border-gray-300 min-h-[115px] border-gray-200" id="label-jenis-hilang" onclick="pilihJenis('Orang Hilang')">
                            <input type="radio" name="jenis" value="Orang Hilang" class="sr-only">
                            <div class="flex items-start justify-between w-full mb-2">
                                <div class="w-10 h-10 rounded-xl bg-gray-100 text-gray-700 flex items-center justify-center text-base border border-gray-200 shrink-0 transition" id="icon-box-hilang">
                                    <i class="fa-solid fa-person-hiking"></i>
                                </div>
                                <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center shrink-0 mt-0.5" id="dot-hilang">
                                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-700 hidden" id="dot-fill-hilang"></div>
                                </div>
                            </div>
                            <div>
                                <div class="font-bold text-xs sm:text-sm text-gray-900">Orang Hilang</div>
                                <div class="text-[11px] text-gray-500 mt-0.5 leading-snug">Pendaki / warga tersesat</div>
                            </div>
                        </label>

                        <label class="relative flex flex-col justify-between p-4 rounded-2xl border-2 cursor-pointer transition select-none bg-white hover:border-gray-300 min-h-[115px] border-gray-200" id="label-jenis-lainnya" onclick="pilihJenis('Lainnya')">
                            <input type="radio" name="jenis" value="Lainnya" class="sr-only">
                            <div class="flex items-start justify-between w-full mb-2">
                                <div class="w-10 h-10 rounded-xl bg-gray-100 text-gray-700 flex items-center justify-center text-base border border-gray-200 shrink-0 transition" id="icon-box-lainnya">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                </div>
                                <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center shrink-0 mt-0.5" id="dot-lainnya">
                                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-700 hidden" id="dot-fill-lainnya"></div>
                                </div>
                            </div>
                            <div>
                                <div class="font-bold text-xs sm:text-sm text-gray-900">Lainnya</div>
                                <div class="text-[11px] text-gray-500 mt-0.5 leading-snug">Illegal logging, longsor</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- SUB-DETAIL 1: KEBAKARAN -->
                <div id="wadah-detail-kebakaran" class="space-y-3.5 pt-1">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div>
                            <label for="tipe_vegetasi" class="block text-xs font-semibold text-gray-700 mb-1">
                                Vegetasi / Bahan Terbakar <span class="text-rose-500">*</span>
                            </label>
                            <select id="tipe_vegetasi" name="tipe_vegetasi" class="field text-xs sm:text-sm">
                                <option value="">-- Pilih Jenis Vegetasi Terbakar --</option>
                                <option value="Semak Belukar / Alang-alang">Semak Belukar / Alang-alang Kering</option>
                                <option value="Tegakan Pohon Pinus / Rimba">Tegakan Pohon Pinus / Rimba Hutan</option>
                                <option value="Lahan Gambut / Serasah Kering">Lahan Gambut / Serasah Daun Kering</option>
                                <option value="Perkebunan Warga dekat Hutan">Perkebunan Warga dekat Hutan</option>
                                <option value="Lainnya / Tidak Tahu">Lainnya / Belum Diketahui</option>
                            </select>
                        </div>

                        <div>
                            <label for="perkiraan_luas" class="block text-xs font-semibold text-gray-700 mb-1">
                                Perkiraan Luas Area Terbakar <span class="text-rose-500">*</span>
                            </label>
                            <select id="perkiraan_luas" name="perkiraan_luas" class="field text-xs sm:text-sm">
                                <option value="">-- Pilih Perkiraan Luas --</option>
                                <option value="Spot Kecil (< 0.5 Ha)">Spot Kecil (&lt; 0.5 Hektare)</option>
                                <option value="Sedang (0.5 - 2 Ha)">Sedang (0.5 - 2 Hektare)</option>
                                <option value="Luas (> 2 Ha)">Luas / Menjalar (&gt; 2 Hektare)</option>
                                <option value="Sangat Luas (> 10 Ha)">Sangat Luas / Masif (&gt; 10 Hektare)</option>
                                <option value="Belum Terukur">Belum Dapat Diperkirakan</option>
                            </select>
                        </div>

                        <div>
                            <label for="kondisi_api" class="block text-xs font-semibold text-gray-700 mb-1">
                                Kondisi Kobaran Api &amp; Asap <span class="text-rose-500">*</span>
                            </label>
                            <select id="kondisi_api" name="kondisi_api" class="field text-xs sm:text-sm">
                                <option value="">-- Pilih Kondisi Api --</option>
                                <option value="Kepulan Asap Tebal (Api belum tampak)">Kepulan Asap Tebal (Api belum tampak)</option>
                                <option value="Api Berkobar Menjalar Cepat">Api Berkobar &amp; Menjalar Cepat</option>
                                <option value="Api Merayap di Permukaan">Api Merayap di Permukaan Tanah</option>
                                <option value="Bara Api & Sisa Asap">Bara Api &amp; Sisa-sisa Asap</option>
                            </select>
                        </div>

                        <div>
                            <label for="arah_angin" class="block text-xs font-semibold text-gray-700 mb-1">
                                Arah Tiupan Angin <span class="text-rose-500">*</span>
                            </label>
                            <select id="arah_angin" name="arah_angin" class="field text-xs sm:text-sm">
                                <option value="">-- Pilih Arah Angin --</option>
                                <option value="Mengarah ke Permukiman / Kebun">Mengarah ke Permukiman / Kebun Warga</option>
                                <option value="Mengarah ke Puncak Hutan">Mengarah ke Puncak / Lereng Hutan</option>
                                <option value="Angin Tenang">Angin Tenang / Lambat</option>
                                <option value="Angin Kencang Berubah-ubah">Angin Kencang &amp; Berubah-ubah</option>
                            </select>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="potensi_bahaya" class="block text-xs font-semibold text-gray-700 mb-1">
                                Posisi / Kerentanan Area <span class="text-rose-500">*</span>
                            </label>
                            <select id="potensi_bahaya" name="potensi_bahaya" class="field text-xs sm:text-sm">
                                <option value="">-- Pilih Kerentanan Area --</option>
                                <option value="Dekat Permukiman Warga (< 500m)">Dekat Permukiman Warga (&lt; 500 Meter)</option>
                                <option value="Dekat Sumber Air / Sungai">Dekat Sumber Air / Sungai</option>
                                <option value="Di Tebing Curam / Sulit Dijangkau">Di Tebing Curam / Jurang (Sulit Dijangkau)</option>
                                <option value="Jauh di Tengah Kawasan Hutan">Jauh di Tengah Kawasan Hutan</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- SUB-DETAIL 2: HEWAN MASUK KAMPUNG -->
                <div id="wadah-detail-hewan" class="hidden space-y-3.5 pt-1">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div>
                            <label for="jenis_hewan" class="block text-xs font-semibold text-gray-700 mb-1">
                                Jenis Satwa yang Terlihat <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="jenis_hewan" name="jenis_hewan" list="daftar-hewan-rekomendasi" placeholder="Contoh: Monyet Ekor Panjang, Lutung, Babi Hutan..." class="field text-xs sm:text-sm">
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
                            <label for="jumlah_satwa" class="block text-xs font-semibold text-gray-700 mb-1">
                                Perkiraan Jumlah Ekor <span class="text-rose-500">*</span>
                            </label>
                            <select id="jumlah_satwa" name="jumlah_satwa" class="field text-xs sm:text-sm">
                                <option value="">-- Pilih Perkiraan Jumlah --</option>
                                <option value="1 Ekor (Sendirian)">1 Ekor (Sendirian)</option>
                                <option value="2 - 5 Ekor (Kelompok Kecil)">2 - 5 Ekor (Kelompok Kecil)</option>
                                <option value="Lebih dari 5 Ekor (Kawanan)">Lebih dari 5 Ekor (Kawanan Besar)</option>
                                <option value="Tidak Terhitung Jelas">Tidak Terhitung Jelas</option>
                            </select>
                        </div>

                        <div>
                            <label for="aktivitas_satwa" class="block text-xs font-semibold text-gray-700 mb-1">
                                Aktivitas / Dampak Satwa <span class="text-rose-500">*</span>
                            </label>
                            <select id="aktivitas_satwa" name="aktivitas_satwa" class="field text-xs sm:text-sm">
                                <option value="">-- Pilih Aktivitas Satwa --</option>
                                <option value="Merusak Kebun / Tanaman Warga">Merusak Kebun / Tanaman Warga</option>
                                <option value="Masuk ke Halaman / Rumah Warga">Masuk ke Halaman / Rumah Warga</option>
                                <option value="Memangsa Hewan Ternak">Memangsa Hewan Ternak (Ayam, Kambing, dll)</option>
                                <option value="Agresif / Menyerang Warga">Agresif / Menyerang / Mengancam Warga</option>
                                <option value="Satwa Terluka / Terjebak">Satwa Terluka / Terjebak</option>
                            </select>
                        </div>

                        <div>
                            <label for="posisi_satwa" class="block text-xs font-semibold text-gray-700 mb-1">
                                Posisi Satwa Saat Ini <span class="text-rose-500">*</span>
                            </label>
                            <select id="posisi_satwa" name="posisi_satwa" class="field text-xs sm:text-sm">
                                <option value="">-- Pilih Posisi Satwa --</option>
                                <option value="Masih di Lokasi (Pohon / Atap)">Masih di Lokasi (Pohon / Atap / Pekarangan)</option>
                                <option value="Bersembunyi di Rumpun Semak">Bersembunyi di Rumpun Semak / Bambu</option>
                                <option value="Bergerak Kembali Menuju Hutan">Sudah Bergerak Menjauh Kembali ke Hutan</option>
                                <option value="Terjebak di Bangunan / Sumur">Terjebak di Bangunan / Sumur / Kandang</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- SUB-DETAIL 3: ORANG HILANG -->
                <div id="wadah-detail-hilang" class="hidden space-y-3.5 pt-1">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div>
                            <label for="nama_korban" class="block text-xs font-semibold text-gray-700 mb-1">
                                Nama Korban / Survivor <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="nama_korban" name="nama_korban" placeholder="Contoh: Rian Pratama (atau rombongan X)" class="field text-xs sm:text-sm">
                        </div>

                        <div>
                            <label for="jumlah_korban" class="block text-xs font-semibold text-gray-700 mb-1">
                                Jumlah Orang yang Dicari <span class="text-rose-500">*</span>
                            </label>
                            <select id="jumlah_korban" name="jumlah_korban" class="field text-xs sm:text-sm">
                                <option value="">-- Pilih Jumlah Korban --</option>
                                <option value="1 Orang (Sendirian)">1 Orang (Sendirian / Terpisah)</option>
                                <option value="2 - 4 Orang (Kelompok Kecil)">2 - 4 Orang (Kelompok Kecil)</option>
                                <option value="Lebih dari 4 Orang (Rombongan)">Lebih dari 4 Orang (Rombongan)</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label for="usia_korban" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Perkiraan Usia <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" id="usia_korban" name="usia_korban" placeholder="Contoh: 23 Tahun" class="field text-xs sm:text-sm">
                            </div>
                            <div>
                                <label for="gender_korban" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Jenis Kelamin <span class="text-rose-500">*</span>
                                </label>
                                <select id="gender_korban" name="gender_korban" class="field text-xs sm:text-sm">
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                    <option value="Campuran">Campuran</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="kontak_terakhir" class="block text-xs font-semibold text-gray-700 mb-1">
                                Waktu Kontak / Terlihat Terakhir <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="kontak_terakhir" name="kontak_terakhir" placeholder="Contoh: Kemarin jam 16:30 WIB" class="field text-xs sm:text-sm">
                        </div>

                        <div>
                            <label for="jalur_pendakian" class="block text-xs font-semibold text-gray-700 mb-1">
                                Jalur / Titik Masuk Terakhir <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="jalur_pendakian" name="jalur_pendakian" placeholder="Contoh: Pos 3 Jalur Apuy / Palutungan" class="field text-xs sm:text-sm">
                        </div>

                        <div>
                            <label for="kondisi_bekal" class="block text-xs font-semibold text-gray-700 mb-1">
                                Perlengkapan / Bekal Logistik <span class="text-rose-500">*</span>
                            </label>
                            <select id="kondisi_bekal" name="kondisi_bekal" class="field text-xs sm:text-sm">
                                <option value="">-- Pilih Kondisi Bekal --</option>
                                <option value="Logistik Diperkirakan Habis">Logistik / Air Diperkirakan Habis</option>
                                <option value="Membawa Tenda & Logistik Lengkap">Membawa Tenda &amp; Logistik Lengkap</option>
                                <option value="Membawa HP Aktif / HT / Peluit">Membawa HP Aktif / HT / Peluit</option>
                                <option value="Perlengkapan Minim / Bukan Pendaki">Perlengkapan Minim / Tanpa Alat Gunung</option>
                            </select>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="ciri_pakaian" class="block text-xs font-semibold text-gray-700 mb-1">
                                Ciri Fisik &amp; Pakaian Terakhir yang Dikenakan <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="ciri_pakaian" name="ciri_pakaian" placeholder="Contoh: Jaket parasut merah, tas carrier biru 60L, celana kargo loreng..." class="field text-xs sm:text-sm">
                        </div>
                    </div>
                </div>

                <!-- SUB-DETAIL 4: LAINNYA -->
                <div id="wadah-detail-lainnya" class="hidden space-y-3.5 pt-1">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div>
                            <label for="kategori_lainnya" class="block text-xs font-semibold text-gray-700 mb-1">
                                Kategori Kejadian Lapangan <span class="text-rose-500">*</span>
                            </label>
                            <select id="kategori_lainnya" name="kategori_lainnya" class="field text-xs sm:text-sm">
                                <option value="">-- Pilih Kategori Kejadian --</option>
                                <option value="Pembalakan Liar / Penebangan Ilegal">Pembalakan Liar (Illegal Logging)</option>
                                <option value="Perburuan Liar / Pemasangan Jerat">Perburuan Liar / Jerat Satwa</option>
                                <option value="Tanah Longsor di Kawasan Hutan">Tanah Longsor di Kawasan Hutan</option>
                                <option value="Pohon Tumbang Menutup Akses">Pohon Tumbang Menutup Akses Hutan</option>
                                <option value="Perambahan / Penyerobotan Lahan">Perambahan / Penyerobotan Lahan Hutan</option>
                                <option value="Pencemaran Sungai / Sumber Air Hutan">Pencemaran Sungai / Sumber Air Hutan</option>
                                <option value="Kejadian Khusus Lainnya">Kejadian Khusus Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label for="tingkat_urgensi" class="block text-xs font-semibold text-gray-700 mb-1">
                                Tingkat Urgensi / Dampak <span class="text-rose-500">*</span>
                            </label>
                            <select id="tingkat_urgensi" name="tingkat_urgensi" class="field text-xs sm:text-sm">
                                <option value="">-- Pilih Tingkat Urgensi --</option>
                                <option value="Sangat Mendesak (Mengancam Keselamatan)">Sangat Mendesak (Mengancam Keselamatan Warga)</option>
                                <option value="Mendesak (Akses Tertutup / Kerusakan Hutan)">Mendesak (Akses Tertutup / Kerusakan Berlanjut)</option>
                                <option value="Perlu Penyelidikan / Investigasi">Perlu Investigasi / Pengecekan Petugas</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- LOKASI & PETA -->
                <div class="pt-2">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2.5">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                            2. Titik Lokasi Kejadian (Jawa Barat) <span class="text-rose-500">*</span>
                        </label>
                        <button type="button" onclick="ambilLokasiSaya()" class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-semibold border border-gray-200 transition active:scale-95 cursor-pointer">
                            <i class="fa-solid fa-location-crosshairs mr-1.5 text-emerald-600"></i>
                            <span>Deteksi Lokasi GPS Saya</span>
                        </button>
                    </div>

                    <!-- Pencarian Kawasan Hutan -->
                    <div class="relative mb-2.5">
                        <div class="relative flex items-center">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-emerald-700 pointer-events-none">
                                <i class="fa-solid fa-tree text-xs"></i>
                            </span>
                            <input type="text" id="input-cari-hutan" placeholder="Cari kawasan hutan di peta (Contoh: Gn. Ciremai, Papandayan, Halimun...)" autocomplete="off" class="w-full pl-9 pr-10 py-2.5 rounded-xl border border-gray-200 text-xs sm:text-sm focus:border-emerald-600 outline-none transition bg-gray-50 focus:bg-white">
                            <button type="button" id="btn-bersihkan-hutan" onclick="bersihkanCariHutan()" class="hidden absolute inset-y-0 right-2 px-2.5 text-gray-400 hover:text-gray-700 cursor-pointer">
                                <i class="fa-solid fa-xmark text-xs"></i>
                            </button>
                        </div>
                        <div id="hasil-cari-hutan" class="hidden absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-xl border border-gray-200 max-h-56 overflow-y-auto z-40 divide-y divide-gray-100 text-xs"></div>
                    </div>

                    <!-- Mini Map Lapor -->
                    <div class="rounded-2xl border border-gray-200 overflow-hidden relative shadow-sm mb-2">
                        <div id="map-lapor" class="w-full h-80 relative z-0"></div>
                        <div class="absolute top-2.5 right-2.5 z-20 bg-white/90 backdrop-blur px-2.5 py-1 rounded-lg border border-gray-200 text-[10px] text-gray-600 font-medium shadow-sm">
                            Klik peta untuk menandai titik
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 text-[11px] text-gray-500 px-1 mb-3">
                        <span id="label-status-lokasi" class="flex items-center">
                            <i class="fa-solid fa-map-pin mr-1.5 text-gray-400"></i>
                            Lokasi belum ditentukan. Silakan klik pada peta atau cari kawasan hutan.
                        </span>
                        <span class="font-mono text-gray-800 font-semibold bg-gray-100 px-2 py-0.5 rounded-md" id="label-koordinat-terpilih">-</span>
                    </div>

                    <input type="hidden" id="latitude" name="latitude" required>
                    <input type="hidden" id="longitude" name="longitude" required>
                </div>

                <!-- WILAYAH KABUPATEN / KOTA -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="id_kabupaten_kota" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Kabupaten / Kota di Jawa Barat <span class="text-rose-500">*</span>
                        </label>
                        <span id="badge-auto-kabupaten" class="hidden text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                            <i class="fa-solid fa-wand-magic-sparkles mr-1"></i> Terpilih Otomatis dari Koordinat
                        </span>
                    </div>
                    <select id="id_kabupaten_kota" name="id_kabupaten_kota" required class="field text-xs sm:text-sm bg-white">
                        <option value="">-- Pilih Wilayah Kabupaten/Kota --</option>
                        @foreach($kabupatenKota as $kab)
                            <option value="{{ $kab->id }}">{{ $kab->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- DESKRIPSI KEJADIAN -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="deskripsi" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                            3. Deskripsi Kejadian <span class="text-rose-500">*</span>
                        </label>
                        <span id="char-count" class="text-[11px] text-gray-400">0 / 1000</span>
                    </div>
                    <textarea id="deskripsi" name="deskripsi" rows="3" required maxlength="1000" placeholder="Gambarkan situasi terkini di lapangan, patokan menuju lokasi kejadian, serta kondisi korban/lingkungan..." class="field text-xs sm:text-sm bg-gray-50 focus:bg-white leading-relaxed"></textarea>
                </div>

                <!-- FOTO LAMPIRAN -->
                <div>
                    <label for="foto" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Lampiran Foto Lapangan (Opsional)
                    </label>
                    <div class="border-2 border-dashed border-gray-200 hover:border-emerald-500 rounded-2xl p-4 text-center transition cursor-pointer relative bg-gray-50/50" onclick="document.getElementById('foto').click()">
                        <input type="file" id="foto" name="foto" accept="image/png,image/jpeg,image/jpg" class="hidden" onchange="previewFoto(this)">
                        <div class="flex flex-col items-center justify-center space-y-1.5" id="foto-placeholder">
                            <div class="w-9 h-9 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-emerald-600 shadow-sm">
                                <i class="fa-solid fa-camera text-sm"></i>
                            </div>
                            <div class="text-xs font-semibold text-gray-800">
                                Pilih atau Ambil Foto dari Kamera
                            </div>
                            <div class="text-[11px] text-gray-400">
                                Format JPG / PNG, ukuran maksimal 5 MB
                            </div>
                        </div>
                        <div id="foto-preview-box" class="hidden flex items-center justify-center space-x-2 text-xs font-semibold text-gray-800">
                            <i class="fa-solid fa-image text-emerald-600"></i>
                            <span id="foto-file-name" class="truncate max-w-xs"></span>
                            <button type="button" onclick="hapusFoto(event)" class="text-gray-400 hover:text-rose-600 ml-2">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- IDENTITAS PELAPOR -->
                <div class="pt-4 border-t border-gray-100 space-y-3.5">
                    <div>
                        <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wider">Identitas Pelapor (Opsional)</h3>
                        <p class="text-[11px] text-gray-500 mt-0.5">
                            Boleh dikosongkan. Nomor HP Anda bersifat rahasia dan hanya digunakan untuk konfirmasi penanganan darurat oleh petugas.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div>
                            <label for="nama_pelapor" class="block text-xs font-medium text-gray-700 mb-1">Nama Lengkap / Panggilan</label>
                            <input type="text" id="nama_pelapor" name="nama_pelapor" placeholder="Contoh: Budi Santoso" class="field text-xs sm:text-sm bg-gray-50 focus:bg-white">
                        </div>

                        <div>
                            <label for="no_hp" class="block text-xs font-medium text-gray-700 mb-1">Nomor WhatsApp / HP</label>
                            <input type="tel" id="no_hp" name="no_hp" inputmode="numeric" pattern="[0-9]*" maxlength="20" placeholder="Contoh: 08123456789" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="field text-xs sm:text-sm bg-gray-50 focus:bg-white font-mono">
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" id="btn-submit-lapor" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-base sm:text-lg py-4 rounded-xl transition shadow-lg flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-paper-plane text-sm"></i>
                        <span>Kirim Laporan Darurat Sekarang</span>
                    </button>
                </div>
            </form>
        </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
    /* ===== PAYLOAD DATABASE DARI LARAVEL ===== */
    const DB_FLORA = @json($daftarTumbuhan);
    const DB_FAUNA = @json($daftarFauna);
    const DB_KAWASAN = @json($daftarKawasan);
    const DB_TITIK = @json($daftarTitik);
    const DB_LAPORAN = @json($daftarLaporan);
    const DB_BERITA = @json($daftarPengumuman);
    const DB_PREDIKSI = @json($daftarPrediksiPublik ?? []);
    const ACTIVE_INITIAL_VIEW = '{{ $activeView ?? "beranda" }}';

    /* Helper Utility */
    function esc(s) { 
        return String(s ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c])); 
    }
    const DEFAULT_FALLBACK_IMG = '{{ asset("assets/pemandangan.jpg") }}';
    const IMG_FAIL = `this.onerror=null;this.src='${DEFAULT_FALLBACK_IMG}';`;
    const src = p => p ? encodeURI(p) : '';

    /* Badges IUCN Helper */
    function getStatusBadge(st) {
        st = String(st || '').toUpperCase();
        const map = {
            'CR': { label: 'CR &middot; Kritis', bg: 'bg-red-900/80 text-red-200 border-red-500/50' },
            'EN': { label: 'EN &middot; Terancam', bg: 'bg-rose-900/80 text-rose-200 border-rose-500/50' },
            'VU': { label: 'VU &middot; Rentan', bg: 'bg-amber-900/80 text-amber-200 border-amber-500/50' },
            'NT': { label: 'NT &middot; Hampir Terancam', bg: 'bg-yellow-900/80 text-yellow-200 border-yellow-500/50' },
            'LC': { label: 'LC &middot; Risiko Rendah', bg: 'bg-emerald-900/80 text-emerald-200 border-emerald-500/50' },
            'DD': { label: 'DD &middot; Kurang Data', bg: 'bg-gray-800/80 text-gray-300 border-gray-600/50' },
            'NE': { label: 'NE &middot; Belum Dinilai', bg: 'bg-gray-800/80 text-gray-300 border-gray-600/50' }
        };
        const res = map[st] || { label: st || 'LC', bg: 'bg-gray-800 text-gray-300 border-gray-600' };
        return `<span class="inline-flex items-center text-[10px] font-bold px-2.5 py-0.5 rounded-full border ${res.bg}">${res.label}</span>`;
    }

    /* ===== ADAPTASI DATA FLORA UNTUK TAMPILAN ===== */
    const floraData = DB_FLORA.map((f, idx) => {
        const hasCustomPhoto = Boolean(f.foto);
        return {
            id: f.id,
            nama: f.nama_lokal,
            ilmiah: f.nama_ilmiah,
            kategori: f.jenis ? `Habitus: ${f.jenis}` : 'Flora Kawasan',
            jenis: f.jenis,
            status: f.status_konservasi,
            dilindungi: Boolean(f.dilindungi),
            manfaat: f.manfaat,
            desc: f.deskripsi || 'Tumbuhan khas kawasan konservasi hutan Jawa Barat.',
            funfact: f.manfaat ? `Manfaat Ekologis & Tradisional: ${f.manfaat}` : null,
            hasPhoto: hasCustomPhoto,
            image: hasCustomPhoto ? (f.foto_url || f.foto) : null,
            kawasanHutan: f.kawasan_hutan || [],
            unggulan: Boolean(f.dilindungi)
        };
    });

    /* ===== ADAPTASI DATA FAUNA UNTUK TAMPILAN ===== */
    const faunaData = DB_FAUNA.map((f, idx) => {
        const hasCustomPhoto = Boolean(f.foto);
        return {
            id: f.id,
            nama: f.nama_lokal,
            ilmiah: f.nama_ilmiah,
            kategori: 'Satwa',
            jenis: 'Satwa',
            habitat: f.habitat,
            makanan: f.makanan,
            ciri: f.ciri_khas,
            status: f.status_konservasi,
            dilindungi: Boolean(f.dilindungi),
            desc: f.deskripsi || (f.habitat ? `Habitat di ${f.habitat}` : 'Fauna endemik kawasan hutan Jawa Barat.'),
            funfact: f.ciri_khas ? `Ciri Khas Satwa: ${f.ciri_khas}` : (f.makanan ? `Makanan Alami: ${f.makanan}` : null),
            hasPhoto: hasCustomPhoto,
            image: hasCustomPhoto ? (f.foto_url || f.foto) : null,
            kawasanHutan: f.kawasan_hutan || [],
            unggulan: Boolean(f.dilindungi)
        };
    });

    /* ===== BERITA / PENGUMUMAN DARI DB ===== */
    const KATEGORI_BERITA = { 'Kabar': 'text-emerald-600', 'Edukasi': 'text-emerald-600', 'Satwa': 'text-orange-500', 'Pengumuman': 'text-blue-600', 'Panduan': 'text-purple-600', 'Tips Keselamatan': 'text-amber-600' };
    const beritaData = DB_BERITA.map(b => ({
        id: b.id,
        kategori: b.kategori || 'Pengumuman',
        gambar: b.gambar_url || DEFAULT_FALLBACK_IMG,
        judul: b.judul,
        ringkas: b.isi ? b.isi.substring(0, 130) + '...' : '',
        isi: (b.isi || '').split("\n\n").filter(Boolean)
    }));

    let kategoriBeritaAktif = '';

    function kartuBerita(b, tinggiImg) {
        return `
        <article class="card cursor-pointer flex flex-col group overflow-hidden" onclick="bukaBerita(${b.id})">
            <div class="w-full ${tinggiImg} relative overflow-hidden bg-gradient-to-br from-emerald-800 to-green-950 flex items-center justify-center">
                <img src="${esc(b.gambar)}" alt="${esc(b.judul)}" loading="lazy" class="w-full h-full object-cover transition duration-300 group-hover:scale-105" onerror="${IMG_FAIL}">
            </div>
            <div class="p-6 flex-1 flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold ${KATEGORI_BERITA[b.kategori] || 'text-gray-500'} uppercase tracking-widest">${esc(b.kategori)}</span>
                    <h3 class="font-bold text-lg mt-2 text-gray-900 group-hover:text-emerald-700 transition line-clamp-2">${esc(b.judul)}</h3>
                    <p class="text-gray-500 text-sm mt-2 line-clamp-2 leading-relaxed">${esc(b.ringkas)}</p>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-100 flex items-center text-xs font-semibold text-emerald-600">
                    <span>Baca Selengkapnya</span>
                    <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
                </div>
            </div>
        </article>`;
    }

    function renderBerandaBerita() {
        const box = document.getElementById('berita-beranda');
        if (!box) return;
        box.innerHTML = beritaData.slice(0, 3).map(b => kartuBerita(b, 'h-48')).join('');
    }

    function renderChipBerita() {
        const kats = ['', ...new Set(beritaData.map(b => b.kategori))];
        const chip = document.getElementById('chip-berita');
        if (!chip) return;
        chip.innerHTML = kats.map(k => {
            const aktif = (k === kategoriBeritaAktif);
            const clr = aktif ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white text-gray-600 border-gray-200 hover:border-emerald-400';
            return `<button type="button" class="px-4 py-1.5 rounded-full border text-sm font-semibold transition ${clr}" onclick="setKategoriBerita('${k}')">${k || 'Semua'}</button>`;
        }).join('');
    }

    function setKategoriBerita(k) {
        kategoriBeritaAktif = k;
        renderDaftarBerita();
    }

    function renderDaftarBerita() {
        renderChipBerita();
        const input = document.getElementById('cari-berita');
        const q = (input ? input.value : '').toLowerCase();
        const hasil = beritaData.filter(b => (!kategoriBeritaAktif || b.kategori === kategoriBeritaAktif) && ((b.judul || '') + ' ' + (b.ringkas || '')).toLowerCase().includes(q));
        const box = document.getElementById('berita-daftar');
        if (!box) return;
        box.innerHTML = hasil.length 
            ? hasil.map(b => kartuBerita(b, 'h-44')).join('') 
            : '<p class="text-gray-500 text-sm col-span-full text-center py-10">Tidak ada pengumuman yang cocok.</p>';
    }

    function bukaBerita(id) {
        const b = beritaData.find(x => x.id === id);
        if (!b) return;
        bukaView('info');
        bukaTab('kabar');
        document.getElementById('berita-daftar-wrap').hidden = true;
        const box = document.getElementById('berita-detail');
        box.hidden = false;
        box.innerHTML = `
            <button onclick="tutupBerita()" class="text-emerald-600 font-bold text-sm mb-6 hover:underline inline-flex items-center">
                <i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke daftar pengumuman
            </button>
            <article class="card card-static shadow-lg border-gray-100 overflow-hidden">
                <div class="w-full h-72 md:h-96 relative overflow-hidden bg-gradient-to-br from-emerald-800 to-green-950 flex items-center justify-center">
                    <img src="${esc(b.gambar)}" alt="${esc(b.judul)}" class="w-full h-full object-cover" onerror="${IMG_FAIL}">
                </div>
                <div class="p-8 md:p-10">
                    <span class="text-xs font-bold ${KATEGORI_BERITA[b.kategori] || 'text-gray-500'} uppercase tracking-widest">${esc(b.kategori)}</span>
                    <h2 class="font-serif-elegant text-3xl md:text-4xl font-bold text-gray-900 mt-2 mb-6">${esc(b.judul)}</h2>
                    <div class="space-y-4 text-gray-700 leading-relaxed text-base">
                        ${b.isi.map(p => `<p>${esc(p)}</p>`).join('')}
                    </div>
                </div>
            </article>`;
        window.scrollTo({ top: 100, behavior: 'smooth' });
    }

    function tutupBerita() {
        const box = document.getElementById('berita-detail');
        if (box) box.hidden = true;
        const wrap = document.getElementById('berita-daftar-wrap');
        if (wrap) wrap.hidden = false;
    }

    /* ===== NAVIGASI VIEW & URL MANAGEMENT ===== */
    const VIEW_URLS = {
        'beranda': '{{ route("beranda") }}',
        'peta': '{{ route("peta") }}',
        'flora': '{{ route("tumbuhan") }}',
        'fauna': '{{ route("primata") }}',
        'info': '{{ route("info") }}',
        'cek-status': '{{ route("lapor.status") }}',
        'lapor': '{{ route("lapor") }}'
    };

    function updateHeaderVisibility() {
        const h = document.getElementById('public-header');
        if (!h) return;
        const gelap = ['beranda', 'flora', 'fauna'].some(n => {
            const el = document.getElementById('view-' + n);
            return el && !el.hidden;
        });
        if (gelap && window.scrollY < 50) h.classList.remove('header-scrolled');
        else h.classList.add('header-scrolled');
    }

    function bukaView(nama, push = true) {
        if (!document.getElementById('view-' + nama)) nama = 'beranda';
        document.querySelectorAll('.view').forEach(el => el.hidden = (el.id !== 'view-' + nama));
        
        const menuMob = document.getElementById('menu-mobile');
        if (menuMob) menuMob.hidden = true;
        
        document.querySelectorAll('.nav-btn').forEach(btn => {
            if (btn.dataset.view === nama) btn.classList.add('active');
            else btn.classList.remove('active');
        });

        window.scrollTo(0, 0);
        updateHeaderVisibility();

        if (push && VIEW_URLS[nama] && window.location.pathname !== new URL(VIEW_URLS[nama]).pathname) {
            history.pushState({ view: nama }, '', VIEW_URLS[nama]);
        }

        if (nama === 'flora') {
            mulaiAutoSlide('flora');
            hentikanAutoSlide('fauna');
        } else if (nama === 'fauna') {
            mulaiAutoSlide('fauna');
            hentikanAutoSlide('flora');
        } else {
            hentikanAutoSlide('flora');
            hentikanAutoSlide('fauna');
        }

        if (nama === 'info') { 
            tutupBerita(); 
            renderDaftarBerita(); 
        }
        setTimeout(() => {
            if (nama === 'peta') siapkanPetaHutan();
            if (nama === 'lapor' || nama === 'cek-status') { 
                siapkanPetaLapor(); 
                tampilRiwayat(); 
            }
        }, 120);
    }

    window.addEventListener('popstate', (e) => {
        if (e.state && e.state.view) {
            bukaView(e.state.view, false);
        } else {
            const p = window.location.pathname;
            let v = 'beranda';
            if (p.includes('/peta')) v = 'peta';
            else if (p.includes('/tumbuhan')) v = 'flora';
            else if (p.includes('/primata')) v = 'fauna';
            else if (p.includes('/info')) v = 'info';
            else if (p.includes('/status')) v = 'cek-status';
            else if (p.includes('/lapor')) v = 'lapor';
            bukaView(v, false);
        }
    });

    /* ===== FLORA & FAUNA SLIDER & KATALOG ===== */
    const SPESIES = { flora: () => floraData, fauna: () => faunaData };
    const JUDUL = { 
        flora: { 
            n: 'Flora', 
            h: 'Katalog Flora Jawa Barat', 
            p: 'Daftar lengkap koleksi tumbuhan terdata lengkap dengan status konservasi, habitus, dan manfaat.', 
            cari: 'Cari nama lokal / ilmiah / manfaat...', 
            semua: 'Semua Habitus' 
        }, 
        fauna: { 
            n: 'Fauna', 
            h: 'Katalog Satwa Jawa Barat', 
            p: 'Daftar lengkap fauna endemik & dilindungi di hutan Jawa Barat beserta habitat & perilakunya.', 
            cari: 'Cari satwa / nama ilmiah / ciri khas...', 
            semua: 'Semua Kategori Fauna' 
        } 
    };
    const unggulan = t => {
        const d = SPESIES[t]().filter(x => x.dilindungi);
        return d.length > 0 ? d : SPESIES[t]().filter(x => x.hasPhoto);
    };
    const sliderIdx = { flora: 0, fauna: 0 };
    const sliderTimers = { flora: null, fauna: null };
    const SLIDE_INTERVAL = 4500; // Geser otomatis setiap 4.5 detik

    function isModalDetailBuka() {
        const m = document.getElementById('modal-spesies');
        return Boolean(m && !m.hidden && m.style.display !== 'none');
    }

    function mulaiAutoSlide(t) {
        hentikanAutoSlide(t);
        if (isModalDetailBuka()) return; // Jangan mulai jika modal detail sedang terbuka!
        const list = unggulan(t);
        if (!list || list.length <= 1) return;

        sliderTimers[t] = setInterval(() => {
            if (isModalDetailBuka()) {
                hentikanAutoSlide(t);
                return;
            }
            const el = document.getElementById('view-' + t);
            if (el && !el.hidden && !document.hidden) {
                geser(t, 1, false);
            }
        }, SLIDE_INTERVAL);
    }

    function hentikanAutoSlide(t) {
        if (sliderTimers[t]) {
            clearInterval(sliderTimers[t]);
            sliderTimers[t] = null;
        }
    }

    function resetAutoSlide(t) {
        hentikanAutoSlide(t);
        if (!isModalDetailBuka()) {
            mulaiAutoSlide(t);
        }
    }

    function bangunHalaman(t) {
        const j = JUDUL[t];
        const kats = [...new Set(SPESIES[t]().map(x => x.jenis || x.kategori).filter(Boolean))];
        const el = document.getElementById('view-' + t);
        if (!el) return;

        el.innerHTML = `
        <div class="max-w-7xl mx-auto px-6 pt-28 pb-12">
            <div class="flex items-end justify-between mb-6">
                <div>
                    <span class="text-emerald-400 font-bold text-xs uppercase tracking-widest flex items-center gap-1.5">
                        <i class="fa-solid fa-shield-halved text-amber-400 text-xs"></i> Prioritas Konservasi
                    </span>
                    <h1 class="font-serif-elegant text-3xl md:text-4xl font-bold mt-1">${j.n} Dilindungi</h1>
                </div>
                <div class="flex items-center gap-3">
                    <span class="hidden sm:inline-flex items-center gap-1.5 text-[11px] font-semibold text-emerald-300/80 bg-emerald-950/60 border border-emerald-800/50 px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Auto-slide
                    </span>
                    <span id="${t}-counter" class="text-xs font-bold text-white/70 tracking-widest"></span>
                </div>
            </div>
            <div id="${t}-slider-card" onmouseenter="hentikanAutoSlide('${t}')" onmouseleave="if (!isModalDetailBuka()) mulaiAutoSlide('${t}')" class="grid md:grid-cols-[1.1fr_1fr] gap-6 md:gap-10 items-center bg-white/5 border border-white/10 rounded-3xl p-4 md:p-6 shadow-2xl relative">
                <div id="${t}-img-box" class="slide-anim h-72 md:h-[400px] rounded-2xl overflow-hidden bg-emerald-950 relative flex items-center justify-center">
                    <img id="${t}-image" class="w-full h-full object-cover" src="" alt="" onerror="${IMG_FAIL}">
                    <div id="${t}-placeholder-box" hidden class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-emerald-950 via-[#0a3828] to-[#041f17] p-6 text-center select-none">
                        <div class="w-20 h-20 rounded-2xl bg-white/10 border border-white/20 p-3 flex items-center justify-center mb-3 shadow-inner">
                            <img src="{{ asset('images/Logo_Kementerian_Kehutanan.png') }}" alt="Logo" class="w-full h-full object-contain filter drop-shadow">
                        </div>
                        <span class="text-xs text-emerald-300 font-bold tracking-wider uppercase">Spesimen Konservasi Hutan</span>
                        <span class="text-[11px] text-emerald-400/70 font-medium mt-0.5">Dokumentasi foto belum diunggah</span>
                    </div>
                    <div id="${t}-slider-badges" class="absolute top-4 left-4 flex flex-wrap gap-2"></div>
                </div>
                <div id="${t}-info" class="slide-anim flex flex-col justify-center">
                    <div class="flex items-center gap-2 mb-2 flex-wrap">
                        <span id="${t}-kategori" class="text-[11px] font-bold text-emerald-300 bg-emerald-900/60 border border-emerald-500/30 px-3 py-1 rounded-full uppercase tracking-wider"></span>
                        <span id="${t}-slider-protect" class="text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider"></span>
                    </div>
                    <h2 id="${t}-title" class="font-josefin text-3xl md:text-4xl font-bold mt-1"></h2>
                    <h3 id="${t}-scientific" class="text-base text-[#f3c677] italic mb-3"></h3>
                    <p id="${t}-desc" class="text-[15px] text-gray-100 leading-relaxed line-clamp-3 mb-3"></p>
                    <div id="${t}-manfaat-box" class="bg-emerald-950/70 border border-emerald-700/50 p-3 rounded-xl mb-4 text-xs text-emerald-100">
                        <strong class="text-emerald-300 block mb-0.5"><i class="fa-solid fa-hand-holding-heart mr-1.5"></i>Manfaat &amp; Nilai Ekologis:</strong>
                        <span id="${t}-manfaat-text" class="line-clamp-2"></span>
                    </div>
                    <div class="flex items-center gap-4 mt-2 flex-wrap">
                        <button type="button" class="btn-gold" onclick="bukaDetailSlider('${t}')">
                            <i class="fa-solid fa-circle-info mr-1.5"></i> Lihat Informasi Lengkap
                        </button>
                        <div class="flex items-center gap-2 ml-auto">
                            <button type="button" class="w-11 h-11 rounded-full border border-white/30 hover:bg-[#f3c677] hover:text-black transition flex items-center justify-center" onclick="geser('${t}', -1, true)" aria-label="Sebelumnya">
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                            <button type="button" class="w-11 h-11 rounded-full border border-white/30 hover:bg-[#f3c677] hover:text-black transition flex items-center justify-center" onclick="geser('${t}', 1, true)" aria-label="Berikutnya">
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    <div id="${t}-dots" class="flex gap-2 mt-5"></div>
                </div>
            </div>
        </div>

        <!-- PEMBATAS GELOMBANG ABSTRAK ATAS (Slider ke Katalog) -->
        <div class="w-full overflow-hidden leading-none select-none pointer-events-none -mb-[1px] relative z-10" aria-hidden="true">
            <svg class="w-full h-14 sm:h-18 md:h-24 block text-[#04201a]" viewBox="0 0 1440 120" fill="none" preserveAspectRatio="none">
                <!-- Layer gelombang 1 (aksen hijau rimba elegan) -->
                <path d="M0,35 C180,95 340,15 520,55 C700,95 865,20 1045,60 C1220,95 1350,35 1440,50 L1440,120 L0,120 Z" fill="#047857" opacity="0.3"></path>
                <!-- Layer gelombang 2 (menyatu dengan katalog #04201a) -->
                <path d="M0,60 C200,115 380,35 580,75 C780,115 940,40 1140,80 C1280,105 1380,60 1440,70 L1440,120 L0,120 Z" fill="currentColor"></path>
            </svg>
        </div>

        <div class="bg-[#04201a] pt-4 pb-16 relative">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
                    <div>
                        <span class="text-emerald-400 font-bold text-xs uppercase tracking-widest">Eksplorasi Lengkap</span>
                        <h2 class="font-serif-elegant text-3xl md:text-4xl font-bold mt-1">${j.h}</h2>
                        <p class="text-gray-400 text-sm mt-1">${j.p}</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input id="cari-${t}" class="field sm:w-64 !bg-white/10 !text-white placeholder:text-gray-400 !border-white/20 text-sm" placeholder="${j.cari}" oninput="renderKatalog('${t}')">
                        <select id="filter-${t}" class="field sm:w-56 !bg-[#082f23] !text-white !border-white/20 text-sm" onchange="renderKatalog('${t}')">
                            <option value="">${j.semua}</option>
                            ${kats.map(k => `<option value="${esc(k)}">${esc(k)}</option>`).join('')}
                        </select>
                    </div>
                </div>
                <div id="katalog-${t}-grid" class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6"></div>
            </div>
        </div>

        <!-- PEMBATAS GELOMBANG ABSTRAK BAWAH (Katalog ke Pemandangan Footer) -->
        <div class="w-full overflow-hidden leading-none select-none pointer-events-none -mt-1 relative z-20 bg-[#04201a]" aria-hidden="true">
            <svg class="w-full h-16 sm:h-24 md:h-32 lg:h-40 block" viewBox="0 0 1440 120" fill="none" preserveAspectRatio="none">
                <!-- Layer gelombang aksen (lapisan transisi hijau mint/sage lembut) -->
                <path d="M0,25 C180,85 340,10 520,50 C700,90 865,15 1045,55 C1220,90 1350,30 1440,45 L1440,120 L0,120 Z" fill="#d1fae5" opacity="0.45"></path>
                <!-- Layer gelombang putih utama yang memotong warna hijau gelap menjadi putih bersih secara bergelombang -->
                <path d="M0,50 C200,105 380,30 580,70 C780,110 940,35 1140,75 C1280,100 1380,55 1440,65 L1440,120 L0,120 Z" fill="#ffffff"></path>
            </svg>
        </div>`;

        renderSliderItem(t, 0);
        renderKatalog(t);
        mulaiAutoSlide(t);
    }

    function renderSliderItem(t, i) {
        const list = unggulan(t);
        if (!list.length) return;
        i = (i + list.length) % list.length;
        sliderIdx[t] = i;
        const c = list[i];
        const $ = id => document.getElementById(t + id);

        $('-title').textContent = c.nama;
        $('-scientific').textContent = c.ilmiah;
        $('-kategori').textContent = c.kategori;
        $('-desc').textContent = c.desc;
        $('-counter').textContent = `${i + 1} / ${list.length}`;

        const img = $('-image');
        const phBox = $('-placeholder-box');
        if (c.hasPhoto && c.image) {
            img.classList.remove('img-fail');
            img.alt = c.nama;
            img.src = src(c.image);
            img.hidden = false;
            if (phBox) phBox.hidden = true;
        } else {
            img.hidden = true;
            if (phBox) phBox.hidden = false;
        }

        // Status proteksi
        const prot = $('-slider-protect');
        if (c.dilindungi) {
            prot.className = 'text-[11px] font-bold text-amber-300 bg-amber-950/70 border border-amber-500/40 px-2.5 py-1 rounded-full uppercase tracking-wider inline-flex items-center gap-1';
            prot.innerHTML = '<i class="fa-solid fa-shield-halved text-xs"></i> Dilindungi UU';
            prot.hidden = false;
        } else {
            prot.hidden = true;
        }

        // Manfaat Flora box
        const mBox = $('-manfaat-box');
        if (mBox) {
            if (t === 'flora' && c.manfaat) {
                mBox.hidden = false;
                $('-manfaat-text').textContent = c.manfaat;
            } else if (t === 'fauna' && (c.ciri || c.makanan)) {
                mBox.hidden = false;
                mBox.querySelector('strong').innerHTML = '<i class="fa-solid fa-paw mr-1.5"></i>Ciri &amp; Makanan Utama:';
                $('-manfaat-text').textContent = (c.ciri ? c.ciri + '. ' : '') + (c.makanan ? 'Makanan: ' + c.makanan : '');
            } else {
                mBox.hidden = true;
            }
        }

        // Status IUCN badge on slider image
        const sb = $('-slider-badges');
        if (sb) {
            sb.innerHTML = `${getStatusBadge(c.status)}`;
        }

        $('-dots').innerHTML = list.map((_, k) => `
            <button type="button" onclick="renderSliderItem('${t}', ${k}); resetAutoSlide('${t}');" aria-label="Slide ${k + 1}" class="h-2 rounded-full transition-all ${k === i ? 'w-8 bg-[#f3c677]' : 'w-2 bg-white/30 hover:bg-white/60'}"></button>
        `).join('');

        ['-img-box', '-info'].forEach(s => {
            const el = $(s);
            if (el) {
                el.classList.remove('slide-anim');
                void el.offsetWidth;
                el.classList.add('slide-anim');
            }
        });
    }

    function geser(t, a, manual = false) {
        if (isModalDetailBuka()) return; // Jangan bergeser jika modal detail sedang terbuka!
        renderSliderItem(t, sliderIdx[t] + a);
        if (manual) resetAutoSlide(t);
    }

    function bukaDetailSlider(t) {
        hentikanAutoSlide('flora');
        hentikanAutoSlide('fauna');
        const u = unggulan(t);
        const item = u[sliderIdx[t]];
        if (!item) return;
        const idx = SPESIES[t]().findIndex(x => x.id === item.id);
        bukaDetail(t, idx >= 0 ? idx : 0);
    }

    function renderKatalog(t) {
        const q = (document.getElementById('cari-' + t)?.value || '').toLowerCase();
        const f = document.getElementById('filter-' + t)?.value || '';
        const list = SPESIES[t]().map((x, i) => ({ x, i }));
        
        const hasil = list.filter(({ x }) => {
            const matchFilter = !f || (x.jenis === f || x.kategori === f);
            const matchQuery = ((x.nama || '') + ' ' + (x.ilmiah || '') + ' ' + (x.manfaat || '') + ' ' + (x.ciri || '')).toLowerCase().includes(q);
            return matchFilter && matchQuery;
        });

        const grid = document.getElementById(`katalog-${t}-grid`);
        if (!grid) return;

        grid.innerHTML = hasil.length ? hasil.map(({ x, i }) => `
            <article class="card flex flex-col h-full bg-gray-900 border-gray-800 text-white shadow-xl hover:-translate-y-1.5 transition-all duration-300">
                <div class="h-48 relative bg-emerald-950 shrink-0 overflow-hidden">
                    ${x.hasPhoto && x.image ? `
                        <img src="${esc(src(x.image))}" alt="${esc(x.nama)}" loading="lazy" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" onerror="${IMG_FAIL}">
                    ` : `
                        <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-emerald-950 via-[#0a3828] to-[#041f17] p-4 text-center select-none group">
                            <div class="w-14 h-14 rounded-2xl bg-white/10 border border-white/20 p-2 flex items-center justify-center mb-1.5 shadow-inner group-hover:scale-105 transition-transform">
                                <img src="{{ asset('images/Logo_Kementerian_Kehutanan.png') }}" alt="Logo" class="w-full h-full object-contain filter drop-shadow">
                            </div>
                            <span class="text-[10px] text-emerald-300 font-bold tracking-wider uppercase opacity-90">Koleksi Terdata</span>
                            <span class="text-[9px] text-emerald-400/70 font-medium">Foto Belum Diunggah</span>
                        </div>
                    `}
                    <div class="absolute top-2.5 inset-x-2.5 flex flex-wrap items-center gap-1.5 z-10 pointer-events-none">
                        <span class="bg-emerald-900/90 backdrop-blur-md text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider text-emerald-100 border border-emerald-500/30 shadow-sm">${esc(x.jenis || (t === 'fauna' ? 'Satwa' : 'Flora'))}</span>
                        ${getStatusBadge(x.status)}
                        ${x.dilindungi ? '<span class="bg-amber-500 text-stone-950 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase shadow-sm inline-flex items-center gap-1 border border-amber-300/60"><i class="fa-solid fa-shield-halved text-[9px]"></i>Dilindungi</span>' : ''}
                    </div>
                </div>
                <div class="p-5 flex flex-col flex-1 justify-between">
                    <div>
                        <h3 class="font-josefin text-xl font-bold text-white mb-0.5">${esc(x.nama)}</h3>
                        <p class="text-xs text-[#f3c677] italic mb-3 font-mono">${esc(x.ilmiah)}</p>
                        ${x.manfaat ? `
                            <div class="bg-emerald-950/40 border border-emerald-800/40 rounded-lg p-2 mb-3 text-[11px] text-emerald-200 line-clamp-2">
                                <strong class="text-emerald-400">Manfaat:</strong> ${esc(x.manfaat)}
                            </div>
                        ` : ''}
                        <p class="text-xs text-gray-300 leading-relaxed line-clamp-2 mb-4">${esc(x.desc)}</p>
                    </div>
                    <div>
                        <button type="button" onclick="bukaDetail('${t}', ${i})" class="w-full bg-emerald-600/90 hover:bg-emerald-600 font-bold text-xs py-2.5 rounded-lg transition text-white shadow flex items-center justify-center gap-1.5">
                            <span>Lihat Detail Lengkap</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </button>
                    </div>
                </div>
            </article>
        `).join('') : '<p class="text-gray-400 text-sm col-span-full text-center py-10">Tidak ada data flora/fauna yang sesuai dengan kriteria pencarian.</p>';
    }

    /* Modal Detail Lengkap Spesies */
    function bukaDetail(t, i) {
        hentikanAutoSlide('flora');
        hentikanAutoSlide('fauna');
        const s = SPESIES[t]()[i];
        if (!s) return;

        let bagian = [];
        if (t === 'flora') {
            bagian = [
                ['Habitus / Jenis', s.jenis || s.kategori],
                ['Status Konservasi IUCN', s.status || 'LC (Risiko Rendah)'],
                ['Status Hukum Perlindungan', s.dilindungi ? 'Dilindungi oleh Peraturan Perundang-undangan RI' : 'Tidak Terdaftar Perlindungan Khusus'],
                ['Manfaat Ekologis & Kegunaan', s.manfaat || 'Berperan menjaga keseimbangan ekosistem dan penyusun tajuk hutan.'],
                ['Deskripsi Lengkap', s.desc],
                ['Sebaran Kawasan Hutan', s.kawasanHutan && s.kawasanHutan.length ? s.kawasanHutan.map(k => k.nama).join(', ') : 'Tersebar di beberapa kawasan konservasi hutan Jawa Barat']
            ];
        } else {
            bagian = [
                ['Status Konservasi IUCN', s.status || 'LC (Risiko Rendah)'],
                ['Status Hukum Perlindungan', s.dilindungi ? 'Dilindungi oleh Peraturan Perundang-undangan RI' : 'Tidak Terdaftar'],
                ['Habitat Alami', s.habitat || 'Hutan hujan dataran rendah hingga pegunungan Jawa Barat'],
                ['Makanan Utama', s.makanan || 'Buah-buahan, dedaunan, serangga'],
                ['Ciri Khas & Morfologi', s.ciri || s.desc],
                ['Deskripsi Lengkap', s.desc],
                ['Sebaran Kawasan Hutan', s.kawasanHutan && s.kawasanHutan.length ? s.kawasanHutan.map(k => k.nama).join(', ') : 'Tersebar di wilayah hutan konservasi Jawa Barat']
            ];
        }

        const m = document.getElementById('modal-spesies');
        if (!m) return;

        m.innerHTML = `
        <div class="bg-white rounded-3xl max-w-4xl lg:max-w-5xl w-full max-h-[92vh] md:h-[600px] lg:h-[640px] overflow-hidden flex flex-col md:flex-row shadow-2xl relative text-gray-900 animate-in fade-in zoom-in duration-200" role="dialog" aria-modal="true">
            <!-- Tombol Tutup -->
            <button type="button" onclick="tutupDetail()" aria-label="Tutup" class="absolute top-4 right-4 z-30 w-10 h-10 bg-black/50 hover:bg-black/80 md:bg-stone-100 md:hover:bg-stone-200 text-white md:text-stone-700 rounded-full flex items-center justify-center transition shadow-md">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>

            <!-- SISI KIRI: Foto & Identitas Spesies (FIXED / TIDAK IKUT SCROLL) -->
            <div class="w-full md:w-[45%] lg:w-[42%] h-64 sm:h-72 md:h-full relative bg-emerald-950 flex flex-col justify-end overflow-hidden shrink-0">
                ${s.hasPhoto && s.image ? `
                    <img src="${esc(src(s.image))}" alt="${esc(s.nama)}" class="w-full h-full object-cover select-none" onerror="${IMG_FAIL}">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/45 to-black/20"></div>
                ` : `
                    <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-emerald-950 via-[#0a3828] to-[#041f17] p-6 text-center select-none pb-24 md:pb-28">
                        <div class="w-20 h-20 rounded-2xl bg-white/10 border border-white/20 p-3 flex items-center justify-center mb-3 shadow-inner">
                            <img src="{{ asset('images/Logo_Kementerian_Kehutanan.png') }}" alt="Logo" class="w-full h-full object-contain filter drop-shadow">
                        </div>
                        <span class="text-xs text-emerald-300 font-bold tracking-wider uppercase opacity-85">Koleksi Terdata</span>
                        <span class="text-[11px] text-emerald-400/60 font-medium mt-0.5">Dokumentasi foto belum diunggah</span>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                `}

                <div class="absolute inset-x-0 bottom-0 p-6 md:p-8 text-white z-10 flex flex-col justify-end">
                    <div class="flex items-center gap-1.5 mb-2.5 flex-wrap">
                        <span class="bg-emerald-700/90 backdrop-blur-md text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-widest text-white border border-emerald-500/30 shadow-sm">${esc(s.jenis || (t === 'fauna' ? 'Satwa' : s.kategori))}</span>
                        ${getStatusBadge(s.status)}
                        ${s.dilindungi ? '<span class="bg-amber-500 text-stone-950 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase inline-flex items-center gap-1 shadow-sm border border-amber-300/60"><i class="fa-solid fa-shield-halved text-[9px]"></i>Dilindungi UU</span>' : ''}
                    </div>
                    <h2 class="font-serif-elegant text-2xl md:text-3xl lg:text-4xl font-bold text-white leading-tight drop-shadow-md">${esc(s.nama)}</h2>
                    <p class="text-[#f3c677] italic text-xs md:text-sm font-mono mt-1 drop-shadow">${esc(s.ilmiah)}</p>
                </div>
            </div>

            <!-- SISI KANAN: Detail Informasi Spesies (BISA DI-SCROLL) -->
            <div class="w-full md:w-[55%] lg:w-[58%] h-full flex flex-col bg-white overflow-hidden">
                <div class="px-6 py-5 md:px-8 md:pt-7 md:pb-4 border-b border-stone-100 flex items-center justify-between shrink-0 bg-stone-50/60">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-xs font-bold shadow-sm">
                            <i class="fa-solid ${t === 'flora' ? 'fa-leaf' : 'fa-paw'}"></i>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-emerald-950 uppercase tracking-wider">Karakteristik &amp; Informasi Lengkap</h3>
                            <p class="text-[11px] text-stone-400 font-medium">Dokumentasi Keanekaragaman Hayati Rimba Jawa Barat</p>
                        </div>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto p-6 md:p-8 space-y-4 text-sm text-stone-700 overscroll-contain">
                    ${bagian.filter(b => b[1]).map(([h, v]) => `
                        <div class="bg-stone-50/70 hover:bg-stone-50 border border-stone-200/80 rounded-2xl p-4 transition-colors shadow-none">
                            <h4 class="font-bold text-xs uppercase tracking-wider text-emerald-800 mb-1.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-circle-check text-[10px] text-emerald-600"></i> ${esc(h)}
                            </h4>
                            <p class="leading-relaxed text-xs sm:text-sm text-stone-700 font-normal">${esc(v)}</p>
                        </div>
                    `).join('')}
                    
                    ${s.funfact ? `
                        <div class="bg-amber-50/90 border border-amber-200/90 p-4 rounded-2xl text-amber-950">
                            <h4 class="font-bold text-xs uppercase tracking-wider mb-1 flex items-center gap-1.5 text-amber-800">
                                <i class="fa-solid fa-lightbulb text-amber-600"></i> Catatan Khusus
                            </h4>
                            <p class="italic text-xs leading-relaxed text-amber-900">${esc(s.funfact)}</p>
                        </div>
                    ` : ''}
                </div>
            </div>
        </div>`;

        m.hidden = false;
        document.body.style.overflow = 'hidden';
    }

    function tutupDetail() {
        const m = document.getElementById('modal-spesies');
        if (m) m.hidden = true;
        document.body.style.overflow = '';
        setTimeout(() => {
            const vf = document.getElementById('view-flora');
            const vs = document.getElementById('view-fauna');
            if (vf && !vf.hidden) mulaiAutoSlide('flora');
            if (vs && !vs.hidden) mulaiAutoSlide('fauna');
        }, 150);
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') tutupDetail();
        if (['INPUT', 'SELECT', 'TEXTAREA'].includes(document.activeElement.tagName)) return;
        ['flora', 'fauna'].forEach(t => {
            const el = document.getElementById('view-' + t);
            if (!el || el.hidden) return;
            if (e.key === 'ArrowLeft') geser(t, -1, true);
            if (e.key === 'ArrowRight') geser(t, 1, true);
        });
    });

    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            hentikanAutoSlide('flora');
            hentikanAutoSlide('fauna');
        } else {
            const vf = document.getElementById('view-flora');
            const vs = document.getElementById('view-fauna');
            if (vf && !vf.hidden) mulaiAutoSlide('flora');
            if (vs && !vs.hidden) mulaiAutoSlide('fauna');
        }
    });

    /* ===== PETA SATELIT INTERAKTIF ===== */
    const PETA_PENGATURAN = {
        latPusat: {{ (float) ($pengaturan->lat_pusat ?? -6.87) }},
        longPusat: {{ (float) ($pengaturan->long_pusat ?? 107.60) }},
        zoomAwal: {{ (int) ($pengaturan->zoom_awal ?? 8) }},
        bboxSelatan: {{ (float) ($pengaturan->bbox_selatan ?? -7.83) }},
        bboxBarat: {{ (float) ($pengaturan->bbox_barat ?? 106.36) }},
        bboxUtara: {{ (float) ($pengaturan->bbox_utara ?? -5.90) }},
        bboxTimur: {{ (float) ($pengaturan->bbox_timur ?? 108.85) }}
    };
    const boundsJabar = L.latLngBounds([PETA_PENGATURAN.bboxSelatan, PETA_PENGATURAN.bboxBarat], [PETA_PENGATURAN.bboxUtara, PETA_PENGATURAN.bboxTimur]);
    let petaHutan, petaLapor, penandaLapor;
    const lapisan = {};
    var lajuRambatM = 960;
    var arahAnginDerajat = 240;
    var namaVegetasi = 'Hutan';
    var pusatApiLat = null;
    var pusatApiLng = null;
    var poly0Coords = [];
    var poly1Coords = [];
    var poly3Coords = [];
    var poly6Coords = [];
    var permukimanTerancamList = [];
    var layerApiAnimasi = null;
    var simulasiInterval = null;
    var waktuSimulasi = 0;
    var daftarTitikApiSekunder = [];
    var markerApiSekunder = [];

    const JENIS_INSIDEN = { 
        'Kebakaran': { label: 'Kebakaran Hutan', warna: '#dc2626', ikon: 'fa-fire' }, 
        'Hewan Masuk Kampung': { label: 'Konflik Satwa', warna: '#f97316', ikon: 'fa-paw' },
        'Orang Hilang': { label: 'Orang Hilang', warna: '#3b82f6', ikon: 'fa-person-circle-question' },
        'Lainnya': { label: 'Insiden Lainnya', warna: '#6b7280', ikon: 'fa-circle-exclamation' }
    };

    const STATUS_INSIDEN = [
        { nama: 'Baru', warna: '#dc2626' },
        { nama: 'Diverifikasi', warna: '#f59e0b' },
        { nama: 'Ditangani', warna: '#3b82f6' },
        { nama: 'Selesai', warna: '#16a34a' }
    ];

    function titikPoligon(lat, lng, r) {
        let res = [];
        for (let i = 0; i < 8; i++) {
            const a = i * Math.PI / 4;
            res.push([lat + r * Math.cos(a) / 111.32, lng + r * Math.sin(a) / (111.32 * Math.cos(lat * Math.PI / 180))]);
        }
        return res;
    }

    function petaDasar(id, zoom = PETA_PENGATURAN.zoomAwal, center = [PETA_PENGATURAN.latPusat, PETA_PENGATURAN.longPusat]) {
        const m = L.map(id, { 
            maxBounds: boundsJabar, 
            minZoom: Math.max(1, PETA_PENGATURAN.zoomAwal - 2), 
            scrollWheelZoom: true 
        }).setView(center, zoom);
        m.scrollWheelZoom.enable();
        const wadah = document.getElementById(id);
        if (wadah) {
            wadah.addEventListener('mouseenter', function () {
                m.scrollWheelZoom.enable();
            });
        }
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { 
            attribution: 'Tiles &copy; Esri &mdash; Satellite Imagery' 
        }).addTo(m);
        return m;
    }

    function popupInsiden(i) {
        const j = JENIS_INSIDEN[i.jenis] || { label: i.jenis, warna: '#6b7280' };
        return `
        <div class="popup-insiden">
            <h4 style="color:${j.warna}; margin:0 0 6px; font-weight:800; font-size:14px">${esc(j.label)}</h4>
            <table style="font-size:12px; border-collapse:collapse;">
                <tr><td style="color:#6b7280; padding-right:8px;">Kode</td><td><b>${esc(i.kode)}</b></td></tr>
                <tr><td style="color:#6b7280; padding-right:8px;">Status</td><td><b style="color:${j.warna}">${esc(i.status)}</b></td></tr>
                <tr><td style="color:#6b7280; padding-right:8px;">Deskripsi</td><td>${esc(i.deskripsi || '-')}</td></tr>
            </table>
        </div>`;
    }

    function renderRingkasan(d) {
        const box = document.getElementById('ringkasan-status');
        if (!box) return;
        box.innerHTML = STATUS_INSIDEN.map(s => `
            <div class="flex items-center justify-between">
                <span class="flex items-center gap-2">
                    <span class="inline-block w-3 h-3 rounded-full" style="background:${s.warna}"></span>${s.nama}
                </span>
                <b class="text-gray-900">${d.filter(i => (i.status || '').toLowerCase() === s.nama.toLowerCase()).length}</b>
            </div>
        `).join('') + `
            <div class="flex items-center justify-between border-t border-gray-200 pt-2 mt-2">
                <span>Total Ditampilkan</span>
                <b class="text-gray-900">${d.length}</b>
            </div>`;
    }

    function renderInsiden() {
        if (!petaHutan || !lapisan.laporan) return;
        lapisan.laporan.clearLayers();
        const f = document.getElementById('filter-insiden')?.value || '';
        const d = DB_LAPORAN.filter(i => (!f || i.jenis === f) && i.latitude && i.longitude);

        d.forEach(i => {
            const j = JENIS_INSIDEN[i.jenis] || { warna: '#6b7280', ikon: 'fa-circle-exclamation' };
            const icon = L.divIcon({
                className: '',
                html: `<div class="marker-insiden ${i.status === 'Selesai' ? 'selesai' : ''}" style="background:${j.warna}"><i class="fa-solid ${j.ikon}"></i></div>`,
                iconSize: [30, 30],
                iconAnchor: [15, 15],
                popupAnchor: [0, -15]
            });
            L.marker([i.latitude, i.longitude], { icon, title: i.kode })
                .bindPopup(popupInsiden(i))
                .addTo(lapisan.laporan);
        });

        renderRingkasan(d);
    }

    function siapkanPetaHutan() {
        if (petaHutan) {
            petaHutan.invalidateSize();
            return;
        }
        petaHutan = petaDasar('map-hutan', PETA_PENGATURAN.zoomAwal);
        lapisan.kawasan = L.layerGroup().addTo(petaHutan);
        lapisan.titik = L.layerGroup().addTo(petaHutan);
        lapisan.laporan = L.layerGroup().addTo(petaHutan);

        // Kawasan Hutan
        DB_KAWASAN.forEach(k => {
            if (k.geojson) {
                try {
                    const geo = typeof k.geojson === 'string' ? JSON.parse(k.geojson) : k.geojson;
                    L.geoJSON(geo, {
                        style: { color: '#22c55e', fillColor: '#22c55e', fillOpacity: 0.3, weight: 3 }
                    }).bindPopup(`<b>${esc(k.nama)}</b><br><span class="text-xs text-gray-500">${esc(k.kategori || 'Kawasan Konservasi')}</span>`).addTo(lapisan.kawasan);
                } catch(e) {
                    if (k.lat_pusat && k.long_pusat) {
                        L.polygon(titikPoligon(k.lat_pusat, k.long_pusat, 6), { color: '#22c55e', fillColor: '#22c55e', fillOpacity: 0.3, weight: 3 })
                            .bindPopup(`<b>${esc(k.nama)}</b><br>Batas perkiraan`)
                            .addTo(lapisan.kawasan);
                    }
                }
            } else if (k.lat_pusat && k.long_pusat) {
                L.polygon(titikPoligon(k.lat_pusat, k.long_pusat, 6), { color: '#22c55e', fillColor: '#22c55e', fillOpacity: 0.3, weight: 3 })
                    .bindPopup(`<b>${esc(k.nama)}</b><br>Batas perkiraan`)
                    .addTo(lapisan.kawasan);
            }
        });

        // Titik Penting
        DB_TITIK.forEach(t => {
            if (t.latitude && t.longitude) {
                const color = t.jenis === 'Pos Jaga' ? '#10b981' : '#eab308';
                L.circleMarker([t.latitude, t.longitude], { radius: 7, color: '#fff', fillColor: color, fillOpacity: 1, weight: 2 })
                    .bindPopup(`<b>${esc(t.nama)}</b><br><span class="text-xs">${esc(t.jenis)} &middot; ${esc(t.deskripsi || '')}</span>`)
                    .addTo(lapisan.titik);
            }
        });

        lapisan.prediksi = L.layerGroup().addTo(petaHutan);
        if (Array.isArray(DB_PREDIKSI) && DB_PREDIKSI.length > 0) {
            var predUtama = DB_PREDIKSI[0];
            if (predUtama.latitude && predUtama.longitude) {
                pusatApiLat = parseFloat(predUtama.latitude);
                pusatApiLng = parseFloat(predUtama.longitude);
                arahAnginDerajat = parseFloat(predUtama.arah_angin || 240);
                lajuRambatM = parseFloat(predUtama.laju_efektif || 960);
                namaVegetasi = predUtama.jenis_lahan ? (predUtama.jenis_lahan.nama || 'Hutan') : 'Hutan';
                poly0Coords = [[pusatApiLat, pusatApiLng]];
                if (predUtama.area_terancam) {
                    try {
                        permukimanTerancamList = typeof predUtama.area_terancam === 'string' ? JSON.parse(predUtama.area_terancam) : predUtama.area_terancam;
                    } catch (e) {}
                }
            }

            DB_PREDIKSI.forEach(p => {
                if (p.latitude && p.longitude) {
                    if (p.poligon_6jam) {
                        try {
                            const pts6 = typeof p.poligon_6jam === 'string' ? JSON.parse(p.poligon_6jam) : p.poligon_6jam;
                            if (p === predUtama) poly6Coords = pts6;
                            L.polygon(pts6, { color: '#f87171', fillColor: '#ef4444', fillOpacity: 0.15, weight: 1.5, dashArray: '4, 4' })
                                .bindPopup(`<b>Prediksi Rambatan 6 Jam</b><br>Estimasi Luas: <b>${p.luas_6jam || '-'} Ha</b>`)
                                .addTo(lapisan.prediksi);
                        } catch(e) {}
                    }
                    if (p.poligon_3jam) {
                        try {
                            const pts3 = typeof p.poligon_3jam === 'string' ? JSON.parse(p.poligon_3jam) : p.poligon_3jam;
                            if (p === predUtama) poly3Coords = pts3;
                            L.polygon(pts3, { color: '#ea580c', fillColor: '#ea580c', fillOpacity: 0.25, weight: 2 })
                                .bindPopup(`<b>Prediksi Rambatan 3 Jam</b><br>Estimasi Luas: <b>${p.luas_3jam || '-'} Ha</b>`)
                                .addTo(lapisan.prediksi);
                        } catch(e) {}
                    }
                    if (p.poligon_1jam) {
                        try {
                            const pts1 = typeof p.poligon_1jam === 'string' ? JSON.parse(p.poligon_1jam) : p.poligon_1jam;
                            if (p === predUtama) poly1Coords = pts1;
                            L.polygon(pts1, { color: '#dc2626', fillColor: '#b91c1c', fillOpacity: 0.4, weight: 2.5 })
                                .bindPopup(`<b>Prediksi Rambatan 1 Jam</b><br>Estimasi Luas: <b>${p.luas_1jam || '-'} Ha</b>`)
                                .addTo(lapisan.prediksi);
                        } catch(e) {}
                    }
                    const fireIcon = L.divIcon({
                        className: '',
                        html: `<div class="relative flex items-center justify-center -ml-3.5 -mt-3.5 w-8 h-8"><span class="absolute w-7 h-7 rounded-full bg-red-600/70 animate-ping"></span><div class="w-8 h-8 rounded-full bg-red-600 border-2 border-white shadow-lg flex items-center justify-center text-white text-xs z-10"><i class="fa-solid fa-fire text-amber-300"></i></div></div>`,
                        iconSize: [32, 32],
                        iconAnchor: [16, 16],
                        popupAnchor: [0, -16]
                    });
                    L.marker([p.latitude, p.longitude], { icon: fireIcon, zIndexOffset: 1000 })
                        .bindPopup(`
                            <div class="popup-insiden">
                                <h4 style="color:#dc2626; margin:0 0 6px; font-weight:800; font-size:14px"><i class="fa-solid fa-fire mr-1"></i> Titik Pantau Api &amp; Perambatan</h4>
                                <table style="font-size:12px; border-collapse:collapse;">
                                    <tr><td style="color:#6b7280; padding-right:8px;">Koordinat</td><td>${Number(p.latitude).toFixed(4)}, ${Number(p.longitude).toFixed(4)}</td></tr>
                                    <tr><td style="color:#6b7280; padding-right:8px;">Arah Angin</td><td>${p.arah_angin ?? '-'}° (${p.kecepatan_angin ?? 0} km/j)</td></tr>
                                    <tr><td style="color:#6b7280; padding-right:8px;">Luas 1 Jam</td><td><b>${p.luas_1jam || '-'} Ha</b></td></tr>
                                    <tr><td style="color:#6b7280; padding-right:8px;">Luas 3 Jam</td><td><b>${p.luas_3jam || '-'} Ha</b></td></tr>
                                    <tr><td style="color:#6b7280; padding-right:8px;">Luas 6 Jam</td><td><b>${p.luas_6jam || '-'} Ha</b></td></tr>
                                </table>
                                <div class="mt-2 text-[10px] text-red-600 bg-red-50 p-1.5 rounded font-semibold">Simulasi perambatan aktif satgas kehutanan.</div>
                                <button type="button" onclick="gantiTitikSimulasi(${p.id})" class="mt-2 w-full py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-bold flex items-center justify-center gap-1.5 transition cursor-pointer shadow-xs"><i class="fa-solid fa-play"></i> Simulasikan Titik Ini</button>
                            </div>
                        `)
                        .addTo(lapisan.prediksi);
                }
            });

            inisialisasiTitikApiSekunder();

            if (pusatApiLat && pusatApiLng) {
                layerApiAnimasi = L.polygon([[pusatApiLat, pusatApiLng]], {
                    color: '#ff2200',
                    fillColor: '#ef4444',
                    fillOpacity: 0.65,
                    weight: 3,
                    dashArray: '4, 4'
                }).addTo(petaHutan);

                setTimeout(() => {
                    if (petaHutan && pusatApiLat && pusatApiLng) {
                        petaHutan.setView([pusatApiLat, pusatApiLng], 14);
                        petaHutan.invalidateSize();
                    }
                }, 250);

                ubahWaktuSimulasi(0);
            }
        }

        renderInsiden();
        setTimeout(() => petaHutan.invalidateSize(), 200);
    }

    function buatIconApiSekunder() {
        return L.divIcon({
            className: '',
            html: '<div class="relative flex items-center justify-center -ml-2.5 -mt-2.5 w-6 h-6 pointer-events-none">' +
                '<span class="absolute w-5 h-5 rounded-full bg-amber-500/70 animate-ping"></span>' +
                '<span class="absolute w-4 h-4 rounded-full bg-red-600/80 animate-pulse"></span>' +
                '<div class="w-5 h-5 rounded-full bg-gradient-to-t from-red-600 via-orange-500 to-amber-400 border border-white shadow-lg flex items-center justify-center text-white text-[10px] z-10">' +
                '<i class="fa-solid fa-fire text-yellow-200"></i></div></div>',
            iconSize: [22, 22],
            iconAnchor: [11, 11]
        });
    }

    function inisialisasiTitikApiSekunder() {
        daftarTitikApiSekunder = [];
        if (!pusatApiLat || !pusatApiLng || poly1Coords.length === 0) return;

        var p1 = poly1Coords;
        var p3 = poly3Coords.length > 0 ? poly3Coords : poly1Coords;
        var p6 = poly6Coords.length > 0 ? poly6Coords : p3;

        var n1 = p1.length;
        var n3 = p3.length;
        var n6 = p6.length;

        daftarTitikApiSekunder = [
            { jam: 0.35, lat: pusatApiLat + (p1[2 % n1][0] - pusatApiLat) * 0.45, lng: pusatApiLng + (p1[2 % n1][1] - pusatApiLng) * 0.45, label: 'Lidah Api Awal' },
            { jam: 0.65, lat: pusatApiLat + (p1[34 % n1][0] - pusatApiLat) * 0.65, lng: pusatApiLng + (p1[34 % n1][1] - pusatApiLng) * 0.65, label: 'Lidah Api Samping' },
            { jam: 0.95, lat: p1[0][0] * 0.95 + pusatApiLat * 0.05, lng: p1[0][1] * 0.95 + pusatApiLng * 0.05, label: 'Kepala Api 1 Jam' },
            { jam: 1.25, lat: p1[5 % n1][0], lng: p1[5 % n1][1], label: 'Loncatan Bara Kanan' },
            { jam: 1.55, lat: p1[31 % n1][0], lng: p1[31 % n1][1], label: 'Loncatan Bara Kiri' },
            { jam: 1.85, lat: p1[1 % n1][0] + (p3[1 % n3][0] - p1[1 % n1][0]) * 0.35, lng: p1[1 % n1][1] + (p3[1 % n3][1] - p1[1 % n1][1]) * 0.35, label: 'Perambatan Aktif' },
            { jam: 2.20, lat: p1[4 % n1][0] + (p3[4 % n3][0] - p1[4 % n1][0]) * 0.55, lng: p1[4 % n1][1] + (p3[4 % n3][1] - p1[4 % n1][1]) * 0.55, label: 'Lidah Api Hutan' },
            { jam: 2.55, lat: p1[33 % n1][0] + (p3[33 % n3][0] - p1[33 % n1][0]) * 0.65, lng: p1[33 % n1][1] + (p3[33 % n3][1] - p1[33 % n1][1]) * 0.65, label: 'Fokus Api Menyebar' },
            { jam: 2.90, lat: p3[0][0], lng: p3[0][1], label: 'Kepala Api 3 Jam' },
            { jam: 3.25, lat: p3[6 % n3][0], lng: p3[6 % n3][1], label: 'Titik Api Dekat Jalur Lereng' },
            { jam: 3.65, lat: p3[30 % n3][0], lng: p3[30 % n3][1], label: 'Lidah Api Sisi Barat' },
            { jam: 4.05, lat: p3[2 % n3][0] + (p6[2 % n6][0] - p3[2 % n3][0]) * 0.35, lng: p3[2 % n3][1] + (p6[2 % n6][1] - p3[2 % n3][1]) * 0.35, label: 'Loncatan Bara 4 Jam' },
            { jam: 4.45, lat: p3[32 % n3][0] + (p6[32 % n6][0] - p3[32 % n3][0]) * 0.50, lng: p3[32 % n3][1] + (p6[32 % n6][1] - p3[32 % n3][1]) * 0.50, label: 'Lidah Api Menjalar Luas' },
            { jam: 4.90, lat: p6[1 % n6][0] * 0.9 + p3[1 % n3][0] * 0.1, lng: p6[1 % n6][1] * 0.9 + p3[1 % n3][1] * 0.1, label: 'Garis Depan Lidah Api' },
            { jam: 5.35, lat: p6[5 % n6][0], lng: p6[5 % n6][1], label: 'Perimeter Terluar Timur' },
            { jam: 5.80, lat: p6[0][0], lng: p6[0][1], label: 'Puncak Penjalaran 6 Jam' }
        ];
    }

    function hitungPoligonInterp(jam) {
        if (jam <= 0) return poly0Coords;
        if (jam <= 1) {
            var f = jam;
            var hasil = [];
            var n = poly1Coords.length;
            if (n === 0) return poly0Coords;
            for (var i = 0; i < n; i++) {
                var lat = pusatApiLat + (poly1Coords[i][0] - pusatApiLat) * f;
                var lng = pusatApiLng + (poly1Coords[i][1] - pusatApiLng) * f;
                hasil.push([lat, lng]);
            }
            return hasil;
        }
        var sourceCoords, targetCoords, f;
        if (jam <= 3) {
            sourceCoords = poly1Coords;
            targetCoords = poly3Coords.length > 0 ? poly3Coords : poly1Coords;
            f = (jam - 1) / 2;
        } else {
            sourceCoords = poly3Coords.length > 0 ? poly3Coords : poly1Coords;
            targetCoords = poly6Coords.length > 0 ? poly6Coords : sourceCoords;
            f = (jam - 3) / 3;
        }
        var hasil = [];
        var n = Math.min(sourceCoords.length, targetCoords.length);
        for (var i = 0; i < n; i++) {
            var lat = sourceCoords[i][0] + (targetCoords[i][0] - sourceCoords[i][0]) * f;
            var lng = sourceCoords[i][1] + (targetCoords[i][1] - sourceCoords[i][1]) * f;
            hasil.push([lat, lng]);
        }
        return hasil;
    }

    function ubahWaktuSimulasi(jam) {
        waktuSimulasi = parseFloat(jam);
        var slider = document.getElementById('slider-waktu');
        if (slider) slider.value = waktuSimulasi;

        var menitTotal = Math.round(waktuSimulasi * 60);
        var jamTeks = Math.floor(menitTotal / 60);
        var sisaMenit = menitTotal % 60;
        var teksWaktu = document.getElementById('teks-waktu-simulasi');
        if (teksWaktu) teksWaktu.innerText = 'Waktu Simulasi: +' + jamTeks + ' Jam ' + sisaMenit + ' Menit';

        var jarakMeter = Math.round(waktuSimulasi * lajuRambatM);
        var teksJarak = document.getElementById('teks-jarak-simulasi');
        if (teksJarak) teksJarak.innerText = 'Perkiraan Menjalar: ~' + jarakMeter.toLocaleString('id-ID') + ' m';

        if (!layerApiAnimasi && petaHutan && pusatApiLat && pusatApiLng) {
            layerApiAnimasi = L.polygon([[pusatApiLat, pusatApiLng]], {
                color: '#ff2200',
                fillColor: '#ef4444',
                fillOpacity: 0.65,
                weight: 3,
                dashArray: '4, 4'
            }).addTo(petaHutan);
        }

        if (layerApiAnimasi) {
            var polyCoords = hitungPoligonInterp(waktuSimulasi);
            layerApiAnimasi.setLatLngs(polyCoords);
        }

        var jumlahSekunderAktif = 0;
        daftarTitikApiSekunder.forEach(function (titik, i) {
            if (waktuSimulasi >= titik.jam) {
                jumlahSekunderAktif++;
                if (!markerApiSekunder[i] && petaHutan) {
                    var m = L.marker([titik.lat, titik.lng], { icon: buatIconApiSekunder() }).addTo(petaHutan);
                    m.bindPopup('<div class="p-1 font-sans text-xs">' +
                        '<div class="font-extrabold text-orange-600 flex items-center gap-1"><i class="fa-solid fa-fire"></i> ' + titik.label + '</div>' +
                        '<div class="text-[11px] text-stone-600 mt-0.5">Loncatan api aktif pada jam ke +' + titik.jam.toFixed(1) + '</div>' +
                        '</div>');
                    markerApiSekunder[i] = m;
                }
            } else {
                if (markerApiSekunder[i] && petaHutan) {
                    petaHutan.removeLayer(markerApiSekunder[i]);
                    markerApiSekunder[i] = null;
                }
            }
        });

        var totalTitikAktif = 1 + jumlahSekunderAktif;
        var badgeTitik = document.getElementById('teks-titik-aktif');
        if (badgeTitik) {
            badgeTitik.innerText = totalTitikAktif + ' Titik Api Aktif';
        }

        var kotakStatus = document.getElementById('kotak-status-simulasi');
        var ikonStatus = document.getElementById('ikon-status-simulasi');
        var judulStatus = document.getElementById('judul-status-simulasi');
        var pesanStatus = document.getElementById('pesan-status-simulasi');

        if (!kotakStatus) return;

        var desaTerdampakSekarang = [];
        permukimanTerancamList.forEach(function (area) {
            var jamBahaya = parseFloat(area.jam);
            if (waktuSimulasi >= jamBahaya) {
                desaTerdampakSekarang.push(area.nama);
            }
        });

        if (desaTerdampakSekarang.length > 0) {
            kotakStatus.className = 'p-4 rounded-xl bg-rose-50 border-2 border-rose-500 flex items-start gap-3 shadow-sm transition-all duration-300';
            ikonStatus.className = 'w-9 h-9 rounded-lg bg-rose-600 text-white flex items-center justify-center shrink-0 text-base mt-0.5 animate-bounce';
            judulStatus.className = 'font-black text-rose-900 mb-0.5 text-sm';
            judulStatus.innerText = 'PERINGATAN KRITIS: Lidah Api Memasuki Area Permukiman!';
            pesanStatus.className = 'text-rose-800 leading-relaxed font-medium';
            pesanStatus.innerText = 'Pada waktu simulasi +' + jamTeks + 'j ' + sisaMenit + 'm, api diperkirakan telah menjalar sejauh ~' + jarakMeter.toLocaleString('id-ID') + ' m dengan ' + totalTitikAktif + ' titik api aktif yang mulai mengancam: ' + desaTerdampakSekarang.join(', ') + '. Warga diimbau evakuasi terarah!';
        } else if (waktuSimulasi > 0) {
            kotakStatus.className = 'p-4 rounded-xl bg-amber-50 border border-amber-300 flex items-start gap-3 shadow-sm transition-all duration-300';
            ikonStatus.className = 'w-9 h-9 rounded-lg bg-amber-500 text-white flex items-center justify-center shrink-0 text-base mt-0.5';
            judulStatus.className = 'font-black text-amber-900 mb-0.5 text-sm';
            judulStatus.innerText = 'Api Sedang Merambat di Vegetasi ' + (namaVegetasi || 'Hutan');
            pesanStatus.className = 'text-amber-800 leading-relaxed';
            pesanStatus.innerText = 'Terdeteksi ' + totalTitikAktif + ' titik api aktif yang menyebar mengikuti dorongan angin ' + arahAnginDerajat + '° dengan kecepatan rambat ~' + lajuRambatM + ' m/jam. Jarak penjalaran api saat ini mencapai ~' + jarakMeter.toLocaleString('id-ID') + ' meter.';
        } else {
            kotakStatus.className = 'p-4 rounded-xl bg-white border border-gray-200 flex items-start gap-3 shadow-sm transition-all duration-300';
            ikonStatus.className = 'w-9 h-9 rounded-lg bg-red-50 text-red-600 flex items-center justify-center shrink-0 text-base mt-0.5';
            judulStatus.className = 'font-bold text-gray-900 mb-0.5 text-sm';
            judulStatus.innerText = 'Kondisi Awal Titik Api Terdeteksi';
            pesanStatus.className = 'text-gray-600 leading-relaxed';
            pesanStatus.innerText = 'Titik api teridentifikasi pada kawasan vegetasi hutan. Tekan tombol "Mulai Simulasi" atau geser slider waktu untuk memantau perambatan lidah api dan titik api baru ke arah pemukiman warga.';
        }
    }

    function toggleSimulasi() {
        var btnIcon = document.getElementById('icon-play-simulasi');
        var btnLabel = document.getElementById('label-play-simulasi');

        if (simulasiInterval) {
            clearInterval(simulasiInterval);
            simulasiInterval = null;
            if (btnIcon) btnIcon.className = 'fa-solid fa-play';
            if (btnLabel) btnLabel.innerText = 'Lanjutkan';
        } else {
            if (pusatApiLat && pusatApiLng && petaHutan) {
                if (petaHutan.getZoom() < 13) {
                    petaHutan.setView([pusatApiLat, pusatApiLng], 14, { animate: true });
                }
            }
            if (waktuSimulasi >= 6) {
                waktuSimulasi = 0;
            }
            if (btnIcon) btnIcon.className = 'fa-solid fa-pause';
            if (btnLabel) btnLabel.innerText = 'Jeda';

            simulasiInterval = setInterval(function () {
                waktuSimulasi += 0.05;
                if (waktuSimulasi >= 6) {
                    waktuSimulasi = 6;
                    clearInterval(simulasiInterval);
                    simulasiInterval = null;
                    if (btnIcon) btnIcon.className = 'fa-solid fa-rotate-right';
                    if (btnLabel) btnLabel.innerText = 'Ulangi';
                }
                ubahWaktuSimulasi(waktuSimulasi);
            }, 80);
        }
    }

    function resetSimulasi() {
        if (simulasiInterval) {
            clearInterval(simulasiInterval);
            simulasiInterval = null;
        }
        if (markerApiSekunder && markerApiSekunder.length > 0 && petaHutan) {
            markerApiSekunder.forEach(function (m) {
                if (m) {
                    petaHutan.removeLayer(m);
                }
            });
            markerApiSekunder = [];
        }
        var btnIcon = document.getElementById('icon-play-simulasi');
        var btnLabel = document.getElementById('label-play-simulasi');
        if (btnIcon) btnIcon.className = 'fa-solid fa-play';
        if (btnLabel) btnLabel.innerText = 'Mulai Simulasi';
        ubahWaktuSimulasi(0);
        if (pusatApiLat && pusatApiLng && petaHutan) {
            petaHutan.setView([pusatApiLat, pusatApiLng], 14, { animate: true });
        }
    }

    function toggleLapisan(j, a) {
        if (!petaHutan) return;
        if (a) lapisan[j].addTo(petaHutan);
        else petaHutan.removeLayer(lapisan[j]);
    }

    function fokusPeta(i) {
        if (!petaHutan) return;
        if (i === "") {
            petaHutan.setView([PETA_PENGATURAN.latPusat, PETA_PENGATURAN.longPusat], PETA_PENGATURAN.zoomAwal);
        } else {
            const k = DB_KAWASAN[parseInt(i)];
            if (k && k.lat_pusat && k.long_pusat) {
                petaHutan.setView([k.lat_pusat, k.long_pusat], 11);
            }
        }
    }

    function gantiTitikSimulasi(id) {
        if (!Array.isArray(DB_PREDIKSI) || DB_PREDIKSI.length === 0) return;
        var target = DB_PREDIKSI.find(p => p.id == id) || DB_PREDIKSI[0];
        if (!target) return;

        if (simulasiInterval) {
            clearInterval(simulasiInterval);
            simulasiInterval = null;
        }

        if (markerApiSekunder && markerApiSekunder.length > 0 && petaHutan) {
            markerApiSekunder.forEach(m => {
                if (m) petaHutan.removeLayer(m);
            });
            markerApiSekunder = [];
        }

        pusatApiLat = parseFloat(target.latitude);
        pusatApiLng = parseFloat(target.longitude);
        arahAnginDerajat = parseFloat(target.arah_angin || 240);
        lajuRambatM = parseFloat(target.laju_efektif || 960);
        namaVegetasi = target.jenis_lahan ? (target.jenis_lahan.nama || 'Hutan') : 'Hutan';
        poly0Coords = [[pusatApiLat, pusatApiLng]];

        poly1Coords = [];
        poly3Coords = [];
        poly6Coords = [];
        if (target.poligon_1jam) {
            try {
                poly1Coords = typeof target.poligon_1jam === 'string' ? JSON.parse(target.poligon_1jam) : target.poligon_1jam;
            } catch (e) {}
        }
        if (target.poligon_3jam) {
            try {
                poly3Coords = typeof target.poligon_3jam === 'string' ? JSON.parse(target.poligon_3jam) : target.poligon_3jam;
            } catch (e) {}
        }
        if (target.poligon_6jam) {
            try {
                poly6Coords = typeof target.poligon_6jam === 'string' ? JSON.parse(target.poligon_6jam) : target.poligon_6jam;
            } catch (e) {}
        }

        permukimanTerancamList = [];
        if (target.area_terancam) {
            try {
                permukimanTerancamList = typeof target.area_terancam === 'string' ? JSON.parse(target.area_terancam) : target.area_terancam;
            } catch (e) {}
        }

        var subtextEl = document.getElementById('subteks-model-angin');
        if (subtextEl) {
            subtextEl.innerText = 'Model elips Huygens berbasis dorongan angin ' + (target.arah_angin ?? 240) + '° • Kecepatan ' + (target.kecepatan_angin ?? 14) + ' km/j';
        }

        var selSimulasi = document.getElementById('select-titik-simulasi');
        if (selSimulasi) {
            selSimulasi.value = target.id;
        }

        inisialisasiTitikApiSekunder();

        if (layerApiAnimasi && petaHutan) {
            petaHutan.removeLayer(layerApiAnimasi);
            layerApiAnimasi = null;
        }

        if (pusatApiLat && pusatApiLng && petaHutan) {
            layerApiAnimasi = L.polygon([[pusatApiLat, pusatApiLng]], {
                color: '#ff2200',
                fillColor: '#ef4444',
                fillOpacity: 0.65,
                weight: 3,
                dashArray: '4, 4'
            }).addTo(petaHutan);
        }

        var btnIcon = document.getElementById('icon-play-simulasi');
        var btnLabel = document.getElementById('label-play-simulasi');
        if (btnIcon) btnIcon.className = 'fa-solid fa-play';
        if (btnLabel) btnLabel.innerText = 'Mulai Simulasi';

        ubahWaktuSimulasi(0);

        if (petaHutan && pusatApiLat && pusatApiLng) {
            petaHutan.setView([pusatApiLat, pusatApiLng], 14, { animate: true });
        }
    }

    function fokusPrediksi(lat, lng, id) {
        if (!petaHutan) return;
        if (id) {
            gantiTitikSimulasi(id);
        } else if (lat && lng) {
            petaHutan.setView([lat, lng], 14, { animate: true });
        }
        if (lapisan.prediksi && !petaHutan.hasLayer(lapisan.prediksi)) {
            lapisan.prediksi.addTo(petaHutan);
        }
        var elMap = document.getElementById('map-hutan');
        if (elMap) {
            elMap.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    /* ===== PETA MINI UNTUK LAPORAN & FORM LENGKAP ===== */
    const daftarCentroidKab = [
        { id: 1, lat: -7.02, lng: 107.53 }, { id: 2, lat: -6.84, lng: 107.50 }, { id: 3, lat: -6.24, lng: 107.15 },
        { id: 4, lat: -6.55, lng: 106.80 }, { id: 5, lat: -7.33, lng: 108.35 }, { id: 6, lat: -6.82, lng: 107.14 },
        { id: 7, lat: -6.75, lng: 108.48 }, { id: 8, lat: -7.22, lng: 107.90 }, { id: 9, lat: -6.33, lng: 108.32 },
        { id: 10, lat: -6.30, lng: 107.30 }, { id: 11, lat: -6.98, lng: 108.48 }, { id: 12, lat: -6.83, lng: 108.23 },
        { id: 13, lat: -7.68, lng: 108.65 }, { id: 14, lat: -6.55, lng: 107.44 }, { id: 15, lat: -6.57, lng: 107.76 },
        { id: 16, lat: -7.00, lng: 106.70 }, { id: 17, lat: -6.85, lng: 107.92 }, { id: 18, lat: -7.35, lng: 108.11 },
        { id: 19, lat: -6.9175, lng: 107.6191 }, { id: 20, lat: -7.37, lng: 108.53 }, { id: 21, lat: -6.2383, lng: 106.9756 },
        { id: 22, lat: -6.5971, lng: 106.8060 }, { id: 23, lat: -6.8722, lng: 107.5422 }, { id: 24, lat: -6.7320, lng: 108.5523 },
        { id: 25, lat: -6.4025, lng: 106.7942 }, { id: 26, lat: -6.9277, lng: 106.9300 }, { id: 27, lat: -7.3274, lng: 108.2207 }
    ];

    const daftarTipe = ['Kebakaran', 'Hewan Masuk Kampung', 'Orang Hilang', 'Lainnya'];
    const mapId = {
        'Kebakaran': 'kebakaran',
        'Hewan Masuk Kampung': 'hewan',
        'Orang Hilang': 'hilang',
        'Lainnya': 'lainnya'
    };

    function pilihJenis(jenis) {
        daftarTipe.forEach(t => {
            const id = mapId[t];
            const radio = document.querySelector(`input[name="jenis"][value="${t}"]`);
            const label = document.getElementById('label-jenis-' + id);
            const dotFill = document.getElementById('dot-fill-' + id);
            const dot = document.getElementById('dot-' + id);
            const iconBox = document.getElementById('icon-box-' + id);
            const wadah = document.getElementById('wadah-detail-' + id);

            if (t === jenis) {
                if (radio) radio.checked = true;
                if (label) {
                    label.className = 'relative flex flex-col justify-between p-4 rounded-2xl border-2 border-emerald-600 bg-emerald-50/60 shadow-sm cursor-pointer transition select-none min-h-[115px]';
                }
                if (iconBox) {
                    iconBox.className = 'w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-base shrink-0 transition';
                }
                if (dotFill) dotFill.classList.remove('hidden');
                if (dot) {
                    dot.className = 'w-5 h-5 rounded-full border-2 border-emerald-600 flex items-center justify-center shrink-0 mt-0.5';
                }
                if (wadah) {
                    wadah.classList.remove('hidden');
                    wadah.querySelectorAll('input, select').forEach(f => f.required = true);
                }
            } else {
                if (label) {
                    label.className = 'relative flex flex-col justify-between p-4 rounded-2xl border-2 border-gray-200 hover:border-gray-300 bg-white cursor-pointer transition select-none min-h-[115px]';
                }
                if (iconBox) {
                    iconBox.className = 'w-10 h-10 rounded-xl bg-gray-100 text-gray-700 flex items-center justify-center text-base border border-gray-200 shrink-0 transition';
                }
                if (dotFill) dotFill.classList.add('hidden');
                if (dot) {
                    dot.className = 'w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center shrink-0 mt-0.5';
                }
                if (wadah) {
                    wadah.classList.add('hidden');
                    wadah.querySelectorAll('input, select').forEach(f => f.required = false);
                }
            }
        });
    }

    function otomatisPilihKabupaten(lat, lng) {
        if (!lat || !lng) return;
        let jarakMin = Infinity;
        let kabTerpilih = null;

        daftarCentroidKab.forEach(k => {
            const dLat = lat - k.lat;
            const dLng = lng - k.lng;
            const jarak = (dLat * dLat) + (dLng * dLng);
            if (jarak < jarakMin) {
                jarakMin = jarak;
                kabTerpilih = k.id;
            }
        });

        if (kabTerpilih) {
            const select = document.getElementById('id_kabupaten_kota');
            const badge = document.getElementById('badge-auto-kabupaten');
            if (select) select.value = kabTerpilih;
            if (badge) badge.classList.remove('hidden');
        }

        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=10`)
            .then(res => res.json())
            .then(data => {
                if (!data || !data.address) return;
                const wilayah = data.address.city || data.address.county || data.address.town || data.address.municipality || '';
                if (wilayah) {
                    const select = document.getElementById('id_kabupaten_kota');
                    const clean = wilayah.toLowerCase().replace(/kabupaten|kota/gi, '').trim();
                    for (let i = 0; i < select.options.length; i++) {
                        const optText = select.options[i].text.toLowerCase();
                        if (clean && optText.includes(clean)) {
                            select.selectedIndex = i;
                            const badge = document.getElementById('badge-auto-kabupaten');
                            if (badge) badge.classList.remove('hidden');
                            break;
                        }
                    }
                }
            })
            .catch(() => {});
    }

    function perbaruiTitikLokasi(lat, lng, lewatiAutoKabupaten = false) {
        const latInput = document.getElementById('latitude');
        const longInput = document.getElementById('longitude');
        const labelStatus = document.getElementById('label-status-lokasi');
        const labelKoordinat = document.getElementById('label-koordinat-terpilih');

        latInput.value = parseFloat(lat).toFixed(7);
        longInput.value = parseFloat(lng).toFixed(7);

        const warna = '#059669';

        if (penandaLapor) {
            penandaLapor.setLatLng([lat, lng]);
            penandaLapor.setStyle({ color: '#fff', fillColor: warna });
        } else if (petaLapor) {
            penandaLapor = L.circleMarker([lat, lng], {
                radius: 8,
                color: '#fff',
                fillColor: warna,
                fillOpacity: 0.9,
                weight: 2
            }).addTo(petaLapor);
        }

        if (labelStatus) {
            labelStatus.innerHTML = '<i class="fa-solid fa-circle-check text-emerald-600 mr-1.5"></i> Titik lokasi berhasil ditandai';
        }
        if (labelKoordinat) {
            labelKoordinat.innerText = parseFloat(lat).toFixed(5) + ', ' + parseFloat(lng).toFixed(5);
        }

        if (!lewatiAutoKabupaten) {
            otomatisPilihKabupaten(lat, lng);
        }
    }

    function ambilLokasiSaya() {
        const labelStatus = document.getElementById('label-status-lokasi');
        if (!navigator.geolocation) {
            alert('Peramban Anda tidak mendukung deteksi lokasi otomatis.');
            return;
        }

        if (labelStatus) {
            labelStatus.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-emerald-600 mr-1.5"></i> Mencari sinyal GPS perangkat...';
        }

        navigator.geolocation.getCurrentPosition(posisi => {
            const lat = posisi.coords.latitude;
            const lng = posisi.coords.longitude;
            if (petaLapor) {
                petaLapor.setView([lat, lng], 14);
            }
            perbaruiTitikLokasi(lat, lng);
        }, err => {
            alert('Tidak dapat mendeteksi lokasi GPS otomatis: ' + err.message + '. Silakan klik langsung titik kejadian pada peta.');
            if (labelStatus) {
                labelStatus.innerHTML = '<i class="fa-solid fa-circle-xmark text-rose-500 mr-1.5"></i> Gagal mendeteksi GPS. Silakan klik pada peta.';
            }
        }, {
            enableHighAccuracy: true,
            timeout: 10000
        });
    }

    function cariKawasanHutan(kataKunci) {
        const hasilBox = document.getElementById('hasil-cari-hutan');
        const btnBersihkan = document.getElementById('btn-bersihkan-hutan');
        const kw = (kataKunci || '').trim().toLowerCase();

        if (!kw) {
            hasilBox.classList.add('hidden');
            hasilBox.innerHTML = '';
            btnBersihkan.classList.add('hidden');
            return;
        }

        btnBersihkan.classList.remove('hidden');

        const filterHasil = DB_KAWASAN.filter(k => {
            const namaCocok = k.nama && k.nama.toLowerCase().includes(kw);
            const katCocok = k.kategori && k.kategori.toLowerCase().includes(kw);
            return namaCocok || katCocok;
        });

        if (filterHasil.length === 0) {
            hasilBox.innerHTML = '<div class="px-4 py-3 text-xs text-gray-400 text-center">Kawasan hutan tidak ditemukan</div>';
            hasilBox.classList.remove('hidden');
            return;
        }

        let html = '';
        filterHasil.slice(0, 8).forEach(hutan => {
            html += `
            <button type="button" onclick="pilihKawasanHutan(${hutan.id})" class="w-full text-left px-4 py-3 hover:bg-emerald-50/50 flex items-center justify-between transition cursor-pointer">
                <div>
                    <div class="text-xs sm:text-sm font-bold text-gray-900">${esc(hutan.nama)}</div>
                    <div class="text-[11px] text-gray-500 flex items-center space-x-2 mt-0.5">
                        <span class="text-emerald-700 font-medium">${esc(hutan.kategori || 'Kawasan Hutan')}</span>
                    </div>
                </div>
                <i class="fa-solid fa-arrow-right text-gray-300 text-xs shrink-0 ml-3"></i>
            </button>`;
        });

        hasilBox.innerHTML = html;
        hasilBox.classList.remove('hidden');
    }

    function pilihKawasanHutan(idHutan) {
        const hutan = DB_KAWASAN.find(k => k.id === idHutan);
        if (!hutan) return;

        const input = document.getElementById('input-cari-hutan');
        const hasilBox = document.getElementById('hasil-cari-hutan');
        const btnBersihkan = document.getElementById('btn-bersihkan-hutan');

        if (input) input.value = hutan.nama;
        if (hasilBox) hasilBox.classList.add('hidden');
        if (btnBersihkan) btnBersihkan.classList.remove('hidden');

        const lat = parseFloat(hutan.lat_pusat);
        const lng = parseFloat(hutan.long_pusat);

        if (lat && lng && petaLapor) {
            petaLapor.flyTo([lat, lng], 13, { duration: 1 });
            perbaruiTitikLokasi(lat, lng, false);
        }
    }

    function bersihkanCariHutan() {
        const input = document.getElementById('input-cari-hutan');
        const hasilBox = document.getElementById('hasil-cari-hutan');
        const btnBersihkan = document.getElementById('btn-bersihkan-hutan');

        if (input) {
            input.value = '';
            input.focus();
        }
        if (hasilBox) {
            hasilBox.innerHTML = '';
            hasilBox.classList.add('hidden');
        }
        if (btnBersihkan) btnBersihkan.classList.add('hidden');
    }

    function previewFoto(input) {
        const placeholder = document.getElementById('foto-placeholder');
        const previewBox = document.getElementById('foto-preview-box');
        const fileNameSpan = document.getElementById('foto-file-name');

        if (input.files && input.files[0]) {
            if (placeholder) placeholder.classList.add('hidden');
            if (previewBox) previewBox.classList.remove('hidden');
            if (fileNameSpan) fileNameSpan.innerText = input.files[0].name;
        }
    }

    function hapusFoto(e) {
        if (e && e.stopPropagation) e.stopPropagation();
        const input = document.getElementById('foto');
        if (input) input.value = '';
        const placeholder = document.getElementById('foto-placeholder');
        const previewBox = document.getElementById('foto-preview-box');
        if (placeholder) placeholder.classList.remove('hidden');
        if (previewBox) previewBox.classList.add('hidden');
    }

    function siapkanPetaLapor() {
        if (petaLapor) {
            petaLapor.invalidateSize();
            return;
        }
        petaLapor = petaDasar('map-lapor', PETA_PENGATURAN.zoomAwal);

        // Tambahkan batas poligon kawasan hutan ke peta lapor
        const layerKawasanLapor = L.featureGroup().addTo(petaLapor);
        DB_KAWASAN.forEach(hutan => {
            if (hutan.geojson) {
                try {
                    const geoData = typeof hutan.geojson === 'string' ? JSON.parse(hutan.geojson) : hutan.geojson;
                    const layer = L.geoJSON(geoData, {
                        style: {
                            color: '#15803d',
                            weight: 1.5,
                            fillColor: '#22c55e',
                            fillOpacity: 0.18
                        }
                    });

                    layer.on('click', e => {
                        L.DomEvent.stopPropagation(e);
                        perbaruiTitikLokasi(e.latlng.lat, e.latlng.lng, false);
                        const inputHutan = document.getElementById('input-cari-hutan');
                        if (inputHutan) inputHutan.value = hutan.nama;
                    });

                    layer.bindTooltip(hutan.nama, { sticky: true, className: 'text-[11px] font-sans' });
                    layerKawasanLapor.addLayer(layer);
                } catch (err) {}
            }
        });

        petaLapor.on('click', e => {
            perbaruiTitikLokasi(e.latlng.lat, e.latlng.lng);
        });

        // Hubungkan event search input hutan
        const inputCari = document.getElementById('input-cari-hutan');
        if (inputCari) {
            inputCari.addEventListener('input', function() {
                cariKawasanHutan(this.value);
            });
            document.addEventListener('click', e => {
                const hasilBox = document.getElementById('hasil-cari-hutan');
                if (hasilBox && !inputCari.contains(e.target) && !hasilBox.contains(e.target)) {
                    hasilBox.classList.add('hidden');
                }
            });
        }

        // Counter karakter deskripsi
        const descInput = document.getElementById('deskripsi');
        const charCount = document.getElementById('char-count');
        if (descInput && charCount) {
            charCount.innerText = descInput.value.length + ' / 1000';
            descInput.addEventListener('input', function() {
                charCount.innerText = this.value.length + ' / 1000';
            });
        }
    }

    /* ===== TAB PUSAT INFORMASI ===== */
    function bukaTab(n) {
        document.getElementById('panel-kabar').hidden = (n !== 'kabar');
        document.getElementById('panel-tips').hidden = (n !== 'tips');
        const on = 'flex-1 py-3 text-sm font-bold rounded-md bg-white shadow text-gray-900';
        const off = 'flex-1 py-3 text-sm font-bold rounded-md text-gray-500 hover:text-gray-900';
        document.getElementById('tab-kabar').className = (n === 'kabar' ? on : off);
        document.getElementById('tab-tips').className = (n === 'tips' ? on : off);
    }

    /* ===== CEK STATUS LAPORAN AJAX ===== */
    function getJSON(k) { try { return JSON.parse(localStorage.getItem(k) || '[]'); } catch (e) { return []; } }
    function setJSON(k, v) { try { localStorage.setItem(k, JSON.stringify(v)); return true; } catch (e) { return false; } }

    function tampilRiwayat() {
        const box = document.getElementById('riwayat-kode');
        if (!box) return;
        box.innerHTML = '';
        const list = getJSON('jhd-riwayat');
        if (!list.length) {
            box.innerHTML = '<span class="text-xs text-gray-400">Belum ada riwayat pengiriman di peramban ini.</span>';
            return;
        }
        list.forEach(kode => {
            const b = document.createElement('button');
            b.type = 'button';
            b.className = 'bg-gray-100 text-gray-700 px-3 py-1 rounded text-xs font-bold hover:bg-gray-200 border border-gray-200 font-mono';
            b.textContent = kode;
            b.onclick = () => {
                document.getElementById('kode-input').value = kode;
                document.getElementById('cek-form').dispatchEvent(new Event('submit'));
            };
            box.appendChild(b);
        });
    }

    let kodeAktif = '';
    function salinKode() {
        if (!kodeAktif) return;
        navigator.clipboard.writeText(kodeAktif).then(() => {
            alert('Kode laporan ' + kodeAktif + ' berhasil disalin ke clipboard!');
        });
    }

    function handleCekStatus(e) {
        e.preventDefault();
        const kode = (document.getElementById('kode-input')?.value || '').trim().toUpperCase();
        const res = document.getElementById('hasil-status');
        if (!kode || !res) return;

        res.innerHTML = '<div class="p-4 text-sm text-gray-500 flex items-center gap-2"><i class="fa-solid fa-spinner fa-spin"></i> Mencari laporan...</div>';

        fetch(`{{ url('/lapor/status') }}?kode=${encodeURIComponent(kode)}`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.found && data.laporan) {
                const l = data.laporan;
                const statusColor = {
                    'Baru': 'bg-red-100 text-red-800 border-red-300',
                    'Diverifikasi': 'bg-amber-100 text-amber-800 border-amber-300',
                    'Ditangani': 'bg-blue-100 text-blue-800 border-blue-300',
                    'Selesai': 'bg-emerald-100 text-emerald-800 border-emerald-300'
                }[l.status] || 'bg-gray-100 text-gray-800 border-gray-300';

                res.innerHTML = `
                <div class="bg-white border border-emerald-200 rounded-xl p-5 shadow-sm text-sm space-y-3 mt-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 flex-wrap gap-2">
                        <div>
                            <span class="text-xs text-gray-400 block">Nomor Tiket / Kode</span>
                            <span class="font-mono font-black text-lg text-emerald-950">${esc(l.kode)}</span>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold border ${statusColor}">${esc(l.status)}</span>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-2 text-xs">
                        <div><strong class="text-gray-500">Jenis Insiden:</strong> <span class="font-semibold text-gray-800">${esc(l.jenis)}</span></div>
                        <div><strong class="text-gray-500">Waktu Masuk:</strong> <span class="text-gray-800">${esc(l.created_at)}</span></div>
                    </div>
                    <div class="text-xs bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <strong class="text-gray-600 block mb-1">Deskripsi Kejadian:</strong>
                        <p class="text-gray-700 leading-relaxed">${esc(l.deskripsi)}</p>
                    </div>
                    ${l.catatan_admin ? `
                        <div class="text-xs bg-emerald-50 p-3 rounded-lg border border-emerald-200 text-emerald-900">
                            <strong class="block mb-1 font-bold"><i class="fa-solid fa-headset mr-1"></i> Catatan Tindakan Petugas / Admin:</strong>
                            <p>${esc(l.catatan_admin)}</p>
                        </div>
                    ` : '<p class="text-xs text-gray-400 italic">Belum ada catatan tindak lanjut dari petugas lapangan.</p>'}
                </div>`;
            } else {
                res.innerHTML = `<div class="bg-red-50 text-red-700 p-4 rounded-lg text-sm border border-red-200 mt-4"><i class="fa-solid fa-circle-exclamation mr-1.5"></i> Kode laporan <b>${esc(kode)}</b> tidak ditemukan di dalam sistem. Pastikan kode diketik dengan benar.</div>`;
            }
        })
        .catch(err => {
            res.innerHTML = `<div class="bg-red-50 text-red-700 p-4 rounded-lg text-sm border border-red-200 mt-4">Terjadi gangguan koneksi saat mencari laporan. Silakan coba kembali.</div>`;
        });
    }

    /* ===== SCROLL & FOKUS KE FIELD YANG BELUM DIISI ===== */
    function sorotField(el) {
        if (!el) return;
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => {
            try { el.focus(); } catch (e) {}
        }, 350);

        el.classList.add('ring-4', 'ring-rose-400', 'border-rose-500');
        const bersihkan = () => {
            el.classList.remove('ring-4', 'ring-rose-400', 'border-rose-500');
            el.removeEventListener('input', bersihkan);
            el.removeEventListener('change', bersihkan);
        };
        el.addEventListener('input', bersihkan);
        el.addEventListener('change', bersihkan);
        setTimeout(bersihkan, 5000);
    }

    function fokusKeFieldBelumDiisi(fieldKey = null) {
        // 1. Jika koordinat lokasi belum ditentukan
        if (fieldKey === 'latitude' || fieldKey === 'longitude') {
            const mapBox = document.getElementById('map-lapor');
            const wrap = mapBox ? (mapBox.closest('.rounded-2xl') || mapBox) : null;
            if (wrap) {
                wrap.scrollIntoView({ behavior: 'smooth', block: 'center' });
                wrap.classList.add('ring-4', 'ring-rose-400', 'border-rose-500');
                setTimeout(() => {
                    wrap.classList.remove('ring-4', 'ring-rose-400', 'border-rose-500');
                }, 5000);
            }
            const labelStatus = document.getElementById('label-status-lokasi');
            if (labelStatus) {
                labelStatus.innerHTML = '<span class="text-rose-600 font-bold animate-pulse"><i class="fa-solid fa-triangle-exclamation mr-1.5"></i> Wajib tentukan titik lokasi kejadian pada peta!</span>';
            }
            return;
        }

        // 2. Jika ada fieldKey tertentu dari respons validasi
        if (fieldKey) {
            const target = document.getElementById(fieldKey) || document.querySelector(`[name="${fieldKey}"]`);
            if (target) {
                sorotField(target);
                return;
            }
        }

        // 3. Cek apakah koordinat peta masih kosong
        const latVal = document.getElementById('latitude')?.value;
        const lngVal = document.getElementById('longitude')?.value;
        if (!latVal || !lngVal) {
            fokusKeFieldBelumDiisi('latitude');
            return;
        }

        // 4. Cari input/select/textarea yang kosong di dalam form yang aktif
        const form = document.getElementById('lapor-form');
        if (!form) return;

        const inputs = form.querySelectorAll('input:not([type="hidden"]), select, textarea');
        for (let el of inputs) {
            if (el.closest('.hidden')) continue;
            if (el.hasAttribute('required') && (!el.value || el.value.trim() === '')) {
                sorotField(el);
                return;
            }
        }
    }

    /* ===== KIRIM FORM LAPORAN AJAX ===== */
    function handleKirimLaporan(e) {
        e.preventDefault();
        const form = document.getElementById('lapor-form');
        const submitBtn = document.getElementById('btn-submit-lapor');

        // Validasi awal di browser sebelum kirim: titik lokasi di peta
        const latVal = document.getElementById('latitude')?.value;
        const lngVal = document.getElementById('longitude')?.value;
        if (!latVal || !lngVal) {
            alert('Titik lokasi kejadian pada peta belum ditentukan. Silakan klik pada peta.');
            fokusKeFieldBelumDiisi('latitude');
            return;
        }

        // Validasi awal di browser: field required yang masih kosong
        const inputs = form.querySelectorAll('input:not([type="hidden"]), select, textarea');
        for (let el of inputs) {
            if (el.closest('.hidden')) continue;
            if (el.hasAttribute('required') && (!el.value || el.value.trim() === '')) {
                const label = el.closest('div')?.querySelector('label')?.innerText?.replace('*', '').trim() || 'Field ini';
                alert(label + ' wajib diisi.');
                sorotField(el);
                return;
            }
        }

        // Validasi nomor WhatsApp / HP hanya boleh angka
        const noHpEl = document.getElementById('no_hp');
        const noHpVal = noHpEl?.value?.trim();
        if (noHpVal) {
            if (!/^[0-9]+$/.test(noHpVal)) {
                alert('Nomor WhatsApp / HP hanya boleh berisi angka.');
                sorotField(noHpEl);
                return;
            }
            if (noHpVal.length < 8) {
                alert('Nomor WhatsApp / HP minimal 8 digit angka.');
                sorotField(noHpEl);
                return;
            }
        }

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Mengirim Laporan ke Satgas...';

        const formData = new FormData(form);

        fetch('{{ route("lapor.simpan") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(r => r.json().then(data => ({ status: r.status, ok: r.ok, data })))
        .then(({ status, ok, data }) => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span>Kirim Laporan Resmi</span> <i class="fa-solid fa-paper-plane text-sm"></i>';

            if (ok && data.sukses && data.kode) {
                kodeAktif = data.kode;
                const r = getJSON('jhd-riwayat');
                if (!r.includes(kodeAktif)) {
                    r.unshift(kodeAktif);
                    setJSON('jhd-riwayat', r);
                }

                document.getElementById('sukses').hidden = false;
                document.getElementById('kode-besar').textContent = kodeAktif;
                form.reset();
                if (penandaLapor && petaLapor) petaLapor.removeLayer(penandaLapor);
                document.getElementById('sukses').scrollIntoView({ behavior: 'smooth' });
                tampilRiwayat();
            } else {
                let pesanError = data.pesan || '';
                let firstErrorKey = null;

                if (data.errors && typeof data.errors === 'object') {
                    const keys = Object.keys(data.errors);
                    if (keys.length > 0) {
                        firstErrorKey = keys[0];
                        const errList = data.errors[firstErrorKey];
                        if (Array.isArray(errList) && errList.length > 0) {
                            pesanError = errList[0];
                        }
                    }
                }

                if (!pesanError && data.message) {
                    pesanError = data.message;
                }
                if (!pesanError) {
                    pesanError = 'Gagal mengirim laporan. Periksa kelengkapan form.';
                }

                alert(pesanError);
                fokusKeFieldBelumDiisi(firstErrorKey);
            }
        })
        .catch(err => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span>Kirim Laporan Resmi</span> <i class="fa-solid fa-paper-plane text-sm"></i>';
            alert('Terjadi kesalahan pengiriman. Silakan periksa jaringan Anda.');
        });
    }

    /* ===== INISIALISASI HALAMAN ===== */
    document.addEventListener('DOMContentLoaded', () => {
        renderBerandaBerita();
        bangunHalaman('flora');
        bangunHalaman('fauna');
        pilihJenis('Kebakaran');
        
        let initialView = ACTIVE_INITIAL_VIEW;
        if (!initialView || initialView === 'beranda') {
            const p = window.location.pathname;
            if (p.includes('/peta')) initialView = 'peta';
            else if (p.includes('/tumbuhan')) initialView = 'flora';
            else if (p.includes('/primata')) initialView = 'fauna';
            else if (p.includes('/info')) initialView = 'info';
            else if (p.includes('/status')) initialView = 'cek-status';
            else if (p.includes('/lapor')) initialView = 'lapor';
        }
        bukaView(initialView, false);
    });
</script>
@endsection
