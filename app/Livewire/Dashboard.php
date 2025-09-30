<?php

namespace App\Livewire;

use App\Models\Alternatif;
use App\Models\Gejala;
use App\Models\Penyakit;
use App\Models\RiwayatKonsultasi;
use App\Models\Siswa;
use Livewire\Attributes\Title;
use Livewire\Component;

use App\Helpers\RocEdas;

#[Title('Dashboard')]
class Dashboard extends Component
{
    public $alternatif;
    public $siswa;

    public function mount() {
        $this->penyakit = Siswa::count();
        $this->alternatif = Alternatif::count();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
