<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Helpers\RocEdas;

#[Title('Hasil Seleksi')]
class HasilSeleksi extends Component
{
    public ?bool $lolos;

    public function mount() {

        // user disini hanya siswa

        $siswa = getActiveUser();

        $roc_edas = new RocEdas();
        $siswaLolos = $roc_edas->ranking();
        $siswaLolos = $siswaLolos->sortByDesc('skor')->values()->take(3);

        $this->lolos = $siswaLolos->contains('id_siswa', $siswa->id_siswa);
    }

    public function render()
    {
        return view('livewire.hasil-seleksi');
    }
}

