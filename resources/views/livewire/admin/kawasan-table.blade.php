<div>
    <div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 p-4 sm:p-5 mb-5">
        <div class="flex flex-col sm:flex-row gap-2.5 items-center">
            <div class="relative flex-1 w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-stone-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text"
                    wire:model.live.debounce.300ms="cari"
                    placeholder="Cari nama kawasan..."
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
        @if ($daftarKawasan->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm divide-y divide-stone-200/80">
                    <thead>
                        <tr class="bg-stone-50/90 text-stone-600 uppercase text-[11px] font-bold tracking-wider">
                            <th class="px-4 py-3.5">Nama & Kategori</th>
                            <th class="px-4 py-3.5 whitespace-nowrap">Status Batas</th>
                            <th class="px-4 py-3.5 whitespace-nowrap">Jenis Lahan</th>
                            <th class="px-4 py-3.5 whitespace-nowrap">Luas (ha)</th>
                            <th class="px-4 py-3.5">Kabupaten/Kota</th>
                            <th class="px-4 py-3.5 text-right whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 text-stone-700 bg-white">
                        @foreach ($daftarKawasan as $item)
                            <tr class="hover:bg-stone-50 transition-colors">
                                <td class="px-4 py-3.5">
                                    <div class="font-bold text-stone-900 text-xs sm:text-sm">{{ $item->nama }}</div>
                                    <div class="text-[11px] text-stone-600 font-semibold mt-0.5">{{ $item->kategori }}</div>
                                    @if ($item->pengelola)
                                        <div class="text-[11px] text-stone-500 mt-0.5">Pengelola: {{ $item->pengelola }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 whitespace-nowrap">
                                    <span class="text-xs font-semibold text-stone-900">
                                        {{ $item->batas_resmi ? 'Resmi' : 'Perkiraan' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 whitespace-nowrap">
                                    <span class="text-xs font-medium text-stone-800">
                                        {{ $item->jenisLahan->nama ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 font-mono text-xs whitespace-nowrap font-medium text-stone-800">
                                    {{ $item->luas_ha ? number_format($item->luas_ha, 2, ',', '.') . ' ha' : '-' }}
                                </td>
                                <td class="px-4 py-3.5 text-xs text-stone-600 max-w-xs">
                                    @if ($item->kabupatenKota->count() > 0)
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($item->kabupatenKota as $kab)
                                                <span class="inline-block text-stone-800 font-medium text-[11px]">{{ $kab->nama }}{{ !$loop->last ? ',' : '' }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-stone-400 italic text-[11px]">Belum diatur</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5 justify-end">
                                        <a href="{{ route('admin.kawasan.edit', $item->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 border border-stone-300 font-semibold rounded-lg text-xs transition">
                                            <i class="fa-solid fa-pen-to-square text-[11px] text-stone-600"></i>
                                            <span>Edit</span>
                                        </a>
                                        <form method="POST" action="{{ route('admin.kawasan.destroy', $item->id) }}" class="inline" data-confirm="Apakah Anda yakin ingin menghapus kawasan {{ $item->nama }}?" data-confirm-title="Hapus Kawasan" data-confirm-ok="Ya, Hapus">
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
                {{ $daftarKawasan->links() }}
            </div>
        @else
            <div class="p-12 text-center text-stone-400">
                <i class="fa-solid fa-tree text-3xl mb-2 block text-stone-300"></i>
                <p class="text-xs font-medium">Tidak ada data kawasan hutan yang cocok.</p>
            </div>
        @endif
    </div>
</div>
