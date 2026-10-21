<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Beranda') - {{ $pengaturanGlobal->nama_aplikasi ?? 'Jaga Hutan Desa' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body.mode-gelap {
            background-color: #121214 !important;
            color: #f3f4f6 !important;
        }
        body.mode-gelap .bg-white {
            background-color: #1c1c21 !important;
            color: #f3f4f6 !important;
            border-color: #2e2e36 !important;
        }
        body.mode-gelap .bg-stone-50,
        body.mode-gelap .bg-stone-100,
        body.mode-gelap .bg-stone-200,
        body.mode-gelap [class*="bg-stone-50"],
        body.mode-gelap [class*="bg-stone-100"],
        body.mode-gelap [class*="bg-stone-200"] {
            background-color: #151518 !important;
            color: #f3f4f6 !important;
        }
        body.mode-gelap [class*="bg-white/"] {
            background-color: #1c1c21 !important;
            color: #f3f4f6 !important;
            border-color: #2e2e36 !important;
        }
        body.mode-gelap .hover\:bg-stone-50:hover,
        body.mode-gelap .hover\:bg-stone-100:hover,
        body.mode-gelap .hover\:bg-stone-200:hover,
        body.mode-gelap .hover\:bg-white:hover {
            background-color: #26262e !important;
            color: #ffffff !important;
        }
        body.mode-gelap .text-stone-900,
        body.mode-gelap .text-stone-800,
        body.mode-gelap .text-gray-900,
        body.mode-gelap .text-gray-800,
        body.mode-gelap h1,
        body.mode-gelap h2,
        body.mode-gelap h3,
        body.mode-gelap h4 {
            color: #f9fafb !important;
        }
        body.mode-gelap .text-stone-700,
        body.mode-gelap .text-stone-600,
        body.mode-gelap .text-gray-700,
        body.mode-gelap .text-gray-600 {
            color: #d1d5db !important;
        }
        body.mode-gelap .text-stone-500,
        body.mode-gelap .text-stone-400,
        body.mode-gelap .text-gray-500,
        body.mode-gelap .text-gray-400 {
            color: #9ca3af !important;
        }
        body.mode-gelap .border-stone-100,
        body.mode-gelap .border-stone-200,
        body.mode-gelap .border-stone-300,
        body.mode-gelap [class*="border-stone-"] {
            border-color: #2e2e36 !important;
        }
        body.mode-gelap .divide-stone-100 > :not([hidden]) ~ :not([hidden]),
        body.mode-gelap .divide-stone-200 > :not([hidden]) ~ :not([hidden]) {
            border-color: #2e2e36 !important;
        }
        body.mode-gelap input[type="text"],
        body.mode-gelap input[type="tel"],
        body.mode-gelap input[type="password"],
        body.mode-gelap select,
        body.mode-gelap textarea {
            background-color: #17171b !important;
            color: #f9fafb !important;
            border-color: #383842 !important;
        }
        body.mode-gelap input::placeholder,
        body.mode-gelap textarea::placeholder {
            color: #6b7280 !important;
        }
        body.mode-gelap select option {
            background-color: #17171b !important;
            color: #f9fafb !important;
        }
        body.mode-gelap .text-green-900,
        body.mode-gelap .text-green-800,
        body.mode-gelap .text-green-700 {
            color: #4ade80 !important;
        }
        body.mode-gelap .text-emerald-900,
        body.mode-gelap .text-emerald-800,
        body.mode-gelap .text-emerald-700 {
            color: #34d399 !important;
        }
        body.mode-gelap .text-amber-900,
        body.mode-gelap .text-amber-800,
        body.mode-gelap .text-amber-700 {
            color: #fbbf24 !important;
        }
        body.mode-gelap .text-rose-900,
        body.mode-gelap .text-rose-800,
        body.mode-gelap .text-rose-700,
        body.mode-gelap .text-red-700 {
            color: #f87171 !important;
        }
        body.mode-gelap .text-blue-900,
        body.mode-gelap .text-blue-800,
        body.mode-gelap .text-blue-700 {
            color: #60a5fa !important;
        }
        body.mode-gelap .text-sky-900,
        body.mode-gelap .text-sky-800,
        body.mode-gelap .text-sky-700 {
            color: #38bdf8 !important;
        }
        body.mode-gelap .bg-green-100 {
            background-color: rgba(34, 197, 94, 0.2) !important;
            color: #86efac !important;
        }
        body.mode-gelap .bg-emerald-100 {
            background-color: rgba(16, 185, 129, 0.2) !important;
            color: #6ee7b7 !important;
        }
        body.mode-gelap .bg-amber-100 {
            background-color: rgba(245, 158, 11, 0.2) !important;
            color: #fde68a !important;
        }
        body.mode-gelap .bg-rose-100,
        body.mode-gelap .bg-red-100 {
            background-color: rgba(244, 63, 94, 0.2) !important;
            color: #fca5a5 !important;
        }
        body.mode-gelap .bg-blue-100 {
            background-color: rgba(59, 130, 246, 0.2) !important;
            color: #93c5fd !important;
        }
        body.mode-gelap .bg-sky-100 {
            background-color: rgba(14, 165, 233, 0.2) !important;
            color: #7dd3fc !important;
        }
        body.mode-gelap .bg-lime-100 {
            background-color: rgba(132, 204, 22, 0.2) !important;
            color: #bef264 !important;
        }
        body.mode-gelap .bg-yellow-100 {
            background-color: rgba(234, 179, 8, 0.2) !important;
            color: #fef08a !important;
        }
        body.mode-gelap .bg-orange-100 {
            background-color: rgba(249, 115, 22, 0.2) !important;
            color: #fdba74 !important;
        }
        body.mode-gelap .bg-purple-100 {
            background-color: rgba(168, 85, 247, 0.2) !important;
            color: #d8b4fe !important;
        }
        body.mode-gelap .bg-green-50,
        body.mode-gelap .bg-emerald-50 {
            background-color: rgba(16, 185, 129, 0.12) !important;
            border-color: rgba(16, 185, 129, 0.3) !important;
        }
        body.mode-gelap .bg-amber-50 {
            background-color: rgba(245, 158, 11, 0.12) !important;
            border-color: rgba(245, 158, 11, 0.3) !important;
            color: #fde68a !important;
        }
        body.mode-gelap .bg-rose-50 {
            background-color: rgba(244, 63, 94, 0.12) !important;
            border-color: rgba(244, 63, 94, 0.3) !important;
            color: #fca5a5 !important;
        }
        body.mode-gelap .bg-sky-50 {
            background-color: rgba(14, 165, 233, 0.12) !important;
            border-color: rgba(14, 165, 233, 0.3) !important;
            color: #7dd3fc !important;
        }
        body.mode-gelap button.bg-stone-100,
        body.mode-gelap a.bg-stone-100 {
            background-color: #24242b !important;
            color: #e5e7eb !important;
            border-color: #383842 !important;
        }
        body.mode-gelap button.bg-stone-100:hover,
        body.mode-gelap a.bg-stone-100:hover {
            background-color: #31313a !important;
        }
        body.mode-gelap button.bg-stone-900,
        body.mode-gelap a.bg-stone-900 {
            background-color: #24242b !important;
            color: #ffffff !important;
            border: 1px solid #383842 !important;
        }
        body.mode-gelap button.bg-stone-900:hover,
        body.mode-gelap a.bg-stone-900:hover {
            background-color: #31313a !important;
        }
        body.mode-gelap .leaflet-popup-content-wrapper,
        body.mode-gelap .leaflet-popup-tip {
            background-color: #1c1c21 !important;
            color: #f3f4f6 !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.6) !important;
        }
        body.mode-gelap .leaflet-popup-content h4 {
            color: #ffffff !important;
        }
        body.mode-gelap .leaflet-popup-content p,
        body.mode-gelap .leaflet-popup-content .text-stone-600 {
            color: #d1d5db !important;
        }
        body.mode-gelap .leaflet-popup-content .border-stone-100 {
            border-color: #2e2e36 !important;
        }
        body.mode-gelap .leaflet-bar a {
            background-color: #1c1c21 !important;
            color: #f3f4f6 !important;
            border-bottom-color: #2e2e36 !important;
        }
        body.mode-gelap .leaflet-bar a:hover {
            background-color: #2a2a32 !important;
            color: #ffffff !important;
        }
        body.mode-gelap .tombol-layar-penuh-peta,
        body.mode-gelap [wire\:click="toggleLayarPenuh"] {
            background-color: #1c1c21 !important;
            color: #f9fafb !important;
            border-color: #383842 !important;
        }
        body.mode-gelap [wire\:click="toggleLayarPenuh"] i {
            color: #9ca3af !important;
        }
        body.mode-gelap [wire\:click="toggleLayarPenuh"] span {
            color: #f9fafb !important;
        }
        body.mode-gelap nav[role="navigation"] span,
        body.mode-gelap nav[role="navigation"] a {
            background-color: #1c1c21 !important;
            color: #d1d5db !important;
            border-color: #2e2e36 !important;
        }
        body.mode-gelap nav[role="navigation"] span[aria-current="page"] span {
            background-color: #059669 !important;
            color: #ffffff !important;
        }
        .wadah-peta-fullscreen {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            z-index: 9999 !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        .wadah-peta-fullscreen [wire\:ignore],
        .wadah-peta-fullscreen .leaflet-container {
            width: 100% !important;
            height: 100% !important;
            max-height: 100vh !important;
        }
        body.huruf-kecil {
            font-size: 14px !important;
        }
        body.huruf-normal {
            font-size: 16px !important;
        }
        body.huruf-besar {
            font-size: 18px !important;
        }
    </style>
    @yield('styles')
    @livewireStyles
</head>
<body class="bg-stone-50 text-stone-800 font-sans antialiased min-h-screen flex flex-col justify-between">
    @php
        $pengaturanGlobal = \App\Models\PengaturanHutan::first();
        $kontakDaruratFooter = \App\Models\KontakDarurat::orderBy('urutan')->take(4)->get();
    @endphp

    <header class="bg-green-900 text-white h-20 sticky top-0 z-40 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center justify-between">
            <a href="{{ route('beranda') }}" class="flex items-center space-x-3 group">
                <div class="w-11 h-11 bg-white text-green-900 font-black rounded-xl flex items-center justify-center text-xl shadow shrink-0 group-hover:scale-105 transition">
                    @if ($pengaturanGlobal && $pengaturanGlobal->logo)
                        <img src="{{ asset('storage/' . $pengaturanGlobal->logo) }}" alt="Logo" class="w-8 h-8 object-contain rounded-lg">
                    @else
                        <i class="fa-solid fa-tree"></i>
                    @endif
                </div>
                <div>
                    <span class="block text-lg font-black tracking-tight leading-tight">{{ $pengaturanGlobal->nama_aplikasi ?? 'Jaga Hutan Desa' }}</span>
                    <span class="block text-xs text-green-200 tracking-wide">{{ $pengaturanGlobal->nama_instansi ?? 'Pemerintah Desa Hutan Lestari' }}</span>
                </div>
            </a>

            <nav class="hidden lg:flex items-center space-x-1 font-medium text-sm">
                <a href="{{ route('beranda') }}" class="px-4 py-2 rounded-xl transition {{ request()->routeIs('beranda') ? 'bg-green-800 text-white font-semibold' : 'text-green-100 hover:bg-green-800 hover:text-white' }}">
                    Beranda
                </a>
                <a href="{{ Route::has('peta') ? route('peta') : url('/peta') }}" class="px-4 py-2 rounded-xl transition {{ request()->is('peta*') ? 'bg-green-800 text-white font-semibold' : 'text-green-100 hover:bg-green-800 hover:text-white' }}">
                    Peta Hutan
                </a>
                <a href="{{ Route::has('primata') ? route('primata') : url('/primata') }}" class="px-4 py-2 rounded-xl transition {{ request()->is('primata*') ? 'bg-green-800 text-white font-semibold' : 'text-green-100 hover:bg-green-800 hover:text-white' }}">
                    Primata
                </a>
                <a href="{{ Route::has('tumbuhan') ? route('tumbuhan') : url('/tumbuhan') }}" class="px-4 py-2 rounded-xl transition {{ request()->is('tumbuhan*') ? 'bg-green-800 text-white font-semibold' : 'text-green-100 hover:bg-green-800 hover:text-white' }}">
                    Tumbuhan
                </a>
                <a href="{{ Route::has('info') ? route('info') : url('/info') }}" class="px-4 py-2 rounded-xl transition {{ request()->is('info*') ? 'bg-green-800 text-white font-semibold' : 'text-green-100 hover:bg-green-800 hover:text-white' }}">
                    Info Hutan
                </a>
                <a href="{{ Route::has('peringatan') ? route('peringatan') : url('/peringatan') }}" class="px-4 py-2 rounded-xl transition {{ request()->is('peringatan*') ? 'bg-green-800 text-white font-semibold' : 'text-green-100 hover:bg-green-800 hover:text-white' }}">
                    Peringatan
                </a>
                <div class="flex items-center space-x-1 pl-2 border-l border-green-800">
                    <button type="button" onclick="ubahUkuranHuruf('kecil')" title="Huruf Kecil" class="px-2 py-1 rounded-lg text-xs font-bold hover:bg-green-800 text-green-200 hover:text-white transition">A-</button>
                    <button type="button" onclick="ubahUkuranHuruf('normal')" title="Huruf Normal" class="px-2 py-1 rounded-lg text-xs font-bold hover:bg-green-800 text-green-200 hover:text-white transition">A</button>
                    <button type="button" onclick="ubahUkuranHuruf('besar')" title="Huruf Besar" class="px-2 py-1 rounded-lg text-xs font-bold hover:bg-green-800 text-green-200 hover:text-white transition">A+</button>
                    <button type="button" onclick="alihModeGelap()" title="Mode Gelap / Terang" class="p-2 rounded-lg text-xs hover:bg-green-800 text-green-200 hover:text-white transition">
                        <i id="ikon-mode-gelap" class="fa-solid fa-moon"></i>
                    </button>
                </div>
                <div class="pl-2">
                    <a href="{{ Route::has('lapor') ? route('lapor') : url('/lapor') }}" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-500 text-white font-bold rounded-xl shadow-md transition transform active:scale-95">
                        <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                        <span>Lapor Darurat</span>
                    </a>
                </div>
            </nav>

            <button type="button" onclick="alihMenuMobile()" class="lg:hidden p-2.5 rounded-xl text-green-100 hover:text-white hover:bg-green-800 transition" aria-label="Menu Navigasi">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
        </div>

        <div id="menu-mobile" class="hidden lg:hidden bg-green-950 border-t border-green-800 px-4 pt-3 pb-5 space-y-2 shadow-2xl">
            <div class="flex items-center justify-between px-3 py-2 bg-green-900/60 rounded-xl mb-2 text-xs">
                <span class="text-green-200 font-medium">Tampilan:</span>
                <div class="flex items-center space-x-2">
                    <button type="button" onclick="ubahUkuranHuruf('kecil')" class="px-2 py-1 rounded bg-green-800 text-white font-bold">A-</button>
                    <button type="button" onclick="ubahUkuranHuruf('normal')" class="px-2 py-1 rounded bg-green-800 text-white font-bold">A</button>
                    <button type="button" onclick="ubahUkuranHuruf('besar')" class="px-2 py-1 rounded bg-green-800 text-white font-bold">A+</button>
                    <button type="button" onclick="alihModeGelap()" class="p-1.5 rounded bg-green-800 text-white">
                        <i id="ikon-mode-gelap-mobile" class="fa-solid fa-moon"></i>
                    </button>
                </div>
            </div>
            <a href="{{ route('beranda') }}" class="block px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('beranda') ? 'bg-green-800 text-white' : 'text-green-100 hover:bg-green-900' }}">
                Beranda
            </a>
            <a href="{{ Route::has('peta') ? route('peta') : url('/peta') }}" class="block px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->is('peta*') ? 'bg-green-800 text-white' : 'text-green-100 hover:bg-green-900' }}">
                Peta Hutan
            </a>
            <a href="{{ Route::has('primata') ? route('primata') : url('/primata') }}" class="block px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->is('primata*') ? 'bg-green-800 text-white' : 'text-green-100 hover:bg-green-900' }}">
                Primata
            </a>
            <a href="{{ Route::has('tumbuhan') ? route('tumbuhan') : url('/tumbuhan') }}" class="block px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->is('tumbuhan*') ? 'bg-green-800 text-white' : 'text-green-100 hover:bg-green-900' }}">
                Tumbuhan
            </a>
            <a href="{{ Route::has('info') ? route('info') : url('/info') }}" class="block px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->is('info*') ? 'bg-green-800 text-white' : 'text-green-100 hover:bg-green-900' }}">
                Info Hutan
            </a>
            <a href="{{ Route::has('peringatan') ? route('peringatan') : url('/peringatan') }}" class="block px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->is('peringatan*') ? 'bg-green-800 text-white' : 'text-green-100 hover:bg-green-900' }}">
                Peringatan
            </a>
            <div class="pt-2">
                <a href="{{ Route::has('lapor') ? route('lapor') : url('/lapor') }}" class="block text-center w-full py-3 bg-red-600 hover:bg-red-500 text-white font-bold rounded-xl shadow transition">
                    <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                    <span>Lapor Darurat</span>
                </a>
            </div>
        </div>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    <a href="{{ Route::has('lapor') ? route('lapor') : url('/lapor') }}" class="fixed bottom-6 right-6 z-40 bg-red-600 hover:bg-red-500 text-white font-bold px-5 py-3.5 rounded-2xl shadow-2xl flex items-center space-x-3 transform hover:-translate-y-1 transition duration-200">
        <span class="flex h-3 w-3 relative">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
        </span>
        <span class="tracking-wide">Lapor Darurat</span>
    </a>

    <footer class="bg-stone-950 text-stone-400 pt-16 pb-12 mt-20 border-t border-stone-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-white text-green-900 font-black rounded-xl flex items-center justify-center text-lg shrink-0 shadow">
                            @if ($pengaturanGlobal && $pengaturanGlobal->logo)
                                <img src="{{ asset('storage/' . $pengaturanGlobal->logo) }}" alt="Logo" class="w-7 h-7 object-contain rounded-lg">
                            @else
                                <i class="fa-solid fa-tree"></i>
                            @endif
                        </div>
                        <span class="text-white font-black text-lg tracking-tight">{{ $pengaturanGlobal->nama_aplikasi ?? 'Jaga Hutan Desa' }}</span>
                    </div>
                    <p class="text-xs text-stone-400 leading-relaxed mb-4">
                        {{ $pengaturanGlobal->deskripsi_singkat ?? 'Sistem informasi terpadu pengelolaan dan pemantauan kawasan hutan desa, tanggap bencana karhutla dan konflik satwa.' }}
                    </p>
                    <div class="text-xs text-stone-500 space-y-1">
                        <p><i class="fa-solid fa-location-dot w-4 text-green-600 mr-1"></i> {{ $pengaturanGlobal->alamat ?? 'Desa Hutan Lestari' }}</p>
                        <p><i class="fa-solid fa-envelope w-4 text-green-600 mr-1"></i> {{ $pengaturanGlobal->email ?? 'jagahutan@desahutanlestari.id' }}</p>
                        <p><i class="fa-solid fa-phone w-4 text-green-600 mr-1"></i> {{ $pengaturanGlobal->telepon ?? '081234567890' }}</p>
                    </div>
                </div>

                <div>
                    <h3 class="text-white font-bold text-sm tracking-wider uppercase mb-4">Tautan Cepat</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('beranda') }}" class="hover:text-green-400 transition">Beranda Utama</a></li>
                        <li><a href="{{ Route::has('peta') ? route('peta') : url('/peta') }}" class="hover:text-green-400 transition">Peta Kawasan Hutan</a></li>
                        <li><a href="{{ Route::has('primata') ? route('primata') : url('/primata') }}" class="hover:text-green-400 transition">Katalog Satwa Primata</a></li>
                        <li><a href="{{ Route::has('tumbuhan') ? route('tumbuhan') : url('/tumbuhan') }}" class="hover:text-green-400 transition">Data Tumbuhan Rimba</a></li>
                        <li><a href="{{ Route::has('info') ? route('info') : url('/info') }}" class="hover:text-green-400 transition">Jadwal Patroli & Kegiatan</a></li>
                        <li><a href="{{ Route::has('peringatan') ? route('peringatan') : url('/peringatan') }}" class="hover:text-green-400 transition">Peringatan Area Terancam</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-bold text-sm tracking-wider uppercase mb-4">Kontak Darurat</h3>
                    <ul class="space-y-2.5 text-xs">
                        @forelse ($kontakDaruratFooter as $kontak)
                            <li>
                                <div class="text-stone-300 font-semibold">{{ $kontak->nama }}</div>
                                <a href="tel:{{ $kontak->nomor_telepon }}" class="text-red-400 hover:text-red-300 font-mono font-bold flex items-center mt-0.5">
                                    <i class="fa-solid fa-phone mr-1.5 text-[10px]"></i>
                                    {{ $kontak->nomor_telepon }}
                                    <span class="text-stone-500 font-normal ml-1">({{ $kontak->instansi }})</span>
                                </a>
                            </li>
                        @empty
                            <li class="text-stone-500">Belum ada kontak darurat terdaftar.</li>
                        @endforelse
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-bold text-sm tracking-wider uppercase mb-4">Warga & Petugas</h3>
                    <div class="space-y-3 text-xs">
                        <a href="{{ Route::has('lapor.status') ? route('lapor.status') : url('/lapor/status') }}" class="flex items-center p-3 rounded-xl bg-stone-900 hover:bg-stone-800 text-stone-200 transition">
                            <i class="fa-solid fa-magnifying-glass-location text-green-500 mr-2.5 text-base"></i>
                            <div>
                                <div class="font-semibold">Cek Status Laporan</div>
                                <div class="text-[11px] text-stone-500">Pantau tindak lanjut laporan</div>
                            </div>
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center text-stone-500 hover:text-stone-300 transition text-[11px] pt-2">
                            <i class="fa-solid fa-lock mr-1.5"></i>
                            <span>Login Administrator</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-stone-900 flex flex-col md:flex-row items-center justify-between text-xs text-stone-600 gap-4">
                <p>&copy; {{ date('Y') }} {{ $pengaturanGlobal->nama_aplikasi ?? 'Jaga Hutan Desa' }}. Hak cipta dilindungi.</p>
                <p>{{ $pengaturanGlobal->nama_instansi ?? 'Pemerintah Desa Hutan Lestari' }} &bull; Wilayah Konservasi Hutan Desa</p>
            </div>
        </div>
    </footer>

    @include('partials.modal-pesan')

    <script>
    function alihMenuMobile() {
        var menu = document.getElementById('menu-mobile');
        if (menu) {
            menu.classList.toggle('hidden');
        }
    }

    function alihModeGelap() {
        var aktif = document.body.classList.toggle('mode-gelap');
        localStorage.setItem('mode_gelap', aktif ? '1' : '0');
        perbaruiIkonGelap(aktif);
    }

    function perbaruiIkonGelap(aktif) {
        var ikon = document.getElementById('ikon-mode-gelap');
        var ikonMobile = document.getElementById('ikon-mode-gelap-mobile');
        if (ikon) {
            ikon.className = aktif ? 'fa-solid fa-sun text-yellow-300' : 'fa-solid fa-moon';
        }
        if (ikonMobile) {
            ikonMobile.className = aktif ? 'fa-solid fa-sun text-yellow-300' : 'fa-solid fa-moon';
        }
    }

    function ubahUkuranHuruf(ukuran) {
        document.body.classList.remove('huruf-kecil', 'huruf-normal', 'huruf-besar');
        document.body.classList.add('huruf-' + ukuran);
        localStorage.setItem('ukuran_huruf', ukuran);
    }

    (function() {
        var gelap = localStorage.getItem('mode_gelap') === '1';
        if (gelap) {
            document.body.classList.add('mode-gelap');
            perbaruiIkonGelap(true);
        }
        var ukuran = localStorage.getItem('ukuran_huruf');
        if (ukuran) {
            document.body.classList.add('huruf-' + ukuran);
        }
    })();
    </script>
    @yield('scripts')
    @livewireScripts
</body>
</html>
