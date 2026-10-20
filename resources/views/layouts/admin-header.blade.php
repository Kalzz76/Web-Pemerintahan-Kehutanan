@php
    $jumlahLaporanBaru = \App\Models\Laporan::where('status', 'Baru')->count();
    $pengaturanGlobal = \App\Models\PengaturanHutan::first();
@endphp

<header class="sticky top-0 z-30 bg-white/95 backdrop-blur border-b border-stone-200/80 px-4 md:px-8 py-3.5 flex items-center justify-between shadow-xs transition-all">
    <div class="flex items-center space-x-3">
        <button id="sidebarToggle" type="button" class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-stone-200 bg-white hover:bg-stone-100 text-stone-700 hover:text-stone-900 focus:outline-none transition cursor-pointer shadow-xs shrink-0" title="Buka/Tutup Sidebar" aria-label="Buka/Tutup Sidebar">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>

        <div class="hidden sm:block">
            <nav class="flex items-center space-x-2 text-xs text-stone-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0F8179] transition flex items-center">
                    <i class="fa-solid fa-house text-[10px] mr-1.5"></i>
                    <span>Admin</span>
                </a>
                <span class="text-stone-300">/</span>
                <span class="text-stone-800 font-semibold">@yield('title', 'Dashboard')</span>
            </nav>
        </div>
    </div>

    <div class="flex items-center space-x-2.5 sm:space-x-3.5">
        <a href="{{ route('beranda') }}" target="_blank" class="hidden sm:inline-flex items-center space-x-2 px-3.5 py-2 rounded-xl text-xs font-semibold text-stone-600 bg-stone-100 hover:bg-stone-200 transition" title="Lihat Website Publik">
            <i class="fa-solid fa-earth-americas text-[#0F8179]"></i>
            <span>Lihat Website</span>
            <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-stone-400"></i>
        </a>

        <button id="btnFullscreen" type="button" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-600 hover:text-stone-900 transition cursor-pointer" title="Mode Layar Penuh" aria-label="Mode Layar Penuh">
            <svg id="fsIconExpand" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/>
            </svg>
            <svg id="fsIconCompress" style="display:none;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3"/>
            </svg>
        </button>

        <a href="{{ route('admin.laporan.index', ['status' => 'Baru']) }}" class="relative inline-flex items-center justify-center w-10 h-10 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-600 transition" title="Laporan Darurat Baru">
            <i class="fa-solid fa-bell text-sm"></i>
            @if ($jumlahLaporanBaru > 0)
                <span class="absolute -top-1 -right-1 flex h-5 min-w-5 items-center justify-center px-1.5 rounded-full bg-rose-600 text-[10px] font-black text-white shadow-sm ring-2 ring-white animate-pulse">
                    {{ $jumlahLaporanBaru }}
                </span>
            @endif
        </a>

        <div class="h-6 w-px bg-stone-200"></div>

        <div class="flex items-center space-x-3 pl-1">
            <div class="w-9 h-9 rounded-xl bg-[#0F8179] text-white font-bold flex items-center justify-center text-sm shadow-xs shrink-0">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="hidden md:block text-left">
                <div class="text-xs font-bold text-stone-800 leading-tight">{{ Auth::user()->name ?? 'Administrator' }}</div>
                <div class="text-[10px] text-[#0F8179] font-semibold">Administrator Desa</div>
            </div>
        </div>
    </div>
</header>
