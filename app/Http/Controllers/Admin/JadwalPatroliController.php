<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPatroli;
use Illuminate\Http\Request;

class JadwalPatroliController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->query('cari');

        $query = JadwalPatroli::latest('tanggal');

        if (!empty($cari)) {
            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', '%' . $cari . '%')
                    ->orWhere('lokasi', 'like', '%' . $cari . '%')
                    ->orWhere('keterangan', 'like', '%' . $cari . '%');
            });
        }

        $daftarJadwal = $query->paginate(10)->withQueryString();

        return view('admin.jadwal-patroli.index', compact('daftarJadwal', 'cari'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam' => 'required|string|max:50',
            'lokasi' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'judul.required' => 'Judul kegiatan patroli wajib diisi.',
            'tanggal.required' => 'Tanggal patroli wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'jam.required' => 'Jam pelaksanaan patroli wajib diisi.',
            'lokasi.required' => 'Lokasi patroli wajib diisi.',
        ]);

        JadwalPatroli::create([
            'judul' => $request->judul,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.jadwal-patroli.index')->with('sukses', 'Jadwal patroli baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalPatroli::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam' => 'required|string|max:50',
            'lokasi' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'judul.required' => 'Judul kegiatan patroli wajib diisi.',
            'tanggal.required' => 'Tanggal patroli wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'jam.required' => 'Jam pelaksanaan patroli wajib diisi.',
            'lokasi.required' => 'Lokasi patroli wajib diisi.',
        ]);

        $jadwal->update([
            'judul' => $request->judul,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.jadwal-patroli.index')->with('sukses', 'Jadwal patroli berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalPatroli::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal-patroli.index')->with('sukses', 'Jadwal patroli berhasil dihapus.');
    }
}
