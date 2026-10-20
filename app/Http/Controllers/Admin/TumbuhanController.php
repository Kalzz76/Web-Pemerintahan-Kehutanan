<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KawasanHutan;
use App\Models\Tumbuhan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TumbuhanController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->query('cari');
        $jenis = $request->query('jenis');
        $statusKonservasi = $request->query('status_konservasi');

        $query = Tumbuhan::with('kawasanHutan')->latest();

        if (!empty($cari)) {
            $query->where(function ($q) use ($cari) {
                $q->where('nama_lokal', 'like', '%' . $cari . '%')
                    ->orWhere('nama_ilmiah', 'like', '%' . $cari . '%')
                    ->orWhere('manfaat', 'like', '%' . $cari . '%');
            });
        }

        if (!empty($jenis)) {
            $query->where('jenis', $jenis);
        }

        if (!empty($statusKonservasi)) {
            $query->where('status_konservasi', $statusKonservasi);
        }

        $daftarTumbuhan = $query->paginate(10)->withQueryString();
        $daftarKawasan = KawasanHutan::orderBy('nama')->get();

        return view('admin.tumbuhan.index', compact('daftarTumbuhan', 'daftarKawasan', 'cari', 'jenis', 'statusKonservasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lokal' => 'required|string|max:255',
            'nama_ilmiah' => 'required|string|max:255',
            'jenis' => 'required|in:Pohon,Perdu,Herba,Liana,Lainnya',
            'status_konservasi' => 'required|in:CR,EN,VU,NT,LC,DD,NE',
            'dilindungi' => 'nullable|boolean',
            'manfaat' => 'required|string|max:500',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kawasan' => 'nullable|array',
            'kawasan.*' => 'exists:kawasan_hutan,id',
        ], [
            'nama_lokal.required' => 'Nama lokal tumbuhan wajib diisi.',
            'nama_ilmiah.required' => 'Nama ilmiah tumbuhan wajib diisi.',
            'jenis.required' => 'Jenis habitus tumbuhan wajib dipilih.',
            'jenis.in' => 'Pilihan jenis tumbuhan tidak valid.',
            'status_konservasi.required' => 'Status konservasi wajib dipilih.',
            'status_konservasi.in' => 'Pilihan status konservasi tidak valid.',
            'manfaat.required' => 'Manfaat tumbuhan wajib diisi.',
            'deskripsi.required' => 'Deskripsi tumbuhan wajib diisi.',
            'foto.image' => 'File foto harus berupa gambar.',
            'foto.mimes' => 'Format foto harus berupa JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran foto maksimal adalah 2 MB.',
        ]);

        $pathFoto = null;
        if ($request->hasFile('foto')) {
            $pathFoto = $request->file('foto')->store('tumbuhan', 'public');
        }

        $tumbuhan = Tumbuhan::create([
            'nama_lokal' => $request->nama_lokal,
            'nama_ilmiah' => $request->nama_ilmiah,
            'jenis' => $request->jenis,
            'status_konservasi' => $request->status_konservasi,
            'dilindungi' => $request->has('dilindungi') ? 1 : 0,
            'manfaat' => $request->manfaat,
            'deskripsi' => $request->deskripsi,
            'foto' => $pathFoto,
        ]);

        if ($request->has('kawasan')) {
            $tumbuhan->kawasanHutan()->sync($request->kawasan);
        }

        return redirect()->route('admin.tumbuhan.index')->with('sukses', 'Data tumbuhan baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $tumbuhan = Tumbuhan::findOrFail($id);

        $request->validate([
            'nama_lokal' => 'required|string|max:255',
            'nama_ilmiah' => 'required|string|max:255',
            'jenis' => 'required|in:Pohon,Perdu,Herba,Liana,Lainnya',
            'status_konservasi' => 'required|in:CR,EN,VU,NT,LC,DD,NE',
            'dilindungi' => 'nullable|boolean',
            'manfaat' => 'required|string|max:500',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kawasan' => 'nullable|array',
            'kawasan.*' => 'exists:kawasan_hutan,id',
        ], [
            'nama_lokal.required' => 'Nama lokal tumbuhan wajib diisi.',
            'nama_ilmiah.required' => 'Nama ilmiah tumbuhan wajib diisi.',
            'jenis.required' => 'Jenis habitus tumbuhan wajib dipilih.',
            'jenis.in' => 'Pilihan jenis tumbuhan tidak valid.',
            'status_konservasi.required' => 'Status konservasi wajib dipilih.',
            'status_konservasi.in' => 'Pilihan status konservasi tidak valid.',
            'manfaat.required' => 'Manfaat tumbuhan wajib diisi.',
            'deskripsi.required' => 'Deskripsi tumbuhan wajib diisi.',
            'foto.image' => 'File foto harus berupa gambar.',
            'foto.mimes' => 'Format foto harus berupa JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran foto maksimal adalah 2 MB.',
        ]);

        $pathFoto = $tumbuhan->foto;
        if ($request->hasFile('foto')) {
            if ($tumbuhan->foto && Storage::disk('public')->exists($tumbuhan->foto)) {
                Storage::disk('public')->delete($tumbuhan->foto);
            }
            $pathFoto = $request->file('foto')->store('tumbuhan', 'public');
        }

        $tumbuhan->update([
            'nama_lokal' => $request->nama_lokal,
            'nama_ilmiah' => $request->nama_ilmiah,
            'jenis' => $request->jenis,
            'status_konservasi' => $request->status_konservasi,
            'dilindungi' => $request->has('dilindungi') ? 1 : 0,
            'manfaat' => $request->manfaat,
            'deskripsi' => $request->deskripsi,
            'foto' => $pathFoto,
        ]);

        $tumbuhan->kawasanHutan()->sync($request->kawasan ?? []);

        return redirect()->route('admin.tumbuhan.index')->with('sukses', 'Data tumbuhan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tumbuhan = Tumbuhan::findOrFail($id);

        if ($tumbuhan->foto && Storage::disk('public')->exists($tumbuhan->foto)) {
            Storage::disk('public')->delete($tumbuhan->foto);
        }

        $tumbuhan->kawasanHutan()->detach();
        $tumbuhan->delete();

        return redirect()->route('admin.tumbuhan.index')->with('sukses', 'Data tumbuhan berhasil dihapus.');
    }
}
