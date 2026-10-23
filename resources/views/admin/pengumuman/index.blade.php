@extends('layouts.admin')

@section('title', 'Kelola Pengumuman & Berita')

@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-lg md:text-xl font-bold text-stone-900 tracking-tight">Pengumuman & Kabar Hutan</h1>
            <p class="text-stone-500 text-xs mt-0.5">
                Publikasikan kabar desa, pengumuman kedaruratan, dan tips keselamatan hutan kepada warga.
            </p>
        </div>
        <button type="button" onclick="bukaModalTambah()" class="inline-flex items-center px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl text-xs sm:text-sm shadow-sm transition active:scale-95 shrink-0">
            <i class="fa-solid fa-plus mr-1.5 text-xs"></i>
            <span>Tambah Pengumuman</span>
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

    <livewire:admin.pengumuman-table />
</div>

<div id="modal-pengumuman" class="fixed inset-0 z-[50000] hidden overflow-y-auto bg-stone-950/60 backdrop-blur-sm p-4 sm:p-6 flex items-center justify-center">
    <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto border border-stone-200">
        <div class="flex items-center justify-between border-b border-stone-200/80 pb-3">
            <h3 id="modal-judul" class="text-base font-bold text-stone-900">Tambah Pengumuman</h3>
            <button type="button" onclick="tutupModal()" class="text-stone-400 hover:text-stone-700 text-base">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="form-pengumuman" method="POST" action="{{ route('admin.pengumuman.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div id="metode-put"></div>

            <div>
                <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Judul Pengumuman <span class="text-rose-500">*</span></label>
                <input type="text" name="judul" id="input-judul" required placeholder="Contoh: Larangan Membakar Sampah di Musim Kemarau" class="w-full px-3.5 py-2 rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 text-xs sm:text-sm">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Kategori <span class="text-rose-500">*</span></label>
                    <select name="kategori" id="input-kategori" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 text-xs sm:text-sm bg-white">
                        <option value="Kabar">Kabar</option>
                        <option value="Pengumuman">Pengumuman</option>
                        <option value="Tips Keselamatan">Tips Keselamatan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Tanggal <span class="text-rose-500">*</span></label>
                    <input type="date" name="tanggal" id="input-tanggal" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 text-xs sm:text-sm bg-white">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Status <span class="text-rose-500">*</span></label>
                    <select name="status" id="input-status" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 text-xs sm:text-sm bg-white">
                        <option value="Publish">Publish</option>
                        <option value="Draft">Draft</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Isi Pengumuman <span class="text-rose-500">*</span></label>
                <textarea name="isi" id="input-isi" rows="5" required placeholder="Tuliskan isi pengumuman atau himbauan..." class="w-full px-3.5 py-2 rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 text-xs sm:text-sm"></textarea>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Gambar (Maks 2 MB, Opsional)</label>
                <input type="file" name="gambar" id="input-gambar" accept="image/png,image/jpeg,image/jpg" class="w-full text-xs text-stone-500 file:mr-4 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-stone-100 file:text-stone-800 hover:file:bg-stone-200">
                <div id="pratinjau-gambar-wadah" class="mt-2 hidden">
                    <img id="pratinjau-gambar" src="" alt="Pratinjau" class="w-24 h-24 rounded-xl object-cover border border-stone-200" onerror="this.parentElement.classList.add('hidden');">
                </div>
            </div>

            <div class="flex items-center justify-end space-x-2 pt-3 border-t border-stone-200/80">
                <button type="button" onclick="tutupModal()" class="px-4 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 border border-stone-300 font-semibold text-xs transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-stone-900 hover:bg-stone-800 text-white font-semibold text-xs transition active:scale-95 shadow-sm">
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
