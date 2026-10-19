@extends('layouts.admin')

@section('title', 'Kelola Kontak Darurat')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-stone-900 tracking-tight">I. Kontak Darurat Desa</h1>
            <p class="text-sm text-stone-500 mt-1">
                Kelola daftar nomor posko siaga, pemadam kebakaran desa, dan puskesmas yang tampil di publik.
            </p>
        </div>
        <button type="button" onclick="bukaModalTambah()" class="inline-flex items-center px-4 py-2.5 bg-green-700 hover:bg-green-600 text-white font-bold rounded-xl text-sm shadow transition">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Kontak Darurat
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
        <form method="GET" action="{{ route('admin.kontak-darurat.index') }}" class="w-full md:w-auto flex flex-col sm:flex-row gap-3 flex-1">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-stone-400 text-sm"></i>
                <input type="text" name="cari" value="{{ $cari ?? '' }}" placeholder="Cari nama kontak, instansi, atau nomor..." class="w-full pl-10 pr-4 py-2 text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-green-600">
            </div>

            <button type="submit" class="px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-bold rounded-xl text-sm transition">
                Cari
            </button>

            @if (!empty($cari))
                <a href="{{ route('admin.kontak-darurat.index') }}" class="px-3 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 font-semibold rounded-xl text-sm transition text-center">
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
                        <th class="py-3 px-4 w-16 text-center">Urutan</th>
                        <th class="py-3 px-4">Nama Posko / Kontak</th>
                        <th class="py-3 px-4">Instansi</th>
                        <th class="py-3 px-4">Nomor Telepon</th>
                        <th class="py-3 px-4">Keterangan</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($daftarKontak as $kontak)
                        <tr class="hover:bg-stone-50 transition">
                            <td class="py-3 px-4 text-center font-bold text-stone-500">
                                {{ $kontak->urutan }}
                            </td>
                            <td class="py-3 px-4 font-bold text-stone-900">
                                {{ $kontak->nama }}
                            </td>
                            <td class="py-3 px-4 text-xs font-semibold text-stone-600">
                                {{ $kontak->instansi }}
                            </td>
                            <td class="py-3 px-4 text-xs font-mono font-bold text-green-800">
                                <a href="tel:{{ $kontak->nomor_telepon }}" class="hover:underline">
                                    {{ $kontak->nomor_telepon }}
                                </a>
                            </td>
                            <td class="py-3 px-4 text-xs text-stone-500">
                                {{ $kontak->keterangan ?? '-' }}
                            </td>
                            <td class="py-3 px-4 text-center whitespace-nowrap">
                                <div class="inline-flex items-center space-x-2">
                                    <button type="button"
                                        onclick="bukaModalEdit(this)"
                                        data-id="{{ $kontak->id }}"
                                        data-nama="{{ $kontak->nama }}"
                                        data-instansi="{{ $kontak->instansi }}"
                                        data-nomor-telepon="{{ $kontak->nomor_telepon }}"
                                        data-keterangan="{{ $kontak->keterangan }}"
                                        data-urutan="{{ $kontak->urutan }}"
                                        class="px-3 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-xl text-xs font-bold transition">
                                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                    </button>

                                    <form method="POST" action="{{ route('admin.kontak-darurat.destroy', $kontak->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kontak darurat ini?');" class="inline">
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
                                <i class="fa-solid fa-address-book text-3xl mb-2 block text-stone-300"></i>
                                Belum ada kontak darurat yang tersimpan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($daftarKontak->hasPages())
            <div class="p-4 border-t border-stone-100">
                {{ $daftarKontak->links() }}
            </div>
        @endif
    </div>
</div>

<div id="modal-kontak" class="fixed inset-0 z-50 hidden overflow-y-auto bg-stone-900/60 backdrop-blur-sm p-4 sm:p-6 flex items-center justify-center">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl space-y-6">
        <div class="flex items-center justify-between border-b border-stone-100 pb-4">
            <h3 id="modal-judul" class="text-lg font-black text-stone-900">Tambah Kontak Darurat</h3>
            <button type="button" onclick="tutupModal()" class="w-8 h-8 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-600 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="form-kontak" method="POST" action="{{ route('admin.kontak-darurat.store') }}" class="space-y-4">
            @csrf
            <div id="metode-put"></div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Nama Kontak / Posko <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" id="input-nama" required placeholder="Contoh: Posko Karhutla Desa" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Nama Instansi <span class="text-rose-500">*</span></label>
                    <input type="text" name="instansi" id="input-instansi" required placeholder="Contoh: BPBD / Satgas Desa" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Nomor Telepon <span class="text-rose-500">*</span></label>
                    <input type="text" name="nomor_telepon" id="input-nomor-telepon" required placeholder="08123456789 atau (0232) 12345" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm font-mono">
                </div>
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Urutan</label>
                    <input type="number" name="urutan" id="input-urutan" value="1" min="0" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Keterangan Tambahan</label>
                <input type="text" name="keterangan" id="input-keterangan" placeholder="Contoh: Siaga 24 Jam atau Layanan Ambulans" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm">
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-stone-100">
                <button type="button" onclick="tutupModal()" class="px-5 py-2.5 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 font-bold text-sm transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-green-700 hover:bg-green-600 text-white font-bold text-sm transition shadow">
                    Simpan Kontak
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    var modal = document.getElementById('modal-kontak');
    var form = document.getElementById('form-kontak');
    var judul = document.getElementById('modal-judul');
    var wadahPut = document.getElementById('metode-put');

    function bukaModalTambah() {
        judul.textContent = 'Tambah Kontak Darurat';
        form.action = "{{ route('admin.kontak-darurat.store') }}";
        wadahPut.innerHTML = '';

        document.getElementById('input-nama').value = '';
        document.getElementById('input-instansi').value = '';
        document.getElementById('input-nomor-telepon').value = '';
        document.getElementById('input-keterangan').value = '';
        document.getElementById('input-urutan').value = '1';

        modal.classList.remove('hidden');
    }

    function bukaModalEdit(el) {
        var id = el.getAttribute('data-id');
        var nama = el.getAttribute('data-nama');
        var instansi = el.getAttribute('data-instansi');
        var nomorTelepon = el.getAttribute('data-nomor-telepon');
        var keterangan = el.getAttribute('data-keterangan');
        var urutan = el.getAttribute('data-urutan');

        judul.textContent = 'Edit Kontak Darurat';
        form.action = "{{ url('admin/kontak-darurat') }}/" + id;
        wadahPut.innerHTML = '<input type="hidden" name="_method" value="PUT">';

        document.getElementById('input-nama').value = nama;
        document.getElementById('input-instansi').value = instansi;
        document.getElementById('input-nomor-telepon').value = nomorTelepon;
        document.getElementById('input-keterangan').value = keterangan || '';
        document.getElementById('input-urutan').value = urutan || '0';

        modal.classList.remove('hidden');
    }

    function tutupModal() {
        modal.classList.add('hidden');
    }
</script>
@endsection
