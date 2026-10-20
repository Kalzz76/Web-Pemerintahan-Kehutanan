<?php

namespace App\Livewire\Admin;

use App\Models\TitikPenting;
use Livewire\Component;
use Livewire\WithPagination;

class TitikPentingTable extends Component
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
        $query = TitikPenting::with(['kabupatenKota', 'kawasanHutan'])->orderBy('nama');

        if (!empty($this->cari)) {
            $query->where('nama', 'like', '%' . $this->cari . '%');
        }

        $daftarTitik = $query->paginate(10);

        return view('livewire.admin.titik-penting-table', compact('daftarTitik'));
    }
}
