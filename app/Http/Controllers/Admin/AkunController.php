<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->query('cari');

        $query = User::latest();

        if (!empty($cari)) {
            $query->where(function ($q) use ($cari) {
                $q->where('name', 'like', '%' . $cari . '%')
                    ->orWhere('username', 'like', '%' . $cari . '%');
            });
        }

        $daftarAkun = $query->paginate(10)->withQueryString();

        return view('admin.akun.index', compact('daftarAkun', 'cari'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username|regex:/^[a-z0-9_]+$/',
            'password' => 'required|string|min:6',
            'status' => 'required|in:Aktif,Nonaktif',
        ], [
            'name.required' => 'Nama lengkap pengguna wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username ini sudah digunakan.',
            'username.regex' => 'Username hanya boleh menggunakan huruf kecil, angka, dan garis bawah tanpa spasi.',
            'password.required' => 'Kata sandi akun wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'status.required' => 'Status akun wajib dipilih.',
        ]);

        User::create([
            'name' => $request->name,
            'username' => strtolower($request->username),
            'password' => Hash::make($request->password),
            'status' => $request->status,
        ]);

        return redirect()->route('admin.akun.index')->with('sukses', 'Akun admin baru berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username,' . $user->id . '|regex:/^[a-z0-9_]+$/',
            'password' => 'nullable|string|min:6',
            'status' => 'required|in:Aktif,Nonaktif',
        ], [
            'name.required' => 'Nama lengkap pengguna wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username ini sudah digunakan.',
            'username.regex' => 'Username hanya boleh menggunakan huruf kecil, angka, dan garis bawah tanpa spasi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'status.required' => 'Status akun wajib dipilih.',
        ]);

        if ($user->id === Auth::id() && $request->status === 'Nonaktif') {
            return redirect()->route('admin.akun.index')->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri saat sedang masuk.');
        }

        $data = [
            'name' => $request->name,
            'username' => strtolower($request->username),
            'status' => $request->status,
        ];

        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.akun.index')->with('sukses', 'Data akun admin berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()->route('admin.akun.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif digunakan.');
        }

        $user->delete();

        return redirect()->route('admin.akun.index')->with('sukses', 'Akun admin berhasil dihapus.');
    }
}
