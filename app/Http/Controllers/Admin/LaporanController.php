<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KawasanHutan;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->query('cari');
        $filterStatus = $request->query('status');
        $filterJenis = $request->query('jenis');

        $query = Laporan::with(['kawasanHutan', 'admin']);

        if ($cari) {
            $query->where(function ($q) use ($cari) {
                $q->where('kode', 'like', '%' . $cari . '%')
                  ->orWhere('deskripsi', 'like', '%' . $cari . '%')
                  ->orWhere('nama_pelapor', 'like', '%' . $cari . '%')
                  ->orWhere('no_hp', 'like', '%' . $cari . '%')
                  ->orWhere('jenis_hewan', 'like', '%' . $cari . '%');
            });
        }

        if ($filterStatus) {
            $query->where('status', $filterStatus);
        }

        if ($filterJenis) {
            $query->where('jenis', $filterJenis);
        }

        $daftarLaporan = $query->latest('created_at')->paginate(10)->withQueryString();

        return view('admin.laporan.index', compact('daftarLaporan', 'cari', 'filterStatus', 'filterJenis'));
    }

    public function show($id)
    {
        $laporan = Laporan::with(['kawasanHutan', 'admin'])->findOrFail($id);
        $daftarKawasan = KawasanHutan::orderBy('nama')->get();

        return view('admin.laporan.show', compact('laporan', 'daftarKawasan'));
    }

    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Baru,Diverifikasi,Ditangani,Selesai',
            'id_kawasan' => 'nullable|exists:kawasan_hutan,id',
            'catatan_admin' => 'nullable|max:1000',
        ], [
            'status.required' => 'Status laporan wajib dipilih.',
            'status.in' => 'Status laporan tidak valid.',
            'id_kawasan.exists' => 'Kawasan hutan yang dipilih tidak valid.',
            'catatan_admin.max' => 'Catatan admin maksimal 1000 karakter.',
        ]);

        $laporan->update([
            'status' => $request->status,
            'id_kawasan' => $request->id_kawasan,
            'catatan_admin' => $request->catatan_admin,
            'id_admin' => Auth::id(),
        ]);

        return redirect()->route('admin.laporan.show', $laporan->id)->with('sukses', 'Status dan tindak lanjut laporan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);

        if ($laporan->foto && Storage::disk('public')->exists($laporan->foto)) {
            Storage::disk('public')->delete($laporan->foto);
        }

        $laporan->delete();

        return redirect()->route('admin.laporan.index')->with('sukses', 'Laporan berhasil dihapus.');
    }
}
