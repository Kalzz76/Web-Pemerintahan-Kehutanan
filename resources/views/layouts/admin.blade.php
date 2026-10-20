<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Jaga Hutan Desa</title>
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
    </style>
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
        document.addEventListener('livewire:navigated', pasangEventSidebar);

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
    </script>
    @yield('scripts')
    @livewireScripts
</body>
</html>
