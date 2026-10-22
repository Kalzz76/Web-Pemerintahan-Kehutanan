<?php

namespace App\Http\Controllers;

use App\Models\JadwalPatroli;
use App\Models\KawasanHutan;
use App\Models\KontakDarurat;
use App\Models\Laporan;
use App\Models\PengaturanHutan;
use App\Models\Pengumuman;
use App\Models\PrediksiApi;
use App\Models\Primata;
use App\Models\TitikPenting;
use App\Models\Tumbuhan;
use Illuminate\Http\Request;

class PublikController extends Controller
{
    public function muatDataPublik(string $activeView = 'beranda')
    {
        $pengaturan = PengaturanHutan::first();
        $kontakDarurat = KontakDarurat::orderBy('urutan')->get();
        $pengumumanTerbaru = Pengumuman::where('status', 'Publish')->latest('tanggal')->take(3)->get();
        $daftarPengumuman = Pengumuman::where('status', 'Publish')->latest('tanggal')->get();
        $totalKawasan = KawasanHutan::count();
        $totalPrimata = Primata::count();
        $totalTumbuhan = Tumbuhan::count();
        $totalLaporanSelesai = Laporan::where('status', 'Selesai')->count();
        $peringatanPublik = PrediksiApi::where('tampil_publik', 1)->latest()->first();

        $daftarTumbuhan = Tumbuhan::with('kawasanHutan')->orderBy('nama_lokal')->get();
        $daftarFauna = Primata::with('kawasanHutan')->orderBy('nama_lokal')->get();
        $daftarKawasan = KawasanHutan::with('jenisLahan')->orderBy('nama')->get();
        $daftarTitik = TitikPenting::with('kawasanHutan')->get();
        $daftarLaporan = Laporan::whereIn('status', ['Baru', 'Diverifikasi', 'Ditangani', 'Selesai'])
            ->select('id', 'kode', 'jenis', 'jenis_hewan', 'latitude', 'longitude', 'deskripsi', 'foto', 'status', 'created_at')
            ->latest()
            ->take(50)
            ->get();

        $daftarPrediksiPublik = PrediksiApi::where('tampil_publik', 1)
            ->with(['laporan', 'jenisLahan'])
            ->latest()
            ->get();
        $daftarJadwalPatroli = JadwalPatroli::latest('tanggal')->take(5)->get();

        $kabupatenKota = \App\Models\KabupatenKota::orderBy('nama')->get();

        return compact(
            'pengaturan',
            'kontakDarurat',
            'pengumumanTerbaru',
            'daftarPengumuman',
            'totalKawasan',
            'totalPrimata',
            'totalTumbuhan',
            'totalLaporanSelesai',
            'peringatanPublik',
            'daftarTumbuhan',
            'daftarFauna',
            'daftarKawasan',
            'daftarTitik',
            'daftarLaporan',
            'daftarPrediksiPublik',
            'daftarJadwalPatroli',
            'kabupatenKota',
            'activeView'
        );
    }

    public function beranda(Request $request)
    {
        $activeView = $request->query('view', 'beranda');
        return view('publik.beranda', $this->muatDataPublik($activeView));
    }

    public function peta(Request $request)
    {
        return view('publik.beranda', $this->muatDataPublik('peta'));
    }

    public function peringatan()
    {
        return redirect()->route('peta');
    }

    public function primata(Request $request)
    {
        return view('publik.beranda', $this->muatDataPublik('fauna'));
    }

    public function detailPrimata($id)
    {
        $pengaturan = PengaturanHutan::first();
        $primata = Primata::with('kawasanHutan')->findOrFail($id);
        $primataLain = Primata::where('id', '!=', $id)->inRandomOrder()->take(3)->get();

        return view('publik.primata.show', compact('pengaturan', 'primata', 'primataLain'));
    }

    public function tumbuhan(Request $request)
    {
        return view('publik.beranda', $this->muatDataPublik('flora'));
    }

    public function detailTumbuhan($id)
    {
        $pengaturan = PengaturanHutan::first();
        $tumbuhan = Tumbuhan::with('kawasanHutan')->findOrFail($id);
        $tumbuhanLain = Tumbuhan::where('id', '!=', $id)->inRandomOrder()->take(3)->get();

        return view('publik.tumbuhan.show', compact('pengaturan', 'tumbuhan', 'tumbuhanLain'));
    }

    public function info(Request $request)
    {
        return view('publik.beranda', $this->muatDataPublik('info'));
    }
}


