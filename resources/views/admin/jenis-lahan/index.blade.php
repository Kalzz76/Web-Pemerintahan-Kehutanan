@extends('layouts.admin')

@section('title', 'Jenis Lahan')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
    <div>
        <h1 class="text-lg md:text-xl font-bold text-stone-900 tracking-tight">Jenis Lahan</h1>
        <p class="text-stone-500 text-xs mt-0.5">Daftar tipe vegetasi dan nilai laju dasar perambatan api (meter per jam).</p>
    </div>
    <button type="button" onclick="bukaModalTambah()" class="inline-flex items-center px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl text-xs sm:text-sm shadow-sm transition active:scale-95 shrink-0">
        <i class="fa-solid fa-plus mr-1.5 text-xs"></i>
        <span>Tambah Jenis Lahan</span>
    </button>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 p-4 sm:p-5 mb-5">
    <form method="GET" action="{{ route('admin.jenis-lahan.index') }}" class="flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-stone-400">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
            </span>
            <input type="text" name="cari" value="{{ $cari }}" placeholder="Cari nama jenis lahan atau keterangan..." class="w-full pl-10 pr-4 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition">
        </div>
        <button type="submit" class="px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl text-xs sm:text-sm transition">
            Cari
        </button>
        @if ($cari)
            <a href="{{ route('admin.jenis-lahan.index') }}" class="px-3.5 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 border border-stone-300 font-semibold rounded-xl text-xs sm:text-sm transition text-center">
                Reset
            </a>
        @endif
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-stone-200/80 overflow-hidden">
    @if ($daftarJenisLahan->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-stone-50/90 text-stone-600 uppercase text-[11px] font-bold tracking-wider">
                        <th class="px-4 py-3.5">Nama Jenis Lahan</th>
                        <th class="px-4 py-3.5">Laju Dasar Api</th>
                        <th class="px-4 py-3.5">Keterangan</th>
                        <th class="px-4 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-200/70 text-stone-700">
                    @foreach ($daftarJenisLahan as $item)
                        <tr class="hover:bg-stone-50/80 transition">
                            <td class="px-4 py-3.5 font-bold text-stone-900 text-xs sm:text-sm">
                                {{ $item->nama }}
                            </td>
                            <td class="px-4 py-3.5 font-mono font-bold text-xs text-stone-800">
                                {{ $item->laju_dasar }} m/jam
                            </td>
                            <td class="px-4 py-3.5 text-xs text-stone-500 max-w-md">
                                {{ $item->keterangan ?? '-' }}
                            </td>
                            <td class="px-4 py-3.5 text-right space-x-1.5 whitespace-nowrap">
                                <button type="button"
                                    data-id="{{ $item->id }}"
                                    data-nama="{{ $item->nama }}"
                                    data-laju="{{ $item->laju_dasar }}"
                                    data-keterangan="{{ $item->keterangan }}"
                                    onclick="bukaModalEdit(this)"
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 border border-stone-300 font-semibold rounded-lg text-xs transition">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Edit</span>
                                </button>
                                <form method="POST" action="{{ route('admin.jenis-lahan.destroy', $item->id) }}" class="inline" data-confirm="Apakah Anda yakin ingin menghapus jenis lahan {{ $item->nama }}?" data-confirm-title="Hapus Jenis Lahan" data-confirm-ok="Ya, Hapus">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-white hover:bg-stone-100 text-stone-700 hover:text-stone-900 border border-stone-300 font-semibold rounded-lg text-xs transition">
                                        <i class="fa-solid fa-trash"></i>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-stone-200/80">
            {{ $daftarJenisLahan->links() }}
        </div>
    @else
        <div class="p-12 text-center text-stone-400">
            <i class="fa-solid fa-layer-group text-3xl mb-2 text-stone-300 block"></i>
            <p class="text-xs font-medium">Belum ada data jenis lahan.</p>
        </div>
    @endif
</div>

<div id="modal-tambah" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-stone-950/60 backdrop-blur-sm">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full shadow-2xl border border-stone-200">
        <div class="flex items-center justify-between pb-3 border-b border-stone-200/80 mb-4">
            <h3 class="text-base font-bold text-stone-900">Tambah Jenis Lahan</h3>
            <button type="button" onclick="tutupModalTambah()" class="text-stone-400 hover:text-stone-700 text-base">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.jenis-lahan.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="tambah-nama" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Nama Jenis Lahan</label>
                <input type="text" id="tambah-nama" name="nama" required placeholder="Contoh: Semak Belukar" class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition">
            </div>

            <div>
                <label for="tambah-laju" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Laju Dasar Api (m/jam)</label>
                <input type="number" id="tambah-laju" name="laju_dasar" required min="1" placeholder="Contoh: 400" class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition">
            </div>

            <div>
                <label for="tambah-keterangan" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Keterangan (Opsional)</label>
                <textarea id="tambah-keterangan" name="keterangan" rows="3" placeholder="Deskripsi karakteristik vegetasi..." class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition"></textarea>
            </div>

            <div class="flex items-center justify-end space-x-2 pt-3 border-t border-stone-200/80">
                <button type="button" onclick="tutupModalTambah()" class="px-4 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 border border-stone-300 text-xs font-semibold transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-stone-900 hover:bg-stone-800 text-white text-xs font-semibold transition active:scale-95 shadow-sm">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modal-edit" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-stone-950/60 backdrop-blur-sm">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full shadow-2xl border border-stone-200">
        <div class="flex items-center justify-between pb-3 border-b border-stone-200/80 mb-4">
            <h3 class="text-base font-bold text-stone-900">Edit Jenis Lahan</h3>
            <button type="button" onclick="tutupModalEdit()" class="text-stone-400 hover:text-stone-700 text-base">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="form-edit" method="POST" action="" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="edit-nama" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Nama Jenis Lahan</label>
                <input type="text" id="edit-nama" name="nama" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition">
            </div>

            <div>
                <label for="edit-laju" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Laju Dasar Api (m/jam)</label>
                <input type="number" id="edit-laju" name="laju_dasar" required min="1" class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition">
            </div>

            <div>
                <label for="edit-keterangan" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Keterangan (Opsional)</label>
                <textarea id="edit-keterangan" name="keterangan" rows="3" class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs sm:text-sm focus:border-stone-900 outline-none transition"></textarea>
            </div>

            <div class="flex items-center justify-end space-x-2 pt-3 border-t border-stone-200/80">
                <button type="button" onclick="tutupModalEdit()" class="px-4 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 border border-stone-300 text-xs font-semibold transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-stone-900 hover:bg-stone-800 text-white text-xs font-semibold transition active:scale-95 shadow-sm">
                    Perbarui
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function bukaModalTambah() {
    document.getElementById('modal-tambah').classList.remove('hidden');
}

function tutupModalTambah() {
    document.getElementById('modal-tambah').classList.add('hidden');
}

function bukaModalEdit(tombol) {
    var id = tombol.getAttribute('data-id');
    var nama = tombol.getAttribute('data-nama');
    var laju = tombol.getAttribute('data-laju');
    var keterangan = tombol.getAttribute('data-keterangan');

    document.getElementById('form-edit').action = '/admin/jenis-lahan/' + id;
    document.getElementById('edit-nama').value = nama;
    document.getElementById('edit-laju').value = laju;
    document.getElementById('edit-keterangan').value = keterangan ? keterangan : '';

    document.getElementById('modal-edit').classList.remove('hidden');
}

function tutupModalEdit() {
    document.getElementById('modal-edit').classList.add('hidden');
}
</script>
@endsection
