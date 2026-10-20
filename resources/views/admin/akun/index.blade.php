@extends('layouts.admin')

@section('title', 'Kelola Akun Admin')

@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-lg md:text-xl font-bold text-stone-900 tracking-tight">Akun Administrator</h1>
            <p class="text-stone-500 text-xs mt-0.5">
                Kelola kredensial akun pengelola web, penambahan admin baru, dan hak akses sistem desa.
            </p>
        </div>
        <button type="button" onclick="bukaModalTambah()" class="inline-flex items-center px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl text-xs sm:text-sm shadow-sm transition active:scale-95 shrink-0">
            <i class="fa-solid fa-user-plus mr-1.5 text-xs"></i>
            <span>Tambah Akun Admin</span>
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
        <form method="GET" action="{{ route('admin.akun.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-stone-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="cari" value="{{ $cari ?? '' }}" placeholder="Cari nama atau username..." class="w-full pl-10 pr-4 py-2 text-xs sm:text-sm rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 transition">
            </div>

            <button type="submit" class="px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-xl text-xs sm:text-sm transition">
                Cari
            </button>

            @if (!empty($cari))
                <a href="{{ route('admin.akun.index') }}" class="px-3.5 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 border border-stone-300 font-semibold rounded-xl text-xs sm:text-sm transition text-center">
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
                        <th class="px-4 py-3.5">Nama Lengkap</th>
                        <th class="px-4 py-3.5">Username</th>
                        <th class="px-4 py-3.5">Status</th>
                        <th class="px-4 py-3.5">Terdaftar Pada</th>
                        <th class="px-4 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-200/70 text-stone-700">
                    @forelse ($daftarAkun as $item)
                        <tr class="hover:bg-stone-50/80 transition">
                            <td class="px-4 py-3.5 font-bold text-stone-900 text-xs sm:text-sm">
                                <div class="flex items-center space-x-1.5">
                                    <span>{{ $item->name }}</span>
                                    @if ($item->id === Auth::id())
                                        <span class="text-stone-400 text-xs font-normal">
                                            (Anda)
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-xs font-mono font-semibold text-stone-600">
                                {{ $item->username }}
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap">
                                <span class="text-xs font-semibold {{ $item->status === 'Aktif' ? 'text-stone-900' : 'text-stone-400' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-xs text-stone-500 whitespace-nowrap">
                                {{ $item->created_at ? $item->created_at->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="px-4 py-3.5 text-right whitespace-nowrap space-x-1.5">
                                <button type="button"
                                    onclick="bukaModalEdit(this)"
                                    data-id="{{ $item->id }}"
                                    data-name="{{ $item->name }}"
                                    data-username="{{ $item->username }}"
                                    data-status="{{ $item->status }}"
                                    data-is-self="{{ $item->id === Auth::id() ? '1' : '0' }}"
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 border border-stone-300 font-semibold rounded-lg text-xs transition">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Edit</span>
                                </button>

                                @if ($item->id !== Auth::id())
                                    <form method="POST" action="{{ route('admin.akun.destroy', $item->id) }}" class="inline" data-confirm="Apakah Anda yakin ingin menghapus akun admin {{ $item->name }}?" data-confirm-title="Hapus Akun Admin" data-confirm-ok="Ya, Hapus">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-white hover:bg-stone-100 text-stone-700 hover:text-stone-900 border border-stone-300 font-semibold rounded-lg text-xs transition">
                                            <i class="fa-solid fa-trash"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-stone-400">
                                <i class="fa-solid fa-users text-3xl mb-2 block text-stone-300"></i>
                                <p class="text-xs font-medium">Belum ada data akun yang sesuai.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($daftarAkun->hasPages())
            <div class="p-4 border-t border-stone-200/80">
                {{ $daftarAkun->links() }}
            </div>
        @endif
    </div>
</div>

<div id="modal-akun" class="fixed inset-0 z-50 hidden overflow-y-auto bg-stone-950/60 backdrop-blur-sm p-4 sm:p-6 flex items-center justify-center">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-5 border border-stone-200">
        <div class="flex items-center justify-between border-b border-stone-200/80 pb-3">
            <h3 id="modal-judul" class="text-base font-bold text-stone-900">Tambah Akun Admin</h3>
            <button type="button" onclick="tutupModal()" class="text-stone-400 hover:text-stone-700 text-base">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="form-akun" method="POST" action="{{ route('admin.akun.store') }}" class="space-y-4">
            @csrf
            <div id="metode-put"></div>

            <div>
                <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="input-name" required placeholder="Contoh: Budi Santoso" class="w-full px-3.5 py-2 rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 text-xs sm:text-sm">
            </div>

            <div>
                <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Username (Huruf Kecil) <span class="text-rose-500">*</span></label>
                <input type="text" name="username" id="input-username" required placeholder="Contoh: budi_admin" class="w-full px-3.5 py-2 rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 text-xs sm:text-sm font-mono lowercase">
            </div>

            <div>
                <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                    Kata Sandi <span id="label-wajib-password" class="text-rose-500">*</span>
                </label>
                <input type="password" name="password" id="input-password" placeholder="Minimal 6 karakter" class="w-full px-3.5 py-2 rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 text-xs sm:text-sm">
                <div id="catatan-password" class="text-[10px] text-stone-400 mt-1 hidden">
                    Kosongkan jika tidak ingin mengubah kata sandi saat ini.
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">Status Akun <span class="text-rose-500">*</span></label>
                <select name="status" id="input-status" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 focus:outline-none focus:border-stone-900 text-xs sm:text-sm bg-white">
                    <option value="Aktif">Aktif</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
                <div id="peringatan-self" class="text-[10px] text-stone-500 mt-1 hidden">
                    Anda tidak dapat menonaktifkan akun sendiri.
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
