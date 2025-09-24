<?php

namespace App\Livewire\Diagnosis;

use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.guest')]
class Flow extends Component
{
    public int $step = 1;

    public $penyakit = [];

    public $belief = 0.0;

    #[On('showInfoPasien')]
    public function infoPasien()
    {
        $this->step = 1;
    }

    #[On('showPilihGejala')]
    public function pilihGejala()
    {
        $this->step = 2;
    }

    #[On('showHasilDiagnosis')]
    public function hasilDiagnosis()
    {
        $this->step = 3;
    }

    #[On('restartDiagnosisFlow')]
    public function restartDiagnosisFlow()
    {
        $this->step = 1;
    }

    public function render()
    {
        return view('livewire.diagnosis.flow');
    }
}
