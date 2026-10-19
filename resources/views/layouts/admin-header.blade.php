@php
    $jumlahLaporanBaru = \App\Models\Laporan::where('status', 'Baru')->count();
    $pengaturanGlobal = \App\Models\PengaturanHutan::first();
@endphp

<header class="sticky top-0 z-30 bg-white/95 backdrop-blur border-b border-stone-200/80 px-4 md:px-8 py-3.5 flex items-center justify-between shadow-xs transition-all">
    <!-- Left: Mobile Toggle & Page Context -->
    <div class="flex items-center space-x-3">
        <!-- Mobile Hamburger Toggle -->
        <button type="button" onclick="toggleSidebar()" class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 focus:outline-none transition" aria-label="Buka Menu">
            <i class="fa-solid fa-bars text-base"></i>
        </button>

        <div class="hidden sm:block">
            <nav class="flex items-center space-x-2 text-xs text-stone-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-green-700 transition flex items-center">
                    <i class="fa-solid fa-house text-[10px] mr-1.5"></i>
                    <span>Admin</span>
                </a>
                <span class="text-stone-300">/</span>
                <span class="text-stone-800 font-semibold">@yield('title', 'Dashboard')</span>
            </nav>
        </div>
    </div>

    <!-- Right: Quick Actions & Profile -->
    <div class="flex items-center space-x-2.5 sm:space-x-4">
        <!-- Shortcut to Public Web -->
        <a href="{{ route('beranda') }}" target="_blank" class="hidden sm:inline-flex items-center space-x-2 px-3.5 py-2 rounded-xl text-xs font-semibold text-stone-600 bg-stone-100 hover:bg-stone-200 transition" title="Lihat Website Publik">
            <i class="fa-solid fa-earth-americas text-green-700"></i>
            <span>Lihat Website</span>
            <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-stone-400"></i>
        </a>

        <!-- Notification Bell (Laporan Baru) -->
        <a href="{{ route('admin.laporan.index', ['status' => 'Baru']) }}" class="relative inline-flex items-center justify-center w-10 h-10 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-600 transition" title="Laporan Darurat Baru">
            <i class="fa-solid fa-bell text-sm"></i>
            @if ($jumlahLaporanBaru > 0)
                <span class="absolute -top-1 -right-1 flex h-5 min-w-5 items-center justify-center px-1.5 rounded-full bg-rose-600 text-[10px] font-black text-white shadow-sm ring-2 ring-white animate-pulse">
                    {{ $jumlahLaporanBaru }}
                </span>
            @endif
        </a>

        <!-- Divider -->
        <div class="h-6 w-px bg-stone-200"></div>

        <!-- User Profile Pill -->
        <div class="flex items-center space-x-3 pl-1">
            <div class="w-9 h-9 rounded-xl bg-green-700 text-white font-bold flex items-center justify-center text-sm shadow-xs shrink-0">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="hidden md:block text-left">
                <div class="text-xs font-bold text-stone-800 leading-tight">{{ Auth::user()->name ?? 'Administrator' }}</div>
                <div class="text-[10px] text-green-700 font-semibold">Administrator Desa</div>
            </div>
        </div>
    </div>
</header>
