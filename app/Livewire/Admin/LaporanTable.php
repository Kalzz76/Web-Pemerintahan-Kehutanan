<?php

namespace App\Livewire\Admin;

use App\Models\KabupatenKota;
use App\Models\Laporan;
use Livewire\Component;
use Livewire\WithPagination;

class LaporanTable extends Component
{
    use WithPagination;

    public $cari = '';
    public $status = '';
    public $jenis = '';
    public $idKabupatenKota = '';

    public function updatedCari()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function updatedJenis()
    {
        $this->resetPage();
    }

    public function updatedIdKabupatenKota()
    {
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->cari = '';
        $this->status = '';
        $this->jenis = '';
        $this->idKabupatenKota = '';
        $this->resetPage();
    }

    public function render()
    {
        $daftarKabupaten = KabupatenKota::orderBy('nama')->get();

        $query = Laporan::with(['kabupatenKota', 'kawasanHutan'])->latest();

        if (!empty($this->cari)) {
            $cari = $this->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('kode', 'like', '%' . $cari . '%')
                    ->orWhere('deskripsi', 'like', '%' . $cari . '%');
            });
        }

        if (!empty($this->status)) {
            $query->where('status', $this->status);
        }

        if (!empty($this->jenis)) {
            $query->where('jenis', $this->jenis);
        }

        if (!empty($this->idKabupatenKota)) {
            $query->where('id_kabupaten_kota', $this->idKabupatenKota);
        }

        $daftarLaporan = $query->paginate(10);

        return view('livewire.admin.laporan-table', compact(
            'daftarKabupaten',
            'daftarLaporan'
        ));
    }
}
