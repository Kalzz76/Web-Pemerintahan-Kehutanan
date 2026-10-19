@extends('layouts.publik')

@section('title', 'Pusat Informasi Hutan & Layanan Siaga')

@section('content')
<div class="bg-stone-50 py-10 px-4 sm:px-6 lg:px-8 min-h-[calc(100vh-80px)]">
    <div class="max-w-7xl mx-auto space-y-12">
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <div class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                <i class="fa-solid fa-bullhorn mr-1.5"></i> Informasi, Patroli & Kontak Siaga
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-stone-900 tracking-tight">Pusat Informasi Hutan Desa</h1>
            <p class="text-stone-600 text-sm sm:text-base leading-relaxed">
                Akses berita resmi kawasan, jadwal patroli tim siaga desa, tips pencegahan karhutla, dan direktori nomor darurat terpadu.
            </p>
        </div>

        <section class="space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-stone-200 pb-4">
                <div>
                    <h2 class="text-xl sm:text-2xl font-black text-stone-900">Kabar Hutan & Pengumuman</h2>
                    <p class="text-xs sm:text-sm text-stone-500 mt-0.5">Warta terkini dan himbauan keselamatan kawasan</p>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('info') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ empty($kategori) ? 'bg-green-700 text-white shadow-sm' : 'bg-white text-stone-700 hover:bg-stone-100 border border-stone-200' }}">
                        Semua
                    </a>
                    <a href="{{ route('info', ['kategori' => 'Pengumuman']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ ($kategori ?? '') == 'Pengumuman' ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-stone-700 hover:bg-stone-100 border border-stone-200' }}">
                        Pengumuman
                    </a>
                    <a href="{{ route('info', ['kategori' => 'Tips Keselamatan']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ ($kategori ?? '') == 'Tips Keselamatan' ? 'bg-amber-600 text-white shadow-sm' : 'bg-white text-stone-700 hover:bg-stone-100 border border-stone-200' }}">
                        Tips Keselamatan
                    </a>
                    <a href="{{ route('info', ['kategori' => 'Kabar']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ ($kategori ?? '') == 'Kabar' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-stone-700 hover:bg-stone-100 border border-stone-200' }}">
                        Kabar
                    </a>
                </div>
            </div>

            @if ($daftarPengumuman->isEmpty())
                <div class="bg-white rounded-3xl p-10 text-center border border-stone-200 shadow-sm max-w-md mx-auto">
                    <i class="fa-solid fa-newspaper text-3xl text-stone-300 mb-2 block"></i>
                    <p class="text-stone-500 text-sm font-semibold">Belum ada warta dalam kategori ini.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($daftarPengumuman as $pengumuman)
                        <div class="bg-white rounded-3xl border border-stone-200 shadow-sm overflow-hidden flex flex-col justify-between group hover:shadow-md transition">
                            <div>
                                @if ($pengumuman->gambar)
                                    <div class="h-44 bg-stone-100 overflow-hidden">
                                        <img src="{{ asset('storage/' . $pengumuman->gambar) }}" alt="{{ $pengumuman->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    </div>
                                @endif

                                <div class="p-6 space-y-3">
                                    <div class="flex items-center justify-between">
                                        @if ($pengumuman->kategori == 'Tips Keselamatan')
                                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-amber-100 text-amber-800">
                                                Tips Keselamatan
                                            </span>
                                        @elseif ($pengumuman->kategori == 'Pengumuman')
                                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-blue-100 text-blue-800">
                                                Pengumuman
                                            </span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-emerald-100 text-emerald-800">
                                                Kabar
                                            </span>
                                        @endif

                                        <span class="text-xs text-stone-400 font-medium">
                                            {{ $pengumuman->tanggal ? $pengumuman->tanggal->format('d M Y') : '' }}
                                        </span>
                                    </div>

                                    <h3 class="text-base font-black text-stone-900 group-hover:text-green-700 transition leading-snug">
                                        {{ $pengumuman->judul }}
                                    </h3>

                                    <p class="text-xs text-stone-600 leading-relaxed whitespace-pre-line line-clamp-4">
                                        {{ $pengumuman->isi }}
                                    </p>
                                </div>
                            </div>

                            <div class="p-6 pt-0">
                                <button type="button"
                                    onclick="bukaModalBaca(this)"
                                    data-judul="{{ $pengumuman->judul }}"
                                    data-kategori="{{ $pengumuman->kategori }}"
                                    data-tanggal="{{ $pengumuman->tanggal ? $pengumuman->tanggal->format('d F Y') : '' }}"
                                    data-isi="{{ $pengumuman->isi }}"
                                    data-gambar="{{ $pengumuman->gambar ? asset('storage/' . $pengumuman->gambar) : '' }}"
                                    class="w-full py-2 bg-stone-100 hover:bg-stone-200 text-stone-800 text-xs font-bold rounded-xl transition text-center">
                                    Baca Selengkapnya
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($daftarPengumuman->hasPages())
                    <div class="pt-4">
                        {{ $daftarPengumuman->links() }}
                    </div>
                @endif
            @endif
        </section>

        <section class="space-y-6">
            <div class="border-b border-stone-200 pb-4">
                <h2 class="text-xl sm:text-2xl font-black text-stone-900">Jadwal Patroli Hutan Siaga</h2>
                <p class="text-xs sm:text-sm text-stone-500 mt-0.5">Rencana pemantauan lapangan oleh satgas desa</p>
            </div>

            @if ($jadwalPatroli->isEmpty())
                <div class="bg-white rounded-3xl p-8 text-center border border-stone-200 shadow-sm max-w-md mx-auto">
                    <i class="fa-solid fa-calendar-check text-3xl text-emerald-400 mb-2 block"></i>
                    <p class="text-stone-700 text-sm font-bold">Tidak ada agenda patroli mendatang saat ini.</p>
                    <p class="text-stone-400 text-xs mt-1">Pemantauan tetap dilakukan melalui pos pantau jaga desa.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($jadwalPatroli as $patroli)
                        <div class="bg-white rounded-3xl p-6 border border-stone-200 shadow-sm flex items-start space-x-4">
                            <div class="w-14 h-14 rounded-2xl bg-green-50 text-green-700 border border-green-100 flex flex-col items-center justify-center shrink-0">
                                <span class="text-xs uppercase font-extrabold">{{ $patroli->tanggal ? $patroli->tanggal->format('M') : '' }}</span>
                                <span class="text-lg font-black leading-none">{{ $patroli->tanggal ? $patroli->tanggal->format('d') : '' }}</span>
                            </div>
                            <div class="min-w-0 flex-1 space-y-1">
                                <h3 class="text-sm font-bold text-stone-900 truncate">{{ $patroli->judul }}</h3>
                                <div class="text-xs text-stone-500 flex items-center">
                                    <i class="fa-solid fa-clock text-stone-400 mr-1.5 text-[10px]"></i>
                                    <span>{{ $patroli->jam }}</span>
                                </div>
                                <div class="text-xs font-semibold text-rose-600 flex items-center">
                                    <i class="fa-solid fa-location-dot mr-1.5 text-[10px]"></i>
                                    <span class="truncate">{{ $patroli->lokasi }}</span>
                                </div>
                                @if ($patroli->keterangan)
                                    <p class="text-[11px] text-stone-500 pt-1 border-t border-stone-100 leading-relaxed">
                                        {{ $patroli->keterangan }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <section id="kontak-darurat" class="space-y-6">
            <div class="border-b border-stone-200 pb-4">
                <h2 class="text-xl sm:text-2xl font-black text-stone-900">Daftar Kontak Darurat</h2>
                <p class="text-xs sm:text-sm text-stone-500 mt-0.5">Nomor posko siaga dan instansi penanganan tanggap darurat</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($kontakDarurat as $kontak)
                    <div class="bg-white rounded-2xl p-5 border border-stone-200 shadow-sm flex items-center justify-between">
                        <div class="min-w-0 pr-3">
                            <h3 class="text-sm font-bold text-stone-900 truncate">{{ $kontak->nama }}</h3>
                            <p class="text-xs text-stone-500 font-medium">{{ $kontak->instansi }}</p>
                            @if ($kontak->keterangan)
                                <p class="text-[11px] text-amber-700 mt-0.5">{{ $kontak->keterangan }}</p>
                            @endif
                        </div>
                        <a href="tel:{{ $kontak->nomor_telepon }}" class="inline-flex items-center px-4 py-2.5 bg-rose-600 hover:bg-rose-500 text-white rounded-xl text-xs font-bold shadow transition shrink-0">
                            <i class="fa-solid fa-phone mr-1.5"></i> Hubungi
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</div>

<div id="modal-baca" class="fixed inset-0 z-50 hidden overflow-y-auto bg-stone-900/60 backdrop-blur-sm p-4 sm:p-6 flex items-center justify-center">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl space-y-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-stone-100 pb-4">
            <span id="baca-kategori" class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800"></span>
            <button type="button" onclick="tutupModalBaca()" class="w-8 h-8 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-600 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="space-y-3">
            <h2 id="baca-judul" class="text-xl sm:text-2xl font-black text-stone-900 leading-snug"></h2>
            <div id="baca-tanggal" class="text-xs text-stone-400 font-medium"></div>
        </div>

        <div id="baca-gambar-wadah" class="hidden rounded-2xl overflow-hidden max-h-72">
            <img id="baca-gambar" src="" alt="Gambar Pengumuman" class="w-full h-full object-cover">
        </div>

        <div id="baca-isi" class="text-stone-700 text-sm leading-relaxed whitespace-pre-line"></div>

        <div class="pt-4 border-t border-stone-100 text-right">
            <button type="button" onclick="tutupModalBaca()" class="px-5 py-2.5 bg-stone-900 hover:bg-stone-800 text-white font-bold rounded-xl text-xs transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    var modalBaca = document.getElementById('modal-baca');

    function bukaModalBaca(el) {
        var judul = el.getAttribute('data-judul');
        var kategori = el.getAttribute('data-kategori');
        var tanggal = el.getAttribute('data-tanggal');
        var isi = el.getAttribute('data-isi');
        var gambar = el.getAttribute('data-gambar');

        document.getElementById('baca-judul').textContent = judul;
        document.getElementById('baca-kategori').textContent = kategori;
        document.getElementById('baca-tanggal').textContent = tanggal;
        document.getElementById('baca-isi').textContent = isi;

        var wadahGambar = document.getElementById('baca-gambar-wadah');
        var img = document.getElementById('baca-gambar');
        if (gambar) {
            img.src = gambar;
            wadahGambar.classList.remove('hidden');
        } else {
            wadahGambar.classList.add('hidden');
            img.src = '';
        }

        modalBaca.classList.remove('hidden');
    }

    function tutupModalBaca() {
        modalBaca.classList.add('hidden');
    }
</script>
@endsection
