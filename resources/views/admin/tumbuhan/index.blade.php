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

    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200/80 shadow-sm flex flex-col md:flex-row gap-2.5 items-stretch md:items-center justify-between">
        <form method="GET" action="{{ route('admin.tumbuhan.index') }}" class="w-full flex flex-col sm:flex-row gap-2.5 flex-1">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-stone-400 text-xs"></i>
                <input type="text" name="cari" value="{{ $cari ?? '' }}" placeholder="Cari nama lokal, ilmiah, atau manfaat..." class="w-full pl-9 pr-3.5 py-2 text-xs sm:text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-stone-800 focus:ring-1 focus:ring-stone-800 bg-stone-50/50 focus:bg-white">
            </div>

            <div class="w-full sm:w-48">
                <select name="jenis" class="w-full px-3 py-2 text-xs sm:text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-stone-800 bg-stone-50/50 focus:bg-white text-stone-700">
                    <option value="">Semua Habitus</option>
                    <option value="Pohon" {{ ($jenis ?? '') == 'Pohon' ? 'selected' : '' }}>Pohon</option>
                    <option value="Perdu" {{ ($jenis ?? '') == 'Perdu' ? 'selected' : '' }}>Perdu</option>
                    <option value="Herba" {{ ($jenis ?? '') == 'Herba' ? 'selected' : '' }}>Herba</option>
                    <option value="Liana" {{ ($jenis ?? '') == 'Liana' ? 'selected' : '' }}>Liana</option>
                    <option value="Lainnya" {{ ($jenis ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <div class="w-full sm:w-56">
                <select name="status_konservasi" class="w-full px-3 py-2 text-xs sm:text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-stone-800 bg-stone-50/50 focus:bg-white text-stone-700">
                    <option value="">Semua Status</option>
                    <option value="CR" {{ ($statusKonservasi ?? '') == 'CR' ? 'selected' : '' }}>CR (Kritis)</option>
                    <option value="EN" {{ ($statusKonservasi ?? '') == 'EN' ? 'selected' : '' }}>EN (Genting)</option>
                    <option value="VU" {{ ($statusKonservasi ?? '') == 'VU' ? 'selected' : '' }}>VU (Rentan)</option>
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

            @if (!empty($cari) || !empty($jenis) || !empty($statusKonservasi))
                <a href="{{ route('admin.tumbuhan.index') }}" class="px-3.5 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 border border-stone-300 font-semibold rounded-xl text-xs sm:text-sm transition text-center" title="Reset filter">
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
                        <th class="py-3.5 px-4 whitespace-nowrap">Habitus</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Status</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Dilindungi</th>
                        <th class="py-3.5 px-4">Sebaran Kawasan</th>
                        <th class="py-3.5 px-4 text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 text-stone-700 bg-white">
                    @forelse ($daftarTumbuhan as $tumbuhan)
                        <tr class="hover:bg-stone-50 transition-colors">
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if ($tumbuhan->foto)
                                    <img src="{{ asset('storage/' . $tumbuhan->foto) }}" alt="{{ $tumbuhan->nama_lokal }}" class="w-10 h-10 rounded-xl object-cover border border-stone-200">
                                @else
                                    <div class="w-10 h-10 rounded-xl bg-stone-100 text-stone-500 flex items-center justify-center text-sm border border-stone-200">
                                        <i class="fa-solid fa-seedling"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-bold text-stone-900 whitespace-nowrap">
                                {{ $tumbuhan->nama_lokal }}
                            </td>
                            <td class="py-3.5 px-4 italic text-stone-600 whitespace-nowrap">
                                {{ $tumbuhan->nama_ilmiah }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="text-xs font-medium text-stone-800">
                                    {{ $tumbuhan->jenis }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="text-xs font-semibold text-stone-900">
                                    {{ $tumbuhan->status_konservasi }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="text-xs font-semibold text-stone-900">
                                    {{ $tumbuhan->dilindungi ? 'Ya' : 'Tidak' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-xs text-stone-600">
                                @if ($tumbuhan->kawasanHutan->count() > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($tumbuhan->kawasanHutan as $kws)
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
                                        data-id="{{ $tumbuhan->id }}"
                                        data-nama-lokal="{{ $tumbuhan->nama_lokal }}"
                                        data-nama-ilmiah="{{ $tumbuhan->nama_ilmiah }}"
                                        data-jenis="{{ $tumbuhan->jenis }}"
                                        data-status-konservasi="{{ $tumbuhan->status_konservasi }}"
                                        data-dilindungi="{{ $tumbuhan->dilindungi ? '1' : '0' }}"
                                        data-manfaat="{{ $tumbuhan->manfaat }}"
                                        data-deskripsi="{{ $tumbuhan->deskripsi }}"
                                        data-kawasan="{{ json_encode($tumbuhan->kawasanHutan->pluck('id')) }}"
                                        data-foto-url="{{ $tumbuhan->foto ? asset('storage/' . $tumbuhan->foto) : '' }}"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 border border-stone-300 font-semibold rounded-lg text-xs transition">
                                        <i class="fa-solid fa-pen-to-square text-[11px] text-stone-600"></i>
                                        <span>Edit</span>
                                    </button>

                                    <form method="POST" action="{{ route('admin.tumbuhan.destroy', $tumbuhan->id) }}" class="inline" data-confirm="Apakah Anda yakin ingin menghapus data tumbuhan {{ $tumbuhan->nama_lokal }}?" data-confirm-title="Hapus Tumbuhan Rimba" data-confirm-ok="Ya, Hapus">
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
                            <td colspan="8" class="py-8 text-center text-stone-400">
                                <i class="fa-solid fa-seedling text-3xl mb-2 block text-stone-300"></i>
                                Belum ada data tumbuhan yang tersimpan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($daftarTumbuhan->hasPages())
            <div class="p-4 border-t border-stone-100">
                {{ $daftarTumbuhan->links() }}
            </div>
        @endif
    </div>
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
