<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisLahan;
use App\Models\KawasanHutan;
use App\Models\PrediksiApi;
use Illuminate\Http\Request;

class JenisLahanController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->query('cari');
        $query = JenisLahan::query();

        if ($cari) {
            $query->where('nama', 'like', '%' . $cari . '%')
                  ->orWhere('keterangan', 'like', '%' . $cari . '%');
        }

        $daftarJenisLahan = $query->orderBy('nama')->paginate(10)->withQueryString();

        return view('admin.jenis-lahan.index', compact('daftarJenisLahan', 'cari'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:jenis_lahan,nama|max:100',
            'laju_dasar' => 'required|integer|min:1',
            'keterangan' => 'nullable|max:500',
        ], [
            'nama.required' => 'Nama jenis lahan wajib diisi.',
            'nama.unique' => 'Nama jenis lahan sudah ada.',
            'laju_dasar.required' => 'Laju dasar api wajib diisi.',
            'laju_dasar.integer' => 'Laju dasar api harus berupa angka bulat meter/jam.',
            'laju_dasar.min' => 'Laju dasar api minimal 1 meter/jam.',
        ]);

        JenisLahan::create([
            'nama' => $request->nama,
            'laju_dasar' => $request->laju_dasar,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.jenis-lahan.index')->with('sukses', 'Jenis lahan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $jenisLahan = JenisLahan::findOrFail($id);

        $request->validate([
            'nama' => 'required|max:100|unique:jenis_lahan,nama,' . $jenisLahan->id,
            'laju_dasar' => 'required|integer|min:1',
            'keterangan' => 'nullable|max:500',
        ], [
            'nama.required' => 'Nama jenis lahan wajib diisi.',
            'nama.unique' => 'Nama jenis lahan sudah ada.',
            'laju_dasar.required' => 'Laju dasar api wajib diisi.',
            'laju_dasar.integer' => 'Laju dasar api harus berupa angka bulat meter/jam.',
            'laju_dasar.min' => 'Laju dasar api minimal 1 meter/jam.',
        ]);

        $jenisLahan->update([
            'nama' => $request->nama,
            'laju_dasar' => $request->laju_dasar,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.jenis-lahan.index')->with('sukses', 'Jenis lahan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jenisLahan = JenisLahan::findOrFail($id);

        $terpakaiKawasan = KawasanHutan::where('id_jenis_lahan', $jenisLahan->id)->exists();
        $terpakaiPrediksi = PrediksiApi::where('id_jenis_lahan', $jenisLahan->id)->exists();

        if ($terpakaiKawasan || $terpakaiPrediksi) {
            return redirect()->route('admin.jenis-lahan.index')->with('error', 'Jenis lahan tidak dapat dihapus karena masih digunakan oleh data kawasan hutan atau riwayat prediksi.');
        }

        $jenisLahan->delete();

        return redirect()->route('admin.jenis-lahan.index')->with('sukses', 'Jenis lahan berhasil dihapus.');
    }
}
