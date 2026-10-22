<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanHutan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = PengaturanHutan::first();

        return view('admin.pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_aplikasi' => 'required|max:100',
            'nama_instansi' => 'required|max:150',
            'slogan' => 'required|max:200',
            'deskripsi_singkat' => 'required|max:1000',
            'alamat' => 'required|max:500',
            'email' => 'required|email|max:100',
            'telepon' => 'required|max:30',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'lat_pusat' => 'required|numeric|between:-90,90',
            'long_pusat' => 'required|numeric|between:-180,180',
            'zoom_awal' => 'required|integer|between:1,20',
            'bbox_barat' => 'required|numeric|between:-180,180',
            'bbox_selatan' => 'required|numeric|between:-90,90',
            'bbox_timur' => 'required|numeric|between:-180,180',
            'bbox_utara' => 'required|numeric|between:-90,90',
        ], [
            'nama_aplikasi.required' => 'Nama aplikasi wajib diisi.',
            'nama_instansi.required' => 'Nama instansi wajib diisi.',
            'slogan.required' => 'Slogan wajib diisi.',
            'deskripsi_singkat.required' => 'Deskripsi singkat wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'telepon.required' => 'Nomor telepon wajib diisi.',
            'logo.image' => 'Logo harus berupa berkas gambar.',
            'logo.mimes' => 'Format logo harus berupa JPG, JPEG, atau PNG.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',
            'lat_pusat.required' => 'Latitude pusat wajib diisi.',
            'lat_pusat.between' => 'Latitude harus bernilai antara -90 dan 90.',
            'long_pusat.required' => 'Longitude pusat wajib diisi.',
            'long_pusat.between' => 'Longitude harus bernilai antara -180 dan 180.',
            'zoom_awal.required' => 'Zoom awal peta wajib diisi.',
            'bbox_barat.required' => 'Batas barat (longitude) wajib diisi.',
            'bbox_selatan.required' => 'Batas selatan (latitude) wajib diisi.',
            'bbox_timur.required' => 'Batas timur (longitude) wajib diisi.',
            'bbox_utara.required' => 'Batas utara (latitude) wajib diisi.',
        ]);

        $pengaturan = PengaturanHutan::first();
        if (!$pengaturan) {
            $pengaturan = new PengaturanHutan();
        }

        $data = [
            'nama_aplikasi' => $request->nama_aplikasi,
            'nama_instansi' => $request->nama_instansi,
            'slogan' => $request->slogan,
            'deskripsi_singkat' => $request->deskripsi_singkat,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'tampilkan_hiasan_sidebar' => $request->boolean('tampilkan_hiasan_sidebar'),
            'lat_pusat' => $request->lat_pusat,
            'long_pusat' => $request->long_pusat,
            'zoom_awal' => $request->zoom_awal,
            'bbox_barat' => $request->bbox_barat,
            'bbox_selatan' => $request->bbox_selatan,
            'bbox_timur' => $request->bbox_timur,
            'bbox_utara' => $request->bbox_utara,
        ];

        if ($request->hasFile('logo')) {
            if ($pengaturan->logo && Storage::disk('public')->exists($pengaturan->logo)) {
                Storage::disk('public')->delete($pengaturan->logo);
            }
            $data['logo'] = $request->file('logo')->store('pengaturan', 'public');
        }

        $pengaturan->fill($data);
        $pengaturan->save();

        return redirect()->route('admin.pengaturan.index')->with('sukses', 'Pengaturan berhasil diperbarui.');
    }
}
