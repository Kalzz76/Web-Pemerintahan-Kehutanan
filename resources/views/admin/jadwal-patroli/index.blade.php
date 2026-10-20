@extends('layouts.admin')

@section('title', 'Kelola Jadwal Patroli')

@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-lg md:text-xl font-bold text-stone-900 tracking-tight">Jadwal Patroli Hutan</h1>
            <p class="text-stone-500 text-xs mt-0.5">
                Atur agenda patroli keliling satgas, pemantauan batas kawasan, dan siaga karhutla.
            </p>
        </div>
        <button type="button" onclick="bukaModalTambah()" class="inline-flex items-center px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl text-xs sm:text-sm shadow-sm transition active:scale-95 shrink-0">
            <i class="fa-solid fa-plus mr-1.5 text-xs"></i>
            <span>Tambah Jadwal Patroli</span>
        </button>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-stone-100 border border-stone-300 rounded-2xl text-stone-800 text-xs">
            <div class="font-bold mb-1 flex items-center">
                <i class="fa-solid fa-triangle-exclamation mr-1.5"></i>
                <span>Terjadi kesalahan input:</span>
            </div>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 p-4 sm:p-5">
        <form method="GET" action="{{ route('admin.jadwal-patroli.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-stone-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="cari" value="{{ $cari ?? '' }}" placeholder="Cari kegiatan, lokasi, atau keterangan..." class="w-full pl-10 pr-4 py-2 text-xs sm:text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 transition">
            </div>

            <button type="submit" class="px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl text-xs sm:text-sm transition">
                Cari
            </button>

            @if (!empty($cari))
                <a href="{{ route('admin.jadwal-patroli.index') }}" class="px-3.5 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 border border-stone-300 font-semibold rounded-xl text-xs sm:text-sm transition text-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-stone-50/90 text-stone-600 uppercase text-[11px] font-bold tracking-wider">
                        <th class="px-4 py-3.5">Kegiatan</th>
                        <th class="px-4 py-3.5">Tanggal & Waktu</th>
                        <th class="px-4 py-3.5">Lokasi Patroli</th>
                        <th class="px-4 py-3.5">Keterangan</th>
                        <th class="px-4 py-3.5">Status</th>
                        <th class="px-4 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-200/70 text-stone-700">
                    @forelse ($daftarJadwal as $jadwal)
                        @php
                            $lewat = $jadwal->tanggal ? $jadwal->tanggal->isPast() && !$jadwal->tanggal->isToday() : false;
                        @endphp
                        <tr class="hover:bg-stone-50/80 transition">
                            <td class="px-4 py-3.5 font-bold text-stone-900 text-xs sm:text-sm">
                                {{ $jadwal->judul }}
                            </td>
                            <td class="px-4 py-3.5 text-xs">
                                <div class="font-bold text-stone-800">{{ $jadwal->tanggal ? $jadwal->tanggal->format('d M Y') : '-' }}</div>
                                <div class="text-stone-500 text-[11px]">{{ $jadwal->jam }}</div>
                            </td>
                            <td class="px-4 py-3.5 text-xs font-semibold text-stone-700">
                                <i class="fa-solid fa-location-dot text-stone-400 mr-1 text-[11px]"></i>
                                {{ $jadwal->lokasi }}
                            </td>
                            <td class="px-4 py-3.5 text-xs text-stone-500 max-w-xs truncate">
                                {{ $jadwal->keterangan ?? '-' }}
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap">
                                @if ($lewat)
                                    <span class="text-xs text-stone-400 font-medium">Selesai / Lewat</span>
                                @elseif ($jadwal->tanggal && $jadwal->tanggal->isToday())
                                    <span class="text-xs text-stone-900 font-bold">Hari Ini</span>
                                @else
                                    <span class="text-xs text-stone-700 font-semibold">Mendatang</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-right whitespace-nowrap space-x-1.5">
                                <button type="button"
                                    onclick="bukaModalEdit(this)"
                                    data-id="{{ $jadwal->id }}"
                                    data-judul="{{ $jadwal->judul }}"
                                    data-tanggal="{{ $jadwal->tanggal ? $jadwal->tanggal->format('Y-m-d') : '' }}"
                                    data-jam="{{ $jadwal->jam }}"
                                    data-lokasi="{{ $jadwal->lokasi }}"
                                    data-keterangan="{{ $jadwal->keterangan }}"
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 border border-stone-300 font-semibold rounded-lg text-xs transition">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Edit</span>
                                </button>

                                <form method="POST" action="{{ route('admin.jadwal-patroli.destroy', $jadwal->id) }}" class="inline" data-confirm="Apakah Anda yakin ingin menghapus jadwal patroli ini?" data-confirm-title="Hapus Jadwal Patroli" data-confirm-ok="Ya, Hapus">
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
                                <i class="fa-solid fa-calendar-days text-3xl mb-2 block text-stone-300"></i>
                                <p class="text-xs font-medium">Belum ada jadwal patroli yang tersimpan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($daftarJadwal->hasPages())
            <div class="p-4 border-t border-stone-200/80">
                {{ $daftarJadwal->links() }}
            </div>
        @endif
    </div>
</div>

<div id="modal-jadwal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-stone-950/60 backdrop-blur-sm p-4 sm:p-6 flex items-center justify-center">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl space-y-5 border border-stone-200">
        <div class="flex items-center justify-between border-b border-stone-200/80 pb-3">
            <h3 id="modal-judul" class="text-base font-bold text-stone-900">Tambah Jadwal Patroli</h3>
            <button type="button" onclick="tutupModal()" class="text-stone-400 hover:text-stone-700 text-base">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="form-jadwal" method="POST" action="{{ route('admin.jadwal-patroli.store') }}" class="space-y-4">
            @csrf
            <div id="metode-put"></div>

            <div>
                <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Judul Kegiatan Patroli <span class="text-rose-500">*</span></label>
                <input type="text" name="judul" id="input-judul" required placeholder="Contoh: Patroli Siaga Jalur Timur" class="w-full px-3.5 py-2 rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 text-xs sm:text-sm">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Tanggal <span class="text-rose-500">*</span></label>
                    <input type="date" name="tanggal" id="input-tanggal" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 text-xs sm:text-sm bg-white">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Jam Pelaksanaan <span class="text-rose-500">*</span></label>
                    <input type="text" name="jam" id="input-jam" required placeholder="08:00 - 12:00 WIB" class="w-full px-3.5 py-2 rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 text-xs sm:text-sm">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Lokasi / Rute Patroli <span class="text-rose-500">*</span></label>
                <input type="text" name="lokasi" id="input-lokasi" required placeholder="Contoh: Jalur Blok Cikawung - Batas Dusun" class="w-full px-3.5 py-2 rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 text-xs sm:text-sm">
            </div>

            <div>
                <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Keterangan / Personel (Opsional)</label>
                <textarea name="keterangan" id="input-keterangan" rows="3" placeholder="Nama tim petugas, perlengkapan yang dibawa..." class="w-full px-3.5 py-2 rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 text-xs sm:text-sm"></textarea>
            </div>

            <div class="flex items-center justify-end space-x-2 pt-3 border-t border-stone-200/80">
                <button type="button" onclick="tutupModal()" class="px-4 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 border border-stone-300 font-semibold text-xs transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-stone-900 hover:bg-stone-800 text-white font-semibold text-xs transition active:scale-95 shadow-sm">
                    Simpan Jadwal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    var modal = document.getElementById('modal-jadwal');
    var form = document.getElementById('form-jadwal');
    var judul = document.getElementById('modal-judul');
    var wadahPut = document.getElementById('metode-put');

    function bukaModalTambah() {
        judul.textContent = 'Tambah Jadwal Patroli';
        form.action = "{{ route('admin.jadwal-patroli.store') }}";
        wadahPut.innerHTML = '';

        document.getElementById('input-judul').value = '';
        document.getElementById('input-tanggal').value = "{{ date('Y-m-d') }}";
        document.getElementById('input-jam').value = '08:00 - 12:00 WIB';
        document.getElementById('input-lokasi').value = '';
        document.getElementById('input-keterangan').value = '';

        modal.classList.remove('hidden');
    }

    function bukaModalEdit(el) {
        var id = el.getAttribute('data-id');
        var judulItem = el.getAttribute('data-judul');
        var tanggal = el.getAttribute('data-tanggal');
        var jam = el.getAttribute('data-jam');
        var lokasi = el.getAttribute('data-lokasi');
        var keterangan = el.getAttribute('data-keterangan');

        judul.textContent = 'Edit Jadwal Patroli';
        form.action = "{{ url('admin/jadwal-patroli') }}/" + id;
        wadahPut.innerHTML = '<input type="hidden" name="_method" value="PUT">';

        document.getElementById('input-judul').value = judulItem;
        document.getElementById('input-tanggal').value = tanggal;
        document.getElementById('input-jam').value = jam;
        document.getElementById('input-lokasi').value = lokasi;
        document.getElementById('input-keterangan').value = keterangan || '';

        modal.classList.remove('hidden');
    }

    function tutupModal() {
        modal.classList.add('hidden');
    }
</script>
@endsection
