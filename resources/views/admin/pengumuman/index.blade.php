@extends('layouts.admin')

@section('title', 'Kelola Pengumuman & Berita')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-stone-900 tracking-tight">G. Pengumuman & Kabar Hutan</h1>
            <p class="text-sm text-stone-500 mt-1">
                Publikasikan kabar desa, pengumuman kedaruratan, dan tips keselamatan hutan kepada warga.
            </p>
        </div>
        <button type="button" onclick="bukaModalTambah()" class="inline-flex items-center px-4 py-2.5 bg-green-700 hover:bg-green-600 text-white font-bold rounded-xl text-sm shadow transition">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Pengumuman
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
        <form method="GET" action="{{ route('admin.pengumuman.index') }}" class="w-full md:w-auto flex flex-col sm:flex-row gap-3 flex-1">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-stone-400 text-sm"></i>
                <input type="text" name="cari" value="{{ $cari ?? '' }}" placeholder="Cari judul atau isi pengumuman..." class="w-full pl-10 pr-4 py-2 text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-green-600">
            </div>

            <select name="kategori" class="px-3 py-2 text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 bg-white">
                <option value="">Semua Kategori</option>
                <option value="Kabar" {{ ($kategori ?? '') == 'Kabar' ? 'selected' : '' }}>Kabar</option>
                <option value="Pengumuman" {{ ($kategori ?? '') == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                <option value="Tips Keselamatan" {{ ($kategori ?? '') == 'Tips Keselamatan' ? 'selected' : '' }}>Tips Keselamatan</option>
            </select>

            <select name="status" class="px-3 py-2 text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 bg-white">
                <option value="">Semua Status</option>
                <option value="Publish" {{ ($status ?? '') == 'Publish' ? 'selected' : '' }}>Publish</option>
                <option value="Draft" {{ ($status ?? '') == 'Draft' ? 'selected' : '' }}>Draft</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-bold rounded-xl text-sm transition">
                Filter
            </button>

            @if (!empty($cari) || !empty($kategori) || !empty($status))
                <a href="{{ route('admin.pengumuman.index') }}" class="px-3 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 font-semibold rounded-xl text-sm transition text-center">
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
                        <th class="py-3 px-4">Judul</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Penulis</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($daftarPengumuman as $item)
                        <tr class="hover:bg-stone-50 transition">
                            <td class="py-3 px-4 font-bold text-stone-900 max-w-xs">
                                <div class="flex items-center space-x-3">
                                    @if ($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-10 h-10 rounded-lg object-cover shrink-0 border border-stone-200">
                                    @endif
                                    <span class="truncate block">{{ $item->judul }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                @if ($item->kategori == 'Tips Keselamatan')
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">Tips Keselamatan</span>
                                @elseif ($item->kategori == 'Pengumuman')
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800">Pengumuman</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">Kabar</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-xs text-stone-600">
                                {{ $item->tanggal ? $item->tanggal->format('d M Y') : '-' }}
                            </td>
                            <td class="py-3 px-4">
                                @if ($item->status == 'Publish')
                                    <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Publish</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-stone-100 text-stone-600">Draft</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-xs text-stone-500">
                                {{ $item->user->name ?? 'Admin' }}
                            </td>
                            <td class="py-3 px-4 text-center whitespace-nowrap">
                                <div class="inline-flex items-center space-x-2">
                                    <button type="button"
                                        onclick="bukaModalEdit(this)"
                                        data-id="{{ $item->id }}"
                                        data-judul="{{ $item->judul }}"
                                        data-kategori="{{ $item->kategori }}"
                                        data-isi="{{ $item->isi }}"
                                        data-tanggal="{{ $item->tanggal ? $item->tanggal->format('Y-m-d') : '' }}"
                                        data-status="{{ $item->status }}"
                                        data-gambar-url="{{ $item->gambar ? asset('storage/' . $item->gambar) : '' }}"
                                        class="px-3 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-xl text-xs font-bold transition">
                                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                    </button>

                                    <form method="POST" action="{{ route('admin.pengumuman.destroy', $item->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');" class="inline">
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
                                <i class="fa-solid fa-bullhorn text-3xl mb-2 block text-stone-300"></i>
                                Belum ada pengumuman yang tersimpan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($daftarPengumuman->hasPages())
            <div class="p-4 border-t border-stone-100">
                {{ $daftarPengumuman->links() }}
            </div>
        @endif
    </div>
</div>

<div id="modal-pengumuman" class="fixed inset-0 z-50 hidden overflow-y-auto bg-stone-900/60 backdrop-blur-sm p-4 sm:p-6 flex items-center justify-center">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl space-y-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-stone-100 pb-4">
            <h3 id="modal-judul" class="text-lg font-black text-stone-900">Tambah Pengumuman</h3>
            <button type="button" onclick="tutupModal()" class="w-8 h-8 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-600 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="form-pengumuman" method="POST" action="{{ route('admin.pengumuman.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div id="metode-put"></div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Judul Pengumuman <span class="text-rose-500">*</span></label>
                <input type="text" name="judul" id="input-judul" required placeholder="Contoh: Larangan Membakar Sampah di Musim Kemarau" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Kategori <span class="text-rose-500">*</span></label>
                    <select name="kategori" id="input-kategori" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm bg-white">
                        <option value="Kabar">Kabar</option>
                        <option value="Pengumuman">Pengumuman</option>
                        <option value="Tips Keselamatan">Tips Keselamatan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Tanggal <span class="text-rose-500">*</span></label>
                    <input type="date" name="tanggal" id="input-tanggal" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm bg-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Status <span class="text-rose-500">*</span></label>
                    <select name="status" id="input-status" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm bg-white">
                        <option value="Publish">Publish</option>
                        <option value="Draft">Draft</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Isi Pengumuman <span class="text-rose-500">*</span></label>
                <textarea name="isi" id="input-isi" rows="5" required placeholder="Tuliskan isi pengumuman atau himbauan..." class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm"></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Gambar (Maks 2 MB, Opsional)</label>
                <input type="file" name="gambar" id="input-gambar" accept="image/png,image/jpeg,image/jpg" class="w-full text-xs text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                <div id="pratinjau-gambar-wadah" class="mt-2 hidden">
                    <img id="pratinjau-gambar" src="" alt="Pratinjau" class="w-24 h-24 rounded-xl object-cover border border-stone-200">
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-stone-100">
                <button type="button" onclick="tutupModal()" class="px-5 py-2.5 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 font-bold text-sm transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-green-700 hover:bg-green-600 text-white font-bold text-sm transition shadow">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    var modal = document.getElementById('modal-pengumuman');
    var form = document.getElementById('form-pengumuman');
    var judul = document.getElementById('modal-judul');
    var wadahPut = document.getElementById('metode-put');
    var pratinjauWadah = document.getElementById('pratinjau-gambar-wadah');
    var pratinjauImg = document.getElementById('pratinjau-gambar');

    function bukaModalTambah() {
        judul.textContent = 'Tambah Pengumuman';
        form.action = "{{ route('admin.pengumuman.store') }}";
        wadahPut.innerHTML = '';

        document.getElementById('input-judul').value = '';
        document.getElementById('input-kategori').value = 'Kabar';
        document.getElementById('input-tanggal').value = "{{ date('Y-m-d') }}";
        document.getElementById('input-status').value = 'Publish';
        document.getElementById('input-isi').value = '';
        document.getElementById('input-gambar').value = '';

        pratinjauWadah.classList.add('hidden');
        pratinjauImg.src = '';

        modal.classList.remove('hidden');
    }

    function bukaModalEdit(el) {
        var id = el.getAttribute('data-id');
        var judulItem = el.getAttribute('data-judul');
        var kategori = el.getAttribute('data-kategori');
        var isi = el.getAttribute('data-isi');
        var tanggal = el.getAttribute('data-tanggal');
        var status = el.getAttribute('data-status');
        var gambarUrl = el.getAttribute('data-gambar-url');

        judul.textContent = 'Edit Pengumuman';
        form.action = "{{ url('admin/pengumuman') }}/" + id;
        wadahPut.innerHTML = '<input type="hidden" name="_method" value="PUT">';

        document.getElementById('input-judul').value = judulItem;
        document.getElementById('input-kategori').value = kategori;
        document.getElementById('input-tanggal').value = tanggal;
        document.getElementById('input-status').value = status;
        document.getElementById('input-isi').value = isi;
        document.getElementById('input-gambar').value = '';

        if (gambarUrl) {
            pratinjauImg.src = gambarUrl;
            pratinjauWadah.classList.remove('hidden');
        } else {
            pratinjauWadah.classList.add('hidden');
            pratinjauImg.src = '';
        }

        modal.classList.remove('hidden');
    }

    function tutupModal() {
        modal.classList.add('hidden');
    }
</script>
@endsection
