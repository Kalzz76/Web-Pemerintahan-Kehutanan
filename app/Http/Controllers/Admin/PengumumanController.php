<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->query('cari');
        $kategori = $request->query('kategori');
        $status = $request->query('status');

        $query = Pengumuman::with('user')->latest('tanggal');

        if (!empty($cari)) {
            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', '%' . $cari . '%')
                    ->orWhere('isi', 'like', '%' . $cari . '%');
            });
        }

        if (!empty($kategori)) {
            $query->where('kategori', $kategori);
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        $daftarPengumuman = $query->paginate(10)->withQueryString();

        return view('admin.pengumuman.index', compact('daftarPengumuman', 'cari', 'kategori', 'status'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:Kabar,Pengumuman,Tips Keselamatan',
            'isi' => 'required|string',
            'tanggal' => 'required|date',
            'status' => 'required|in:Draft,Publish',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'judul.required' => 'Judul pengumuman wajib diisi.',
            'kategori.required' => 'Kategori pengumuman wajib dipilih.',
            'kategori.in' => 'Pilihan kategori tidak valid.',
            'isi.required' => 'Isi materi pengumuman wajib diisi.',
            'tanggal.required' => 'Tanggal pengumuman wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'status.required' => 'Status publikasi wajib dipilih.',
            'status.in' => 'Pilihan status tidak valid.',
            'gambar.image' => 'File gambar harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus berupa JPG, JPEG, atau PNG.',
            'gambar.max' => 'Ukuran gambar maksimal adalah 2 MB.',
        ]);

        $pathGambar = null;
        if ($request->hasFile('gambar')) {
            $pathGambar = $request->file('gambar')->store('pengumuman', 'public');
        }

        Pengumuman::create([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'isi' => $request->isi,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'gambar' => $pathGambar,
            'id_user' => Auth::id(),
        ]);

        return redirect()->route('admin.pengumuman.index')->with('sukses', 'Pengumuman baru berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:Kabar,Pengumuman,Tips Keselamatan',
            'isi' => 'required|string',
            'tanggal' => 'required|date',
            'status' => 'required|in:Draft,Publish',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'judul.required' => 'Judul pengumuman wajib diisi.',
            'kategori.required' => 'Kategori pengumuman wajib dipilih.',
            'kategori.in' => 'Pilihan kategori tidak valid.',
            'isi.required' => 'Isi materi pengumuman wajib diisi.',
            'tanggal.required' => 'Tanggal pengumuman wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'status.required' => 'Status publikasi wajib dipilih.',
            'status.in' => 'Pilihan status tidak valid.',
            'gambar.image' => 'File gambar harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus berupa JPG, JPEG, atau PNG.',
            'gambar.max' => 'Ukuran gambar maksimal adalah 2 MB.',
        ]);

        $pathGambar = $pengumuman->gambar;
        if ($request->hasFile('gambar')) {
            if ($pengumuman->gambar && Storage::disk('public')->exists($pengumuman->gambar)) {
                Storage::disk('public')->delete($pengumuman->gambar);
            }
            $pathGambar = $request->file('gambar')->store('pengumuman', 'public');
        }

        $pengumuman->update([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'isi' => $request->isi,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'gambar' => $pathGambar,
        ]);

        return redirect()->route('admin.pengumuman.index')->with('sukses', 'Data pengumuman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        if ($pengumuman->gambar && Storage::disk('public')->exists($pengumuman->gambar)) {
            Storage::disk('public')->delete($pengumuman->gambar);
        }

        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')->with('sukses', 'Data pengumuman berhasil dihapus.');
    }
}
