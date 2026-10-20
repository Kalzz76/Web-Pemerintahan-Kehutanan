<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\On;
use Livewire\Component;

class TombolLayarPenuh extends Component
{
    public $layarPenuh = false;

    public function toggleLayarPenuh()
    {
        $this->layarPenuh = !$this->layarPenuh;
    }

    #[On('fullscreen-berubah')]
    public function setLayarPenuh($status)
    {
        $this->layarPenuh = (bool) $status;
    }

    public function render()
    {
        return view('livewire.admin.tombol-layar-penuh');
    }
}
