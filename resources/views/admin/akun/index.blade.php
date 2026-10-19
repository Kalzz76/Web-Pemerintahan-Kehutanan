@extends('layouts.admin')

@section('title', 'Kelola Akun Admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-stone-900 tracking-tight">Akun Administrator</h1>
            <p class="text-sm text-stone-500 mt-1">
                Kelola kredensial akun pengelola web, penambahan admin baru, dan hak akses sistem desa.
            </p>
        </div>
        <button type="button" onclick="bukaModalTambah()" class="inline-flex items-center px-4 py-2.5 bg-green-700 hover:bg-green-600 text-white font-bold rounded-xl text-sm shadow transition">
            <i class="fa-solid fa-user-plus mr-2"></i> Tambah Akun Admin
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
        <form method="GET" action="{{ route('admin.akun.index') }}" class="w-full md:w-auto flex flex-col sm:flex-row gap-3 flex-1">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-stone-400 text-sm"></i>
                <input type="text" name="cari" value="{{ $cari ?? '' }}" placeholder="Cari nama atau username..." class="w-full pl-10 pr-4 py-2 text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-green-600">
            </div>

            <button type="submit" class="px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-bold rounded-xl text-sm transition">
                Cari
            </button>

            @if (!empty($cari))
                <a href="{{ route('admin.akun.index') }}" class="px-3 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 font-semibold rounded-xl text-sm transition text-center">
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
                        <th class="py-3 px-4">Nama Lengkap</th>
                        <th class="py-3 px-4">Username</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Terdaftar Pada</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($daftarAkun as $item)
                        <tr class="hover:bg-stone-50 transition">
                            <td class="py-3 px-4 font-bold text-stone-900">
                                <div class="flex items-center space-x-2">
                                    <span>{{ $item->name }}</span>
                                    @if ($item->id === Auth::id())
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-green-100 text-green-800 border border-green-200">
                                            Anda
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-4 text-xs font-mono font-semibold text-stone-600">
                                {{ $item->username }}
                            </td>
                            <td class="py-3 px-4">
                                @if ($item->status === 'Aktif')
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-xs text-stone-500">
                                {{ $item->created_at ? $item->created_at->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="py-3 px-4 text-center whitespace-nowrap">
                                <div class="inline-flex items-center space-x-2">
                                    <button type="button"
                                        onclick="bukaModalEdit(this)"
                                        data-id="{{ $item->id }}"
                                        data-name="{{ $item->name }}"
                                        data-username="{{ $item->username }}"
                                        data-status="{{ $item->status }}"
                                        data-is-self="{{ $item->id === Auth::id() ? '1' : '0' }}"
                                        class="px-3 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-xl text-xs font-bold transition">
                                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                    </button>

                                    @if ($item->id !== Auth::id())
                                        <form method="POST" action="{{ route('admin.akun.destroy', $item->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun admin {{ $item->name }}?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl text-xs font-bold transition">
                                                <i class="fa-solid fa-trash mr-1"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-stone-400">
                                Belum ada data akun yang sesuai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($daftarAkun->hasPages())
            <div class="p-4 border-t border-stone-100">
                {{ $daftarAkun->links() }}
            </div>
        @endif
    </div>
</div>

<div id="modal-akun" class="fixed inset-0 z-50 hidden overflow-y-auto bg-stone-900/60 backdrop-blur-sm p-4 sm:p-6 flex items-center justify-center">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl space-y-6">
        <div class="flex items-center justify-between border-b border-stone-100 pb-4">
            <h3 id="modal-judul" class="text-lg font-black text-stone-900">Tambah Akun Admin</h3>
            <button type="button" onclick="tutupModal()" class="w-8 h-8 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-600 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="form-akun" method="POST" action="{{ route('admin.akun.store') }}" class="space-y-4">
            @csrf
            <div id="metode-put"></div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="input-name" required placeholder="Contoh: Budi Santoso" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm">
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Username (Huruf Kecil) <span class="text-rose-500">*</span></label>
                <input type="text" name="username" id="input-username" required placeholder="Contoh: budi_admin" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm font-mono lowercase">
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">
                    Kata Sandi <span id="label-wajib-password" class="text-rose-500">*</span>
                </label>
                <input type="password" name="password" id="input-password" placeholder="Minimal 6 karakter" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm">
                <div id="catatan-password" class="text-[11px] text-stone-400 mt-1 hidden">
                    Kosongkan jika tidak ingin mengubah kata sandi saat ini.
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Status Akun <span class="text-rose-500">*</span></label>
                <select name="status" id="input-status" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-green-600 text-sm bg-white">
                    <option value="Aktif">Aktif</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
                <div id="peringatan-self" class="text-[11px] text-amber-600 mt-1 hidden">
                    Anda tidak dapat menonaktifkan akun sendiri.
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
    var modal = document.getElementById('modal-akun');
    var form = document.getElementById('form-akun');
    var judul = document.getElementById('modal-judul');
    var wadahPut = document.getElementById('metode-put');
    var inputPass = document.getElementById('input-password');
    var labelWajibPass = document.getElementById('label-wajib-password');
    var catatanPass = document.getElementById('catatan-password');
    var selectStatus = document.getElementById('input-status');
    var peringatanSelf = document.getElementById('peringatan-self');

    function bukaModalTambah() {
        judul.textContent = 'Tambah Akun Admin';
        form.action = "{{ route('admin.akun.store') }}";
        wadahPut.innerHTML = '';

        document.getElementById('input-name').value = '';
        document.getElementById('input-username').value = '';
        inputPass.value = '';
        inputPass.required = true;
        labelWajibPass.classList.remove('hidden');
        catatanPass.classList.add('hidden');

        selectStatus.value = 'Aktif';
        selectStatus.disabled = false;
        peringatanSelf.classList.add('hidden');

        modal.classList.remove('hidden');
    }

    function bukaModalEdit(el) {
        var id = el.getAttribute('data-id');
        var name = el.getAttribute('data-name');
        var username = el.getAttribute('data-username');
        var status = el.getAttribute('data-status');
        var isSelf = el.getAttribute('data-is-self') === '1';

        judul.textContent = 'Edit Akun Admin: ' + name;
        form.action = "{{ url('admin/akun') }}/" + id;
        wadahPut.innerHTML = '<input type="hidden" name="_method" value="PUT">';

        document.getElementById('input-name').value = name;
        document.getElementById('input-username').value = username;

        inputPass.value = '';
        inputPass.required = false;
        labelWajibPass.classList.add('hidden');
        catatanPass.classList.remove('hidden');

        selectStatus.value = status;
        if (isSelf) {
            selectStatus.disabled = true;
            peringatanSelf.classList.remove('hidden');
        } else {
            selectStatus.disabled = false;
            peringatanSelf.classList.add('hidden');
        }

        modal.classList.remove('hidden');
    }

    function tutupModal() {
        modal.classList.add('hidden');
    }
</script>
@endsection
