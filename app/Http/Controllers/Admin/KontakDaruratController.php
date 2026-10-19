<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KontakDarurat;
use Illuminate\Http\Request;

class KontakDaruratController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->query('cari');

        $query = KontakDarurat::orderBy('urutan');

        if (!empty($cari)) {
            $query->where(function ($q) use ($cari) {
                $q->where('nama', 'like', '%' . $cari . '%')
                    ->orWhere('instansi', 'like', '%' . $cari . '%')
                    ->orWhere('nomor_telepon', 'like', '%' . $cari . '%');
            });
        }

        $daftarKontak = $query->paginate(10)->withQueryString();

        return view('admin.kontak-darurat.index', compact('daftarKontak', 'cari'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:50',
            'keterangan' => 'nullable|string|max:255',
            'urutan' => 'nullable|integer|min:0',
        ], [
            'nama.required' => 'Nama kontak/posko wajib diisi.',
            'instansi.required' => 'Nama instansi wajib diisi.',
            'nomor_telepon.required' => 'Nomor telepon wajib diisi.',
        ]);

        KontakDarurat::create([
            'nama' => $request->nama,
            'instansi' => $request->instansi,
            'nomor_telepon' => $request->nomor_telepon,
            'keterangan' => $request->keterangan,
            'urutan' => $request->urutan ?? 0,
        ]);

        return redirect()->route('admin.kontak-darurat.index')->with('sukses', 'Kontak darurat baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $kontak = KontakDarurat::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:50',
            'keterangan' => 'nullable|string|max:255',
            'urutan' => 'nullable|integer|min:0',
        ], [
            'nama.required' => 'Nama kontak/posko wajib diisi.',
            'instansi.required' => 'Nama instansi wajib diisi.',
            'nomor_telepon.required' => 'Nomor telepon wajib diisi.',
        ]);

        $kontak->update([
            'nama' => $request->nama,
            'instansi' => $request->instansi,
            'nomor_telepon' => $request->nomor_telepon,
            'keterangan' => $request->keterangan,
            'urutan' => $request->urutan ?? 0,
        ]);

        return redirect()->route('admin.kontak-darurat.index')->with('sukses', 'Kontak darurat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kontak = KontakDarurat::findOrFail($id);
        $kontak->delete();

        return redirect()->route('admin.kontak-darurat.index')->with('sukses', 'Kontak darurat berhasil dihapus.');
    }
}
