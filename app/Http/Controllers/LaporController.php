<?php

namespace App\Http\Controllers;

use App\Models\KabupatenKota;
use App\Models\KawasanHutan;
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

    private function susunDetailKejadian(Request $request, string $jenis): ?array
    {
        $data = [];

        if ($jenis === 'Kebakaran') {
            $data = [
                'tipe_vegetasi' => $request->input('tipe_vegetasi'),
                'perkiraan_luas' => $request->input('perkiraan_luas'),
                'kondisi_api' => $request->input('kondisi_api'),
                'arah_angin' => $request->input('arah_angin'),
                'potensi_bahaya' => $request->input('potensi_bahaya'),
            ];
        } elseif ($jenis === 'Hewan Masuk Kampung') {
            $data = [
                'jenis_hewan' => $request->input('jenis_hewan'),
                'jumlah_satwa' => $request->input('jumlah_satwa'),
                'aktivitas_satwa' => $request->input('aktivitas_satwa'),
                'posisi_satwa' => $request->input('posisi_satwa'),
            ];
        } elseif ($jenis === 'Orang Hilang') {
            $data = [
                'nama_korban' => $request->input('nama_korban'),
                'usia_korban' => $request->input('usia_korban'),
                'gender_korban' => $request->input('gender_korban'),
                'jumlah_korban' => $request->input('jumlah_korban'),
                'kontak_terakhir' => $request->input('kontak_terakhir'),
                'jalur_pendakian' => $request->input('jalur_pendakian'),
                'ciri_pakaian' => $request->input('ciri_pakaian'),
                'kondisi_bekal' => $request->input('kondisi_bekal'),
            ];
        } elseif ($jenis === 'Lainnya') {
            $data = [
                'kategori_lainnya' => $request->input('kategori_lainnya'),
                'tingkat_urgensi' => $request->input('tingkat_urgensi'),
            ];
        }

        $filtered = array_filter($data, function ($val) {
            return !is_null($val) && $val !== '';
        });

        return count($filtered) > 0 ? $filtered : null;
    }

    public function index(Request $request)
    {
        return (new PublikController())->beranda($request->merge(['view' => 'lapor']));
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:Kebakaran,Hewan Masuk Kampung,Orang Hilang,Lainnya',
            'tipe_vegetasi' => 'required_if:jenis,Kebakaran|nullable|max:100',
            'perkiraan_luas' => 'required_if:jenis,Kebakaran|nullable|max:100',
            'kondisi_api' => 'required_if:jenis,Kebakaran|nullable|max:100',
            'arah_angin' => 'required_if:jenis,Kebakaran|nullable|max:100',
            'potensi_bahaya' => 'required_if:jenis,Kebakaran|nullable|max:100',
            'jenis_hewan' => 'required_if:jenis,Hewan Masuk Kampung|nullable|max:100',
            'jumlah_satwa' => 'required_if:jenis,Hewan Masuk Kampung|nullable|max:100',
            'aktivitas_satwa' => 'required_if:jenis,Hewan Masuk Kampung|nullable|max:150',
            'posisi_satwa' => 'required_if:jenis,Hewan Masuk Kampung|nullable|max:100',
            'nama_korban' => 'required_if:jenis,Orang Hilang|nullable|max:150',
            'usia_korban' => 'required_if:jenis,Orang Hilang|nullable|max:50',
            'gender_korban' => 'required_if:jenis,Orang Hilang|nullable|max:50',
            'jumlah_korban' => 'required_if:jenis,Orang Hilang|nullable|max:50',
            'kontak_terakhir' => 'required_if:jenis,Orang Hilang|nullable|max:100',
            'jalur_pendakian' => 'required_if:jenis,Orang Hilang|nullable|max:150',
            'ciri_pakaian' => 'required_if:jenis,Orang Hilang|nullable|max:255',
            'kondisi_bekal' => 'required_if:jenis,Orang Hilang|nullable|max:150',
            'kategori_lainnya' => 'required_if:jenis,Lainnya|nullable|max:100',
            'tingkat_urgensi' => 'required_if:jenis,Lainnya|nullable|max:100',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'id_kabupaten_kota' => 'nullable|exists:kabupaten_kota,id',
            'deskripsi' => 'required|max:1000',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'nama_pelapor' => 'nullable|max:100',
            'no_hp' => ['nullable', 'min:8', 'max:20', 'regex:/^[0-9]+$/'],
        ], [
            'jenis.required' => 'Jenis laporan wajib dipilih.',
            'jenis.in' => 'Jenis laporan tidak valid.',
            'latitude.required' => 'Lokasi kejadian wajib ditentukan.',
            'latitude.between' => 'Koordinat latitude tidak valid.',
            'longitude.required' => 'Lokasi kejadian wajib ditentukan.',
            'longitude.between' => 'Koordinat longitude tidak valid.',
            'id_kabupaten_kota.required' => 'Wilayah kabupaten atau kota wajib dipilih.',
            'id_kabupaten_kota.exists' => 'Kabupaten atau kota tidak valid.',
            'deskripsi.required' => 'Deskripsi kejadian wajib diisi.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
            'foto.image' => 'Berkas foto harus berupa gambar.',
            'foto.mimes' => 'Format foto harus berupa JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran foto maksimal 5MB.',
            'no_hp.regex' => 'Nomor WhatsApp / HP hanya boleh berisi angka.',
            'no_hp.min' => 'Nomor WhatsApp / HP minimal 8 digit angka.',
            'no_hp.max' => 'Nomor WhatsApp / HP maksimal 20 digit angka.',
        ]);

        $pengaturan = PengaturanHutan::first();
        if ($pengaturan) {
            if (
                $request->latitude < $pengaturan->bbox_selatan ||
                $request->latitude > $pengaturan->bbox_utara ||
                $request->longitude < $pengaturan->bbox_barat ||
                $request->longitude > $pengaturan->bbox_timur
            ) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'sukses' => false,
                        'pesan' => 'Lokasi laporan harus berada di wilayah Jawa Barat.',
                        'errors' => ['latitude' => ['Lokasi laporan harus berada di wilayah Jawa Barat.']],
                    ], 422);
                }
                return back()->withInput()->withErrors(['latitude' => 'Lokasi laporan harus berada di wilayah Jawa Barat.']);
            }
        }

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('laporan', 'public');
        }

        $kode = $this->buatKodeLaporan();
        $detailKejadian = $this->susunDetailKejadian($request, $request->jenis);

        $laporan = Laporan::create([
            'kode' => $kode,
            'jenis' => $request->jenis,
            'jenis_hewan' => $request->jenis === 'Hewan Masuk Kampung' ? $request->jenis_hewan : null,
            'detail_kejadian' => $detailKejadian,
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

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'sukses' => true,
                'kode' => $laporan->kode,
                'pesan' => 'Laporan berhasil diterima dan masuk ke sistem petugas.',
            ]);
        }

        return view('publik.lapor.sukses', compact('laporan'));
    }

    public function sinkron(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:Kebakaran,Hewan Masuk Kampung,Orang Hilang,Lainnya',
            'jenis_hewan' => 'nullable|max:100',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'id_kabupaten_kota' => 'nullable|exists:kabupaten_kota,id',
            'deskripsi' => 'required|max:1000',
            'nama_pelapor' => 'nullable|max:100',
            'no_hp' => ['nullable', 'min:8', 'max:20', 'regex:/^[0-9]+$/'],
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
        $detailKejadian = $this->susunDetailKejadian($request, $request->jenis);

        $laporan = Laporan::create([
            'kode' => $kode,
            'jenis' => $request->jenis,
            'jenis_hewan' => $request->jenis === 'Hewan Masuk Kampung' ? $request->jenis_hewan : null,
            'detail_kejadian' => $detailKejadian,
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

        if ($request->ajax() || $request->wantsJson()) {
            if ($laporan) {
                return response()->json([
                    'sukses' => true,
                    'laporan' => [
                        'kode' => $laporan->kode,
                        'jenis' => $laporan->jenis,
                        'status' => $laporan->status,
                        'latitude' => $laporan->latitude,
                        'longitude' => $laporan->longitude,
                        'deskripsi' => $laporan->deskripsi,
                        'catatan_admin' => $laporan->catatan_admin,
                        'kawasan' => $laporan->kawasanHutan->nama ?? 'Wilayah Hutan Jawa Barat',
                        'kabupaten' => $laporan->kabupatenKota->nama ?? 'Jawa Barat',
                        'tanggal' => $laporan->created_at->format('d M Y, H:i') . ' WIB',
                    ],
                ]);
            }
            return response()->json([
                'sukses' => false,
                'pesan' => 'Kode laporan tidak valid atau tidak terdaftar di sistem.',
            ], 404);
        }

        return (new PublikController())->beranda($request->merge(['view' => 'cek-status', 'kode' => $kodeCari]));
    }
}
