@extends('layouts.admin')

@section('title', 'Jenis Lahan')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl md:text-3xl font-extrabold text-stone-900 tracking-tight">Jenis Lahan</h1>
        <p class="text-stone-500 text-sm mt-1">Daftar tipe vegetasi dan nilai laju dasar perambatan api (meter per jam).</p>
    </div>
    <button type="button" onclick="bukaModalTambah()" class="inline-flex items-center px-5 py-3 bg-green-700 hover:bg-green-600 text-white font-bold rounded-xl shadow transition active:scale-95 text-sm shrink-0">
        <i class="fa-solid fa-plus mr-2"></i>
        <span>Tambah Jenis Lahan</span>
    </button>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-6 mb-8">
    <form method="GET" action="{{ route('admin.jenis-lahan.index') }}" class="flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-stone-400">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" name="cari" value="{{ $cari }}" placeholder="Cari nama jenis lahan atau keterangan..." class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition">
        </div>
        <button type="submit" class="px-5 py-2.5 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl text-sm transition">
            Cari
        </button>
        @if ($cari)
            <a href="{{ route('admin.jenis-lahan.index') }}" class="px-5 py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-700 font-semibold rounded-xl text-sm transition text-center">
                Reset
            </a>
        @endif
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-stone-100 overflow-hidden">
    @if ($daftarJenisLahan->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-stone-100 text-stone-700 uppercase text-xs">
                        <th class="px-6 py-4 font-bold">Nama Jenis Lahan</th>
                        <th class="px-6 py-4 font-bold">Laju Dasar Api</th>
                        <th class="px-6 py-4 font-bold">Keterangan</th>
                        <th class="px-6 py-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 text-stone-700">
                    @foreach ($daftarJenisLahan as $item)
                        <tr class="hover:bg-stone-50 transition">
                            <td class="px-6 py-4 font-semibold text-stone-900">
                                {{ $item->nama }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-xl bg-amber-50 text-amber-800 font-mono font-bold text-xs">
                                    <i class="fa-solid fa-fire text-[10px] mr-1.5 text-amber-600"></i>
                                    {{ $item->laju_dasar }} m/jam
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-stone-500 max-w-md">
                                {{ $item->keterangan ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                <button type="button"
                                    data-id="{{ $item->id }}"
                                    data-nama="{{ $item->nama }}"
                                    data-laju="{{ $item->laju_dasar }}"
                                    data-keterangan="{{ $item->keterangan }}"
                                    onclick="bukaModalEdit(this)"
                                    class="px-3.5 py-1.5 bg-green-50 hover:bg-green-100 text-green-700 font-semibold rounded-lg text-xs transition">
                                    <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                </button>
                                <form method="POST" action="{{ route('admin.jenis-lahan.destroy', $item->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis lahan {{ $item->nama }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-semibold rounded-lg text-xs transition">
                                        <i class="fa-solid fa-trash mr-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-stone-100">
            {{ $daftarJenisLahan->links() }}
        </div>
    @else
        <div class="p-12 text-center text-stone-400">
            <i class="fa-solid fa-layer-group text-4xl mb-3 text-stone-300"></i>
            <p class="text-sm font-medium">Belum ada data jenis lahan.</p>
        </div>
    @endif
</div>

<div id="modal-tambah" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-stone-950/60 backdrop-blur-sm">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-stone-900">Tambah Jenis Lahan</h3>
            <button type="button" onclick="tutupModalTambah()" class="text-stone-400 hover:text-stone-700 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.jenis-lahan.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="tambah-nama" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Nama Jenis Lahan</label>
                <input type="text" id="tambah-nama" name="nama" required placeholder="Contoh: Semak Belukar" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition">
            </div>

            <div>
                <label for="tambah-laju" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Laju Dasar Api (m/jam)</label>
                <input type="number" id="tambah-laju" name="laju_dasar" required min="1" placeholder="Contoh: 400" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition">
            </div>

            <div>
                <label for="tambah-keterangan" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Keterangan (Opsional)</label>
                <textarea id="tambah-keterangan" name="keterangan" rows="3" placeholder="Deskripsi karakteristik vegetasi..." class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition"></textarea>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-stone-100">
                <button type="button" onclick="tutupModalTambah()" class="px-5 py-2.5 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-semibold transition">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-green-700 hover:bg-green-600 text-white text-xs font-bold transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modal-edit" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-stone-950/60 backdrop-blur-sm">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-stone-900">Edit Jenis Lahan</h3>
            <button type="button" onclick="tutupModalEdit()" class="text-stone-400 hover:text-stone-700 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="form-edit" method="POST" action="" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="edit-nama" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Nama Jenis Lahan</label>
                <input type="text" id="edit-nama" name="nama" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition">
            </div>

            <div>
                <label for="edit-laju" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Laju Dasar Api (m/jam)</label>
                <input type="number" id="edit-laju" name="laju_dasar" required min="1" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition">
            </div>

            <div>
                <label for="edit-keterangan" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Keterangan (Opsional)</label>
                <textarea id="edit-keterangan" name="keterangan" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-green-600 outline-none transition"></textarea>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-stone-100">
                <button type="button" onclick="tutupModalEdit()" class="px-5 py-2.5 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-semibold transition">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-green-700 hover:bg-green-600 text-white text-xs font-bold transition">
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
