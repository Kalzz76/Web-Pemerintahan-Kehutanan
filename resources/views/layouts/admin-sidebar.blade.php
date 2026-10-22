@php
    $jumlahLaporanBaru = \App\Models\Laporan::where('status', 'Baru')->count();
    $pengaturanGlobal = \App\Models\PengaturanHutan::first();
@endphp

<aside id="admin-sidebar" wire:persist="admin-sidebar" class="sidebar fixed inset-y-0 left-0 z-50 h-screen flex flex-col justify-between shrink-0 shadow-2xl transition-all duration-300 ease-in-out -translate-x-full md:translate-x-0 md:static md:h-screen md:shadow-none overflow-hidden">
    @if ($pengaturanGlobal->tampilkan_hiasan_sidebar ?? true)
    <!-- Hiasan Tanaman Rambat & Pemandangan Hutan Transparan (Menu Tetap Jelas & Interaktif) -->
    <div class="absolute inset-0 pointer-events-none z-0 overflow-hidden select-none opacity-45">
        <img src="{{ asset('images/sidebar-forest-vines.svg') }}" alt="" class="w-full h-full object-cover object-bottom pointer-events-none select-none">
    </div>
    @endif

    <div class="relative z-10 flex flex-col h-full overflow-hidden">
        <div class="brand flex items-center justify-between h-11 pr-4 pl-1 shrink-0">
            <div class="brand-left flex items-center space-x-3 overflow-hidden">
                <div class="brand-logo w-9 h-9 rounded-xl bg-white text-[#064B38] flex items-center justify-center font-black text-lg shrink-0 shadow-sm">
                    @if ($pengaturanGlobal && $pengaturanGlobal->logo)
                        <img src="{{ asset('storage/' . $pengaturanGlobal->logo) }}" alt="Logo" class="w-6 h-6 object-contain rounded-lg">
                    @else
                        <i class="fa-solid fa-tree text-[#064B38]"></i>
                    @endif
                </div>
                <div class="brand-text truncate">
                    <div class="text-sm font-bold text-white tracking-tight truncate leading-tight">{{ $pengaturanGlobal->nama_aplikasi ?? 'Jaga Hutan Desa' }}</div>
                    <div class="text-[10px] font-semibold text-white/75 tracking-wider uppercase">Portal Kehutanan</div>
                </div>
            </div>
            <button type="button" id="sidebarCloseBtn" class="md:hidden w-8 h-8 rounded-full bg-white/15 hover:bg-white/25 text-white flex items-center justify-center transition focus:outline-none shrink-0" aria-label="Tutup Menu">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <div class="divider h-px bg-white/20 my-3.5 mr-4 ml-1 shrink-0"></div>

        <nav id="admin-sidebar-nav" class="flex-1 space-y-5 overflow-y-auto no-scrollbar overscroll-contain pr-0">
            <div>
                <div class="nav-section-title px-3 mb-1.5 text-[10px] font-bold uppercase tracking-wider text-white/70">
                    Menu Utama
                </div>
                <div class="space-y-1.5">
                    <a href="{{ route('admin.dashboard') }}" wire:navigate class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'on' : '' }}" title="Dashboard">
                        <i class="fa-solid fa-gauge w-5 text-center text-sm shrink-0"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>

            <div>
                <div class="nav-section-title px-3 mb-1.5 text-[10px] font-bold uppercase tracking-wider text-white/70">
                    Pemantauan & Patroli
                </div>
                <div class="space-y-1.5">
                    <a href="{{ Route::has('admin.laporan.index') ? route('admin.laporan.index') : '#' }}" wire:navigate class="admin-nav-item {{ request()->is('admin/laporan*') ? 'on' : '' }}" title="Kelola Laporan">
                        <i class="fa-solid fa-triangle-exclamation w-5 text-center text-sm shrink-0"></i>
                        <span>Kelola Laporan</span>
                        @if ($jumlahLaporanBaru > 0)
                            <span class="badge-counter-pill">
                                {{ $jumlahLaporanBaru }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ Route::has('admin.prediksi.index') ? route('admin.prediksi.index') : '#' }}" wire:navigate class="admin-nav-item {{ request()->is('admin/prediksi*') ? 'on' : '' }}" title="Prediksi Kebakaran">
                        <i class="fa-solid fa-fire-flame-curved w-5 text-center text-sm shrink-0"></i>
                        <span>Prediksi Kebakaran</span>
                    </a>

                    <a href="{{ Route::has('admin.jadwal-patroli.index') ? route('admin.jadwal-patroli.index') : '#' }}" wire:navigate class="admin-nav-item {{ request()->is('admin/jadwal-patroli*') ? 'on' : '' }}" title="Jadwal Patroli">
                        <i class="fa-regular fa-calendar-check w-5 text-center text-sm shrink-0"></i>
                        <span>Jadwal Patroli</span>
                    </a>
                </div>
            </div>

            <div>
                <div class="nav-section-title px-3 mb-1.5 text-[10px] font-bold uppercase tracking-wider text-white/70">
                    Pemetaan & Wilayah
                </div>
                <div class="space-y-1.5">
                    <a href="{{ Route::has('admin.kawasan.index') ? route('admin.kawasan.index') : '#' }}" wire:navigate class="admin-nav-item {{ request()->is('admin/kawasan*') ? 'on' : '' }}" title="Kawasan Hutan">
                        <i class="fa-solid fa-mountain-sun w-5 text-center text-sm shrink-0"></i>
                        <span>Kawasan Hutan</span>
                    </a>

                    <a href="{{ Route::has('admin.titik-penting.index') ? route('admin.titik-penting.index') : '#' }}" wire:navigate class="admin-nav-item {{ request()->is('admin/titik-penting*') ? 'on' : '' }}" title="Titik Penting">
                        <i class="fa-solid fa-location-dot w-5 text-center text-sm shrink-0"></i>
                        <span>Titik Penting</span>
                    </a>

                    <a href="{{ Route::has('admin.jenis-lahan.index') ? route('admin.jenis-lahan.index') : '#' }}" wire:navigate class="admin-nav-item {{ request()->is('admin/jenis-lahan*') ? 'on' : '' }}" title="Jenis Lahan">
                        <i class="fa-solid fa-layer-group w-5 text-center text-sm shrink-0"></i>
                        <span>Jenis Lahan</span>
                    </a>
                </div>
            </div>

            <div>
                <div class="nav-section-title px-3 mb-1.5 text-[10px] font-bold uppercase tracking-wider text-white/70">
                    Keanekaragaman Hayati
                </div>
                <div class="space-y-1.5">
                    <a href="{{ Route::has('admin.primata.index') ? route('admin.primata.index') : '#' }}" wire:navigate class="admin-nav-item {{ request()->is('admin/primata*') ? 'on' : '' }}" title="Satwa Primata">
                        <i class="fa-solid fa-paw w-5 text-center text-sm shrink-0"></i>
                        <span>Satwa Primata</span>
                    </a>

                    <a href="{{ Route::has('admin.tumbuhan.index') ? route('admin.tumbuhan.index') : '#' }}" wire:navigate class="admin-nav-item {{ request()->is('admin/tumbuhan*') ? 'on' : '' }}" title="Tumbuhan Rimba">
                        <i class="fa-solid fa-seedling w-5 text-center text-sm shrink-0"></i>
                        <span>Tumbuhan Rimba</span>
                    </a>
                </div>
            </div>

            <div>
                <div class="nav-section-title px-3 mb-1.5 text-[10px] font-bold uppercase tracking-wider text-white/70">
                    Informasi & Layanan
                </div>
                <div class="space-y-1.5">
                    <a href="{{ Route::has('admin.pengumuman.index') ? route('admin.pengumuman.index') : '#' }}" wire:navigate class="admin-nav-item {{ request()->is('admin/pengumuman*') ? 'on' : '' }}" title="Pengumuman">
                        <i class="fa-solid fa-bullhorn w-5 text-center text-sm shrink-0"></i>
                        <span>Pengumuman</span>
                    </a>

                    <a href="{{ Route::has('admin.kontak-darurat.index') ? route('admin.kontak-darurat.index') : '#' }}" wire:navigate class="admin-nav-item {{ request()->is('admin/kontak-darurat*') ? 'on' : '' }}" title="Kontak Darurat">
                        <i class="fa-solid fa-phone-volume w-5 text-center text-sm shrink-0"></i>
                        <span>Kontak Darurat</span>
                    </a>
                </div>
            </div>

            <div>
                <div class="nav-section-title px-3 mb-1.5 text-[10px] font-bold uppercase tracking-wider text-white/70">
                    Sistem & Konfigurasi
                </div>
                <div class="space-y-1.5">
                    <a href="{{ Route::has('admin.akun.index') ? route('admin.akun.index') : '#' }}" wire:navigate class="admin-nav-item {{ request()->is('admin/akun*') ? 'on' : '' }}" title="Akun Admin">
                        <i class="fa-solid fa-users-gear w-5 text-center text-sm shrink-0"></i>
                        <span>Akun Admin</span>
                    </a>

                    <a href="{{ Route::has('admin.pengaturan.index') ? route('admin.pengaturan.index') : '#' }}" wire:navigate class="admin-nav-item {{ request()->is('admin/pengaturan*') ? 'on' : '' }}" title="Pengaturan Sistem">
                        <i class="fa-solid fa-sliders w-5 text-center text-sm shrink-0"></i>
                        <span>Pengaturan Sistem</span>
                    </a>
                </div>
            </div>
        </nav>

        <div class="pt-3 pb-1 pr-4 pl-1 border-t border-white/20 shrink-0 space-y-2.5">
            <div class="sidebar-user flex items-center gap-2.5 px-3 py-2 rounded-2xl bg-white/10 border border-white/15">
                <div class="avatar w-8 h-8 rounded-full bg-white text-[#064B38] font-bold text-xs flex items-center justify-center shrink-0 shadow-sm">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
                </div>
                <div class="info truncate flex-1">
                    <div class="text-xs font-bold text-white leading-tight truncate">{{ Auth::user()->name ?? 'Administrator' }}</div>
                    <div class="text-[10px] text-white/75 font-semibold">Administrator</div>
                </div>
            </div>

            <div class="sidebar-actions grid grid-cols-2 gap-2">
                <a href="{{ route('beranda') }}" target="_blank" class="flex items-center justify-center py-2 px-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-[11px] font-semibold transition border border-white/15 truncate" title="Lihat Website Publik">
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    <span class="sidebar-action-text ml-1.5">Publik</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="w-full" data-confirm="Apakah Anda yakin ingin keluar dari akun sistem?" data-confirm-title="Keluar Akun" data-confirm-ok="Ya, Keluar">
                    @csrf
                    <button type="submit" class="flex items-center justify-center w-full py-2 px-2.5 rounded-xl bg-white/10 hover:bg-rose-600 text-white text-[11px] font-semibold transition border border-white/15 truncate" title="Keluar">
                        <i class="fa-solid fa-right-from-bracket text-[10px]"></i>
                        <span class="sidebar-action-text ml-1.5">Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>

<div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 z-40 bg-stone-950/60 backdrop-blur-sm hidden md:hidden transition-opacity"></div>
