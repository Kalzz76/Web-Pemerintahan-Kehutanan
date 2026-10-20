<?php

namespace App\Livewire;

use App\Models\KabupatenKota;
use App\Models\KawasanHutan;
use Livewire\Component;

class PilihWilayah extends Component
{
    public $idKabupatenKota = '';
    public $idKawasan = '';

    public function updatedIdKabupatenKota($value)
    {
        $this->idKawasan = '';
    }

    public function updatedIdKawasan($value)
    {
        if (empty($value)) {
            return;
        }

        $kawasan = KawasanHutan::find($value);
        if ($kawasan && $kawasan->lat_pusat && $kawasan->long_pusat) {
            $radiusKm = sqrt(($kawasan->luas_ha ?: 100) / 314.159);
            if ($radiusKm <= 2) {
                $zoom = 13;
            } elseif ($radiusKm <= 5) {
                $zoom = 12;
            } elseif ($radiusKm <= 9) {
                $zoom = 11;
            } else {
                $zoom = 10;
            }

            $this->dispatch('peta-terbang', lat: $kawasan->lat_pusat, long: $kawasan->long_pusat, zoom: $zoom);
        }
    }

    public function resetPilihan()
    {
        $this->idKabupatenKota = '';
        $this->idKawasan = '';
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

        return view('livewire.pilih-wilayah', compact('daftarKabupaten', 'daftarKawasan'));
    }
}
