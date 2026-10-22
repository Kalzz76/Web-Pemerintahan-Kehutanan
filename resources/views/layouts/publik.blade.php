<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $pengaturanGlobal = \App\Models\PengaturanHutan::first();
        $kontakDaruratFooter = \App\Models\KontakDarurat::orderBy('urutan')->take(6)->get();
    @endphp
    <title>@yield('title', 'Jaga Hutan Desa — Provinsi Jawa Barat') - {{ $pengaturanGlobal->nama_aplikasi ?? 'Jaga Hutan Desa' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Logo_Kementerian_Kehutanan.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Josefin+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                        josefin: ['Josefin Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #fff;
            color: #1f2937;
            margin: 0;
            overflow-x: hidden;
        }

        .font-serif-elegant {
            font-family: 'Playfair Display', serif;
        }

        .font-josefin {
            font-family: 'Josefin Sans', 'Inter', sans-serif;
        }

        [hidden] {
            display: none !important;
        }

        .card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
            border: 1px solid #f3f4f6;
            overflow: hidden;
            transition: transform .3s, box-shadow .3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-static:hover {
            transform: none;
        }

        .field {
            width: 100%;
            padding: .75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: .5rem;
            outline: none;
            transition: border .3s;
            background: #fff;
        }

        .field:focus {
            border-color: #059669;
        }

        .map {
            height: 480px;
            z-index: 1;
            border-radius: 1rem;
            overflow: hidden;
            isolation: isolate;
        }

        .mini-map {
            height: 250px;
            z-index: 1;
            border-radius: .5rem;
            overflow: hidden;
            isolation: isolate;
        }

        /* Isolasi total elemen peta Leaflet publik agar tidak menimpa header dan modal */
        .leaflet-container:not(.wadah-peta-fullscreen .leaflet-container),
        [id^="peta-"]:not(.wadah-peta-fullscreen [id^="peta-"]),
        [id^="map-"]:not(.wadah-peta-fullscreen [id^="map-"]) {
            isolation: isolate !important;
            z-index: 1 !important;
        }

        :not(.wadah-peta-fullscreen) > .leaflet-container {
            isolation: isolate !important;
            z-index: 1 !important;
            overflow: hidden !important;
        }

        .img-fail {
            background: linear-gradient(135deg, #065f46, #14532d);
        }

        .hero-section {
            position: relative;
            min-height: 100vh;
            min-height: 100dvh;
            background-image: url('{{ asset("assets/pemandangan.jpg") }}'), linear-gradient(135deg, #064e3b, #14532d 50%, #0f3d2e);
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(0, 0, 0, .8), rgba(0, 0, 0, .45) 50%, rgba(0, 0, 0, .1));
        }

        @media(max-width:768px) {
            .hero-overlay {
                background: linear-gradient(to bottom, rgba(0, 0, 0, .65), rgba(0, 0, 0, .55));
            }
        }

        .fade {
            animation: rise .5s ease both;
        }

        @keyframes rise {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: none;
            }
        }

        .slide-anim {
            animation: slideEffect .5s cubic-bezier(.25, 1, .5, 1) both;
        }

        @keyframes slideEffect {
            from {
                opacity: 0;
                transform: scale(.97) translateY(8px);
            }
            to {
                opacity: 1;
                transform: none;
            }
        }

        @media(prefers-reduced-motion:reduce) {
            .fade, .slide-anim {
                animation: none;
            }
        }

        .marker-insiden {
            width: 30px;
            height: 30px;
            border-radius: 9999px;
            border: 3px solid #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 13px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .5);
        }

        .marker-insiden.selesai {
            opacity: .55;
        }

        .popup-insiden h4 {
            margin: 0 0 6px;
            font-weight: 800;
            font-size: 14px;
        }

        .popup-insiden table {
            font-size: 12px;
            border-collapse: collapse;
        }

        .popup-insiden td {
            padding: 2px 0;
            vertical-align: top;
        }

        .popup-insiden td:first-child {
            color: #6b7280;
            padding-right: 10px;
            white-space: nowrap;
        }

        .showcase {
            background: radial-gradient(120% 90% at 70% 20%, #0d3a2c, #082f23 45%, #04201a);
        }

        .btn-gold {
            background: #f3c677;
            color: #1a1a1a;
            font-weight: 700;
            font-size: .8rem;
            letter-spacing: .04em;
            text-transform: uppercase;
            padding: .75rem 1.4rem;
            border-radius: .5rem;
            transition: background .2s;
        }

        .btn-gold:hover {
            background: #ffd98f;
        }

        #public-header {
            transition: background-color .3s, box-shadow .3s, color .3s;
        }

        .header-scrolled {
            background: rgba(255, 255, 255, .98) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, .05);
            color: #111827 !important;
        }

        .nav-btn.active {
            color: #34d399 !important;
        }

        .header-scrolled .nav-btn.active {
            color: #059669 !important;
        }

        #menu-mobile .nav-btn.active {
            background-color: #ecfdf5;
            color: #059669 !important;
        }

        .header-scrolled .logo-icon {
            color: #059669 !important;
        }

        .header-scrolled .btn-lapor {
            background: #059669 !important;
            color: #fff !important;
        }

        .header-scrolled .btn-lapor:hover {
            background: #047857 !important;
        }

        .footer-anim-wrapper {
            position: relative;
            width: 100%;
            height: 400px;
            background: #fff;
            overflow: hidden;
        }

        @media(min-width:768px) {
            .footer-anim-wrapper {
                height: 600px;
            }
        }

        .footer-top-smoke {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 200px;
            background: linear-gradient(#fff, rgba(255, 255, 255, .7) 40%, transparent);
            z-index: 10;
            pointer-events: none;
        }

        .footer-anim-bg {
            position: absolute;
            top: -10%;
            left: 0;
            width: 100%;
            height: 120%;
            background-image: url('{{ asset("assets/footer.png") }}'), linear-gradient(#e7f3ec, #2f5d44);
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            z-index: 5;
            will-change: transform;
        }

        .footer-bottom-blend {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 250px;
            background: linear-gradient(to top, #1a2f23, rgba(26, 47, 35, .8) 40%, transparent);
            z-index: 10;
            pointer-events: none;
        }
    </style>
    @yield('styles')
    @livewireStyles
</head>
<body class="w-full relative antialiased selection:bg-emerald-500 selection:text-white">

    <!-- HEADER FLOTAN / STICKY -->
    <header id="public-header" class="fixed top-0 w-full z-[1000] px-6 py-4 text-white {{ !request()->routeIs('beranda') ? 'header-scrolled' : '' }}">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('beranda') }}" onclick="if(typeof bukaView === 'function'){ bukaView('beranda'); return false; }" class="flex items-center gap-3 shrink-0" aria-label="Ke beranda">
                @if ($pengaturanGlobal && $pengaturanGlobal->logo)
                    <img src="{{ asset('storage/' . $pengaturanGlobal->logo) }}" alt="Logo" class="w-8 h-8 object-contain">
                @else
                    <img src="{{ asset('images/Logo_Kementerian_Kehutanan.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                @endif
                <span class="font-bold text-xl tracking-tight leading-tight">{{ $pengaturanGlobal->nama_aplikasi ?? 'Jaga Hutan Desa' }}</span>
            </a>

            <nav class="hidden lg:flex items-center gap-8 text-sm font-semibold">
                <a href="{{ route('beranda') }}" onclick="if(typeof bukaView === 'function'){ bukaView('beranda'); return false; }" class="nav-btn hover:text-emerald-400 transition-colors active" data-view="beranda">Beranda</a>
                <a href="{{ route('peta') }}" onclick="if(typeof bukaView === 'function'){ bukaView('peta'); return false; }" class="nav-btn hover:text-emerald-400 transition-colors" data-view="peta">Peta Kawasan</a>
                <a href="{{ route('tumbuhan') }}" onclick="if(typeof bukaView === 'function'){ bukaView('flora'); return false; }" class="nav-btn hover:text-emerald-400 transition-colors" data-view="flora">Flora</a>
                <a href="{{ route('primata') }}" onclick="if(typeof bukaView === 'function'){ bukaView('fauna'); return false; }" class="nav-btn hover:text-emerald-400 transition-colors" data-view="fauna">Fauna</a>
                <a href="{{ route('info') }}" onclick="if(typeof bukaView === 'function'){ bukaView('info'); return false; }" class="nav-btn hover:text-emerald-400 transition-colors" data-view="info">Pusat Info</a>
                <a href="{{ route('lapor.status') }}" onclick="if(typeof bukaView === 'function'){ bukaView('cek-status'); return false; }" class="nav-btn hover:text-emerald-400 transition-colors" data-view="cek-status">Cek Status</a>
            </nav>

            <div class="hidden lg:flex items-center">
                <a href="{{ route('lapor') }}" onclick="if(typeof bukaView === 'function'){ bukaView('lapor'); return false; }"
                    class="btn-lapor bg-emerald-600 hover:bg-emerald-500 text-white rounded-full px-6 py-2.5 font-bold transition-all shadow-lg flex items-center gap-2">
                    Lapor Darurat <i class="fa-solid fa-arrow-right text-sm"></i>
                </a>
            </div>

            <button id="menu-button"
                onclick="document.getElementById('menu-mobile').hidden=!document.getElementById('menu-mobile').hidden"
                class="lg:hidden p-2 text-white" aria-label="Menu">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
        </div>

        <nav id="menu-mobile" hidden class="lg:hidden bg-white mt-4 rounded-xl p-4 flex flex-col gap-2 absolute left-4 right-4 shadow-2xl text-gray-900 border border-gray-200">
            <a href="{{ route('beranda') }}" onclick="if(typeof bukaView === 'function'){ bukaView('beranda'); return false; }" class="nav-btn text-left p-3 hover:bg-gray-50 rounded-lg font-bold active" data-view="beranda">Beranda</a>
            <a href="{{ route('peta') }}" onclick="if(typeof bukaView === 'function'){ bukaView('peta'); return false; }" class="nav-btn text-left p-3 hover:bg-gray-50 rounded-lg font-bold" data-view="peta">Peta Kawasan</a>
            <a href="{{ route('tumbuhan') }}" onclick="if(typeof bukaView === 'function'){ bukaView('flora'); return false; }" class="nav-btn text-left p-3 hover:bg-gray-50 rounded-lg font-bold" data-view="flora">Flora</a>
            <a href="{{ route('primata') }}" onclick="if(typeof bukaView === 'function'){ bukaView('fauna'); return false; }" class="nav-btn text-left p-3 hover:bg-gray-50 rounded-lg font-bold" data-view="fauna">Fauna</a>
            <a href="{{ route('info') }}" onclick="if(typeof bukaView === 'function'){ bukaView('info'); return false; }" class="nav-btn text-left p-3 hover:bg-gray-50 rounded-lg font-bold" data-view="info">Pusat Info</a>
            <a href="{{ route('lapor.status') }}" onclick="if(typeof bukaView === 'function'){ bukaView('cek-status'); return false; }" class="nav-btn text-left p-3 hover:bg-gray-50 rounded-lg font-bold" data-view="cek-status">Cek Status</a>
            <a href="{{ route('lapor') }}" onclick="if(typeof bukaView === 'function'){ bukaView('lapor'); return false; }" class="mt-2 text-center p-3 bg-emerald-600 text-white font-bold rounded-lg shadow">
                Lapor Darurat
            </a>
        </nav>
    </header>

    <!-- CONTENT WRAPPER -->
    <main id="public-main" class="w-full">
        @yield('content')
    </main>

    <!-- MODAL DETAIL SPESIES (Flora & Fauna) -->
    <div id="modal-spesies"
        class="fixed inset-0 z-[3000] bg-black/80 backdrop-blur-sm flex items-center justify-center p-4" hidden
        onclick="if(event.target===this)tutupDetail()"></div>

    <!-- FOOTER ANIMASI PARALLAX KABUT & RIMBA -->
    <div class="footer-anim-wrapper">
        <div class="footer-top-smoke"></div>
        <div class="footer-anim-bg" id="footer-parallax"></div>
        <div class="footer-bottom-blend"></div>
    </div>
    <footer class="w-full pt-4 pb-12 px-6 relative z-10" style="background:#1a2f23">
        <div class="max-w-7xl mx-auto">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10 text-white">
                <div>
                    <div class="flex items-center gap-3 font-bold text-2xl mb-4 text-white">
                        @if ($pengaturanGlobal && $pengaturanGlobal->logo)
                            <img src="{{ asset('storage/' . $pengaturanGlobal->logo) }}" alt="Logo" class="w-7 h-7 object-contain">
                        @else
                            <img src="{{ asset('images/Logo_Kementerian_Kehutanan.png') }}" alt="Logo" class="w-7 h-7 object-contain">
                        @endif
                        <span>{{ $pengaturanGlobal->nama_aplikasi ?? 'Jaga Hutan Desa' }}</span>
                    </div>
                    <p class="text-sm leading-relaxed text-emerald-100 font-light">
                        {{ $pengaturanGlobal->deskripsi_singkat ?? 'Menjaga ruang hidup, melindungi satwa, dan melestarikan ekosistem hutan Provinsi Jawa Barat untuk generasi mendatang.' }}
                    </p>
                    <p class="text-xs text-emerald-300/80 mt-3">
                        <i class="fa-solid fa-location-dot mr-1.5"></i> {{ $pengaturanGlobal->alamat ?? 'Provinsi Jawa Barat' }}
                    </p>
                    @if ($pengaturanGlobal && $pengaturanGlobal->email)
                    <p class="text-xs text-emerald-300/80 mt-1.5">
                        <a href="mailto:{{ $pengaturanGlobal->email }}" class="hover:text-white transition inline-flex items-center">
                            <i class="fa-solid fa-envelope mr-1.5"></i> {{ $pengaturanGlobal->email }}
                        </a>
                    </p>
                    @endif
                </div>
                <div>
                    <h2 class="font-bold mb-4 uppercase tracking-widest text-sm text-emerald-400">Navigasi Utama</h2>
                    <div class="flex flex-col gap-2 text-sm">
                        <a href="{{ route('peta') }}" onclick="if(typeof bukaView === 'function'){ bukaView('peta'); return false; }" class="text-left hover:text-white text-emerald-100 transition">Peta Kawasan &amp; Titik Api</a>
                        <a href="{{ route('tumbuhan') }}" onclick="if(typeof bukaView === 'function'){ bukaView('flora'); return false; }" class="text-left hover:text-white text-emerald-100 transition">Katalog Flora</a>
                        <a href="{{ route('primata') }}" onclick="if(typeof bukaView === 'function'){ bukaView('fauna'); return false; }" class="text-left hover:text-white text-emerald-100 transition">Katalog Fauna</a>
                        <a href="{{ route('info') }}" onclick="if(typeof bukaView === 'function'){ bukaView('info'); return false; }" class="text-left hover:text-white text-emerald-100 transition">Pusat Informasi</a>
                        <a href="{{ route('peta') }}" onclick="if(typeof bukaView === 'function'){ bukaView('peta'); return false; }" class="text-left hover:text-white text-emerald-100 transition">Pantauan Titik Api</a>
                    </div>
                </div>
                <div id="kontak-darurat" class="scroll-mt-24">
                    <h2 class="font-bold mb-4 uppercase tracking-widest text-sm text-emerald-400">Pusat Bantuan Darurat</h2>
                    <div class="flex flex-col gap-2 text-sm">
                        @if ($kontakDaruratFooter && $kontakDaruratFooter->count() > 0)
                            @foreach ($kontakDaruratFooter as $kontak)
                                <a href="tel:{{ $kontak->nomor_telepon }}" class="hover:text-white text-emerald-100 transition flex items-center justify-between group py-0.5">
                                    <span class="flex items-center gap-2 truncate">
                                        <i class="fa-solid fa-phone text-xs text-emerald-400 shrink-0 group-hover:scale-110 transition"></i>
                                        <span class="truncate">{{ $kontak->nama }}</span>
                                    </span>
                                    <span class="font-mono text-xs font-bold text-emerald-300 ml-2 shrink-0">{{ $kontak->nomor_telepon }}</span>
                                </a>
                            @endforeach
                        @else
                            <a href="tel:112" class="hover:text-white text-emerald-100 transition flex items-center gap-2"><i class="fa-solid fa-phone text-xs text-emerald-400"></i> 112 &middot; Darurat Terpadu</a>
                            <a href="tel:113" class="hover:text-white text-emerald-100 transition flex items-center gap-2"><i class="fa-solid fa-fire-extinguisher text-xs text-emerald-400"></i> 113 &middot; Pemadam Kebakaran</a>
                            <a href="tel:110" class="hover:text-white text-emerald-100 transition flex items-center gap-2"><i class="fa-solid fa-shield-halved text-xs text-emerald-400"></i> 110 &middot; Kepolisian Satgas</a>
                        @endif

                        @if ($pengaturanGlobal && $pengaturanGlobal->telepon)
                            <a href="tel:{{ $pengaturanGlobal->telepon }}" class="hover:text-white text-emerald-100 transition flex items-center justify-between group pt-1 border-t border-emerald-800/60">
                                <span class="flex items-center gap-2 truncate">
                                    <i class="fa-solid fa-headset text-xs text-emerald-400 shrink-0"></i>
                                    <span class="truncate">Posko Resmi</span>
                                </span>
                                <span class="font-mono text-xs font-bold text-emerald-300 ml-2 shrink-0">{{ $pengaturanGlobal->telepon }}</span>
                            </a>
                        @endif
                    </div>
                </div>
                <div>
                    <h2 class="font-bold mb-4 uppercase tracking-widest text-sm text-emerald-400">Aksi Cepat</h2>
                    <p class="text-xs text-emerald-100 mb-4 leading-relaxed">Kirim laporan insiden darurat atau pantau perkembangan laporan Anda secara real-time.</p>
                    <a href="{{ route('lapor') }}" onclick="if(typeof bukaView === 'function'){ bukaView('lapor'); return false; }"
                        class="block text-center w-full bg-emerald-600 text-white py-3 rounded-md font-bold text-sm hover:bg-emerald-500 transition shadow-lg mb-2">
                        Lapor Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center text-xs text-emerald-300 hover:text-white transition mt-2">
                        <i class="fa-solid fa-lock mr-1.5"></i> Portal Petugas / Admin
                    </a>
                </div>
            </div>
            <div class="border-t border-emerald-800/80 mt-10 pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-emerald-400 gap-3">
                <div>&copy; {{ date('Y') }} {{ $pengaturanGlobal->nama_aplikasi ?? 'Jaga Hutan Desa' }} &middot; {{ $pengaturanGlobal->nama_instansi ?? 'Pemerintah Provinsi Jawa Barat' }}</div>
                <div>Portal Informasi Kehutanan, Tanggap Darurat & Konservasi Rimba</div>
            </div>
        </div>
    </footer>

    @include('partials.modal-pesan')

    <script>
        /* PARALLAX FOOTER */
        window.addEventListener('scroll', () => {
            const w = document.querySelector('.footer-anim-wrapper'), bg = document.getElementById('footer-parallax');
            if (w && bg) {
                const r = w.getBoundingClientRect();
                if (r.top < innerHeight && r.bottom >= 0) {
                    bg.style.transform = `translate3d(0,${(innerHeight - r.top) / innerHeight * 60}px,0)`;
                }
            }
            if (typeof updateHeaderVisibility === 'function') {
                updateHeaderVisibility();
            } else {
                const h = document.getElementById('public-header');
                if (h) {
                    if (window.scrollY > 40) h.classList.add('header-scrolled');
                    else h.classList.remove('header-scrolled');
                }
            }
        });
    </script>
    @yield('scripts')
    @livewireScripts
</body>
</html>
