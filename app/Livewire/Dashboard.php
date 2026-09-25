<?php

namespace App\Livewire;

use App\Enums\StatusSeleksi;
use App\Helpers\RocEdas;
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
    public $lolos;

    public function mount()
    {
        $this->siswa = Siswa::count();
        $this->alternatif = Alternatif::count();
        $this->kriteria = Kriteria::count();

        $rocEdas = new RocEdas();
        $siswaList = $rocEdas->ranking()->sortByDesc('skor')->values();
        $siswaLolos = $siswaList->take(RocEdas::JUMLAH_LOLOS);

        $this->lolos = $siswaList
            ->filter(function ($siswa) use ($siswaLolos) {
                $rekomendasiLolos = $siswaLolos->contains('id_siswa', $siswa->id_siswa);
                return StatusSeleksi::efektif($siswa->status_seleksi ?? null, $rekomendasiLolos) === StatusSeleksi::LOLOS;
            })
            ->count();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
