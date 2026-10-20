<?php

namespace App\Livewire\Publik;

use App\Models\KabupatenKota;
use App\Models\KawasanHutan;
use App\Models\Primata;
use Livewire\Component;
use Livewire\WithPagination;

class PrimataIndex extends Component
{
    use WithPagination;

    public $cari = '';
    public $idKabupatenKota = '';
    public $idKawasan = '';
    public $statusKonservasi = '';

    public function updatedCari()
    {
        $this->resetPage();
    }

    public function updatedIdKabupatenKota()
    {
        $this->idKawasan = '';
        $this->resetPage();
    }

    public function updatedIdKawasan()
    {
        $this->resetPage();
    }

    public function updatedStatusKonservasi()
    {
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->cari = '';
        $this->idKabupatenKota = '';
        $this->idKawasan = '';
        $this->statusKonservasi = '';
        $this->resetPage();
    }

    public function render()
    {
        $daftarKabupaten = KabupatenKota::orderBy('nama')->get();

        if (!empty($this->idKabupatenKota)) {
            $daftarKawasan = KawasanHutan::whereHas('kabupatenKota', function ($q) {
                $q->where('kabupaten_kota.id', $this->idKabupatenKota);
            })->orderBy('nama')->get();
        } else {
            $daftarKawasan = KawasanHutan::orderBy('nama')->get();
        }

        $query = Primata::with('kawasanHutan')->orderBy('nama_lokal');

        if (!empty($this->cari)) {
            $cari = $this->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('nama_lokal', 'like', '%' . $cari . '%')
                    ->orWhere('nama_ilmiah', 'like', '%' . $cari . '%');
            });
        }

        if (!empty($this->idKawasan)) {
            $idKawasan = $this->idKawasan;
            $query->whereHas('kawasanHutan', function ($q) use ($idKawasan) {
                $q->where('kawasan_hutan.id', $idKawasan);
            });
        } elseif (!empty($this->idKabupatenKota)) {
            $idKabupaten = $this->idKabupatenKota;
            $query->whereHas('kawasanHutan.kabupatenKota', function ($q) use ($idKabupaten) {
                $q->where('kabupaten_kota.id', $idKabupaten);
            });
        }

        if (!empty($this->statusKonservasi)) {
            $query->where('status_konservasi', $this->statusKonservasi);
        }

        $daftarPrimata = $query->paginate(9);

        return view('livewire.publik.primata-index', compact(
            'daftarKabupaten',
            'daftarKawasan',
            'daftarPrimata'
        ));
    }
}
