<div class="bg-white p-5 sm:p-6 rounded-2xl border border-stone-200/80 shadow-sm space-y-5">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-xl bg-[#064B38]/10 text-[#064B38] flex items-center justify-center text-sm">
                    <i class="fa-solid fa-chart-simple"></i>
                </span>
                <h2 class="text-base sm:text-lg font-bold text-stone-900 tracking-tight">Grafik Laporan Masuk</h2>
            </div>
            <p class="text-xs text-stone-500 mt-1">
                {{ $judulPeriode }} &bull; Total <span class="font-bold text-stone-900">{{ $totalLaporan }}</span> Laporan
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <div class="inline-flex rounded-xl bg-stone-100 p-1 border border-stone-200/80 text-xs font-semibold">
                <button type="button" wire:click="setPeriode('hari-ini')" class="px-2.5 py-1.5 rounded-lg transition {{ $periode === 'hari-ini' ? 'bg-stone-900 text-white shadow-xs' : 'text-stone-600 hover:text-stone-900' }}">
                    Hari Ini
                </button>
                <button type="button" wire:click="setPeriode('7-hari')" class="px-2.5 py-1.5 rounded-lg transition {{ $periode === '7-hari' ? 'bg-stone-900 text-white shadow-xs' : 'text-stone-600 hover:text-stone-900' }}">
                    7 Hari
                </button>
                <button type="button" wire:click="setPeriode('30-hari')" class="px-2.5 py-1.5 rounded-lg transition {{ $periode === '30-hari' ? 'bg-stone-900 text-white shadow-xs' : 'text-stone-600 hover:text-stone-900' }}">
                    30 Hari
                </button>
                <button type="button" wire:click="setPeriode('5-bulan')" class="px-2.5 py-1.5 rounded-lg transition {{ $periode === '5-bulan' ? 'bg-stone-900 text-white shadow-xs' : 'text-stone-600 hover:text-stone-900' }}">
                    5 Bulan
                </button>
                <button type="button" wire:click="setPeriode('1-tahun')" class="px-2.5 py-1.5 rounded-lg transition {{ $periode === '1-tahun' ? 'bg-stone-900 text-white shadow-xs' : 'text-stone-600 hover:text-stone-900' }}">
                    1 Tahun
                </button>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-3 text-xs">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-stone-100 text-stone-800 font-medium">
            <span class="w-2.5 h-2.5 rounded-full bg-stone-900"></span>
            <span>Total: <strong>{{ $totalLaporan }}</strong></span>
        </span>
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-rose-50 text-rose-700 font-medium">
            <span class="w-2.5 h-2.5 rounded-full bg-rose-600"></span>
            <span>Kebakaran: <strong>{{ $totalKebakaran }}</strong></span>
        </span>
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-amber-50 text-amber-700 font-medium">
            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
            <span>Satwa Masuk: <strong>{{ $totalHewan }}</strong></span>
        </span>
    </div>

    <div class="relative bg-stone-50/50 rounded-2xl p-4 sm:p-6 border border-stone-100">
        <div class="absolute inset-x-6 top-6 bottom-14 flex flex-col justify-between pointer-events-none opacity-40">
            <div class="border-b border-dashed border-stone-300 w-full"></div>
            <div class="border-b border-dashed border-stone-300 w-full"></div>
            <div class="border-b border-dashed border-stone-300 w-full"></div>
            <div class="border-b border-dashed border-stone-300 w-full"></div>
        </div>

        <div class="h-60 flex items-end justify-between gap-2 sm:gap-4 relative z-10 pt-8 pb-1">
            @foreach ($dataGrafik as $item)
                <div class="flex-1 flex flex-col items-center h-full justify-end group">
                    <div class="relative w-full flex items-end justify-center h-full">
                        <div class="absolute -top-12 left-1/2 -translate-x-1/2 z-30 pointer-events-none opacity-0 group-hover:opacity-100 transition-all duration-150 bg-stone-900 text-white text-[11px] py-1.5 px-3 rounded-xl whitespace-nowrap shadow-xl">
                            <div class="font-bold">{{ $item['label'] }}</div>
                            <div class="text-[10px] text-stone-300 flex items-center gap-2 mt-0.5">
                                <span>Total: {{ $item['jumlah'] }}</span>
                                <span>&bull;</span>
                                <span class="text-rose-400">{{ $item['kebakaran'] }} Api</span>
                                <span>&bull;</span>
                                <span class="text-amber-400">{{ $item['hewan'] }} Satwa</span>
                            </div>
                        </div>

                        <div class="w-full max-w-[42px] rounded-t-xl transition-all duration-300 relative {{ $item['jumlah'] > 0 ? 'bg-gradient-to-t from-stone-900 via-stone-800 to-[#064B38] group-hover:from-[#064B38] group-hover:to-[#0B3D2E] shadow-sm' : 'bg-stone-200/70 group-hover:bg-stone-300' }}" style="height: {{ $item['persen'] }}%;">
                            @if ($item['jumlah'] > 0)
                                <span class="absolute -top-5 left-1/2 -translate-x-1/2 text-[10px] font-bold text-stone-900 font-mono">
                                    {{ $item['jumlah'] }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-3 text-center w-full">
                        <span class="block text-[10px] sm:text-[11px] font-semibold text-stone-600 truncate group-hover:text-stone-900 transition" title="{{ $item['label'] }}">
                            {{ $item['label'] }}
                        </span>
                        <span class="text-[9px] text-stone-400 font-mono block">
                            {{ $item['jumlah'] }} laporan
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
