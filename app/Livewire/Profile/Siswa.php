<?php

namespace App\Livewire\Profile;

use App\Models\Siswa as AppSiswa;
use Livewire\Component;

class Siswa extends Component
{
    public ?AppSiswa $user;

    public function mount() {
        $this->user = getActiveUser();
    }

    public function render()
    {
        return view('livewire.profile.siswa');
    }
}
