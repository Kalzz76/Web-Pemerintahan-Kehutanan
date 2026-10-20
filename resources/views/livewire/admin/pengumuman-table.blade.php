<div class="space-y-4">
    <div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 p-4 sm:p-5">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-stone-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" wire:model.live.debounce.300ms="cari" placeholder="Cari judul atau isi pengumuman..." class="w-full pl-10 pr-4 py-2 text-xs sm:text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 transition">
            </div>

            <select wire:model.live="kategori" class="px-3.5 py-2 text-xs sm:text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 bg-white">
                <option value="">Semua Kategori</option>
                <option value="Kabar">Kabar</option>
                <option value="Pengumuman">Pengumuman</option>
                <option value="Tips Keselamatan">Tips Keselamatan</option>
            </select>

            <select wire:model.live="status" class="px-3.5 py-2 text-xs sm:text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 bg-white">
                <option value="">Semua Status</option>
                <option value="Publish">Publish</option>
                <option value="Draft">Draft</option>
            </select>

            @if (!empty($cari) || !empty($kategori) || !empty($status))
                <button type="button" wire:click="resetFilter" class="px-3.5 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 border border-stone-300 font-semibold rounded-xl text-xs sm:text-sm transition text-center">
                    Reset
                </button>
            @endif
        </div>

        <div wire:loading class="text-xs text-stone-500 font-medium mt-2 flex items-center gap-1.5">
            <i class="fa-solid fa-circle-notch fa-spin"></i> Memuat...
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-stone-50/90 text-stone-600 uppercase text-[11px] font-bold tracking-wider">
                        <th class="px-4 py-3.5">Judul</th>
                        <th class="px-4 py-3.5">Kategori</th>
                        <th class="px-4 py-3.5">Tanggal</th>
                        <th class="px-4 py-3.5">Status</th>
                        <th class="px-4 py-3.5">Penulis</th>
                        <th class="px-4 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-200/70 text-stone-700">
                    @forelse ($daftarPengumuman as $item)
                        <tr class="hover:bg-stone-50/80 transition">
                            <td class="px-4 py-3.5 font-bold text-stone-900 max-w-xs text-xs sm:text-sm">
                                <div class="flex items-center space-x-3">
                                    @if ($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-9 h-9 rounded-lg object-cover shrink-0 border border-stone-200">
                                    @endif
                                    <span class="truncate block">{{ $item->judul }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-xs font-semibold text-stone-700 whitespace-nowrap">
                                {{ $item->kategori }}
                            </td>
                            <td class="px-4 py-3.5 text-xs text-stone-600 whitespace-nowrap">
                                {{ $item->tanggal ? $item->tanggal->format('d M Y') : '-' }}
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap">
                                @if ($item->status == 'Publish')
                                    <span class="text-xs font-semibold text-stone-900">Publish</span>
                                @else
                                    <span class="text-xs font-medium text-stone-400">Draft</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-xs text-stone-500 whitespace-nowrap">
                                {{ $item->user->name ?? 'Admin' }}
                            </td>
                            <td class="px-4 py-3.5 text-right whitespace-nowrap space-x-1.5">
                                <button type="button"
                                    onclick="bukaModalEdit(this)"
                                    data-id="{{ $item->id }}"
                                    data-judul="{{ $item->judul }}"
                                    data-kategori="{{ $item->kategori }}"
                                    data-isi="{{ $item->isi }}"
                                    data-tanggal="{{ $item->tanggal ? $item->tanggal->format('Y-m-d') : '' }}"
                                    data-status="{{ $item->status }}"
                                    data-gambar-url="{{ $item->gambar ? asset('storage/' . $item->gambar) : '' }}"
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 border border-stone-300 font-semibold rounded-lg text-xs transition">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Edit</span>
                                </button>

                                <form method="POST" action="{{ route('admin.pengumuman.destroy', $item->id) }}" class="inline" data-confirm="Apakah Anda yakin ingin menghapus pengumuman ini?" data-confirm-title="Hapus Pengumuman" data-confirm-ok="Ya, Hapus">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-white hover:bg-stone-100 text-stone-700 hover:text-stone-900 border border-stone-300 font-semibold rounded-lg text-xs transition">
                                        <i class="fa-solid fa-trash"></i>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-stone-400">
                                <i class="fa-solid fa-bullhorn text-3xl mb-2 block text-stone-300"></i>
                                <p class="text-xs font-medium">Belum ada pengumuman yang tersimpan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($daftarPengumuman->hasPages())
            <div class="p-4 border-t border-stone-200/80">
                {{ $daftarPengumuman->links() }}
            </div>
        @endif
    </div>
</div>
