<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KabupatenKota;
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
        $filterKabupaten = $request->query('id_kabupaten_kota');

        $query = Laporan::with(['kawasanHutan', 'kabupatenKota', 'admin']);

        if ($cari) {
            $query->where(function ($q) use ($cari) {
                $q->where('kode', 'like', '%' . $cari . '%')
                  ->orWhere('deskripsi', 'like', '%' . $cari . '%')
                  ->orWhere('nama_pelapor', 'like', '%' . $cari . '%')
                  ->orWhere('no_hp', 'like', '%' . $cari . '%')
                  ->orWhere('jenis_hewan', 'like', '%' . $cari . '%')
                  ->orWhere('detail_kejadian', 'like', '%' . $cari . '%');
            });
        }

        if ($filterStatus) {
            $query->where('status', $filterStatus);
        }

        if ($filterJenis) {
            $query->where('jenis', $filterJenis);
        }

        if ($filterKabupaten) {
            $query->where('id_kabupaten_kota', $filterKabupaten);
        }

        $daftarLaporan = $query->latest('created_at')->paginate(10)->withQueryString();
        $daftarKabupaten = KabupatenKota::orderBy('nama')->get();

        return view('admin.laporan.index', compact('daftarLaporan', 'daftarKabupaten', 'cari', 'filterStatus', 'filterJenis', 'filterKabupaten'));
    }

    public function show($id)
    {
        $laporan = Laporan::with(['kawasanHutan', 'kabupatenKota', 'admin'])->findOrFail($id);
        $daftarKawasan = KawasanHutan::orderBy('nama')->get();
        $daftarKabupaten = KabupatenKota::orderBy('nama')->get();

        return view('admin.laporan.show', compact('laporan', 'daftarKawasan', 'daftarKabupaten'));
    }

    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Baru,Diverifikasi,Ditangani,Selesai',
            'id_kawasan' => 'nullable|exists:kawasan_hutan,id',
            'id_kabupaten_kota' => 'nullable|exists:kabupaten_kota,id',
            'catatan_admin' => 'nullable|max:1000',
        ], [
            'status.required' => 'Status laporan wajib dipilih.',
            'status.in' => 'Status laporan tidak valid.',
            'id_kawasan.exists' => 'Kawasan hutan yang dipilih tidak valid.',
            'id_kabupaten_kota.exists' => 'Kabupaten/Kota yang dipilih tidak valid.',
            'catatan_admin.max' => 'Catatan admin maksimal 1000 karakter.',
        ]);

        $laporan->update([
            'status' => $request->status,
            'id_kawasan' => $request->id_kawasan,
            'id_kabupaten_kota' => $request->id_kabupaten_kota,
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
