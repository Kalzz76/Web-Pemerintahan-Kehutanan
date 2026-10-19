<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisLahan;
use App\Models\KawasanHutan;
use App\Models\Laporan;
use App\Models\PengaturanHutan;
use App\Models\TitikPenting;
use Illuminate\Http\Request;

class KawasanController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->query('cari');
        $query = KawasanHutan::with('jenisLahan');

        if ($cari) {
            $query->where('nama', 'like', '%' . $cari . '%')
                  ->orWhere('deskripsi', 'like', '%' . $cari . '%');
        }

        $daftarKawasan = $query->latest()->paginate(10)->withQueryString();

        return view('admin.kawasan.index', compact('daftarKawasan', 'cari'));
    }

    public function create()
    {
        $daftarJenisLahan = JenisLahan::orderBy('nama')->get();
        $pengaturan = PengaturanHutan::first();

        return view('admin.kawasan.create', compact('daftarJenisLahan', 'pengaturan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:150',
            'id_jenis_lahan' => 'required|exists:jenis_lahan,id',
            'deskripsi' => 'required',
            'luas_ha' => 'nullable|numeric|min:0',
            'geojson' => 'required',
        ], [
            'nama.required' => 'Nama kawasan hutan wajib diisi.',
            'id_jenis_lahan.required' => 'Jenis lahan wajib dipilih.',
            'id_jenis_lahan.exists' => 'Jenis lahan yang dipilih tidak valid.',
            'deskripsi.required' => 'Deskripsi kawasan wajib diisi.',
            'luas_ha.numeric' => 'Luas kawasan harus berupa angka desimal hektar.',
            'geojson.required' => 'Batas poligon kawasan hutan wajib digambar pada peta.',
        ]);

        KawasanHutan::create([
            'nama' => $request->nama,
            'id_jenis_lahan' => $request->id_jenis_lahan,
            'deskripsi' => $request->deskripsi,
            'luas_ha' => $request->luas_ha,
            'geojson' => $request->geojson,
        ]);

        return redirect()->route('admin.kawasan.index')->with('sukses', 'Kawasan hutan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kawasan = KawasanHutan::findOrFail($id);
        $daftarJenisLahan = JenisLahan::orderBy('nama')->get();
        $pengaturan = PengaturanHutan::first();

        return view('admin.kawasan.edit', compact('kawasan', 'daftarJenisLahan', 'pengaturan'));
    }

    public function update(Request $request, $id)
    {
        $kawasan = KawasanHutan::findOrFail($id);

        $request->validate([
            'nama' => 'required|max:150',
            'id_jenis_lahan' => 'required|exists:jenis_lahan,id',
            'deskripsi' => 'required',
            'luas_ha' => 'nullable|numeric|min:0',
            'geojson' => 'required',
        ], [
            'nama.required' => 'Nama kawasan hutan wajib diisi.',
            'id_jenis_lahan.required' => 'Jenis lahan wajib dipilih.',
            'id_jenis_lahan.exists' => 'Jenis lahan yang dipilih tidak valid.',
            'deskripsi.required' => 'Deskripsi kawasan wajib diisi.',
            'luas_ha.numeric' => 'Luas kawasan harus berupa angka desimal hektar.',
            'geojson.required' => 'Batas poligon kawasan hutan wajib digambar pada peta.',
        ]);

        $kawasan->update([
            'nama' => $request->nama,
            'id_jenis_lahan' => $request->id_jenis_lahan,
            'deskripsi' => $request->deskripsi,
            'luas_ha' => $request->luas_ha,
            'geojson' => $request->geojson,
        ]);

        return redirect()->route('admin.kawasan.index')->with('sukses', 'Kawasan hutan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kawasan = KawasanHutan::findOrFail($id);

        $terkaitTitikPenting = TitikPenting::where('id_kawasan', $kawasan->id)->exists();
        $terkaitLaporan = Laporan::where('id_kawasan', $kawasan->id)->exists();

        if ($terkaitTitikPenting || $terkaitLaporan) {
            return redirect()->route('admin.kawasan.index')->with('error', 'Kawasan hutan tidak dapat dihapus karena masih terkait dengan data titik penting atau laporan.');
        }

        $kawasan->delete();

        return redirect()->route('admin.kawasan.index')->with('sukses', 'Kawasan hutan berhasil dihapus.');
    }
}
