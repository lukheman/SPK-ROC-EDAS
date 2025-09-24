<?php

namespace App\Livewire\Diagnosis;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class InfoPasien extends Component
{
    public string $nama = '';

    public string $umur = '';

    public string $jenis_kelamin = '';

    public string $alamat = '';

    public function mount()
    {
        $info_pasien = session('info_pasien', []);
        $this->nama = $info_pasien['nama'] ?? '';
        $this->umur = $info_pasien['umur'] ?? '';
        $this->jenis_kelamin = $info_pasien['jenis_kelamin'] ?? '';
        $this->alamat = $info_pasien['alamat'] ?? '';
    }

    public function nextStep()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'umur' => 'required|integer|min:1|max:150',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
        ]);

        session(['info_pasien' => [
            'nama' => $this->nama,
            'umur' => $this->umur,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat' => $this->alamat,
        ]]);
        $this->dispatch('showPilihGejala');
    }

    public function render()
    {
        return view('livewire.diagnosis.info-pasien');
    }
}
