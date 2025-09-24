<?php

namespace App\Livewire;

use App\Models\Gejala;
use App\Models\Penyakit;
use App\Models\RiwayatKonsultasi;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class Dashboard extends Component
{
    public $penyakit;
    public $gejala;
    public $riwayatKonsultasi;

    public function mount() {

        $this->penyakit = Penyakit::count();
        $this->gejala = Gejala::count();
        $this->riwayatKonsultasi = \App\Models\RiwayatKonsultasi::count();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
