<header class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-stone-200/80 px-4 md:px-8 py-3.5 flex items-center justify-between shadow-xs transition-all">
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
                <a href="{{ route('admin.dashboard') }}" wire:navigate class="hover:text-[#064B38] transition flex items-center">
                    <i class="fa-solid fa-house text-[10px] mr-1.5"></i>
                    <span>Admin</span>
                </a>
                @hasSection('breadcrumb')
                    @yield('breadcrumb')
                @else
                    <span class="text-stone-300">/</span>
                    <span class="text-stone-800 font-semibold">@yield('title', 'Dashboard')</span>
                @endif
            </nav>
        </div>
    </div>

    <div class="flex items-center space-x-2.5 sm:space-x-3.5">
        <a href="{{ route('beranda') }}" target="_blank" class="hidden sm:inline-flex items-center space-x-2 px-3.5 py-2 rounded-xl text-xs font-semibold text-stone-600 bg-stone-100 hover:bg-stone-200 transition" title="Lihat Website Publik">
            <i class="fa-solid fa-earth-americas text-[#064B38]"></i>
            <span>Lihat Website</span>
            <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-stone-400"></i>
        </a>

        <livewire:admin.tombol-layar-penuh />

        <button type="button" onclick="alihModeGelapAdmin()" id="btn-mode-gelap-admin" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-600 hover:text-stone-900 transition cursor-pointer" title="Mode Gelap / Terang" aria-label="Mode Gelap / Terang">
            <i id="ikon-mode-gelap-admin" class="fa-solid fa-moon text-sm"></i>
        </button>

        <livewire:admin.notifikasi-modal />
    </div>
</header>
