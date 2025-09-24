<?php

namespace App\Livewire;

use App\Models\Penyakit;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class Landing extends Component
{
    public $penyakit;

    public function mount() {
        $this->penyakit = Penyakit::all();
    }

    public function render()
    {
        $this->penyakit = Penyakit::all();

        return view('livewire.landing');
    }
}
