<?php

namespace App\Livewire;

use Livewire\Component;

class PetaLayarPenuh extends Component
{
    public $idPeta = 'peta';
    public $tinggi = '500px';
    public $layarPenuh = false;

    public function mount($idPeta = 'peta', $tinggi = '500px')
    {
        $this->idPeta = $idPeta;
        $this->tinggi = $tinggi;
    }

    public function toggleLayarPenuh()
    {
        $this->layarPenuh = !$this->layarPenuh;
        $this->dispatch('peta-toggle-layar-penuh', layarPenuh: $this->layarPenuh, idPeta: $this->idPeta);
    }

    public function render()
    {
        return view('livewire.peta-layar-penuh');
    }
}
