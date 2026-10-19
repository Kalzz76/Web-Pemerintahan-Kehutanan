<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KawasanHutan;
use App\Models\Laporan;
use App\Models\Primata;
use App\Models\Tumbuhan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahLaporanBaru = Laporan::where('status', 'Baru')->count();
        $kebakaranAktif = Laporan::where('jenis', 'Kebakaran')
            ->whereIn('status', ['Baru', 'Diverifikasi', 'Ditangani'])
            ->count();
        $hewanBulanIni = Laporan::where('jenis', 'Hewan Masuk Kampung')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $totalKawasan = KawasanHutan::count();
        $totalPrimata = Primata::count();
        $totalTumbuhan = Tumbuhan::count();

        $namaBulanIndo = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];

        $grafikBulanan = [];
        $maksLaporan = 1;

        for ($i = 5; $i >= 0; $i--) {
            $tgl = now()->subMonths($i);
            $bln = $tgl->month;
            $thn = $tgl->year;
            $jumlah = Laporan::whereMonth('created_at', $bln)->whereYear('created_at', $thn)->count();

            if ($jumlah > $maksLaporan) {
                $maksLaporan = $jumlah;
            }

            $grafikBulanan[] = [
                'label' => $namaBulanIndo[$bln] . ' ' . $thn,
                'jumlah' => $jumlah,
            ];
        }

        foreach ($grafikBulanan as $k => $item) {
            $grafikBulanan[$k]['persen'] = round(($item['jumlah'] / $maksLaporan) * 100);
        }

        $kawasanRawan = KawasanHutan::withCount(['laporan' => function ($q) {
            $q->where('jenis', 'Kebakaran');
        }])->orderBy('laporan_count', 'desc')->take(5)->get();

        $laporanTerbaru = Laporan::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'jumlahLaporanBaru',
            'kebakaranAktif',
            'hewanBulanIni',
            'totalKawasan',
            'totalPrimata',
            'totalTumbuhan',
            'grafikBulanan',
            'kawasanRawan',
            'laporanTerbaru'
        ));
    }
}
