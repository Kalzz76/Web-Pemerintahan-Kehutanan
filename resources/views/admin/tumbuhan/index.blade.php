@extends('layouts.admin')

@section('title', 'Kelola Tumbuhan Rimba')

@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-lg md:text-xl font-bold text-stone-900 tracking-tight">Tumbuhan Rimba</h1>
            <p class="text-xs text-stone-500 mt-0.5">
                Kelola data keanekaragaman flora, jenis habitus pohon/herba, manfaat obat atau ekologis, dan kawasan sebarannya.
            </p>
        </div>
        <button type="button" onclick="bukaModalTambah()" class="inline-flex items-center px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl text-xs sm:text-sm shadow-sm transition active:scale-95 shrink-0">
            <i class="fa-solid fa-plus mr-1.5 text-xs"></i> Tambah Tumbuhan
        </button>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-700 text-xs">
            <div class="font-bold mb-1 flex items-center">
                <i class="fa-solid fa-triangle-exclamation mr-2"></i> Terjadi kesalahan input:
            </div>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <livewire:admin.tumbuhan-table />


</div>

<div id="modal-tumbuhan" class="fixed inset-0 z-50 hidden overflow-y-auto bg-stone-900/60 backdrop-blur-sm p-4 sm:p-6 flex items-center justify-center">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl space-y-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-stone-100 pb-4">
            <h3 id="modal-judul" class="text-lg font-black text-stone-900">Tambah Data Tumbuhan</h3>
            <button type="button" onclick="tutupModal()" class="w-8 h-8 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-600 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="form-tumbuhan" method="POST" action="{{ route('admin.tumbuhan.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div id="metode-put"></div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Nama Lokal <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_lokal" id="input-nama-lokal" required placeholder="Contoh: Rasamala" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Nama Ilmiah <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_ilmiah" id="input-nama-ilmiah" required placeholder="Contoh: Altingia excelsa" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm italic">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Jenis Habitus <span class="text-rose-500">*</span></label>
                    <select name="jenis" id="input-jenis" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm bg-white">
                        <option value="Pohon">Pohon</option>
                        <option value="Perdu">Perdu</option>
                        <option value="Herba">Herba</option>
                        <option value="Liana">Liana</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Status Konservasi <span class="text-rose-500">*</span></label>
                    <select name="status_konservasi" id="input-status-konservasi" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm bg-white">
                        <option value="LC">LC - Risiko Rendah</option>
                        <option value="NT">NT - Hampir Terancam</option>
                        <option value="VU">VU - Rentan</option>
                        <option value="EN">EN - Genting</option>
                        <option value="CR">CR - Kritis</option>
                        <option value="DD">DD - Kurang Data</option>
                        <option value="NE">NE - Belum Dinilai</option>
                    </select>
                </div>
                <div class="flex items-center pt-6">
                    <label class="relative flex items-center cursor-pointer space-x-3">
                        <input type="checkbox" name="dilindungi" id="input-dilindungi" value="1" class="w-5 h-5 text-green-700 rounded border-stone-300 focus:ring-green-600">
                        <span class="text-xs font-bold text-stone-800">Dilindungi</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Manfaat Ekologis / Tradisional <span class="text-rose-500">*</span></label>
                <input type="text" name="manfaat" id="input-manfaat" required placeholder="Contoh: Penahan air tanah, getah wangi, penahan erosi lereng" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm">
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Deskripsi Lengkap <span class="text-rose-500">*</span></label>
                <textarea name="deskripsi" id="input-deskripsi" rows="3" required placeholder="Karakter batang, daun, bunga, habitat dan peran dalam ekosistem..." class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm"></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Sebaran Kawasan Hutan</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 bg-stone-50 p-3 rounded-2xl border border-stone-200 max-h-36 overflow-y-auto">
                    @foreach ($daftarKawasan as $kws)
                        <label class="flex items-center space-x-2 text-xs text-stone-800 cursor-pointer">
                            <input type="checkbox" name="kawasan[]" value="{{ $kws->id }}" class="checkbox-kawasan w-4 h-4 rounded text-green-700 border-stone-300">
                            <span>{{ $kws->nama }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Foto Tumbuhan (Maks 2 MB)</label>
                <input type="file" name="foto" id="input-foto" accept="image/png,image/jpeg,image/jpg" class="w-full text-xs text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                <div id="pratinjau-foto-wadah" class="mt-2 hidden">
                    <img id="pratinjau-foto" src="" alt="Pratinjau" class="w-20 h-20 rounded-xl object-cover border border-stone-200">
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-stone-100">
                <button type="button" onclick="tutupModal()" class="px-5 py-2.5 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 font-bold text-sm transition">
                    Batal
                </button>
                <button type="submit" id="tombol-simpan" class="px-5 py-2.5 rounded-xl bg-green-700 hover:bg-green-600 text-white font-bold text-sm transition shadow">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    var modal = document.getElementById('modal-tumbuhan');
    var form = document.getElementById('form-tumbuhan');
    var judul = document.getElementById('modal-judul');
    var wadahPut = document.getElementById('metode-put');
    var pratinjauWadah = document.getElementById('pratinjau-foto-wadah');
    var pratinjauImg = document.getElementById('pratinjau-foto');

    function bukaModalTambah() {
        judul.textContent = 'Tambah Data Tumbuhan';
        form.action = "{{ route('admin.tumbuhan.store') }}";
        wadahPut.innerHTML = '';

        document.getElementById('input-nama-lokal').value = '';
        document.getElementById('input-nama-ilmiah').value = '';
        document.getElementById('input-jenis').value = 'Pohon';
        document.getElementById('input-status-konservasi').value = 'LC';
        document.getElementById('input-dilindungi').checked = false;
        document.getElementById('input-manfaat').value = '';
        document.getElementById('input-deskripsi').value = '';
        document.getElementById('input-foto').value = '';

        document.querySelectorAll('.checkbox-kawasan').forEach(function(cb) {
            cb.checked = false;
        });

        pratinjauWadah.classList.add('hidden');
        pratinjauImg.src = '';

        modal.classList.remove('hidden');
    }

    function bukaModalEdit(el) {
        var id = el.getAttribute('data-id');
        var namaLokal = el.getAttribute('data-nama-lokal');
        var namaIlmiah = el.getAttribute('data-nama-ilmiah');
        var jenis = el.getAttribute('data-jenis');
        var statusKonservasi = el.getAttribute('data-status-konservasi');
        var dilindungi = el.getAttribute('data-dilindungi') === '1';
        var manfaat = el.getAttribute('data-manfaat');
        var deskripsi = el.getAttribute('data-deskripsi');
        var kawasan = JSON.parse(el.getAttribute('data-kawasan') || '[]');
        var fotoUrl = el.getAttribute('data-foto-url');

        judul.textContent = 'Edit Data Tumbuhan: ' + namaLokal;
        form.action = "{{ url('admin/tumbuhan') }}/" + id;
        wadahPut.innerHTML = '<input type="hidden" name="_method" value="PUT">';

        document.getElementById('input-nama-lokal').value = namaLokal;
        document.getElementById('input-nama-ilmiah').value = namaIlmiah;
        document.getElementById('input-jenis').value = jenis;
        document.getElementById('input-status-konservasi').value = statusKonservasi;
        document.getElementById('input-dilindungi').checked = dilindungi;
        document.getElementById('input-manfaat').value = manfaat;
        document.getElementById('input-deskripsi').value = deskripsi;
        document.getElementById('input-foto').value = '';

        document.querySelectorAll('.checkbox-kawasan').forEach(function(cb) {
            var val = parseInt(cb.value);
            cb.checked = kawasan.includes(val);
        });

        if (fotoUrl) {
            pratinjauImg.src = fotoUrl;
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
