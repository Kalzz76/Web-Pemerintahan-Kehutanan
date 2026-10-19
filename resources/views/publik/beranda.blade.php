@extends('layouts.publik')

@section('title', 'Beranda')

@section('content')
<section class="bg-gradient-to-r from-green-950 via-green-900 to-stone-900 text-white py-16 md:py-24 px-4 sm:px-6 lg:px-8 shadow-inner">
    <div class="max-w-7xl mx-auto">
        <div class="max-w-3xl">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-800 text-green-200 border border-green-700 mb-6">
                <i class="fa-solid fa-shield-halved mr-2"></i> Sistem Siaga dan Konservasi Desa
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight leading-tight mb-6">
                {{ $pengaturan->slogan ?? 'Bersama Menjaga Rimba, Demi Kelestarian Desa' }}
            </h1>
            <p class="text-stone-300 text-base md:text-lg leading-relaxed mb-8">
                {{ $pengaturan->deskripsi_singkat ?? 'Sistem tanggap cepat laporan warga, pantauan perambatan kebakaran hutan, perlindungan satwa primata terancam, dan edukasi keanekaragaman hayati desa.' }}
            </p>

            <div class="flex flex-col sm:flex-row gap-4 pt-2">
                <a href="{{ Route::has('lapor') ? route('lapor', ['jenis' => 'Kebakaran']) : url('/lapor?jenis=Kebakaran') }}" class="inline-flex items-center justify-center px-6 py-4 bg-red-600 hover:bg-red-500 text-white font-bold rounded-2xl shadow-xl transition transform active:scale-95 text-base group">
                    <i class="fa-solid fa-fire-flame-curved text-xl mr-3 group-hover:scale-110 transition"></i>
                    <span>Lapor Kebakaran</span>
                </a>
                <a href="{{ Route::has('lapor') ? route('lapor', ['jenis' => 'Hewan Masuk Kampung']) : url('/lapor?jenis=Hewan Masuk Kampung') }}" class="inline-flex items-center justify-center px-6 py-4 bg-amber-600 hover:bg-amber-500 text-white font-bold rounded-2xl shadow-xl transition transform active:scale-95 text-base group">
                    <i class="fa-solid fa-paw text-xl mr-3 group-hover:scale-110 transition"></i>
                    <span>Lapor Hewan Masuk Kampung</span>
                </a>
            </div>
        </div>
    </div>
</section>

@if ($peringatanPublik)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20">
    <div class="bg-rose-600 text-white rounded-3xl p-6 sm:p-8 shadow-2xl border-2 border-rose-400">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-start space-x-4">
                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center text-2xl shrink-0">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <div class="inline-block px-2.5 py-0.5 rounded-full text-xs font-black bg-white text-rose-700 uppercase tracking-wider mb-1">
                        Peringatan Aktif
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black">Peringatan Area Terancam Perambatan Api</h2>
                    <p class="text-rose-100 text-sm mt-1">
                        Ditemukan indikasi rambatan kebakaran aktif. Segera cek jalur evakuasi dan perhatikan arahan satgas.
                    </p>
                </div>
            </div>
            <div class="shrink-0">
                <a href="{{ Route::has('peringatan') ? route('peringatan') : url('/peringatan') }}" class="inline-flex items-center px-6 py-3.5 bg-white hover:bg-rose-50 text-rose-700 font-extrabold rounded-xl shadow transition text-sm">
                    <span>Lihat Peta Peringatan</span>
                    <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endif

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-6 flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 bg-green-50 text-green-700 rounded-xl flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-mountain-sun"></i>
                </div>
                <div class="text-3xl font-black text-stone-900 mb-1">{{ $totalKawasan }}</div>
                <div class="text-xs font-bold text-stone-500 uppercase tracking-wider">Kawasan Hutan</div>
            </div>
            <a href="{{ Route::has('peta') ? route('peta') : url('/peta') }}" class="text-xs font-semibold text-green-700 hover:text-green-800 mt-4 inline-flex items-center">
                <span>Buka Peta</span>
                <i class="fa-solid fa-chevron-right ml-1 text-[10px]"></i>
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-6 flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 bg-amber-50 text-amber-700 rounded-xl flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-paw"></i>
                </div>
                <div class="text-3xl font-black text-stone-900 mb-1">{{ $totalPrimata }}</div>
                <div class="text-xs font-bold text-stone-500 uppercase tracking-wider">Satwa Primata</div>
            </div>
            <a href="{{ Route::has('primata') ? route('primata') : url('/primata') }}" class="text-xs font-semibold text-amber-700 hover:text-amber-800 mt-4 inline-flex items-center">
                <span>Lihat Katalog</span>
                <i class="fa-solid fa-chevron-right ml-1 text-[10px]"></i>
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-6 flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 bg-emerald-50 text-emerald-700 rounded-xl flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-seedling"></i>
                </div>
                <div class="text-3xl font-black text-stone-900 mb-1">{{ $totalTumbuhan }}</div>
                <div class="text-xs font-bold text-stone-500 uppercase tracking-wider">Tumbuhan Rimba</div>
            </div>
            <a href="{{ Route::has('tumbuhan') ? route('tumbuhan') : url('/tumbuhan') }}" class="text-xs font-semibold text-emerald-700 hover:text-emerald-800 mt-4 inline-flex items-center">
                <span>Lihat Tumbuhan</span>
                <i class="fa-solid fa-chevron-right ml-1 text-[10px]"></i>
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-6 flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 bg-sky-50 text-sky-700 rounded-xl flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="text-3xl font-black text-stone-900 mb-1">{{ $totalLaporanSelesai }}</div>
                <div class="text-xs font-bold text-stone-500 uppercase tracking-wider">Laporan Ditangani</div>
            </div>
            <a href="{{ Route::has('lapor.status') ? route('lapor.status') : url('/lapor/status') }}" class="text-xs font-semibold text-sky-700 hover:text-sky-800 mt-4 inline-flex items-center">
                <span>Cek Status</span>
                <i class="fa-solid fa-chevron-right ml-1 text-[10px]"></i>
            </a>
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-black text-stone-900 tracking-tight">Kabar dan Pengumuman Desa</h2>
            <p class="text-stone-500 text-sm mt-1">Informasi terkini mengenai kondisi kawasan hutan dan kegiatan warga.</p>
        </div>
        <a href="{{ Route::has('info') ? route('info') : url('/info') }}" class="hidden sm:inline-flex items-center text-sm font-bold text-green-700 hover:text-green-800">
            <span>Lihat Semua Kabar</span>
            <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse ($pengumumanTerbaru as $pengumuman)
            <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-6 flex flex-col justify-between hover:shadow-md transition">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                            {{ $pengumuman->kategori }}
                        </span>
                        <span class="text-xs text-stone-400">
                            {{ \Carbon\Carbon::parse($pengumuman->tanggal)->locale('id')->isoFormat('D MMMM Y') }}
                        </span>
                    </div>
                    <h3 class="font-bold text-stone-900 text-base mb-3 leading-snug">
                        {{ $pengumuman->judul }}
                    </h3>
                    <p class="text-stone-600 text-xs line-clamp-3 leading-relaxed mb-4">
                        {{ $pengumuman->isi }}
                    </p>
                </div>
                <div class="pt-4 border-t border-stone-100 flex items-center justify-between">
                    <span class="text-[11px] text-stone-400">Oleh Admin Satgas</span>
                    <a href="{{ Route::has('info.detail') ? route('info.detail', $pengumuman->id) : url('/info/' . $pengumuman->id) }}" class="text-xs font-semibold text-green-700 hover:text-green-800 inline-flex items-center">
                        <span>Baca Selengkapnya</span>
                        <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white rounded-2xl p-12 text-center text-stone-400 border border-stone-100">
                <i class="fa-solid fa-bullhorn text-4xl mb-3 text-stone-300"></i>
                <p class="text-sm">Belum ada pengumuman yang diterbitkan.</p>
            </div>
        @endforelse
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    <div class="bg-stone-900 text-white rounded-3xl p-8 sm:p-10 shadow-xl">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8">
            <div class="max-w-xl">
                <span class="text-xs font-bold uppercase tracking-wider text-green-400 mb-2 block">Layanan Cepat Tanggap</span>
                <h2 class="text-2xl font-black text-white mb-2">Kontak Darurat Siaga 24 Jam</h2>
                <p class="text-stone-400 text-xs sm:text-sm leading-relaxed">
                    Jika Anda menemukan situasi gawat darurat kebakaran hutan atau ancaman satwa berbahaya yang mendesak, segera hubungi petugas melalui nomor di bawah ini.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($kontakDarurat as $kontak)
                    <div class="bg-stone-800/80 rounded-2xl p-4 border border-stone-700/60 flex items-center justify-between">
                        <div>
                            <div class="text-xs font-bold text-stone-200">{{ $kontak->nama }}</div>
                            <div class="text-[11px] text-stone-400">{{ $kontak->instansi }}</div>
                        </div>
                        <a href="tel:{{ $kontak->nomor_telepon }}" class="ml-4 px-3.5 py-2 rounded-xl bg-red-600 hover:bg-red-500 text-white font-mono font-bold text-xs flex items-center space-x-1.5 shadow transition">
                            <i class="fa-solid fa-phone text-[10px]"></i>
                            <span>{{ $kontak->nomor_telepon }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
