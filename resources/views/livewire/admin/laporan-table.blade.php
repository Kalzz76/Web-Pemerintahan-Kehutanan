<div>
    <div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 p-5 mb-6">
        <div class="flex flex-col lg:flex-row gap-3 items-stretch lg:items-center">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-stone-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text"
                    wire:model.live.debounce.300ms="cari"
                    placeholder="Cari kode atau isi deskripsi laporan..."
                    class="w-full pl-9 pr-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-green-600 focus:ring-1 focus:ring-green-600 outline-none transition bg-stone-50/50 focus:bg-white">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                <div class="w-full sm:w-36">
                    <select wire:model.live="status" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-green-600 outline-none transition bg-stone-50/50 focus:bg-white text-stone-700">
                        <option value="">Semua Status</option>
                        <option value="Baru">Baru</option>
                        <option value="Diverifikasi">Diverifikasi</option>
                        <option value="Ditangani">Ditangani</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>

                <div class="w-full sm:w-36">
                    <select wire:model.live="jenis" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-green-600 outline-none transition bg-stone-50/50 focus:bg-white text-stone-700">
                        <option value="">Semua Jenis</option>
                        <option value="Kebakaran">Kebakaran</option>
                        <option value="Hewan Masuk Kampung">Satwa Masuk</option>
                        <option value="Orang Hilang">Orang Hilang</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="w-full sm:w-44">
                    <select wire:model.live="idKabupatenKota" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-green-600 outline-none transition bg-stone-50/50 focus:bg-white text-stone-700">
                        <option value="">Semua Kab/Kota</option>
                        @foreach ($daftarKabupaten as $kab)
                            <option value="{{ $kab->id }}">{{ $kab->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-2">
                @if ($cari || $status || $jenis || $idKabupatenKota)
                    <button type="button" wire:click="resetFilter" class="px-3.5 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 font-semibold rounded-xl text-xs sm:text-sm transition text-center" title="Reset filter">
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
        @if ($daftarLaporan->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm divide-y divide-stone-200/80">
                    <thead>
                        <tr class="bg-stone-50/90 text-stone-600 uppercase text-[11px] font-bold tracking-wider">
                            <th class="px-4 py-3.5 whitespace-nowrap">Kode</th>
                            <th class="px-4 py-3.5 whitespace-nowrap">Jenis Kejadian</th>
                            <th class="px-4 py-3.5">Lokasi / Wilayah</th>
                            <th class="px-4 py-3.5 whitespace-nowrap">Waktu Lapor</th>
                            <th class="px-4 py-3.5">Pelapor</th>
                            <th class="px-4 py-3.5 whitespace-nowrap">Status</th>
                            <th class="px-4 py-3.5 text-right whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 text-stone-700 bg-white">
                        @foreach ($daftarLaporan as $laporan)
                            <tr class="hover:bg-stone-50 transition-colors">
                                <td class="px-4 py-3.5 whitespace-nowrap">
                                    <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="font-mono font-bold text-xs text-stone-900 hover:text-stone-600 hover:underline">
                                        {{ $laporan->kode }}
                                    </a>
                                </td>
                                <td class="px-4 py-3.5 whitespace-nowrap">
                                    <div class="font-semibold text-stone-900 text-xs">
                                        @if ($laporan->jenis === 'Kebakaran')
                                            Kebakaran
                                        @elseif ($laporan->jenis === 'Hewan Masuk Kampung')
                                            Satwa Masuk
                                        @elseif ($laporan->jenis === 'Orang Hilang')
                                            Orang Hilang
                                        @else
                                            Lainnya
                                        @endif
                                    </div>
                                    @if ($laporan->jenis === 'Hewan Masuk Kampung' && $laporan->jenis_hewan)
                                        <div class="text-[11px] text-stone-500 font-normal mt-0.5">{{ $laporan->jenis_hewan }}</div>
                                    @elseif ($laporan->jenis === 'Orang Hilang' && !empty($laporan->detail_kejadian['nama_korban']))
                                        <div class="text-[11px] text-stone-500 font-normal mt-0.5">{{ $laporan->detail_kejadian['nama_korban'] }}</div>
                                    @elseif ($laporan->jenis === 'Lainnya' && !empty($laporan->detail_kejadian['kategori_lainnya']))
                                        <div class="text-[11px] text-stone-500 font-normal mt-0.5 truncate max-w-[140px]">{{ $laporan->detail_kejadian['kategori_lainnya'] }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5">
                                    @if ($laporan->kabupatenKota)
                                        <div class="font-semibold text-stone-900 text-xs">{{ $laporan->kabupatenKota->nama }}</div>
                                        @if ($laporan->kawasanHutan)
                                            <div class="text-[11px] text-stone-500 truncate max-w-[200px]" title="{{ $laporan->kawasanHutan->nama }}">
                                                {{ $laporan->kawasanHutan->nama }}
                                            </div>
                                        @endif
                                    @elseif ($laporan->kawasanHutan)
                                        <div class="font-semibold text-stone-900 text-xs truncate max-w-[200px]" title="{{ $laporan->kawasanHutan->nama }}">
                                            {{ $laporan->kawasanHutan->nama }}
                                        </div>
                                        <div class="text-[11px] text-stone-500">Jawa Barat</div>
                                    @else
                                        <div class="font-semibold text-stone-900 text-xs">Jawa Barat</div>
                                        <div class="text-[11px] text-stone-500">Belum ditentukan</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 whitespace-nowrap text-xs">
                                    <div class="font-medium text-stone-900">{{ \Carbon\Carbon::parse($laporan->created_at)->locale('id')->isoFormat('D MMM Y') }}</div>
                                    <div class="text-[11px] text-stone-500 font-mono">{{ \Carbon\Carbon::parse($laporan->created_at)->format('H:i') }} WIB</div>
                                </td>
                                <td class="px-4 py-3.5 text-xs">
                                    <div class="font-semibold text-stone-900 truncate max-w-[140px]" title="{{ $laporan->nama_pelapor ?: 'Warga Anonim' }}">
                                        {{ $laporan->nama_pelapor ?: 'Warga Anonim' }}
                                    </div>
                                    <div class="text-stone-500 font-mono text-[11px]">{{ $laporan->no_hp ?: '-' }}</div>
                                </td>
                                <td class="px-4 py-3.5 whitespace-nowrap">
                                    <span class="text-xs font-semibold text-stone-900">
                                        {{ $laporan->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5 justify-end">
                                        @if ($laporan->jenis === 'Kebakaran' && $laporan->status !== 'Selesai' && $laporan->latitude && $laporan->longitude)
                                            <a href="{{ route('admin.prediksi.index', ['id_laporan' => $laporan->id, 'lat' => $laporan->latitude, 'long' => $laporan->longitude]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 font-semibold rounded-lg text-xs transition" title="Buka dan Prediksi di Peta Kebakaran">
                                                <i class="fa-solid fa-fire text-[11px] text-red-600"></i>
                                                <span>Prediksi</span>
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 border border-stone-300 font-semibold rounded-lg text-xs transition">
                                            <i class="fa-solid fa-eye text-[11px] text-stone-600"></i>
                                            <span>Detail</span>
                                        </a>
                                        <form method="POST" action="{{ route('admin.laporan.destroy', $laporan->id) }}" class="inline" data-confirm="Apakah Anda yakin ingin menghapus laporan {{ $laporan->kode }}?" data-confirm-title="Hapus Laporan" data-confirm-ok="Ya, Hapus">
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
                {{ $daftarLaporan->links() }}
            </div>
        @else
            <div class="p-12 text-center text-stone-400">
                <i class="fa-solid fa-clipboard-list text-4xl mb-3 text-stone-300"></i>
                <p class="text-sm font-medium">Belum ada laporan darurat yang sesuai filter.</p>
            </div>
        @endif
    </div>
</div>
