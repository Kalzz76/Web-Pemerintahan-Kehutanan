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
    public function beranda()
    {
        $pengaturan = PengaturanHutan::first();
        $kontakDarurat = KontakDarurat::orderBy('urutan')->get();
        $pengumumanTerbaru = Pengumuman::where('status', 'Publish')->latest('tanggal')->take(3)->get();
        $totalKawasan = KawasanHutan::count();
        $totalPrimata = Primata::count();
        $totalTumbuhan = Tumbuhan::count();
        $totalLaporanSelesai = Laporan::where('status', 'Selesai')->count();
        $peringatanPublik = PrediksiApi::where('tampil_publik', 1)->latest()->first();

        return view('publik.beranda', compact(
            'pengaturan',
            'kontakDarurat',
            'pengumumanTerbaru',
            'totalKawasan',
            'totalPrimata',
            'totalTumbuhan',
            'totalLaporanSelesai',
            'peringatanPublik'
        ));
    }

    public function peta()
    {
        $pengaturan = PengaturanHutan::first();
        $daftarKawasan = KawasanHutan::with('jenisLahan')->get();
        $daftarTitik = TitikPenting::with('kawasanHutan')->get();
        $daftarLaporan = Laporan::whereIn('status', ['Diverifikasi', 'Ditangani'])
            ->select('id', 'kode', 'jenis', 'jenis_hewan', 'latitude', 'longitude', 'deskripsi', 'foto', 'status', 'created_at')
            ->get();

        return view('publik.peta', compact(
            'pengaturan',
            'daftarKawasan',
            'daftarTitik',
            'daftarLaporan'
        ));
    }

    public function peringatan()
    {
        $pengaturan = PengaturanHutan::first();
        $daftarPeringatan = PrediksiApi::where('tampil_publik', 1)
            ->with(['laporan', 'jenisLahan'])
            ->latest()
            ->get();
        $daftarPermukiman = TitikPenting::where('jenis', 'Permukiman')->get();

        return view('publik.peringatan', compact(
            'pengaturan',
            'daftarPeringatan',
            'daftarPermukiman'
        ));
    }

    public function primata(Request $request)
    {
        $pengaturan = PengaturanHutan::first();
        $cari = $request->query('cari');
        $idKawasan = $request->query('id_kawasan');
        $statusKonservasi = $request->query('status');

        $query = Primata::with('kawasanHutan')->orderBy('nama_lokal');

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

        if (!empty($idKawasan)) {
            $query->whereHas('kawasanHutan', function ($q) use ($idKawasan) {
                $q->where('kawasan_hutan.id', $idKawasan);
            });
        }

        $daftarPrimata = $query->paginate(9)->withQueryString();
        $daftarKawasan = KawasanHutan::orderBy('nama')->get();

        return view('publik.primata.index', compact(
            'pengaturan',
            'daftarPrimata',
            'daftarKawasan',
            'cari',
            'idKawasan',
            'statusKonservasi'
        ));
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
        $pengaturan = PengaturanHutan::first();
        $cari = $request->query('cari');
        $idKawasan = $request->query('id_kawasan');
        $jenis = $request->query('jenis');

        $query = Tumbuhan::with('kawasanHutan')->orderBy('nama_lokal');

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

        if (!empty($idKawasan)) {
            $query->whereHas('kawasanHutan', function ($q) use ($idKawasan) {
                $q->where('kawasan_hutan.id', $idKawasan);
            });
        }

        $daftarTumbuhan = $query->paginate(9)->withQueryString();
        $daftarKawasan = KawasanHutan::orderBy('nama')->get();

        return view('publik.tumbuhan.index', compact(
            'pengaturan',
            'daftarTumbuhan',
            'daftarKawasan',
            'cari',
            'idKawasan',
            'jenis'
        ));
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
        $pengaturan = PengaturanHutan::first();
        $kategori = $request->query('kategori');
        $cari = $request->query('cari');

        $queryPengumuman = Pengumuman::where('status', 'Publish')->latest('tanggal');

        if (!empty($kategori)) {
            $queryPengumuman->where('kategori', $kategori);
        }

        if (!empty($cari)) {
            $queryPengumuman->where(function ($q) use ($cari) {
                $q->where('judul', 'like', '%' . $cari . '%')
                    ->orWhere('isi', 'like', '%' . $cari . '%');
            });
        }

        $daftarPengumuman = $queryPengumuman->paginate(6)->withQueryString();

        $jadwalPatroli = JadwalPatroli::where('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal')
            ->orderBy('jam')
            ->get();

        $kontakDarurat = KontakDarurat::orderBy('urutan')->get();

        return view('publik.info.index', compact(
            'pengaturan',
            'daftarPengumuman',
            'jadwalPatroli',
            'kontakDarurat',
            'kategori',
            'cari'
        ));
    }
}


