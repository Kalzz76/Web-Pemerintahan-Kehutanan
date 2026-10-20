<?php

namespace App\Livewire\Admin;

use App\Models\Primata;
use Livewire\Component;
use Livewire\WithPagination;

class PrimataTable extends Component
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
        $query = Primata::with('kawasanHutan')->orderBy('nama_lokal');

        if (!empty($this->cari)) {
            $cari = $this->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('nama_lokal', 'like', '%' . $cari . '%')
                    ->orWhere('nama_ilmiah', 'like', '%' . $cari . '%');
            });
        }

        $daftarPrimata = $query->paginate(10);

        return view('livewire.admin.primata-table', compact('daftarPrimata'));
    }
}
