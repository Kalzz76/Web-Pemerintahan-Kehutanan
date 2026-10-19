<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Jaga Hutan Desa</title>
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
        /* Sembunyikan scrollbar di sidebar namun tetap bisa di-scroll */
        .no-scrollbar::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }
        .no-scrollbar {
            -ms-overflow-style: none !important; /* IE dan Edge */
            scrollbar-width: none !important; /* Firefox */
        }
    </style>
</head>
<body class="bg-stone-50 text-stone-800 font-sans antialiased h-screen overflow-hidden">
    <!-- Container Utama: Layar Penuh Tanpa Scroll Body Global -->
    <div class="flex h-screen w-full overflow-hidden bg-stone-50">
        <!-- Sidebar Admin Modular (Scroll Terpisah Tanpa Scrollbar) -->
        @include('layouts.admin-sidebar')

        <!-- Wrapper Konten Utama (Scroll Mandiri Terpisah dari Sidebar) -->
        <div id="admin-main-wrapper" class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto overflow-x-hidden">
            <!-- Header Admin Modular -->
            @include('layouts.admin-header')

            <!-- Main Page Content -->
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

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            if (sidebar && backdrop) {
                const isHidden = sidebar.classList.contains('-translate-x-full');
                if (isHidden) {
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');
                    backdrop.classList.remove('hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('translate-x-0');
                    backdrop.classList.add('hidden');
                }
            }
        }
    </script>
    @yield('scripts')
</body>
</html>
