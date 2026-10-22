@php
    $pengaturanGlobal = \App\Models\PengaturanHutan::first();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - {{ $pengaturanGlobal->nama_aplikasi ?? 'Jaga Hutan Desa' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Logo_Kementerian_Kehutanan.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        tealForest: {
                            DEFAULT: '#064B38',
                            dark: '#0B3D2E',
                            light: '#E7F2EE'
                        }
                    },
                    fontFamily: {
                        sans: ["'Plus Jakarta Sans'", 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --teal: #064B38;
            --teal-dark: #0B3D2E;
            --teal-light: #E7F2EE;
            --sidebar-w: 260px;
            --sidebar-w-collapsed: 80px;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }
        .no-scrollbar {
            -ms-overflow-style: none !important;
            scrollbar-width: none !important;
        }

        .sidebar {
            width: var(--sidebar-w);
            height: 100vh;
            flex-shrink: 0;
            background: #064B38;
            color: #ffffff;
            transition: width 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .sidebar::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }

        .admin-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            height: 46px;
            padding: 0 18px 0 16px;
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
            font-size: 13.5px;
            border-radius: 28px 0 0 28px;
            position: relative;
            transition: background 0.15s, color 0.15s;
            white-space: nowrap;
        }

        .admin-nav-item:hover {
            background: rgba(255, 255, 255, 0.14);
        }

        .badge-counter-pill {
            margin-left: auto;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 10px;
            font-weight: 800;
            background: #FFD95A;
            color: #1B2559;
        }

        .admin-nav-item.on .badge-counter-pill {
            background: #064B38;
            color: #ffffff;
        }

        @media (max-width: 767.98px) {
            .sidebar {
                width: 285px !important;
                max-width: 85vw;
                border-top-right-radius: 28px;
                border-bottom-right-radius: 28px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
                padding: 20px 14px 20px 14px !important;
            }

            .admin-nav-item {
                border-radius: 14px !important;
                padding: 0 14px !important;
                width: 100% !important;
                right: 0 !important;
                margin: 0 !important;
            }

            .admin-nav-item.on {
                border-radius: 14px !important;
                width: 100% !important;
                right: 0 !important;
                background: #ffffff !important;
                color: #064B38 !important;
                box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
            }

            .admin-nav-item.on::before,
            .admin-nav-item.on::after {
                display: none !important;
            }

            .sidebar .brand {
                padding: 0 4px !important;
            }

            .sidebar .divider {
                margin: 14px 4px !important;
            }

            .sidebar .nav-section-title {
                padding: 0 6px !important;
            }

            .sidebar-user {
                margin: 0 !important;
            }

            .sidebar-actions {
                margin: 0 !important;
            }
        }

        @media (min-width: 768px) {
            .sidebar {
                width: var(--sidebar-w);
                padding: 20px 0 16px 14px;
                border-radius: 0;
            }

            .admin-nav-item {
                border-radius: 28px 0 0 28px;
                padding: 0 18px 0 16px;
                position: relative;
            }

            .admin-nav-item.on {
                background: #ffffff;
                color: #064B38;
                font-weight: 700;
                position: relative;
                right: -2px;
                width: calc(100% + 2px);
                z-index: 30;
                border-radius: 28px 0 0 28px;
            }

            .admin-nav-item.on::before,
            .admin-nav-item.on::after {
                content: "";
                position: absolute;
                right: 0;
                width: 32px;
                height: 32px;
                pointer-events: none;
                z-index: 30;
            }

            .admin-nav-item.on::before {
                top: -32px;
                background: radial-gradient(circle at 0 0, transparent 32px, #ffffff 32.5px);
            }

            .admin-nav-item.on::after {
                bottom: -32px;
                background: radial-gradient(circle at 0 100%, transparent 32px, #ffffff 32.5px);
            }

            .app.sidebar-collapsed .sidebar {
                width: var(--sidebar-w-collapsed) !important;
                padding-left: 10px;
            }

            .app.sidebar-collapsed .brand-text,
            .app.sidebar-collapsed .admin-nav-item span,
            .app.sidebar-collapsed .badge-counter-pill,
            .app.sidebar-collapsed .sidebar-user .info,
            .app.sidebar-collapsed .nav-section-title,
            .app.sidebar-collapsed .sidebar-actions,
            .app.sidebar-collapsed .sidebar-action-text {
                display: none !important;
            }

            .app.sidebar-collapsed .brand {
                padding: 0 4px;
                justify-content: center;
            }

            .app.sidebar-collapsed .brand-left {
                justify-content: center;
            }

            .app.sidebar-collapsed .admin-nav-item {
                padding: 0 0 0 16px;
                justify-content: flex-start;
            }

            .app.sidebar-collapsed .divider {
                margin: 16px 8px;
            }

            .app.sidebar-collapsed .sidebar-user {
                padding: 6px;
                justify-content: center;
                margin-right: 10px;
            }
        }

        body.mode-gelap {
            background-color: #121214 !important;
            color: #f3f4f6 !important;
        }
        html.mode-gelap body {
            background-color: #121214 !important;
            color: #f3f4f6 !important;
        }
        body.mode-gelap #appRoot,
        body.mode-gelap #admin-main-wrapper {
            background-color: #121214 !important;
            color: #f3f4f6 !important;
        }
        body.mode-gelap header {
            background-color: rgba(18, 18, 20, 0.95) !important;
            border-color: #27272e !important;
        }
        body.mode-gelap .admin-nav-item.on {
            background: #121214 !important;
            color: #34d399 !important;
        }
        body.mode-gelap .admin-nav-item.on::before {
            background: radial-gradient(circle at 0 0, transparent 32px, #121214 32.5px) !important;
        }
        body.mode-gelap .admin-nav-item.on::after {
            background: radial-gradient(circle at 0 100%, transparent 32px, #121214 32.5px) !important;
        }
        body.mode-gelap .admin-nav-item.on .badge-counter-pill {
            background: #34d399 !important;
            color: #064B38 !important;
        }
        body.mode-gelap .bg-white {
            background-color: #1a1a1f !important;
            color: #f3f4f6 !important;
            border-color: #2c2c34 !important;
        }
        body.mode-gelap .bg-stone-50,
        body.mode-gelap .bg-stone-100,
        body.mode-gelap .bg-stone-200,
        body.mode-gelap [class*="bg-stone-50"],
        body.mode-gelap [class*="bg-stone-100"],
        body.mode-gelap [class*="bg-stone-200"] {
            background-color: #141417 !important;
            color: #f3f4f6 !important;
        }
        body.mode-gelap thead,
        body.mode-gelap thead tr {
            background-color: #141417 !important;
            color: #9ca3af !important;
            border-color: #2c2c34 !important;
        }
        body.mode-gelap thead th {
            color: #9ca3af !important;
            border-color: #2c2c34 !important;
        }
        body.mode-gelap tbody {
            background-color: #1a1a1f !important;
        }
        body.mode-gelap tbody tr {
            border-color: #2c2c34 !important;
        }
        body.mode-gelap tbody tr:hover {
            background-color: #22222a !important;
        }
        body.mode-gelap .hover\:bg-stone-50:hover,
        body.mode-gelap .hover\:bg-stone-100:hover,
        body.mode-gelap .hover\:bg-stone-200:hover,
        body.mode-gelap .hover\:bg-white:hover {
            background-color: #262630 !important;
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
            border-color: #2c2c34 !important;
        }
        body.mode-gelap .divide-stone-100 > :not([hidden]) ~ :not([hidden]),
        body.mode-gelap .divide-stone-200 > :not([hidden]) ~ :not([hidden]),
        body.mode-gelap [class*="divide-stone-"] > :not([hidden]) ~ :not([hidden]) {
            border-color: #2c2c34 !important;
        }
        body.mode-gelap input[type="text"],
        body.mode-gelap input[type="password"],
        body.mode-gelap input[type="number"],
        body.mode-gelap input[type="email"],
        body.mode-gelap input[type="date"],
        body.mode-gelap input[type="time"],
        body.mode-gelap select,
        body.mode-gelap textarea {
            background-color: #141417 !important;
            color: #f9fafb !important;
            border-color: #363640 !important;
        }
        body.mode-gelap input::placeholder,
        body.mode-gelap textarea::placeholder {
            color: #6b7280 !important;
        }
        body.mode-gelap select option {
            background-color: #141417 !important;
            color: #f9fafb !important;
        }
        body.mode-gelap button.bg-stone-100,
        body.mode-gelap a.bg-stone-100,
        body.mode-gelap #sidebarToggle,
        body.mode-gelap #btn-mode-gelap-admin,
        body.mode-gelap [wire\:click="toggleLayarPenuh"] {
            background-color: #23232b !important;
            color: #d1d5db !important;
            border-color: #363640 !important;
        }
        body.mode-gelap button.bg-stone-100:hover,
        body.mode-gelap a.bg-stone-100:hover,
        body.mode-gelap #sidebarToggle:hover,
        body.mode-gelap #btn-mode-gelap-admin:hover,
        body.mode-gelap [wire\:click="toggleLayarPenuh"]:hover {
            background-color: #2e2e38 !important;
            color: #ffffff !important;
        }
        body.mode-gelap #wadah-dropdown-notifikasi {
            background-color: #1a1a1f !important;
            border-color: #2c2c34 !important;
        }
        body.mode-gelap #modal-pesan .bg-white,
        body.mode-gelap #modal-konfirmasi-box {
            background-color: #1e1e27 !important;
            border: 1px solid #38384a !important;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.95), 0 0 0 1px rgba(255, 255, 255, 0.1) !important;
            color: #f9fafb !important;
        }
        body.mode-gelap #modal-konfirmasi-title,
        body.mode-gelap #modal-pesan h3 {
            color: #ffffff !important;
        }
        body.mode-gelap #modal-konfirmasi-message,
        body.mode-gelap #modal-pesan p {
            color: #a1a1aa !important;
        }
        body.mode-gelap #modal-konfirmasi-batal {
            background-color: #2b2b3a !important;
            border: 1px solid #4a4a62 !important;
            color: #f3f4f6 !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3) !important;
        }
        body.mode-gelap #modal-konfirmasi-batal:hover {
            background-color: #37374b !important;
            color: #ffffff !important;
            border-color: #636382 !important;
        }
        body.mode-gelap #modal-konfirmasi-ok {
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.25) !important;
        }
        body.mode-gelap #modal-konfirmasi-ok.bg-rose-600,
        body.mode-gelap #modal-konfirmasi-ok:not(.btn-konfirmasi-primer) {
            background-color: #e11d48 !important;
            box-shadow: 0 4px 16px rgba(225, 29, 72, 0.45) !important;
        }
        body.mode-gelap #modal-konfirmasi-ok.bg-rose-600:hover,
        body.mode-gelap #modal-konfirmasi-ok:not(.btn-konfirmasi-primer):hover {
            background-color: #f43f5e !important;
        }
        body.mode-gelap #modal-konfirmasi-ok.btn-konfirmasi-primer {
            background-color: #059669 !important;
            box-shadow: 0 4px 16px rgba(5, 150, 105, 0.45) !important;
        }
        body.mode-gelap #modal-konfirmasi-ok.btn-konfirmasi-primer:hover {
            background-color: #10b981 !important;
        }
        body.mode-gelap #modal-konfirmasi-icon-wrapper {
            background-color: rgba(245, 158, 11, 0.16) !important;
            border: 1px solid rgba(245, 158, 11, 0.35) !important;
            color: #fbbf24 !important;
        }
        body.mode-gelap #modal-konfirmasi-icon-wrapper.bg-rose-50 {
            background-color: rgba(244, 63, 94, 0.18) !important;
            border: 1px solid rgba(244, 63, 94, 0.4) !important;
            color: #fb7185 !important;
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
        body.mode-gelap .text-rose-700 {
            color: #f87171 !important;
        }
        body.mode-gelap .text-blue-900,
        body.mode-gelap .text-blue-800,
        body.mode-gelap .text-blue-700 {
            color: #60a5fa !important;
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
        body.mode-gelap .bg-rose-100 {
            background-color: rgba(244, 63, 94, 0.2) !important;
            color: #fca5a5 !important;
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
        }
        body.mode-gelap .bg-rose-50 {
            background-color: rgba(244, 63, 94, 0.12) !important;
            border-color: rgba(244, 63, 94, 0.3) !important;
        }
        body.mode-gelap nav[role="navigation"] span,
        body.mode-gelap nav[role="navigation"] a {
            background-color: #1a1a1f !important;
            color: #d1d5db !important;
            border-color: #2c2c34 !important;
        }
        body.mode-gelap nav[role="navigation"] span[aria-current="page"] span {
            background-color: #064B38 !important;
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
        /* Isolasi total elemen peta Leaflet agar tidak pernah bocor menimpa header admin dan modal saat di-scroll */
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
    </style>
    <script>
        try {
            if (localStorage.getItem('mode_gelap') === '1') {
                document.documentElement.classList.add('mode-gelap');
            }
        } catch (e) {}
    </script>
    @livewireStyles
</head>
<body class="bg-white text-stone-800 font-sans antialiased h-screen overflow-hidden">
    <div class="app flex h-screen w-full overflow-hidden bg-white" id="appRoot">
        <script>
            try {
                if (window.innerWidth >= 768 && localStorage.getItem('admin_sidebar_collapsed') === 'true') {
                    document.getElementById('appRoot').classList.add('sidebar-collapsed');
                }
            } catch (e) {}
        </script>
        @include('layouts.admin-sidebar')

        <div id="admin-main-wrapper" class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto overflow-x-hidden bg-white">
            @include('layouts.admin-header')

            <main class="flex-1 p-5 md:p-8 max-w-7xl w-full mx-auto">
                @if ($errors->any())
                    <div class="bg-rose-50 text-rose-700 rounded-2xl p-5 mb-8 border border-rose-200 shadow-sm">
                        <div class="flex items-center mb-2 font-bold text-sm">
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

                @yield('content')
            </main>
        </div>
    </div>

    @include('partials.modal-pesan')
    @include('partials.modal-konfirmasi')

    <script>
        function toggleSidebar() {
            const appRoot = document.getElementById('appRoot');
            const sidebar = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            if (!appRoot || !sidebar) return;

            if (window.innerWidth >= 768) {
                appRoot.classList.toggle('sidebar-collapsed');
                try {
                    localStorage.setItem('admin_sidebar_collapsed', appRoot.classList.contains('sidebar-collapsed') ? 'true' : 'false');
                } catch (e) {}
            } else {
                const isHidden = sidebar.classList.contains('-translate-x-full');
                if (isHidden) {
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');
                    if (backdrop) backdrop.classList.remove('hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('translate-x-0');
                    if (backdrop) backdrop.classList.add('hidden');
                }
            }
        }

        function sinkronNavigasiSidebar() {
            const nav = document.getElementById('admin-sidebar-nav') || document.querySelector('#admin-sidebar nav');
            if (!nav) return;

            const path = window.location.pathname.replace(/\/+$/, '');
            const items = nav.querySelectorAll('.admin-nav-item');
            let itemAktif = null;

            items.forEach(function (el) {
                el.classList.remove('on');
                try {
                    const elUrl = new URL(el.getAttribute('href'), window.location.origin);
                    const elPath = elUrl.pathname.replace(/\/+$/, '');
                    if (elPath === path) {
                        itemAktif = el;
                    } else if (!itemAktif && elPath !== '/admin' && elPath.length > 6 && path.startsWith(elPath)) {
                        itemAktif = el;
                    }
                } catch (e) {}
            });

            if (itemAktif) {
                itemAktif.classList.add('on');
            } else if (path === '/admin' || path === '') {
                const itemDashboard = nav.querySelector('a[href$="/admin"]');
                if (itemDashboard) itemDashboard.classList.add('on');
            }

            const tersimpan = sessionStorage.getItem('admin_sidebar_scroll');
            if (tersimpan !== null) {
                nav.scrollTop = parseInt(tersimpan, 10);
            } else if (itemAktif) {
                itemAktif.scrollIntoView({ block: 'nearest' });
            }
        }

        function pasangScrollDanKlikSidebar() {
            const nav = document.getElementById('admin-sidebar-nav') || document.querySelector('#admin-sidebar nav');
            if (!nav || nav.dataset.scrollTerpasang === '1') return;
            nav.dataset.scrollTerpasang = '1';

            nav.addEventListener('scroll', function () {
                sessionStorage.setItem('admin_sidebar_scroll', String(nav.scrollTop));
            }, { passive: true });

            nav.addEventListener('click', function (e) {
                const link = e.target.closest('.admin-nav-item');
                if (link) {
                    sessionStorage.setItem('admin_sidebar_scroll', String(nav.scrollTop));
                    if (window.innerWidth < 768) {
                        const sidebar = document.getElementById('admin-sidebar');
                        const backdrop = document.getElementById('sidebar-backdrop');
                        if (sidebar) {
                            sidebar.classList.add('-translate-x-full');
                            sidebar.classList.remove('translate-x-0');
                        }
                        if (backdrop) backdrop.classList.add('hidden');
                    }
                }
            });
        }

        function pasangEventSidebar() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            if (sidebarToggle) {
                sidebarToggle.onclick = toggleSidebar;
            }

            const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');
            if (sidebarCloseBtn) {
                sidebarCloseBtn.onclick = toggleSidebar;
            }

            const sidebarBackdrop = document.getElementById('sidebar-backdrop');
            if (sidebarBackdrop) {
                sidebarBackdrop.onclick = toggleSidebar;
            }
        }

        pasangEventSidebar();
        pasangScrollDanKlikSidebar();
        sinkronNavigasiSidebar();

        document.addEventListener('livewire:navigating', function () {
            const nav = document.getElementById('admin-sidebar-nav') || document.querySelector('#admin-sidebar nav');
            if (nav) {
                sessionStorage.setItem('admin_sidebar_scroll', String(nav.scrollTop));
            }
        });

        document.addEventListener('livewire:navigated', function () {
            pasangEventSidebar();
            pasangScrollDanKlikSidebar();
            sinkronNavigasiSidebar();
        });

        window.addEventListener('popstate', sinkronNavigasiSidebar);

        function toggleBrowserFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(function (err) {
                    console.warn('Gagal masuk mode layar penuh:', err.message);
                });
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }

        document.addEventListener('fullscreenchange', function () {
            const isFs = !!document.fullscreenElement;
            sessionStorage.setItem('admin_layar_penuh', isFs ? '1' : '0');
            if (typeof Livewire !== 'undefined') {
                Livewire.dispatch('fullscreen-berubah', { status: isFs });
            }
        });

        document.addEventListener('livewire:navigated', function () {
            const isFs = !!document.fullscreenElement;
            if (typeof Livewire !== 'undefined') {
                Livewire.dispatch('fullscreen-berubah', { status: isFs });
            }
        });

        document.addEventListener('click', function () {
            if (sessionStorage.getItem('admin_layar_penuh') === '1' && !document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(function () {});
            }
        });

        window.modalNotifikasiTerbuka = false;

        function updateKunciScrollHalaman(terbuka) {
            window.modalNotifikasiTerbuka = terbuka;
            const wrapper = document.getElementById('admin-main-wrapper');
            if (!wrapper) return;
            if (terbuka) {
                wrapper.classList.remove('overflow-y-auto');
                wrapper.classList.add('overflow-hidden');
            } else {
                wrapper.classList.remove('overflow-hidden');
                wrapper.classList.add('overflow-y-auto');
            }
        }

        window.addEventListener('status-modal-notif', function (event) {
            const detail = Array.isArray(event.detail) ? event.detail[0] : (event.detail || {});
            const terbuka = Boolean(detail.terbuka);
            updateKunciScrollHalaman(terbuka);
        });

        function handleDeteksiScrollLuar(e) {
            if (!window.modalNotifikasiTerbuka) return;
            const wadahModal = document.getElementById('wadah-dropdown-notifikasi');
            if (wadahModal && wadahModal.contains(e.target)) {
                return;
            }
            updateKunciScrollHalaman(false);
            if (typeof Livewire !== 'undefined') {
                Livewire.dispatch('tutup-notifikasi-otomatis');
            }
        }

        window.addEventListener('wheel', handleDeteksiScrollLuar, { passive: true, capture: true });
        window.addEventListener('touchmove', handleDeteksiScrollLuar, { passive: true, capture: true });
        window.addEventListener('scroll', handleDeteksiScrollLuar, { passive: true, capture: true });

        function alihModeGelapAdmin() {
            var aktif = document.body.classList.toggle('mode-gelap');
            localStorage.setItem('mode_gelap', aktif ? '1' : '0');
            perbaruiIkonGelapAdmin(aktif);
        }

        function perbaruiIkonGelapAdmin(aktif) {
            var ikon = document.getElementById('ikon-mode-gelap-admin');
            if (ikon) {
                ikon.className = aktif ? 'fa-solid fa-sun text-yellow-300 text-sm' : 'fa-solid fa-moon text-sm';
            }
        }

        function muatModeGelapAdmin() {
            var gelap = localStorage.getItem('mode_gelap') === '1';
            if (gelap) {
                document.body.classList.add('mode-gelap');
            } else {
                document.body.classList.remove('mode-gelap');
            }
            perbaruiIkonGelapAdmin(gelap);
        }

        muatModeGelapAdmin();
        document.addEventListener('livewire:navigated', muatModeGelapAdmin);
    </script>
    @yield('scripts')
    @livewireScripts
</body>
</html>
