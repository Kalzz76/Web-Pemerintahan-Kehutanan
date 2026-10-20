<?php

namespace App\Livewire\Admin;

use App\Models\JadwalPatroli;
use App\Models\Laporan;
use App\Models\TitikApi;
use Livewire\Attributes\On;
use Livewire\Component;

class NotifikasiModal extends Component
{
    public $terbuka = false;
    public $tab = 'semua';

    public function toggle()
    {
        $this->terbuka = !$this->terbuka;
        $this->dispatch('status-modal-notif', terbuka: $this->terbuka);
    }

    public function tutup()
    {
        $this->terbuka = false;
        $this->dispatch('status-modal-notif', terbuka: false);
    }

    #[On('tutup-notifikasi-otomatis')]
    public function tutupOtomatis()
    {
        $this->terbuka = false;
        $this->dispatch('status-modal-notif', terbuka: false);
    }

    public function gantiTab($namaTab)
    {
        $this->tab = $namaTab;
    }

    public function hapusLaporan($id)
    {
        $dihapus = session()->get('notif_dihapus_laporan', []);
        $dihapus[] = $id;
        session()->put('notif_dihapus_laporan', array_unique($dihapus));
    }

    public function hapusTitikApi($id)
    {
        $dihapus = session()->get('notif_dihapus_titik_api', []);
        $dihapus[] = $id;
        session()->put('notif_dihapus_titik_api', array_unique($dihapus));
    }

    public function hapusPatroli($id)
    {
        $dihapus = session()->get('notif_dihapus_patroli', []);
        $dihapus[] = $id;
        session()->put('notif_dihapus_patroli', array_unique($dihapus));
    }

    public function hapusSemua()
    {
        $dihapusLaporan = session()->get('notif_dihapus_laporan', []);
        $laporanIds = Laporan::where('status', 'Baru')->pluck('id')->toArray();
        session()->put('notif_dihapus_laporan', array_unique(array_merge($dihapusLaporan, $laporanIds)));

        $dihapusTitikApi = session()->get('notif_dihapus_titik_api', []);
        $titikApiIds = TitikApi::latest('id')->take(20)->pluck('id')->toArray();
        session()->put('notif_dihapus_titik_api', array_unique(array_merge($dihapusTitikApi, $titikApiIds)));

        $dihapusPatroli = session()->get('notif_dihapus_patroli', []);
        $patroliIds = JadwalPatroli::whereDate('tanggal', '>=', now()->toDateString())->pluck('id')->toArray();
        session()->put('notif_dihapus_patroli', array_unique(array_merge($dihapusPatroli, $patroliIds)));
    }

    public function render()
    {
        $dihapusLaporan = session()->get('notif_dihapus_laporan', []);
        $dihapusTitikApi = session()->get('notif_dihapus_titik_api', []);
        $dihapusPatroli = session()->get('notif_dihapus_patroli', []);

        $jumlahLaporanBaru = Laporan::whereNotIn('id', $dihapusLaporan)
            ->where('status', 'Baru')
            ->count();

        $daftarLaporan = Laporan::with('kawasanHutan', 'kabupatenKota')
            ->whereNotIn('id', $dihapusLaporan)
            ->where('status', 'Baru')
            ->latest()
            ->take(10)
            ->get();

        $daftarTitikApi = TitikApi::whereNotIn('id', $dihapusTitikApi)
            ->latest('tanggal_deteksi')
            ->latest('id')
            ->take(10)
            ->get();

        $daftarPatroli = JadwalPatroli::whereNotIn('id', $dihapusPatroli)
            ->whereDate('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal')
            ->orderBy('jam')
            ->take(10)
            ->get();

        $adaNotifikasi = $daftarLaporan->isNotEmpty() || $daftarTitikApi->isNotEmpty() || $daftarPatroli->isNotEmpty();

        return view('livewire.admin.notifikasi-modal', compact(
            'jumlahLaporanBaru',
            'daftarLaporan',
            'daftarTitikApi',
            'daftarPatroli',
            'adaNotifikasi'
        ));
    }
}
