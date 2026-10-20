@extends('layouts.admin')

@section('title', 'Kelola Satwa Primata')

@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-lg md:text-xl font-bold text-stone-900 tracking-tight">Satwa Primata</h1>
            <p class="text-xs text-stone-500 mt-0.5">
                Kelola katalog satwa primata yang menghuni kawasan hutan Jawa Barat beserta status konservasi dan sebarannya.
            </p>
        </div>
        <button type="button" onclick="bukaModalTambah()" class="inline-flex items-center px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl text-xs sm:text-sm shadow-sm transition active:scale-95 shrink-0">
            <i class="fa-solid fa-plus mr-1.5 text-xs"></i> Tambah Primata
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

    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200/80 shadow-sm flex flex-col md:flex-row gap-2.5 items-stretch md:items-center justify-between">
        <form method="GET" action="{{ route('admin.primata.index') }}" class="w-full flex flex-col sm:flex-row gap-2.5 flex-1">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-stone-400 text-xs"></i>
                <input type="text" name="cari" value="{{ $cari ?? '' }}" placeholder="Cari nama lokal, ilmiah, atau habitat..." class="w-full pl-9 pr-3.5 py-2 text-xs sm:text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-stone-800 focus:ring-1 focus:ring-stone-800 bg-stone-50/50 focus:bg-white">
            </div>

            <div class="w-full sm:w-64">
                <select name="status_konservasi" class="w-full px-3 py-2 text-xs sm:text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-stone-800 bg-stone-50/50 focus:bg-white text-stone-700">
                    <option value="">Semua Status Konservasi</option>
                    <option value="CR" {{ ($statusKonservasi ?? '') == 'CR' ? 'selected' : '' }}>CR (Kritis / Sangat Terancam)</option>
                    <option value="EN" {{ ($statusKonservasi ?? '') == 'EN' ? 'selected' : '' }}>EN (Genting / Terancam)</option>
                    <option value="VU" {{ ($statusKonservasi ?? '') == 'VU' ? 'selected' : '' }}>VU (Rentan Punah)</option>
                    <option value="NT" {{ ($statusKonservasi ?? '') == 'NT' ? 'selected' : '' }}>NT (Hampir Terancam)</option>
                    <option value="LC" {{ ($statusKonservasi ?? '') == 'LC' ? 'selected' : '' }}>LC (Risiko Rendah)</option>
                    <option value="DD" {{ ($statusKonservasi ?? '') == 'DD' ? 'selected' : '' }}>DD (Kurang Data)</option>
                    <option value="NE" {{ ($statusKonservasi ?? '') == 'NE' ? 'selected' : '' }}>NE (Belum Dinilai)</option>
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl text-xs sm:text-sm transition flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-filter text-xs"></i>
                <span>Filter</span>
            </button>

            @if (!empty($cari) || !empty($statusKonservasi))
                <a href="{{ route('admin.primata.index') }}" class="px-3.5 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 border border-stone-300 font-semibold rounded-xl text-xs sm:text-sm transition text-center" title="Reset filter">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </form>
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
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 border border-stone-300 font-semibold rounded-lg text-xs transition">
                                        <i class="fa-solid fa-pen-to-square text-[11px] text-stone-600"></i>
                                        <span>Edit</span>
                                    </button>

                                    <form method="POST" action="{{ route('admin.primata.destroy', $primata->id) }}" class="inline" data-confirm="Apakah Anda yakin ingin menghapus data primata {{ $primata->nama_lokal }}?" data-confirm-title="Hapus Satwa Primata" data-confirm-ok="Ya, Hapus">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-white hover:bg-stone-100 text-stone-700 hover:text-stone-900 border border-stone-300 font-semibold rounded-lg text-xs transition">
                                            <i class="fa-solid fa-trash text-[11px] text-stone-500"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-stone-400">
                                <i class="fa-solid fa-paw text-3xl mb-2 block text-stone-300"></i>
                                Belum ada data primata yang tersimpan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($daftarPrimata->hasPages())
            <div class="p-4 border-t border-stone-100">
                {{ $daftarPrimata->links() }}
            </div>
        @endif
    </div>
</div>

<div id="modal-primata" class="fixed inset-0 z-50 hidden overflow-y-auto bg-stone-900/60 backdrop-blur-sm p-4 sm:p-6 flex items-center justify-center">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl space-y-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-stone-100 pb-4">
            <h3 id="modal-judul" class="text-lg font-black text-stone-900">Tambah Data Primata</h3>
            <button type="button" onclick="tutupModal()" class="w-8 h-8 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-600 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="form-primata" method="POST" action="{{ route('admin.primata.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div id="metode-put"></div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Nama Lokal <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_lokal" id="input-nama-lokal" required placeholder="Contoh: Owa Jawa" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Nama Ilmiah <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_ilmiah" id="input-nama-ilmiah" required placeholder="Contoh: Hylobates moloch" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm italic">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Status Konservasi <span class="text-rose-500">*</span></label>
                    <select name="status_konservasi" id="input-status-konservasi" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm bg-white">
                        <option value="CR">CR - Kritis (Critically Endangered)</option>
                        <option value="EN">EN - Genting (Endangered)</option>
                        <option value="VU">VU - Rentan (Vulnerable)</option>
                        <option value="NT">NT - Hampir Terancam (Near Threatened)</option>
                        <option value="LC">LC - Risiko Rendah (Least Concern)</option>
                        <option value="DD">DD - Kurang Data (Data Deficient)</option>
                        <option value="NE">NE - Belum Dinilai (Not Evaluated)</option>
                    </select>
                </div>
                <div class="flex items-center pt-6">
                    <label class="relative flex items-center cursor-pointer space-x-3">
                        <input type="checkbox" name="dilindungi" id="input-dilindungi" value="1" class="w-5 h-5 text-green-700 rounded border-stone-300 focus:ring-green-600">
                        <span class="text-sm font-bold text-stone-800">Status Dilindungi Undang-Undang</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Habitat <span class="text-rose-500">*</span></label>
                    <input type="text" name="habitat" id="input-habitat" required placeholder="Contoh: Tajuk pohon hutan primer rapat" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Makanan Utama <span class="text-rose-500">*</span></label>
                    <input type="text" name="makanan" id="input-makanan" required placeholder="Contoh: Buah hutan, pucuk daun, bunga" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Ciri Khas Fisik & Perilaku <span class="text-rose-500">*</span></label>
                <input type="text" name="ciri_khas" id="input-ciri-khas" required placeholder="Contoh: Bulu abu-abu keperakan, suara nyaring merdu" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm">
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Deskripsi Lengkap <span class="text-rose-500">*</span></label>
                <textarea name="deskripsi" id="input-deskripsi" rows="3" required placeholder="Penjelasan morfologi, ekologi, dan informasi konservasi..." class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm"></textarea>
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
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Foto Primata (Maks 2 MB)</label>
                <input type="file" name="foto" id="input-foto" accept="image/png,image/jpeg,image/jpg" class="w-full text-xs text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                <div id="pratinjau-foto-wadah" class="mt-2 hidden">
                    <img id="pratinjau-foto" src="" alt="Pratinjau" class="w-20 h-20 rounded-xl object-cover border border-stone-200">
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-stone-100">
                <button type="button" onclick="tutupModal()" class="px-4 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 border border-stone-300 font-semibold text-xs sm:text-sm transition">
                    Batal
                </button>
                <button type="submit" id="tombol-simpan" class="px-4 py-2 rounded-xl bg-stone-900 hover:bg-stone-800 text-white font-semibold text-xs sm:text-sm transition shadow-sm">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    var modal = document.getElementById('modal-primata');
    var form = document.getElementById('form-primata');
    var judul = document.getElementById('modal-judul');
    var wadahPut = document.getElementById('metode-put');
    var pratinjauWadah = document.getElementById('pratinjau-foto-wadah');
    var pratinjauImg = document.getElementById('pratinjau-foto');

    function bukaModalTambah() {
        judul.textContent = 'Tambah Data Primata';
        form.action = "{{ route('admin.primata.store') }}";
        wadahPut.innerHTML = '';

        document.getElementById('input-nama-lokal').value = '';
        document.getElementById('input-nama-ilmiah').value = '';
        document.getElementById('input-status-konservasi').value = 'VU';
        document.getElementById('input-dilindungi').checked = true;
        document.getElementById('input-habitat').value = '';
        document.getElementById('input-makanan').value = '';
        document.getElementById('input-ciri-khas').value = '';
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
        var statusKonservasi = el.getAttribute('data-status-konservasi');
        var dilindungi = el.getAttribute('data-dilindungi') === '1';
        var habitat = el.getAttribute('data-habitat');
        var makanan = el.getAttribute('data-makanan');
        var ciriKhas = el.getAttribute('data-ciri-khas');
        var deskripsi = el.getAttribute('data-deskripsi');
        var kawasan = JSON.parse(el.getAttribute('data-kawasan') || '[]');
        var fotoUrl = el.getAttribute('data-foto-url');

        judul.textContent = 'Edit Data Primata: ' + namaLokal;
        form.action = "{{ url('admin/primata') }}/" + id;
        wadahPut.innerHTML = '<input type="hidden" name="_method" value="PUT">';

        document.getElementById('input-nama-lokal').value = namaLokal;
        document.getElementById('input-nama-ilmiah').value = namaIlmiah;
        document.getElementById('input-status-konservasi').value = statusKonservasi;
        document.getElementById('input-dilindungi').checked = dilindungi;
        document.getElementById('input-habitat').value = habitat;
        document.getElementById('input-makanan').value = makanan;
        document.getElementById('input-ciri-khas').value = ciriKhas;
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
