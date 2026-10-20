<div>
    <div class="bg-white p-5 rounded-3xl border border-stone-200 shadow-sm mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
            <div class="sm:col-span-4 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-stone-400 text-sm"></i>
                <input type="text"
                    wire:model.live.debounce.300ms="cari"
                    placeholder="Cari nama lokal atau nama ilmiah..."
                    class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-green-600">
            </div>

            <div class="sm:col-span-3">
                <select wire:model.live="idKabupatenKota" class="w-full px-3 py-2.5 text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 bg-white">
                    <option value="">Semua Kabupaten/Kota</option>
                    @foreach ($daftarKabupaten as $kab)
                        <option value="{{ $kab->id }}">{{ $kab->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-3">
                <select wire:model.live="idKawasan" class="w-full px-3 py-2.5 text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 bg-white">
                    <option value="">Semua Kawasan</option>
                    @foreach ($daftarKawasan as $kws)
                        <option value="{{ $kws->id }}">{{ $kws->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2 flex items-center gap-2">
                @if ($cari || $idKabupatenKota || $idKawasan || $statusKonservasi)
                    <button type="button" wire:click="resetFilter" class="w-full py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-700 font-bold rounded-xl text-sm transition flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Reset</span>
                    </button>
                @endif
                <div wire:loading class="text-xs text-green-700 font-semibold px-2 py-1 bg-green-50 rounded-lg shrink-0">
                    <i class="fa-solid fa-spinner fa-spin mr-1"></i> Memuat...
                </div>
            </div>
        </div>
    </div>

    @if ($daftarPrimata->isEmpty())
        <div class="bg-white rounded-3xl p-12 text-center border border-stone-200 shadow-sm max-w-xl mx-auto">
            <div class="w-16 h-16 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center text-2xl mx-auto mb-4">
                <i class="fa-solid fa-paw"></i>
            </div>
            <h3 class="text-lg font-black text-stone-900 mb-1">Satwa Primata Tidak Ditemukan</h3>
            <p class="text-stone-500 text-xs sm:text-sm mb-5">
                Tidak ada satwa yang cocok dengan kata kunci atau filter pencarian Anda.
            </p>
            <button type="button" wire:click="resetFilter" class="px-5 py-2.5 bg-stone-900 hover:bg-stone-800 text-white font-bold rounded-xl text-xs sm:text-sm">
                Lihat Semua Primata
            </button>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($daftarPrimata as $primata)
                <div class="bg-white rounded-3xl border border-stone-200 shadow-sm overflow-hidden flex flex-col group hover:shadow-md hover:border-stone-300 transition duration-200">
                    <div class="h-52 bg-stone-100 relative overflow-hidden">
                        @if ($primata->foto)
                            <img src="{{ asset('storage/' . $primata->foto) }}" alt="{{ $primata->nama_lokal }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-amber-50 to-stone-100 text-amber-500 text-4xl">
                                <i class="fa-solid fa-paw"></i>
                            </div>
                        @endif

                        <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                            @if ($primata->status_konservasi == 'CR')
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-red-100 text-red-800 shadow-sm">Kritis (CR)</span>
                            @elseif ($primata->status_konservasi == 'EN')
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-orange-100 text-orange-800 shadow-sm">Terancam (EN)</span>
                            @elseif ($primata->status_konservasi == 'VU')
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-yellow-100 text-yellow-800 shadow-sm">Rentan (VU)</span>
                            @elseif ($primata->status_konservasi == 'NT')
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-lime-100 text-lime-800 shadow-sm">Hampir Terancam (NT)</span>
                            @elseif ($primata->status_konservasi == 'LC')
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-green-100 text-green-800 shadow-sm">Risiko Rendah (LC)</span>
                            @elseif ($primata->status_konservasi == 'DD')
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-stone-100 text-stone-700 shadow-sm">Data Kurang (DD)</span>
                            @elseif ($primata->status_konservasi == 'NE')
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-stone-50 text-stone-500 border border-stone-200 shadow-sm">Belum Dinilai (NE)</span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-stone-100 text-stone-700 shadow-sm">{{ $primata->status_konservasi }}</span>
                            @endif

                            @if ($primata->dilindungi)
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-emerald-700 text-white shadow-sm flex items-center">
                                    <i class="fa-solid fa-shield text-[10px] mr-1"></i> Dilindungi
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <h3 class="text-lg font-black text-stone-900 group-hover:text-green-700 transition">
                                {{ $primata->nama_lokal }}
                            </h3>
                            <p class="text-xs text-stone-500 italic mt-0.5 font-serif">
                                {{ $primata->nama_ilmiah }}
                            </p>

                            <p class="text-xs text-stone-600 line-clamp-3 mt-3 leading-relaxed">
                                {{ $primata->deskripsi }}
                            </p>
                        </div>

                        <div class="pt-3 border-t border-stone-100 space-y-2">
                            <div class="text-xs text-stone-500">
                                <span class="font-bold text-stone-700">Habitat:</span> {{ Str::limit($primata->habitat, 40) }}
                            </div>

                            @if ($primata->kawasanHutan->count() > 0)
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($primata->kawasanHutan->take(2) as $kws)
                                        <span class="px-2 py-0.5 rounded-md bg-stone-100 text-stone-600 text-[10px] font-medium">{{ $kws->nama }}</span>
                                    @endforeach
                                    @if ($primata->kawasanHutan->count() > 2)
                                        <span class="px-1.5 py-0.5 rounded-md bg-stone-100 text-stone-500 text-[10px]">+{{ $primata->kawasanHutan->count() - 2 }}</span>
                                    @endif
                                </div>
                            @endif

                            <div class="pt-2">
                                <a href="{{ route('primata.detail', $primata->id) }}" class="inline-flex items-center text-xs font-bold text-green-700 hover:text-green-800 transition group/link">
                                    <span>Selengkapnya</span>
                                    <i class="fa-solid fa-arrow-right ml-1.5 text-[10px] group-hover/link:translate-x-1 transition transform"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($daftarPrimata->hasPages())
            <div class="pt-6">
                {{ $daftarPrimata->links() }}
            </div>
        @endif
    @endif
</div>
