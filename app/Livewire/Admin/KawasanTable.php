<?php

namespace App\Livewire\Admin;

use App\Models\KawasanHutan;
use Livewire\Component;
use Livewire\WithPagination;

class KawasanTable extends Component
{
    use WithPagination;

    public $cari = '';

    public function updatedCari()
    {
        $this->resetPage();
    }

    public function resetPencarian()
    {
        $this->cari = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = KawasanHutan::with(['jenisLahan', 'kabupatenKota'])->orderBy('nama');

        if (!empty($this->cari)) {
            $query->where('nama', 'like', '%' . $this->cari . '%');
        }

        $daftarKawasan = $query->paginate(10);

        return view('livewire.admin.kawasan-table', compact('daftarKawasan'));
    }
}
