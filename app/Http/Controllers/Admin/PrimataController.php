<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KawasanHutan;
use App\Models\Primata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrimataController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->query('cari');
        $statusKonservasi = $request->query('status_konservasi');

        $query = Primata::with('kawasanHutan')->latest();

        if (!empty($cari)) {
            $query->where(function ($q) use ($cari) {
                $q->where('nama_lokal', 'like', '%' . $cari . '%')
                    ->orWhere('nama_ilmiah', 'like', '%' . $cari . '%')
                    ->orWhere('habitat', 'like', '%' . $cari . '%');
            });
        }

        if (!empty($statusKonservasi)) {
            $query->where('status_konservasi', $statusKonservasi);
        }

        $daftarPrimata = $query->paginate(10)->withQueryString();
        $daftarKawasan = KawasanHutan::orderBy('nama')->get();

        return view('admin.primata.index', compact('daftarPrimata', 'daftarKawasan', 'cari', 'statusKonservasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lokal' => 'required|string|max:255',
            'nama_ilmiah' => 'required|string|max:255',
            'status_konservasi' => 'required|in:CR,EN,VU,NT,LC,DD,NE',
            'dilindungi' => 'nullable|boolean',
            'habitat' => 'required|string|max:500',
            'makanan' => 'required|string|max:500',
            'ciri_khas' => 'required|string|max:500',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kawasan' => 'nullable|array',
            'kawasan.*' => 'exists:kawasan_hutan,id',
        ], [
            'nama_lokal.required' => 'Nama lokal primata wajib diisi.',
            'nama_ilmiah.required' => 'Nama ilmiah primata wajib diisi.',
            'status_konservasi.required' => 'Status konservasi wajib dipilih.',
            'status_konservasi.in' => 'Pilihan status konservasi tidak valid.',
            'habitat.required' => 'Habitat primata wajib diisi.',
            'makanan.required' => 'Makanan primata wajib diisi.',
            'ciri_khas.required' => 'Ciri khas primata wajib diisi.',
            'deskripsi.required' => 'Deskripsi primata wajib diisi.',
            'foto.image' => 'File foto harus berupa gambar.',
            'foto.mimes' => 'Format foto harus berupa JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran foto maksimal adalah 2 MB.',
        ]);

        $pathFoto = null;
        if ($request->hasFile('foto')) {
            $pathFoto = $request->file('foto')->store('primata', 'public');
        }

        $primata = Primata::create([
            'nama_lokal' => $request->nama_lokal,
            'nama_ilmiah' => $request->nama_ilmiah,
            'status_konservasi' => $request->status_konservasi,
            'dilindungi' => $request->has('dilindungi') ? 1 : 0,
            'habitat' => $request->habitat,
            'makanan' => $request->makanan,
            'ciri_khas' => $request->ciri_khas,
            'deskripsi' => $request->deskripsi,
            'foto' => $pathFoto,
        ]);

        if ($request->has('kawasan')) {
            $primata->kawasanHutan()->sync($request->kawasan);
        }

        return redirect()->route('admin.primata.index')->with('sukses', 'Data primata baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $primata = Primata::findOrFail($id);

        $request->validate([
            'nama_lokal' => 'required|string|max:255',
            'nama_ilmiah' => 'required|string|max:255',
            'status_konservasi' => 'required|in:CR,EN,VU,NT,LC,DD,NE',
            'dilindungi' => 'nullable|boolean',
            'habitat' => 'required|string|max:500',
            'makanan' => 'required|string|max:500',
            'ciri_khas' => 'required|string|max:500',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kawasan' => 'nullable|array',
            'kawasan.*' => 'exists:kawasan_hutan,id',
        ], [
            'nama_lokal.required' => 'Nama lokal primata wajib diisi.',
            'nama_ilmiah.required' => 'Nama ilmiah primata wajib diisi.',
            'status_konservasi.required' => 'Status konservasi wajib dipilih.',
            'status_konservasi.in' => 'Pilihan status konservasi tidak valid.',
            'habitat.required' => 'Habitat primata wajib diisi.',
            'makanan.required' => 'Makanan primata wajib diisi.',
            'ciri_khas.required' => 'Ciri khas primata wajib diisi.',
            'deskripsi.required' => 'Deskripsi primata wajib diisi.',
            'foto.image' => 'File foto harus berupa gambar.',
            'foto.mimes' => 'Format foto harus berupa JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran foto maksimal adalah 2 MB.',
        ]);

        $pathFoto = $primata->foto;
        if ($request->hasFile('foto')) {
            if ($primata->foto && Storage::disk('public')->exists($primata->foto)) {
                Storage::disk('public')->delete($primata->foto);
            }
            $pathFoto = $request->file('foto')->store('primata', 'public');
        }

        $primata->update([
            'nama_lokal' => $request->nama_lokal,
            'nama_ilmiah' => $request->nama_ilmiah,
            'status_konservasi' => $request->status_konservasi,
            'dilindungi' => $request->has('dilindungi') ? 1 : 0,
            'habitat' => $request->habitat,
            'makanan' => $request->makanan,
            'ciri_khas' => $request->ciri_khas,
            'deskripsi' => $request->deskripsi,
            'foto' => $pathFoto,
        ]);

        $primata->kawasanHutan()->sync($request->kawasan ?? []);

        return redirect()->route('admin.primata.index')->with('sukses', 'Data primata berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $primata = Primata::findOrFail($id);

        if ($primata->foto && Storage::disk('public')->exists($primata->foto)) {
            Storage::disk('public')->delete($primata->foto);
        }

        $primata->kawasanHutan()->detach();
        $primata->delete();

        return redirect()->route('admin.primata.index')->with('sukses', 'Data primata berhasil dihapus.');
    }
}
