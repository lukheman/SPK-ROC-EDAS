<?php

namespace App\Livewire\Table;

use App\Enums\State;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Helpers\RocEdas;

#[Title('Ranking')]
class Ranking extends Component
{
    public $siswaList;
    public $kriteriaList;
    public $avgKriteria;
    public $bobotROC;
    public $max_sp;
    public $max_sn;

    public $currentState = State::CREATE;
    public string $idModal = 'modal-form-siswa';

    public $laporan;

    public function mount() {

        $roc_edas = new RocEdas();
        $this->siswaList = $roc_edas->ranking();
        $this->kriteriaList = $roc_edas->kriteriaList;
        $this->avgKriteria = $roc_edas->avgKriteria;
        $this->bobotROC = $roc_edas->bobotROC;
        $this->max_sp = $roc_edas->max_sp;
        $this->max_sn = $roc_edas->max_sn;

        $this->siswaList = $this->siswaList->sortByDesc('skor')->values();

        $siswaLolos = $this->siswaList->take(3);

        foreach($this->siswaList as $siswa) {
            if($siswaLolos->contains('id_siswa', $siswa->id_siswa)) {
                $siswa->lolos = true;
            } else {
                $siswa->lolos = false;
            }
        }

    }

    public function render()
    {
        return view('livewire.table.ranking');
    }
}
