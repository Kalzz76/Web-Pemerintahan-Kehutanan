<div class="relative">
    <button type="button" wire:click="toggle" class="relative inline-flex items-center justify-center w-10 h-10 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-600 transition cursor-pointer" title="Pemberitahuan Sistem" aria-label="Pemberitahuan Sistem">
        <i class="fa-solid fa-bell text-sm"></i>
        @if ($jumlahLaporanBaru > 0)
            <span class="absolute -top-1 -right-1 flex h-5 min-w-5 items-center justify-center px-1.5 rounded-full bg-rose-600 text-[10px] font-black text-white shadow-sm ring-2 ring-white animate-pulse">
                {{ $jumlahLaporanBaru }}
            </span>
        @endif
    </button>

    @if ($terbuka)
        <div wire:click="tutup" class="fixed inset-0 z-40 bg-black/10"></div>

        <div id="wadah-dropdown-notifikasi" class="absolute right-0 top-full mt-2.5 z-50 w-80 sm:w-96 max-w-[calc(100vw-2rem)] bg-white rounded-2xl shadow-2xl border border-stone-200/80 overflow-hidden">
            <div class="p-3.5 bg-stone-50/90 border-b border-stone-200/80 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-7 h-7 rounded-lg bg-stone-900 text-white flex items-center justify-center text-xs">
                        <i class="fa-solid fa-bell"></i>
                    </span>
                    <div>
                        <h3 class="text-xs font-bold text-stone-900 leading-tight">Pemberitahuan</h3>
                        <p class="text-[10px] text-stone-500">Aktivitas dan pantauan darurat</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    @if ($adaNotifikasi)
                        <button type="button" wire:click="hapusSemua" class="text-[11px] font-semibold text-stone-500 hover:text-rose-600 transition flex items-center gap-1 px-2 py-1 rounded-lg hover:bg-stone-200/60" title="Bersihkan semua notifikasi">
                            <i class="fa-solid fa-trash-can text-[10px]"></i>
                            <span>Hapus Semua</span>
                        </button>
                    @endif
                    <button type="button" wire:click="tutup" class="text-stone-400 hover:text-stone-700 text-xs p-1" title="Tutup">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>

            <div class="flex border-b border-stone-200/80 bg-white text-[11px] font-semibold text-stone-500 px-3 pt-2 gap-2">
                <button type="button" wire:click="gantiTab('semua')" class="pb-2 px-2 border-b-2 transition {{ $tab === 'semua' ? 'border-stone-900 text-stone-900' : 'border-transparent hover:text-stone-800' }}">
                    Semua
                </button>
                <button type="button" wire:click="gantiTab('laporan')" class="pb-2 px-2 border-b-2 transition flex items-center gap-1.5 {{ $tab === 'laporan' ? 'border-stone-900 text-stone-900' : 'border-transparent hover:text-stone-800' }}">
                    <span>Laporan</span>
                    @if ($jumlahLaporanBaru > 0)
                        <span class="w-4 h-4 rounded-full bg-rose-600 text-white text-[9px] flex items-center justify-center font-bold">{{ $jumlahLaporanBaru }}</span>
                    @endif
                </button>
                <button type="button" wire:click="gantiTab('satelit')" class="pb-2 px-2 border-b-2 transition {{ $tab === 'satelit' ? 'border-stone-900 text-stone-900' : 'border-transparent hover:text-stone-800' }}">
                    Satelit FIRMS
                </button>
                <button type="button" wire:click="gantiTab('patroli')" class="pb-2 px-2 border-b-2 transition {{ $tab === 'patroli' ? 'border-stone-900 text-stone-900' : 'border-transparent hover:text-stone-800' }}">
                    Patroli
                </button>
            </div>

            <div class="max-h-[360px] overflow-y-auto overscroll-contain divide-y divide-stone-100 bg-white">
                @if ($tab === 'semua' || $tab === 'laporan')
                    @forelse ($daftarLaporan as $lap)
                        <div class="p-3.5 flex items-start gap-3 hover:bg-stone-50/80 transition group relative">
                            <a href="{{ route('admin.laporan.show', $lap->id) }}" wire:navigate wire:click="tutup" class="flex-1 flex items-start gap-3 min-w-0">
                                <div class="w-8 h-8 rounded-xl shrink-0 flex items-center justify-center text-xs {{ $lap->jenis === 'Kebakaran' ? 'bg-rose-100 text-rose-600' : 'bg-amber-100 text-amber-700' }}">
                                    <i class="fa-solid {{ $lap->jenis === 'Kebakaran' ? 'fa-fire' : 'fa-paw' }}"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-1 mb-0.5">
                                        <span class="text-xs font-bold text-stone-900 truncate">
                                            {{ $lap->jenis }} ({{ $lap->kode }})
                                        </span>
                                    </div>
                                    <p class="text-[11px] text-stone-600 line-clamp-2 leading-relaxed">
                                        {{ $lap->deskripsi }}
                                    </p>
                                    <div class="mt-1 flex items-center gap-2 text-[10px] text-stone-400 font-medium">
                                        <span><i class="fa-solid fa-location-dot mr-1"></i>{{ $lap->kawasanHutan->nama ?? ($lap->kabupatenKota->nama ?? 'Jawa Barat') }}</span>
                                        <span>&bull;</span>
                                        <span>{{ $lap->created_at ? $lap->created_at->diffForHumans() : '' }}</span>
                                    </div>
                                </div>
                            </a>
                            <button type="button" wire:click.stop="hapusLaporan({{ $lap->id }})" title="Hapus notifikasi ini" class="text-stone-300 hover:text-rose-600 p-1.5 rounded-lg hover:bg-stone-100 transition shrink-0">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>
                        </div>
                    @empty
                        @if ($tab === 'laporan')
                            <div class="p-8 text-center text-stone-400 text-xs">
                                <i class="fa-solid fa-circle-check text-2xl text-stone-300 block mb-1.5"></i>
                                Tidak ada notifikasi laporan baru.
                            </div>
                        @endif
                    @endforelse
                @endif

                @if ($tab === 'semua' || $tab === 'satelit')
                    @forelse ($daftarTitikApi as $ta)
                        <div class="p-3.5 flex items-start gap-3 hover:bg-stone-50/80 transition group relative">
                            <a href="{{ route('admin.prediksi.index') }}" wire:navigate wire:click="tutup" class="flex-1 flex items-start gap-3 min-w-0">
                                <div class="w-8 h-8 rounded-xl shrink-0 flex items-center justify-center text-xs bg-purple-100 text-purple-700">
                                    <i class="fa-solid fa-satellite"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-1 mb-0.5">
                                        <span class="text-xs font-bold text-stone-900">
                                            Titik Panas Satelit FIRMS
                                        </span>
                                    </div>
                                    <p class="text-[11px] text-stone-600 leading-relaxed font-mono">
                                        Lat: {{ number_format($ta->latitude, 4) }}, Long: {{ number_format($ta->longitude, 4) }}
                                    </p>
                                    <div class="mt-1 flex items-center gap-2 text-[10px] text-stone-400">
                                        <span class="text-purple-700 font-semibold bg-purple-50 px-1.5 py-0.5 rounded">{{ $ta->kepercayaan }}% Yakin</span>
                                        <span>&bull;</span>
                                        <span>{{ $ta->tanggal_deteksi ? $ta->tanggal_deteksi->format('d M Y') : '' }} {{ $ta->waktu_deteksi }}</span>
                                    </div>
                                </div>
                            </a>
                            <button type="button" wire:click.stop="hapusTitikApi({{ $ta->id }})" title="Hapus notifikasi ini" class="text-stone-300 hover:text-rose-600 p-1.5 rounded-lg hover:bg-stone-100 transition shrink-0">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>
                        </div>
                    @empty
                        @if ($tab === 'satelit')
                            <div class="p-8 text-center text-stone-400 text-xs">
                                <i class="fa-solid fa-satellite-dish text-2xl text-stone-300 block mb-1.5"></i>
                                Tidak ada notifikasi titik api satelit.
                            </div>
                        @endif
                    @endforelse
                @endif

                @if ($tab === 'semua' || $tab === 'patroli')
                    @forelse ($daftarPatroli as $pat)
                        <div class="p-3.5 flex items-start gap-3 hover:bg-stone-50/80 transition group relative">
                            <a href="{{ route('admin.jadwal-patroli.index') }}" wire:navigate wire:click="tutup" class="flex-1 flex items-start gap-3 min-w-0">
                                <div class="w-8 h-8 rounded-xl shrink-0 flex items-center justify-center text-xs bg-emerald-100 text-emerald-700">
                                    <i class="fa-solid fa-calendar-check"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-1 mb-0.5">
                                        <span class="text-xs font-bold text-stone-900 truncate">
                                            Patroli: {{ $pat->judul }}
                                        </span>
                                    </div>
                                    <p class="text-[11px] text-stone-600 truncate">
                                        Lokasi: {{ $pat->lokasi }}
                                    </p>
                                    <div class="mt-1 flex items-center gap-2 text-[10px] text-stone-400">
                                        <span class="text-emerald-700 font-semibold bg-emerald-50 px-1.5 py-0.5 rounded">{{ $pat->jam ? substr($pat->jam, 0, 5) : '' }} WIB</span>
                                        <span>&bull;</span>
                                        <span>{{ $pat->tanggal ? $pat->tanggal->format('d M Y') : '' }}</span>
                                    </div>
                                </div>
                            </a>
                            <button type="button" wire:click.stop="hapusPatroli({{ $pat->id }})" title="Hapus notifikasi ini" class="text-stone-300 hover:text-rose-600 p-1.5 rounded-lg hover:bg-stone-100 transition shrink-0">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>
                        </div>
                    @empty
                        @if ($tab === 'patroli')
                            <div class="p-8 text-center text-stone-400 text-xs">
                                <i class="fa-solid fa-calendar-xmark text-2xl text-stone-300 block mb-1.5"></i>
                                Tidak ada notifikasi jadwal patroli.
                            </div>
                        @endif
                    @endforelse
                @endif

                @if (!$adaNotifikasi)
                    <div class="p-8 text-center text-stone-400 text-xs">
                        <i class="fa-solid fa-bell-slash text-2xl text-stone-300 block mb-2"></i>
                        Tidak ada pemberitahuan baru saat ini.
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
