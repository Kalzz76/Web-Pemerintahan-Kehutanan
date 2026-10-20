<?php

namespace App\Http\Controllers;

use App\Models\KabupatenKota;
use App\Models\Laporan;
use App\Models\PengaturanHutan;
use Illuminate\Http\Request;

class LaporController extends Controller
{
    private function buatKodeLaporan()
    {
        $chars = '23456789ABCDEFGHJKMNPQRSTUVWXYZ';
        do {
            $kode = 'JHD-';
            for ($i = 0; $i < 6; $i++) {
                $kode .= $chars[random_int(0, strlen($chars) - 1)];
            }
        } while (Laporan::where('kode', $kode)->exists());

        return $kode;
    }

    public function index(Request $request)
    {
        $jenisTerpilih = $request->query('jenis');
        if ($jenisTerpilih !== 'Kebakaran' && $jenisTerpilih !== 'Hewan Masuk Kampung') {
            $jenisTerpilih = null;
        }

        $pengaturan = PengaturanHutan::first();
        $kabupatenKota = KabupatenKota::orderBy('nama')->get();

        return view('publik.lapor.index', compact('jenisTerpilih', 'pengaturan', 'kabupatenKota'));
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:Kebakaran,Hewan Masuk Kampung',
            'jenis_hewan' => 'nullable|max:100',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'id_kabupaten_kota' => 'nullable|exists:kabupaten_kota,id',
            'deskripsi' => 'required|max:1000',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'nama_pelapor' => 'nullable|max:100',
            'no_hp' => ['nullable', 'max:20', 'regex:/^[0-9\+\-\s]+$/'],
        ], [
            'jenis.required' => 'Jenis laporan wajib dipilih.',
            'jenis.in' => 'Jenis laporan tidak valid.',
            'latitude.required' => 'Lokasi kejadian wajib ditentukan.',
            'latitude.between' => 'Koordinat latitude tidak valid.',
            'longitude.required' => 'Lokasi kejadian wajib ditentukan.',
            'longitude.between' => 'Koordinat longitude tidak valid.',
            'id_kabupaten_kota.exists' => 'Kabupaten atau kota tidak valid.',
            'deskripsi.required' => 'Deskripsi kejadian wajib diisi.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
            'foto.image' => 'Berkas foto harus berupa gambar.',
            'foto.mimes' => 'Format foto harus berupa JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran foto maksimal 5MB.',
            'no_hp.regex' => 'Nomor HP hanya boleh berisi angka dan tanda +.',
            'no_hp.max' => 'Nomor HP maksimal 20 karakter.',
        ]);

        $pengaturan = PengaturanHutan::first();
        if ($pengaturan) {
            if (
                $request->latitude < $pengaturan->bbox_selatan ||
                $request->latitude > $pengaturan->bbox_utara ||
                $request->longitude < $pengaturan->bbox_barat ||
                $request->longitude > $pengaturan->bbox_timur
            ) {
                return back()->withInput()->withErrors(['latitude' => 'Lokasi laporan harus berada di wilayah Jawa Barat.']);
            }
        }

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('laporan', 'public');
        }

        $kode = $this->buatKodeLaporan();

        $laporan = Laporan::create([
            'kode' => $kode,
            'jenis' => $request->jenis,
            'jenis_hewan' => $request->jenis === 'Hewan Masuk Kampung' ? $request->jenis_hewan : null,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'id_kabupaten_kota' => $request->id_kabupaten_kota,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
            'nama_pelapor' => $request->nama_pelapor,
            'no_hp' => $request->no_hp,
            'status' => 'Baru',
            'catatan_admin' => null,
            'id_kawasan' => null,
            'id_admin' => null,
            'ip_pelapor' => $request->ip(),
        ]);

        return view('publik.lapor.sukses', compact('laporan'));
    }

    public function sinkron(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:Kebakaran,Hewan Masuk Kampung',
            'jenis_hewan' => 'nullable|max:100',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'id_kabupaten_kota' => 'nullable|exists:kabupaten_kota,id',
            'deskripsi' => 'required|max:1000',
            'nama_pelapor' => 'nullable|max:100',
            'no_hp' => ['nullable', 'max:20', 'regex:/^[0-9\+\-\s]+$/'],
        ]);

        $pengaturan = PengaturanHutan::first();
        if ($pengaturan) {
            if (
                $request->latitude < $pengaturan->bbox_selatan ||
                $request->latitude > $pengaturan->bbox_utara ||
                $request->longitude < $pengaturan->bbox_barat ||
                $request->longitude > $pengaturan->bbox_timur
            ) {
                return response()->json([
                    'sukses' => false,
                    'pesan' => 'Lokasi laporan harus berada di wilayah Jawa Barat.',
                ], 422);
            }
        }

        $kode = $this->buatKodeLaporan();

        $laporan = Laporan::create([
            'kode' => $kode,
            'jenis' => $request->jenis,
            'jenis_hewan' => $request->jenis === 'Hewan Masuk Kampung' ? $request->jenis_hewan : null,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'id_kabupaten_kota' => $request->id_kabupaten_kota,
            'deskripsi' => $request->deskripsi,
            'foto' => null,
            'nama_pelapor' => $request->nama_pelapor,
            'no_hp' => $request->no_hp,
            'status' => 'Baru',
            'catatan_admin' => null,
            'id_kawasan' => null,
            'id_admin' => null,
            'ip_pelapor' => $request->ip(),
        ]);

        return response()->json([
            'sukses' => true,
            'kode' => $laporan->kode,
            'jenis' => $laporan->jenis,
        ]);
    }

    public function status(Request $request)
    {
        $kodeCari = trim($request->input('kode', $request->query('kode', '')));
        $laporan = null;
        $pesanError = null;

        if ($kodeCari) {
            $laporan = Laporan::with('kabupatenKota', 'kawasanHutan')->where('kode', $kodeCari)->first();
            if (!$laporan) {
                $pesanError = 'Kode laporan tidak ditemukan.';
            }
        }

        return view('publik.lapor.status', compact('laporan', 'kodeCari', 'pesanError'));
    }
}
