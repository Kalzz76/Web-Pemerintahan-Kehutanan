<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KabupatenKota;
use App\Models\KawasanHutan;
use App\Models\PengaturanHutan;
use App\Models\TitikPenting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TitikPentingController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->query('cari');
        $filterJenis = $request->query('jenis');

        $query = TitikPenting::with(['kawasanHutan', 'kabupatenKota']);

        if ($cari) {
            $query->where(function ($q) use ($cari) {
                $q->where('nama', 'like', '%' . $cari . '%')
                  ->orWhere('deskripsi', 'like', '%' . $cari . '%')
                  ->orWhere('kontak', 'like', '%' . $cari . '%');
            });
        }

        if ($filterJenis) {
            $query->where('jenis', $filterJenis);
        }

        $daftarTitik = $query->latest()->paginate(10)->withQueryString();

        return view('admin.titik-penting.index', compact('daftarTitik', 'cari', 'filterJenis'));
    }

    public function create()
    {
        $daftarKawasan = KawasanHutan::orderBy('nama')->get();
        $daftarKabupaten = KabupatenKota::orderBy('nama')->get();
        $pengaturan = PengaturanHutan::first();
        $semuaKawasan = KawasanHutan::select('id', 'nama', 'geojson')->get();

        return view('admin.titik-penting.create', compact('daftarKawasan', 'daftarKabupaten', 'pengaturan', 'semuaKawasan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:150',
            'jenis' => 'required|in:Pos Jaga,Pos Pemadam,Sumber Air,Titik Kumpul Evakuasi,Permukiman',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'deskripsi' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kontak' => 'nullable|max:100',
            'id_kawasan' => 'nullable|exists:kawasan_hutan,id',
            'id_kabupaten_kota' => 'nullable|exists:kabupaten_kota,id',
        ], [
            'nama.required' => 'Nama titik penting wajib diisi.',
            'jenis.required' => 'Jenis titik penting wajib dipilih.',
            'jenis.in' => 'Jenis titik penting tidak valid.',
            'latitude.required' => 'Lokasi latitude wajib ditentukan dari peta.',
            'latitude.between' => 'Latitude harus bernilai antara -90 dan 90.',
            'longitude.required' => 'Lokasi longitude wajib ditentukan dari peta.',
            'longitude.between' => 'Longitude harus bernilai antara -180 dan 180.',
            'deskripsi.required' => 'Deskripsi titik penting wajib diisi.',
            'foto.image' => 'Berkas foto harus berupa gambar.',
            'foto.mimes' => 'Format foto harus berupa JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
            'id_kawasan.exists' => 'Kawasan hutan yang dipilih tidak valid.',
            'id_kabupaten_kota.exists' => 'Kabupaten/Kota yang dipilih tidak valid.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('titik_penting', 'public');
        }

        TitikPenting::create([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
            'kontak' => $request->kontak,
            'id_kawasan' => $request->id_kawasan,
            'id_kabupaten_kota' => $request->id_kabupaten_kota,
        ]);

        return redirect()->route('admin.titik-penting.index')->with('sukses', 'Titik penting berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $titik = TitikPenting::findOrFail($id);
        $daftarKawasan = KawasanHutan::orderBy('nama')->get();
        $daftarKabupaten = KabupatenKota::orderBy('nama')->get();
        $pengaturan = PengaturanHutan::first();
        $semuaKawasan = KawasanHutan::select('id', 'nama', 'geojson')->get();

        return view('admin.titik-penting.edit', compact('titik', 'daftarKawasan', 'daftarKabupaten', 'pengaturan', 'semuaKawasan'));
    }

    public function update(Request $request, $id)
    {
        $titik = TitikPenting::findOrFail($id);

        $request->validate([
            'nama' => 'required|max:150',
            'jenis' => 'required|in:Pos Jaga,Pos Pemadam,Sumber Air,Titik Kumpul Evakuasi,Permukiman',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'deskripsi' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kontak' => 'nullable|max:100',
            'id_kawasan' => 'nullable|exists:kawasan_hutan,id',
            'id_kabupaten_kota' => 'nullable|exists:kabupaten_kota,id',
        ], [
            'nama.required' => 'Nama titik penting wajib diisi.',
            'jenis.required' => 'Jenis titik penting wajib dipilih.',
            'jenis.in' => 'Jenis titik penting tidak valid.',
            'latitude.required' => 'Lokasi latitude wajib ditentukan dari peta.',
            'latitude.between' => 'Latitude harus bernilai antara -90 dan 90.',
            'longitude.required' => 'Lokasi longitude wajib ditentukan dari peta.',
            'longitude.between' => 'Longitude harus bernilai antara -180 dan 180.',
            'deskripsi.required' => 'Deskripsi titik penting wajib diisi.',
            'foto.image' => 'Berkas foto harus berupa gambar.',
            'foto.mimes' => 'Format foto harus berupa JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
            'id_kawasan.exists' => 'Kawasan hutan yang dipilih tidak valid.',
            'id_kabupaten_kota.exists' => 'Kabupaten/Kota yang dipilih tidak valid.',
        ]);

        $fotoPath = $titik->foto;
        if ($request->hasFile('foto')) {
            if ($titik->foto && Storage::disk('public')->exists($titik->foto)) {
                Storage::disk('public')->delete($titik->foto);
            }
            $fotoPath = $request->file('foto')->store('titik_penting', 'public');
        }

        $titik->update([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
            'kontak' => $request->kontak,
            'id_kawasan' => $request->id_kawasan,
            'id_kabupaten_kota' => $request->id_kabupaten_kota,
        ]);

        return redirect()->route('admin.titik-penting.index')->with('sukses', 'Titik penting berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $titik = TitikPenting::findOrFail($id);

        if ($titik->foto && Storage::disk('public')->exists($titik->foto)) {
            Storage::disk('public')->delete($titik->foto);
        }

        $titik->delete();

        return redirect()->route('admin.titik-penting.index')->with('sukses', 'Titik penting berhasil dihapus.');
    }
}
