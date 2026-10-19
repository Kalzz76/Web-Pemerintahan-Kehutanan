@extends('layouts.admin')

@section('title', 'Kelola Jadwal Patroli')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-stone-900 tracking-tight">H. Jadwal Patroli Hutan</h1>
            <p class="text-sm text-stone-500 mt-1">
                Atur agenda patroli keliling satgas, pemantauan batas kawasan, dan siaga karhutla.
            </p>
        </div>
        <button type="button" onclick="bukaModalTambah()" class="inline-flex items-center px-4 py-2.5 bg-green-700 hover:bg-green-600 text-white font-bold rounded-xl text-sm shadow transition">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Jadwal Patroli
        </button>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-700 text-sm">
            <div class="font-bold mb-1 flex items-center">
                <i class="fa-solid fa-triangle-exclamation mr-2"></i> Terjadi kesalahan input:
            </div>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-4 rounded-2xl border border-stone-200 shadow-sm flex flex-col md:flex-row gap-3 items-center justify-between">
        <form method="GET" action="{{ route('admin.jadwal-patroli.index') }}" class="w-full md:w-auto flex flex-col sm:flex-row gap-3 flex-1">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-stone-400 text-sm"></i>
                <input type="text" name="cari" value="{{ $cari ?? '' }}" placeholder="Cari kegiatan, lokasi, atau keterangan..." class="w-full pl-10 pr-4 py-2 text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-green-600">
            </div>

            <button type="submit" class="px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-bold rounded-xl text-sm transition">
                Cari
            </button>

            @if (!empty($cari))
                <a href="{{ route('admin.jadwal-patroli.index') }}" class="px-3 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 font-semibold rounded-xl text-sm transition text-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-stone-100 text-stone-700 uppercase text-xs">
                    <tr>
                        <th class="py-3 px-4">Kegiatan</th>
                        <th class="py-3 px-4">Tanggal & Waktu</th>
                        <th class="py-3 px-4">Lokasi Patroli</th>
                        <th class="py-3 px-4">Keterangan</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($daftarJadwal as $jadwal)
                        @php
                            $lewat = $jadwal->tanggal ? $jadwal->tanggal->isPast() && !$jadwal->tanggal->isToday() : false;
                        @endphp
                        <tr class="hover:bg-stone-50 transition">
                            <td class="py-3 px-4 font-bold text-stone-900">
                                {{ $jadwal->judul }}
                            </td>
                            <td class="py-3 px-4 text-xs">
                                <div class="font-bold text-stone-800">{{ $jadwal->tanggal ? $jadwal->tanggal->format('d M Y') : '-' }}</div>
                                <div class="text-stone-500">{{ $jadwal->jam }}</div>
                            </td>
                            <td class="py-3 px-4 text-xs font-semibold text-stone-700">
                                <i class="fa-solid fa-location-dot text-rose-500 mr-1"></i>
                                {{ $jadwal->lokasi }}
                            </td>
                            <td class="py-3 px-4 text-xs text-stone-500 max-w-xs truncate">
                                {{ $jadwal->keterangan ?? '-' }}
                            </td>
                            <td class="py-3 px-4">
                                @if ($lewat)
                                    <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-stone-100 text-stone-500">Selesai / Lewat</span>
                                @elseif ($jadwal->tanggal && $jadwal->tanggal->isToday())
                                    <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 animate-pulse">Hari Ini</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Mendatang</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center whitespace-nowrap">
                                <div class="inline-flex items-center space-x-2">
                                    <button type="button"
                                        onclick="bukaModalEdit(this)"
                                        data-id="{{ $jadwal->id }}"
                                        data-judul="{{ $jadwal->judul }}"
                                        data-tanggal="{{ $jadwal->tanggal ? $jadwal->tanggal->format('Y-m-d') : '' }}"
                                        data-jam="{{ $jadwal->jam }}"
                                        data-lokasi="{{ $jadwal->lokasi }}"
                                        data-keterangan="{{ $jadwal->keterangan }}"
                                        class="px-3 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-xl text-xs font-bold transition">
                                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                    </button>

                                    <form method="POST" action="{{ route('admin.jadwal-patroli.destroy', $jadwal->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal patroli ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl text-xs font-bold transition">
                                            <i class="fa-solid fa-trash mr-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-stone-400">
                                <i class="fa-solid fa-calendar-days text-3xl mb-2 block text-stone-300"></i>
                                Belum ada jadwal patroli yang tersimpan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($daftarJadwal->hasPages())
            <div class="p-4 border-t border-stone-100">
                {{ $daftarJadwal->links() }}
            </div>
        @endif
    </div>
</div>

<div id="modal-jadwal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-stone-900/60 backdrop-blur-sm p-4 sm:p-6 flex items-center justify-center">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl space-y-6">
        <div class="flex items-center justify-between border-b border-stone-100 pb-4">
            <h3 id="modal-judul" class="text-lg font-black text-stone-900">Tambah Jadwal Patroli</h3>
            <button type="button" onclick="tutupModal()" class="w-8 h-8 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-600 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="form-jadwal" method="POST" action="{{ route('admin.jadwal-patroli.store') }}" class="space-y-4">
            @csrf
            <div id="metode-put"></div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Judul Kegiatan Patroli <span class="text-rose-500">*</span></label>
                <input type="text" name="judul" id="input-judul" required placeholder="Contoh: Patroli Siaga Jalur Timur" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Tanggal <span class="text-rose-500">*</span></label>
                    <input type="date" name="tanggal" id="input-tanggal" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm bg-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Jam Pelaksanaan <span class="text-rose-500">*</span></label>
                    <input type="text" name="jam" id="input-jam" required placeholder="08:00 - 12:00 WIB" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Lokasi / Rute Patroli <span class="text-rose-500">*</span></label>
                <input type="text" name="lokasi" id="input-lokasi" required placeholder="Contoh: Jalur Blok Cikawung - Batas Dusun" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm">
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Keterangan / Personel (Opsional)</label>
                <textarea name="keterangan" id="input-keterangan" rows="3" placeholder="Nama tim petugas, perlengkapan yang dibawa..." class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm"></textarea>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-stone-100">
                <button type="button" onclick="tutupModal()" class="px-5 py-2.5 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 font-bold text-sm transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-green-700 hover:bg-green-600 text-white font-bold text-sm transition shadow">
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
