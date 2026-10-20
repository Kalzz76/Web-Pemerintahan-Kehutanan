<?php

namespace App\Livewire\Admin;

use App\Models\Pengumuman;
use Livewire\Component;
use Livewire\WithPagination;

class PengumumanTable extends Component
{
    use WithPagination;

    public $cari = '';
    public $kategori = '';
    public $status = '';

    public function updatingCari()
    {
        $this->resetPage();
    }

    public function updatingKategori()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->cari = '';
        $this->kategori = '';
        $this->status = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = Pengumuman::with('user')->latest('tanggal');

        if (!empty($this->cari)) {
            $query->where(function ($q) {
                $q->where('judul', 'like', '%' . $this->cari . '%')
                    ->orWhere('isi', 'like', '%' . $this->cari . '%');
            });
        }

        if (!empty($this->kategori)) {
            $query->where('kategori', $this->kategori);
        }

        if (!empty($this->status)) {
            $query->where('status', $this->status);
        }

        $daftarPengumuman = $query->paginate(10);

        return view('livewire.admin.pengumuman-table', compact('daftarPengumuman'));
    }
}
