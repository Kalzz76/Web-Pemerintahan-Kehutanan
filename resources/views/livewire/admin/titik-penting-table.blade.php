<div>
    <div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 p-4 sm:p-5 mb-5">
        <div class="flex flex-col sm:flex-row gap-2.5 items-center">
            <div class="relative flex-1 w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-stone-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text"
                    wire:model.live.debounce.300ms="cari"
                    placeholder="Cari nama titik penting..."
                    class="w-full pl-9 pr-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-800 focus:ring-1 focus:ring-stone-800 outline-none transition bg-stone-50/50 focus:bg-white">
            </div>

            <div class="flex items-center gap-2 self-end sm:self-auto">
                @if ($cari)
                    <button type="button" wire:click="resetPencarian" class="px-3.5 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 border border-stone-300 font-semibold rounded-xl text-xs sm:text-sm transition text-center" title="Reset pencarian">
                        <i class="fa-solid fa-rotate-left"></i>
                    </button>
                @endif
                <div wire:loading class="text-xs text-green-700 font-semibold px-2.5 py-1.5 bg-green-50 rounded-xl shrink-0 flex items-center gap-1.5 border border-green-200">
                    <i class="fa-solid fa-spinner fa-spin text-xs"></i>
                    <span>Memuat...</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 overflow-hidden">
        @if ($daftarTitik->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm divide-y divide-stone-200/80">
                    <thead>
                        <tr class="bg-stone-50/90 text-stone-600 uppercase text-[11px] font-bold tracking-wider">
                            <th class="px-4 py-3.5">Titik & Foto</th>
                            <th class="px-4 py-3.5 whitespace-nowrap">Jenis</th>
                            <th class="px-4 py-3.5">Lokasi / Wilayah</th>
                            <th class="px-4 py-3.5 whitespace-nowrap">Koordinat</th>
                            <th class="px-4 py-3.5 whitespace-nowrap">Kontak</th>
                            <th class="px-4 py-3.5 text-right whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 text-stone-700 bg-white">
                        @foreach ($daftarTitik as $item)
                            <tr class="hover:bg-stone-50 transition-colors">
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-xl bg-stone-100 border border-stone-200 flex items-center justify-center shrink-0 overflow-hidden relative">
                                            @if ($item->foto_url)
                                                <img src="{{ $item->foto_url }}" alt="{{ $item->nama }}" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');">
                                                <div class="hidden w-full h-full flex items-center justify-center bg-stone-100 text-stone-500 text-sm">
                                                    <i class="fa-solid fa-location-dot"></i>
                                                </div>
                                            @else
                                                <i class="fa-solid fa-location-dot text-stone-500 text-sm"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-stone-900 text-xs sm:text-sm">{{ $item->nama }}</div>
                                            <div class="text-[11px] text-stone-500 line-clamp-1 max-w-xs">{{ $item->deskripsi }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 whitespace-nowrap">
                                    <span class="text-xs font-semibold text-stone-900">
                                        {{ $item->jenis }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 text-xs text-stone-600">
                                    @if ($item->kabupatenKota)
                                        <div class="font-semibold text-stone-900">{{ $item->kabupatenKota->nama }}</div>
                                        @if ($item->kawasanHutan)
                                            <div class="text-[11px] text-stone-500">{{ $item->kawasanHutan->nama }}</div>
                                        @endif
                                    @elseif ($item->kawasanHutan)
                                        <div class="font-semibold text-stone-900">{{ $item->kawasanHutan->nama }}</div>
                                        <div class="text-[11px] text-stone-400">Jawa Barat</div>
                                    @else
                                        <div class="font-medium text-stone-800">Luar Kawasan</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 font-mono text-xs text-stone-600 whitespace-nowrap">
                                    {{ number_format($item->latitude, 4) }}, {{ number_format($item->longitude, 4) }}
                                </td>
                                <td class="px-4 py-3.5 text-xs text-stone-600 whitespace-nowrap">
                                    @if ($item->kontak)
                                        <div class="font-medium text-stone-800">{{ $item->kontak }}</div>
                                    @else
                                        <span class="text-stone-400 italic text-[11px]">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5 justify-end">
                                        <a href="{{ route('admin.titik-penting.edit', $item->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 border border-stone-300 font-semibold rounded-lg text-xs transition">
                                            <i class="fa-solid fa-pen-to-square text-[11px] text-stone-600"></i>
                                            <span>Edit</span>
                                        </a>
                                        <form method="POST" action="{{ route('admin.titik-penting.destroy', $item->id) }}" class="inline" data-confirm="Apakah Anda yakin ingin menghapus titik penting {{ $item->nama }}?" data-confirm-title="Hapus Titik Penting" data-confirm-ok="Ya, Hapus">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-stone-100 text-stone-700 hover:text-stone-900 border border-stone-300 font-semibold rounded-lg text-xs transition">
                                                <i class="fa-solid fa-trash text-[11px] text-stone-500"></i>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 sm:p-5 border-t border-stone-100 bg-stone-50/50">
                {{ $daftarTitik->links() }}
            </div>
        @else
            <div class="p-12 text-center text-stone-400">
                <i class="fa-solid fa-location-dot text-3xl mb-2 block text-stone-300"></i>
                <p class="text-xs font-medium">Tidak ada data titik penting yang cocok.</p>
            </div>
        @endif
    </div>
</div>
