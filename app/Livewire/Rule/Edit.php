<?php

namespace App\Livewire\Rule;

use App\Models\Gejala;
use App\Models\Penyakit;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public $gejala_penyakit_all;

    public string $nama_penyakit = '';

    public $id_gejala_terpilih = []; // untuk menyimpan gejala terpilih

    public $gejala_penyakit;

    public $penyakit;

    public string $edit_state = 'normal';

    public $bobots = [];

    #[On('editGejalaPenyakit')]
    public function edit($id)
    {
        $this->mount($id);
    }

    public function mount($id_penyakit = null)
    {

        if ($id_penyakit) {
            $this->nama_penyakit = Penyakit::query()->where('id', $id_penyakit)->first()->nama;
            $this->gejala_penyakit_all = Gejala::all();

            $this->penyakit = Penyakit::query()->with('gejala')->findOrFail($id_penyakit);
            $this->id_gejala_terpilih = $this->penyakit->gejala->pluck('id')->toArray();

            $this->bobots = $this->penyakit->gejala->map(function ($gejala, $index) {
                return [
                    'id' => $gejala->id,
                    'bobot' => $gejala->pivot->bobot ?? 0.0,
                ];

            })->toArray();

        }

    }

    public function updateGejala()
    {
        $this->penyakit->gejala()->sync($this->id_gejala_terpilih);
        $this->dispatch('toast', message: 'Gejala penyakit berhasil diperbarui');

        $this->dispatch('editGejalaPenyakit', id: $this->penyakit->id);
    }

    public function updateBobotGejala()
    {

        foreach ($this->bobots as $bobot) {
            $this->penyakit->gejala()->updateExistingPivot(
                $bobot['id'],
                ['bobot' => $bobot['bobot']]
            );
        }

        $this->dispatch('toast', message: 'Bobot setiap gejala berhasil diatur');
        $this->dispatch('editGejalaPenyakit', id: $this->penyakit->id);

    }

    public function render()
    {
        return view('livewire.rule.edit');
    }
}
