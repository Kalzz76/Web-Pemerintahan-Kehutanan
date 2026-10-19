@php
    $jumlahLaporanBaru = \App\Models\Laporan::where('status', 'Baru')->count();
    $pengaturanGlobal = \App\Models\PengaturanHutan::first();
@endphp

<aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 h-screen bg-stone-900 text-stone-300 flex flex-col justify-between shrink-0 shadow-xl transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0 md:static md:h-screen md:shadow-none">
    <div class="flex flex-col h-full overflow-hidden">
        <!-- Logo & Brand Header (Pinned Top) -->
        <div class="p-5 border-b border-stone-800 flex items-center justify-between shrink-0">
            <div class="flex items-center space-x-3 overflow-hidden">
                <div class="w-10 h-10 rounded-xl bg-white text-green-900 flex items-center justify-center font-black text-xl shrink-0 shadow">
                    @if ($pengaturanGlobal && $pengaturanGlobal->logo)
                        <img src="{{ asset('storage/' . $pengaturanGlobal->logo) }}" alt="Logo" class="w-8 h-8 object-contain rounded-lg">
                    @else
                        <i class="fa-solid fa-tree text-green-800"></i>
                    @endif
                </div>
                <div class="truncate">
                    <div class="text-[10px] uppercase font-extrabold tracking-widest text-green-400">Admin Panel</div>
                    <div class="text-sm font-bold text-white tracking-tight truncate">{{ $pengaturanGlobal->nama_aplikasi ?? 'Jaga Hutan Desa' }}</div>
                </div>
            </div>
            <!-- Mobile Close Button -->
            <button type="button" onclick="toggleSidebar()" class="md:hidden text-stone-400 hover:text-white p-1 rounded-lg focus:outline-none" aria-label="Tutup Menu">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Navigation Menu Groups (Scrollable Independently with Hidden Scrollbar) -->
        <nav class="flex-1 p-4 space-y-6 text-sm overflow-y-auto no-scrollbar overscroll-contain">
            <!-- 1. Menu Utama -->
            <div>
                <div class="px-3 mb-2 text-[10px] font-extrabold uppercase tracking-wider text-stone-500">
                    Menu Utama
                </div>
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3.5 py-2.5 rounded-xl font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-green-700 text-white shadow-sm' : 'hover:bg-stone-800 hover:text-white text-stone-300' }}">
                        <i class="fa-solid fa-gauge w-5 mr-3 text-center text-xs {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-stone-400' }}"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>

            <!-- 2. Pemantauan & Operasional -->
            <div>
                <div class="px-3 mb-2 text-[10px] font-extrabold uppercase tracking-wider text-stone-500">
                    Pemantauan & Patroli
                </div>
                <div class="space-y-1">
                    <a href="{{ Route::has('admin.laporan.index') ? route('admin.laporan.index') : '#' }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/laporan*') ? 'bg-green-700 text-white shadow-sm' : 'hover:bg-stone-800 hover:text-white text-stone-300' }}">
                        <div class="flex items-center">
                            <i class="fa-solid fa-triangle-exclamation w-5 mr-3 text-center text-xs {{ request()->is('admin/laporan*') ? 'text-white' : 'text-stone-400' }}"></i>
                            <span>Kelola Laporan</span>
                        </div>
                        @if ($jumlahLaporanBaru > 0)
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-rose-600 text-white animate-pulse">
                                {{ $jumlahLaporanBaru }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ Route::has('admin.prediksi.index') ? route('admin.prediksi.index') : '#' }}" class="flex items-center px-3.5 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/prediksi*') ? 'bg-green-700 text-white shadow-sm' : 'hover:bg-stone-800 hover:text-white text-stone-300' }}">
                        <i class="fa-solid fa-fire-flame-curved w-5 mr-3 text-center text-xs {{ request()->is('admin/prediksi*') ? 'text-white' : 'text-stone-400' }}"></i>
                        <span>Prediksi Kebakaran</span>
                    </a>

                    <a href="{{ Route::has('admin.jadwal-patroli.index') ? route('admin.jadwal-patroli.index') : '#' }}" class="flex items-center px-3.5 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/jadwal-patroli*') ? 'bg-green-700 text-white shadow-sm' : 'hover:bg-stone-800 hover:text-white text-stone-300' }}">
                        <i class="fa-regular fa-calendar-check w-5 mr-3 text-center text-xs {{ request()->is('admin/jadwal-patroli*') ? 'text-white' : 'text-stone-400' }}"></i>
                        <span>Jadwal Patroli</span>
                    </a>
                </div>
            </div>

            <!-- 3. Pemetaan Wilayah Hutan -->
            <div>
                <div class="px-3 mb-2 text-[10px] font-extrabold uppercase tracking-wider text-stone-500">
                    Pemetaan & Wilayah
                </div>
                <div class="space-y-1">
                    <a href="{{ Route::has('admin.kawasan.index') ? route('admin.kawasan.index') : '#' }}" class="flex items-center px-3.5 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/kawasan*') ? 'bg-green-700 text-white shadow-sm' : 'hover:bg-stone-800 hover:text-white text-stone-300' }}">
                        <i class="fa-solid fa-mountain-sun w-5 mr-3 text-center text-xs {{ request()->is('admin/kawasan*') ? 'text-white' : 'text-stone-400' }}"></i>
                        <span>Kawasan Hutan</span>
                    </a>

                    <a href="{{ Route::has('admin.titik-penting.index') ? route('admin.titik-penting.index') : '#' }}" class="flex items-center px-3.5 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/titik-penting*') ? 'bg-green-700 text-white shadow-sm' : 'hover:bg-stone-800 hover:text-white text-stone-300' }}">
                        <i class="fa-solid fa-location-dot w-5 mr-3 text-center text-xs {{ request()->is('admin/titik-penting*') ? 'text-white' : 'text-stone-400' }}"></i>
                        <span>Titik Penting</span>
                    </a>

                    <a href="{{ Route::has('admin.jenis-lahan.index') ? route('admin.jenis-lahan.index') : '#' }}" class="flex items-center px-3.5 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/jenis-lahan*') ? 'bg-green-700 text-white shadow-sm' : 'hover:bg-stone-800 hover:text-white text-stone-300' }}">
                        <i class="fa-solid fa-layer-group w-5 mr-3 text-center text-xs {{ request()->is('admin/jenis-lahan*') ? 'text-white' : 'text-stone-400' }}"></i>
                        <span>Jenis Lahan</span>
                    </a>
                </div>
            </div>

            <!-- 4. Keanekaragaman Hayati -->
            <div>
                <div class="px-3 mb-2 text-[10px] font-extrabold uppercase tracking-wider text-stone-500">
                    Keanekaragaman Hayati
                </div>
                <div class="space-y-1">
                    <a href="{{ Route::has('admin.primata.index') ? route('admin.primata.index') : '#' }}" class="flex items-center px-3.5 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/primata*') ? 'bg-green-700 text-white shadow-sm' : 'hover:bg-stone-800 hover:text-white text-stone-300' }}">
                        <i class="fa-solid fa-paw w-5 mr-3 text-center text-xs {{ request()->is('admin/primata*') ? 'text-white' : 'text-stone-400' }}"></i>
                        <span>Satwa Primata</span>
                    </a>

                    <a href="{{ Route::has('admin.tumbuhan.index') ? route('admin.tumbuhan.index') : '#' }}" class="flex items-center px-3.5 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/tumbuhan*') ? 'bg-green-700 text-white shadow-sm' : 'hover:bg-stone-800 hover:text-white text-stone-300' }}">
                        <i class="fa-solid fa-seedling w-5 mr-3 text-center text-xs {{ request()->is('admin/tumbuhan*') ? 'text-white' : 'text-stone-400' }}"></i>
                        <span>Tumbuhan Rimba</span>
                    </a>
                </div>
            </div>

            <!-- 5. Informasi Publik & Komunikasi -->
            <div>
                <div class="px-3 mb-2 text-[10px] font-extrabold uppercase tracking-wider text-stone-500">
                    Informasi & Layanan
                </div>
                <div class="space-y-1">
                    <a href="{{ Route::has('admin.pengumuman.index') ? route('admin.pengumuman.index') : '#' }}" class="flex items-center px-3.5 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/pengumuman*') ? 'bg-green-700 text-white shadow-sm' : 'hover:bg-stone-800 hover:text-white text-stone-300' }}">
                        <i class="fa-solid fa-bullhorn w-5 mr-3 text-center text-xs {{ request()->is('admin/pengumuman*') ? 'text-white' : 'text-stone-400' }}"></i>
                        <span>Pengumuman</span>
                    </a>

                    <a href="{{ Route::has('admin.kontak-darurat.index') ? route('admin.kontak-darurat.index') : '#' }}" class="flex items-center px-3.5 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/kontak-darurat*') ? 'bg-green-700 text-white shadow-sm' : 'hover:bg-stone-800 hover:text-white text-stone-300' }}">
                        <i class="fa-solid fa-phone-volume w-5 mr-3 text-center text-xs {{ request()->is('admin/kontak-darurat*') ? 'text-white' : 'text-stone-400' }}"></i>
                        <span>Kontak Darurat</span>
                    </a>
                </div>
            </div>

            <!-- 6. Pengaturan & Sistem -->
            <div>
                <div class="px-3 mb-2 text-[10px] font-extrabold uppercase tracking-wider text-stone-500">
                    Sistem & Konfigurasi
                </div>
                <div class="space-y-1">
                    <a href="{{ Route::has('admin.akun.index') ? route('admin.akun.index') : '#' }}" class="flex items-center px-3.5 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/akun*') ? 'bg-green-700 text-white shadow-sm' : 'hover:bg-stone-800 hover:text-white text-stone-300' }}">
                        <i class="fa-solid fa-users-gear w-5 mr-3 text-center text-xs {{ request()->is('admin/akun*') ? 'text-white' : 'text-stone-400' }}"></i>
                        <span>Akun Admin</span>
                    </a>

                    <a href="{{ Route::has('admin.pengaturan.index') ? route('admin.pengaturan.index') : '#' }}" class="flex items-center px-3.5 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/pengaturan*') ? 'bg-green-700 text-white shadow-sm' : 'hover:bg-stone-800 hover:text-white text-stone-300' }}">
                        <i class="fa-solid fa-sliders w-5 mr-3 text-center text-xs {{ request()->is('admin/pengaturan*') ? 'text-white' : 'text-stone-400' }}"></i>
                        <span>Pengaturan Sistem</span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- Bottom Actions (Pinned Bottom) -->
        <div class="p-4 border-t border-stone-800 space-y-2 bg-stone-950/60 shrink-0">
            <a href="{{ route('beranda') }}" target="_blank" class="flex items-center justify-center w-full py-2.5 px-4 rounded-xl text-stone-300 hover:bg-stone-800 hover:text-white text-xs font-semibold transition border border-stone-800">
                <i class="fa-solid fa-arrow-up-right-from-square mr-2 text-[11px] text-green-400"></i>
                <span>Buka Halaman Publik</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari sistem?')">
                @csrf
                <button type="submit" class="flex items-center justify-center w-full py-2.5 px-4 rounded-xl bg-rose-500/10 hover:bg-rose-600 text-rose-300 hover:text-white font-semibold text-xs transition border border-rose-500/20">
                    <i class="fa-solid fa-right-from-bracket mr-2 text-[11px]"></i>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Backdrop overlay for mobile -->
<div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 z-40 bg-stone-950/60 backdrop-blur-sm hidden md:hidden transition-opacity"></div>
