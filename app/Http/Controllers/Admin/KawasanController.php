<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KabupatenKota;
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
        $query = KawasanHutan::with(['jenisLahan', 'kabupatenKota']);

        if ($cari) {
            $query->where('nama', 'like', '%' . $cari . '%')
                  ->orWhere('deskripsi', 'like', '%' . $cari . '%')
                  ->orWhere('pengelola', 'like', '%' . $cari . '%');
        }

        $daftarKawasan = $query->latest()->paginate(10)->withQueryString();

        return view('admin.kawasan.index', compact('daftarKawasan', 'cari'));
    }

    public function create()
    {
        $daftarJenisLahan = JenisLahan::orderBy('nama')->get();
        $daftarKabupaten = KabupatenKota::orderBy('nama')->get();
        $pengaturan = PengaturanHutan::first();

        return view('admin.kawasan.create', compact('daftarJenisLahan', 'daftarKabupaten', 'pengaturan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:150',
            'kategori' => 'required|in:Taman Nasional,Cagar Alam,Suaka Margasatwa,Taman Wisata Alam,Taman Buru,Taman Hutan Raya,Hutan Lindung,Hutan Produksi,Lainnya',
            'pengelola' => 'nullable|max:150',
            'id_jenis_lahan' => 'required|exists:jenis_lahan,id',
            'deskripsi' => 'required',
            'luas_ha' => 'nullable|numeric|min:0',
            'lat_pusat' => 'nullable|numeric|between:-90,90',
            'long_pusat' => 'nullable|numeric|between:-180,180',
            'geojson' => 'required',
            'kabupaten_kota' => 'nullable|array',
            'kabupaten_kota.*' => 'exists:kabupaten_kota,id',
        ], [
            'nama.required' => 'Nama kawasan hutan wajib diisi.',
            'kategori.required' => 'Kategori kawasan hutan wajib dipilih.',
            'kategori.in' => 'Kategori kawasan hutan tidak valid.',
            'id_jenis_lahan.required' => 'Jenis lahan wajib dipilih.',
            'id_jenis_lahan.exists' => 'Jenis lahan yang dipilih tidak valid.',
            'deskripsi.required' => 'Deskripsi kawasan wajib diisi.',
            'luas_ha.numeric' => 'Luas kawasan harus berupa angka desimal hektar.',
            'geojson.required' => 'Batas poligon kawasan hutan wajib digambar pada peta.',
        ]);

        $kawasan = KawasanHutan::create([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'pengelola' => $request->pengelola,
            'id_jenis_lahan' => $request->id_jenis_lahan,
            'deskripsi' => $request->deskripsi,
            'luas_ha' => $request->luas_ha,
            'lat_pusat' => $request->lat_pusat,
            'long_pusat' => $request->long_pusat,
            'geojson' => $request->geojson,
            'batas_resmi' => $request->has('batas_resmi') ? 1 : 0,
        ]);

        if ($request->has('kabupaten_kota')) {
            $kawasan->kabupatenKota()->sync($request->kabupaten_kota);
        }

        return redirect()->route('admin.kawasan.index')->with('sukses', 'Kawasan hutan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kawasan = KawasanHutan::with('kabupatenKota')->findOrFail($id);
        $daftarJenisLahan = JenisLahan::orderBy('nama')->get();
        $daftarKabupaten = KabupatenKota::orderBy('nama')->get();
        $pengaturan = PengaturanHutan::first();

        return view('admin.kawasan.edit', compact('kawasan', 'daftarJenisLahan', 'daftarKabupaten', 'pengaturan'));
    }

    public function update(Request $request, $id)
    {
        $kawasan = KawasanHutan::findOrFail($id);

        $request->validate([
            'nama' => 'required|max:150',
            'kategori' => 'required|in:Taman Nasional,Cagar Alam,Suaka Margasatwa,Taman Wisata Alam,Taman Buru,Taman Hutan Raya,Hutan Lindung,Hutan Produksi,Lainnya',
            'pengelola' => 'nullable|max:150',
            'id_jenis_lahan' => 'required|exists:jenis_lahan,id',
            'deskripsi' => 'required',
            'luas_ha' => 'nullable|numeric|min:0',
            'lat_pusat' => 'nullable|numeric|between:-90,90',
            'long_pusat' => 'nullable|numeric|between:-180,180',
            'geojson' => 'required',
            'kabupaten_kota' => 'nullable|array',
            'kabupaten_kota.*' => 'exists:kabupaten_kota,id',
        ], [
            'nama.required' => 'Nama kawasan hutan wajib diisi.',
            'kategori.required' => 'Kategori kawasan hutan wajib dipilih.',
            'kategori.in' => 'Kategori kawasan hutan tidak valid.',
            'id_jenis_lahan.required' => 'Jenis lahan wajib dipilih.',
            'id_jenis_lahan.exists' => 'Jenis lahan yang dipilih tidak valid.',
            'deskripsi.required' => 'Deskripsi kawasan wajib diisi.',
            'luas_ha.numeric' => 'Luas kawasan harus berupa angka desimal hektar.',
            'geojson.required' => 'Batas poligon kawasan hutan wajib digambar pada peta.',
        ]);

        $kawasan->update([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'pengelola' => $request->pengelola,
            'id_jenis_lahan' => $request->id_jenis_lahan,
            'deskripsi' => $request->deskripsi,
            'luas_ha' => $request->luas_ha,
            'lat_pusat' => $request->lat_pusat,
            'long_pusat' => $request->long_pusat,
            'geojson' => $request->geojson,
            'batas_resmi' => $request->has('batas_resmi') ? 1 : 0,
        ]);

        $kawasan->kabupatenKota()->sync($request->kabupaten_kota ?? []);

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

        $kawasan->kabupatenKota()->detach();
        $kawasan->primata()->detach();
        $kawasan->tumbuhan()->detach();
        $kawasan->delete();

        return redirect()->route('admin.kawasan.index')->with('sukses', 'Kawasan hutan berhasil dihapus.');
    }
}
