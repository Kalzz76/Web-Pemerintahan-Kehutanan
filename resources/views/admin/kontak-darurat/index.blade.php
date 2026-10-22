@extends('layouts.admin')

@section('title', 'Kelola Kontak Darurat')

@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-lg md:text-xl font-bold text-stone-900 tracking-tight">Kontak Darurat Desa</h1>
            <p class="text-stone-500 text-xs mt-0.5">
                Kelola daftar nomor posko siaga, pemadam kebakaran desa, dan puskesmas yang tampil di publik.
            </p>
        </div>
        <button type="button" onclick="bukaModalTambah()" class="inline-flex items-center px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl text-xs sm:text-sm shadow-sm transition active:scale-95 shrink-0">
            <i class="fa-solid fa-plus mr-1.5 text-xs"></i>
            <span>Tambah Kontak Darurat</span>
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
        <form method="GET" action="{{ route('admin.kontak-darurat.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-stone-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="cari" value="{{ $cari ?? '' }}" placeholder="Cari nama kontak, instansi, atau nomor..." class="w-full pl-10 pr-4 py-2 text-xs sm:text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 transition">
            </div>

            <button type="submit" class="px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl text-xs sm:text-sm transition">
                Cari
            </button>

            @if (!empty($cari))
                <a href="{{ route('admin.kontak-darurat.index') }}" class="px-3.5 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 border border-stone-300 font-semibold rounded-xl text-xs sm:text-sm transition text-center">
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
                        <th class="px-4 py-3.5 w-16 text-center">Urutan</th>
                        <th class="px-4 py-3.5">Nama Posko / Kontak</th>
                        <th class="px-4 py-3.5">Instansi</th>
                        <th class="px-4 py-3.5">Nomor Telepon</th>
                        <th class="px-4 py-3.5">Keterangan</th>
                        <th class="px-4 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-200/70 text-stone-700">
                    @forelse ($daftarKontak as $kontak)
                        <tr class="hover:bg-stone-50/80 transition">
                            <td class="px-4 py-3.5 text-center font-bold text-stone-500 text-xs">
                                {{ $kontak->urutan }}
                            </td>
                            <td class="px-4 py-3.5 font-bold text-stone-900 text-xs sm:text-sm">
                                {{ $kontak->nama }}
                            </td>
                            <td class="px-4 py-3.5 text-xs font-semibold text-stone-600">
                                {{ $kontak->instansi }}
                            </td>
                            <td class="px-4 py-3.5 text-xs font-mono font-bold text-stone-800">
                                <a href="tel:{{ $kontak->nomor_telepon }}" class="hover:underline">
                                    {{ $kontak->nomor_telepon }}
                                </a>
                            </td>
                            <td class="px-4 py-3.5 text-xs text-stone-500">
                                {{ $kontak->keterangan ?? '-' }}
                            </td>
                            <td class="px-4 py-3.5 text-right whitespace-nowrap space-x-1.5">
                                <button type="button"
                                    onclick="bukaModalEdit(this)"
                                    data-id="{{ $kontak->id }}"
                                    data-nama="{{ $kontak->nama }}"
                                    data-instansi="{{ $kontak->instansi }}"
                                    data-nomor-telepon="{{ $kontak->nomor_telepon }}"
                                    data-keterangan="{{ $kontak->keterangan }}"
                                    data-urutan="{{ $kontak->urutan }}"
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 border border-stone-300 font-semibold rounded-lg text-xs transition">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Edit</span>
                                </button>

                                <form method="POST" action="{{ route('admin.kontak-darurat.destroy', $kontak->id) }}" class="inline" data-confirm="Apakah Anda yakin ingin menghapus kontak darurat ini?" data-confirm-title="Hapus Kontak Darurat" data-confirm-ok="Ya, Hapus">
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
                                <i class="fa-solid fa-address-book text-3xl mb-2 block text-stone-300"></i>
                                <p class="text-xs font-medium">Belum ada kontak darurat yang tersimpan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($daftarKontak->hasPages())
            <div class="p-4 border-t border-stone-200/80">
                {{ $daftarKontak->links() }}
            </div>
        @endif
    </div>
</div>

<div id="modal-kontak" class="fixed inset-0 z-[50000] hidden overflow-y-auto bg-stone-950/60 backdrop-blur-sm p-4 sm:p-6 flex items-center justify-center">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl space-y-5 border border-stone-200">
        <div class="flex items-center justify-between border-b border-stone-200/80 pb-3">
            <h3 id="modal-judul" class="text-base font-bold text-stone-900">Tambah Kontak Darurat</h3>
            <button type="button" onclick="tutupModal()" class="text-stone-400 hover:text-stone-700 text-base">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="form-kontak" method="POST" action="{{ route('admin.kontak-darurat.store') }}" class="space-y-4">
            @csrf
            <div id="metode-put"></div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Nama Kontak / Posko <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" id="input-nama" required placeholder="Contoh: Posko Karhutla Desa" class="w-full px-3.5 py-2 rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 text-xs sm:text-sm">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Nama Instansi <span class="text-rose-500">*</span></label>
                    <input type="text" name="instansi" id="input-instansi" required placeholder="Contoh: BPBD / Satgas Desa" class="w-full px-3.5 py-2 rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 text-xs sm:text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Nomor Telepon <span class="text-rose-500">*</span></label>
                    <input type="text" name="nomor_telepon" id="input-nomor-telepon" required placeholder="08123456789 atau (0232) 12345" class="w-full px-3.5 py-2 rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 text-xs sm:text-sm font-mono">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Urutan</label>
                    <input type="number" name="urutan" id="input-urutan" value="1" min="0" class="w-full px-3.5 py-2 rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 text-xs sm:text-sm">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Keterangan Tambahan</label>
                <input type="text" name="keterangan" id="input-keterangan" placeholder="Contoh: Siaga 24 Jam atau Layanan Ambulans" class="w-full px-3.5 py-2 rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 text-xs sm:text-sm">
            </div>

            <div class="flex items-center justify-end space-x-2 pt-3 border-t border-stone-200/80">
                <button type="button" onclick="tutupModal()" class="px-4 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 border border-stone-300 font-semibold text-xs transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-stone-900 hover:bg-stone-800 text-white font-semibold text-xs transition active:scale-95 shadow-sm">
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
