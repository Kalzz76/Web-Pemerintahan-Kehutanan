<?php

namespace App\Livewire\Admin;

use App\Models\Laporan;
use Carbon\Carbon;
use Livewire\Component;

class GrafikLaporan extends Component
{
    public $periode = '5-bulan';

    public function setPeriode($periode)
    {
        $this->periode = $periode;
    }

    public function render()
    {
        $dataGrafik = [];
        $judulPeriode = '';
        $totalLaporan = 0;
        $totalKebakaran = 0;
        $totalHewan = 0;

        if ($this->periode === 'hari-ini') {
            $judulPeriode = 'Hari Ini (' . now()->locale('id')->isoFormat('D MMMM Y') . ')';
            $jamRanges = [
                ['label' => '00:00 - 04:00', 'start' => '00:00:00', 'end' => '03:59:59'],
                ['label' => '04:00 - 08:00', 'start' => '04:00:00', 'end' => '07:59:59'],
                ['label' => '08:00 - 12:00', 'start' => '08:00:00', 'end' => '11:59:59'],
                ['label' => '12:00 - 16:00', 'start' => '12:00:00', 'end' => '15:59:59'],
                ['label' => '16:00 - 20:00', 'start' => '16:00:00', 'end' => '19:59:59'],
                ['label' => '20:00 - 24:00', 'start' => '20:00:00', 'end' => '23:59:59'],
            ];

            foreach ($jamRanges as $jr) {
                $q = Laporan::whereDate('created_at', now()->toDateString())
                    ->whereTime('created_at', '>=', $jr['start'])
                    ->whereTime('created_at', '<=', $jr['end']);

                $jml = (clone $q)->count();
                $keb = (clone $q)->where('jenis', 'Kebakaran')->count();
                $hew = (clone $q)->where('jenis', 'Hewan Masuk Kampung')->count();

                $totalLaporan += $jml;
                $totalKebakaran += $keb;
                $totalHewan += $hew;

                $dataGrafik[] = [
                    'label' => $jr['label'],
                    'jumlah' => $jml,
                    'kebakaran' => $keb,
                    'hewan' => $hew,
                ];
            }
        } elseif ($this->periode === '7-hari') {
            $judulPeriode = '7 Hari Terakhir';
            for ($i = 6; $i >= 0; $i--) {
                $tgl = now()->subDays($i);
                $q = Laporan::whereDate('created_at', $tgl->toDateString());

                $jml = (clone $q)->count();
                $keb = (clone $q)->where('jenis', 'Kebakaran')->count();
                $hew = (clone $q)->where('jenis', 'Hewan Masuk Kampung')->count();

                $totalLaporan += $jml;
                $totalKebakaran += $keb;
                $totalHewan += $hew;

                $label = $i === 0 ? 'Hari Ini' : $tgl->locale('id')->isoFormat('ddd, D MMM');

                $dataGrafik[] = [
                    'label' => $label,
                    'jumlah' => $jml,
                    'kebakaran' => $keb,
                    'hewan' => $hew,
                ];
            }
        } elseif ($this->periode === '30-hari') {
            $judulPeriode = '30 Hari Terakhir (Rentang 5 Hari)';
            for ($i = 5; $i >= 0; $i--) {
                $start = now()->subDays(($i + 1) * 5)->startOfDay();
                $end = now()->subDays($i * 5)->endOfDay();

                $q = Laporan::whereBetween('created_at', [$start, $end]);

                $jml = (clone $q)->count();
                $keb = (clone $q)->where('jenis', 'Kebakaran')->count();
                $hew = (clone $q)->where('jenis', 'Hewan Masuk Kampung')->count();

                $totalLaporan += $jml;
                $totalKebakaran += $keb;
                $totalHewan += $hew;

                $dataGrafik[] = [
                    'label' => $start->format('d M') . ' - ' . $end->format('d M'),
                    'jumlah' => $jml,
                    'kebakaran' => $keb,
                    'hewan' => $hew,
                ];
            }
        } elseif ($this->periode === '1-tahun') {
            $judulPeriode = '1 Tahun Terakhir (12 Bulan)';
            $namaBulan = [
                1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
                7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
            ];

            for ($i = 11; $i >= 0; $i--) {
                $tgl = now()->subMonths($i);
                $bln = $tgl->month;
                $thn = $tgl->year;

                $q = Laporan::whereMonth('created_at', $bln)->whereYear('created_at', $thn);

                $jml = (clone $q)->count();
                $keb = (clone $q)->where('jenis', 'Kebakaran')->count();
                $hew = (clone $q)->where('jenis', 'Hewan Masuk Kampung')->count();

                $totalLaporan += $jml;
                $totalKebakaran += $keb;
                $totalHewan += $hew;

                $dataGrafik[] = [
                    'label' => $namaBulan[$bln] . ' ' . substr($thn, 2),
                    'jumlah' => $jml,
                    'kebakaran' => $keb,
                    'hewan' => $hew,
                ];
            }
        } else {
            $judulPeriode = '5 Bulan Terakhir';
            $namaBulan = [
                1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
                7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
            ];

            for ($i = 4; $i >= 0; $i--) {
                $tgl = now()->subMonths($i);
                $bln = $tgl->month;
                $thn = $tgl->year;

                $q = Laporan::whereMonth('created_at', $bln)->whereYear('created_at', $thn);

                $jml = (clone $q)->count();
                $keb = (clone $q)->where('jenis', 'Kebakaran')->count();
                $hew = (clone $q)->where('jenis', 'Hewan Masuk Kampung')->count();

                $totalLaporan += $jml;
                $totalKebakaran += $keb;
                $totalHewan += $hew;

                $dataGrafik[] = [
                    'label' => $namaBulan[$bln] . ' ' . $thn,
                    'jumlah' => $jml,
                    'kebakaran' => $keb,
                    'hewan' => $hew,
                ];
            }
        }

        $maksJumlah = 1;
        foreach ($dataGrafik as $item) {
            if ($item['jumlah'] > $maksJumlah) {
                $maksJumlah = $item['jumlah'];
            }
        }

        foreach ($dataGrafik as $k => $item) {
            $dataGrafik[$k]['persen'] = $item['jumlah'] > 0
                ? max(12, round(($item['jumlah'] / $maksJumlah) * 100))
                : 6;
        }

        return view('livewire.admin.grafik-laporan', compact(
            'dataGrafik',
            'judulPeriode',
            'totalLaporan',
            'totalKebakaran',
            'totalHewan',
            'maksJumlah'
        ));
    }
}
