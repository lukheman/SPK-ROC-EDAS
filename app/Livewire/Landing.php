<?php

namespace App\Livewire;

use App\Models\Penyakit;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class Landing extends Component
{

    public function render()
    {
        return view('livewire.landing');
    }
}
