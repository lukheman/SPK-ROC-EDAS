<?php

namespace App\Livewire;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Siswa;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class Dashboard extends Component
{
    public $siswa;
    public $alternatif;
    public $kriteria;

    public function mount()
    {
        $this->siswa = Siswa::count();
        $this->alternatif = Alternatif::count();
        $this->kriteria = Kriteria::count();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
