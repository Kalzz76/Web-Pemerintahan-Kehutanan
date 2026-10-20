<div>
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200/80 shadow-sm mb-5 flex flex-col sm:flex-row gap-2.5 items-center justify-between">
        <div class="relative flex-1 w-full">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-stone-400 text-xs"></i>
            <input type="text"
                wire:model.live.debounce.300ms="cari"
                placeholder="Cari nama lokal atau nama ilmiah primata..."
                class="w-full pl-9 pr-3.5 py-2 text-xs sm:text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-stone-800 focus:ring-1 focus:ring-stone-800 bg-stone-50/50 focus:bg-white">
        </div>

        <div class="flex items-center gap-2 self-end sm:self-auto">
            @if ($cari)
                <button type="button" wire:click="resetPencarian" class="px-3.5 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 border border-stone-300 font-semibold rounded-xl text-xs sm:text-sm transition text-center" title="Reset filter">
                    <i class="fa-solid fa-rotate-left"></i>
                </button>
            @endif
            <div wire:loading class="text-xs text-green-700 font-semibold px-2.5 py-1.5 bg-green-50 rounded-xl shrink-0 flex items-center gap-1.5 border border-green-200">
                <i class="fa-solid fa-spinner fa-spin text-xs"></i>
                <span>Memuat...</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-stone-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm divide-y divide-stone-200/80">
                <thead class="bg-stone-50/90 text-stone-600 uppercase text-[11px] font-bold tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4 whitespace-nowrap">Foto</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Nama Lokal</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Nama Ilmiah</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Status</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Dilindungi</th>
                        <th class="py-3.5 px-4">Sebaran Kawasan</th>
                        <th class="py-3.5 px-4 text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 text-stone-700 bg-white">
                    @forelse ($daftarPrimata as $primata)
                        <tr class="hover:bg-stone-50 transition-colors">
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if ($primata->foto)
                                    <img src="{{ asset('storage/' . $primata->foto) }}" alt="{{ $primata->nama_lokal }}" class="w-10 h-10 rounded-xl object-cover border border-stone-200">
                                @else
                                    <div class="w-10 h-10 rounded-xl bg-stone-100 text-stone-500 flex items-center justify-center text-sm border border-stone-200">
                                        <i class="fa-solid fa-paw"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-bold text-stone-900 whitespace-nowrap">
                                {{ $primata->nama_lokal }}
                            </td>
                            <td class="py-3.5 px-4 italic text-stone-600 whitespace-nowrap">
                                {{ $primata->nama_ilmiah }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="text-xs font-semibold text-stone-900">
                                    {{ $primata->status_konservasi }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="text-xs font-semibold text-stone-900">
                                    {{ $primata->dilindungi ? 'Ya' : 'Tidak' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-xs text-stone-600">
                                @if ($primata->kawasanHutan->count() > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($primata->kawasanHutan as $kws)
                                            <span class="inline-block text-stone-800 font-medium text-[11px]">{{ $kws->nama }}{{ !$loop->last ? ',' : '' }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-stone-400 italic text-[11px]">Belum dipetakan</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5 justify-end">
                                    <button type="button"
                                        onclick="bukaModalEdit(this)"
                                        data-id="{{ $primata->id }}"
                                        data-nama-lokal="{{ $primata->nama_lokal }}"
                                        data-nama-ilmiah="{{ $primata->nama_ilmiah }}"
                                        data-status-konservasi="{{ $primata->status_konservasi }}"
                                        data-dilindungi="{{ $primata->dilindungi ? '1' : '0' }}"
                                        data-habitat="{{ $primata->habitat }}"
                                        data-makanan="{{ $primata->makanan }}"
                                        data-ciri-khas="{{ $primata->ciri_khas }}"
                                        data-deskripsi="{{ $primata->deskripsi }}"
                                        data-kawasan="{{ json_encode($primata->kawasanHutan->pluck('id')) }}"
                                        data-foto-url="{{ $primata->foto ? asset('storage/' . $primata->foto) : '' }}"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 border border-stone-300 font-semibold rounded-lg text-xs transition cursor-pointer">
                                        <i class="fa-solid fa-pen-to-square text-[11px] text-stone-600"></i>
                                        <span>Edit</span>
                                    </button>

                                    <form method="POST" action="{{ route('admin.primata.destroy', $primata->id) }}" class="inline" data-confirm="Apakah Anda yakin ingin menghapus data primata {{ $primata->nama_lokal }}?" data-confirm-title="Hapus Satwa Primata" data-confirm-ok="Ya, Hapus">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-white hover:bg-stone-100 text-stone-700 hover:text-stone-900 border border-stone-300 font-semibold rounded-lg text-xs transition cursor-pointer">
                                            <i class="fa-solid fa-trash text-[11px] text-stone-500"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-stone-400">
                                <i class="fa-solid fa-paw text-3xl mb-2 block text-stone-300"></i>
                                <p class="text-xs font-medium">Belum ada data primata yang tersimpan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($daftarPrimata->hasPages())
            <div class="p-4 sm:p-5 border-t border-stone-100 bg-stone-50/50">
                {{ $daftarPrimata->links() }}
            </div>
        @endif
    </div>
</div>
